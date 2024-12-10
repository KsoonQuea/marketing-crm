<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCaseDocumentRequest;
use App\Http\Requests\StoreCaseDocumentRequest;
use App\Http\Requests\UpdateCaseDocumentRequest;
use App\Models\CaseDocument;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseDocumentController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseDocument::with(['case'])->select(sprintf('%s.*', (new CaseDocument())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_document_show';
                $editGate = 'case_document_edit';
                $deleteGate = 'case_document_delete';
                $crudRoutePart = 'case-documents';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->addColumn('case_case_code', function ($row) {
                return $row->case ? $row->case->case_code : '';
            });

            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('file', function ($row) {
                if (! $row->file) {
                    return '';
                }
                $links = [];
                foreach ($row->file as $media) {
                    $links[] = '<a href="'.$media->getUrl().'" target="_blank">'.trans('global.downloadFile').'</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? CaseDocument::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('remark', function ($row) {
                return $row->remark ? $row->remark : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case', 'file']);

            return $table->make(true);
        }

        return view('admin.caseDocuments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseDocuments.create', compact('cases'));
    }

    public function store(StoreCaseDocumentRequest $request)
    {
        $caseDocument = CaseDocument::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $caseDocument->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $caseDocument->id]);
        }

        return to_route('admin.case-documents.index');
    }

    public function edit(CaseDocument $caseDocument)
    {
        abort_if(Gate::denies('case_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseDocument->load('case');

        return view('admin.caseDocuments.edit', compact('caseDocument', 'cases'));
    }

    public function update(UpdateCaseDocumentRequest $request, CaseDocument $caseDocument)
    {
        $caseDocument->update($request->all());

        if (count($caseDocument->file) > 0) {
            foreach ($caseDocument->file as $media) {
                if (! in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $caseDocument->file->pluck('file_name')->toArray();
        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $caseDocument->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
            }
        }

        return to_route('admin.case-documents.index');
    }

    public function show(CaseDocument $caseDocument)
    {
        abort_if(Gate::denies('case_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDocument->load('case');

        return view('admin.caseDocuments.show', compact('caseDocument'));
    }

    public function destroy(CaseDocument $caseDocument)
    {
        abort_if(Gate::denies('case_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDocument->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseDocumentRequest $request)
    {
        CaseDocument::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('case_document_create') && Gate::denies('case_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new CaseDocument();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
