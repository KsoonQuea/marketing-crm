<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCaseDocumentRequest;
use App\Http\Requests\UpdateCaseDocumentRequest;
use App\Http\Resources\Admin\CaseDocumentResource;
use App\Models\CaseDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseDocumentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('case_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDocumentResource(CaseDocument::with(['case'])->get());
    }

    public function store(StoreCaseDocumentRequest $request)
    {
        $caseDocument = CaseDocument::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $caseDocument->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
        }

        return (new CaseDocumentResource($caseDocument))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseDocument $caseDocument)
    {
        abort_if(Gate::denies('case_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDocumentResource($caseDocument->load(['case']));
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

        return (new CaseDocumentResource($caseDocument))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseDocument $caseDocument)
    {
        abort_if(Gate::denies('case_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDocument->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
