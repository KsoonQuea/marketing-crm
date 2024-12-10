<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseRequestRequest;
use App\Http\Requests\StoreCaseRequestRequest;
use App\Http\Requests\UpdateCaseRequestRequest;
use App\Models\CaseList;
use App\Models\CaseRequest;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseRequestController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseRequest::with(['case', 'request_type'])->select(sprintf('%s.*', (new CaseRequest())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_request_show';
                $editGate = 'case_request_edit';
                $deleteGate = 'case_request_delete';
                $crudRoutePart = 'case-requests';

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

            $table->editColumn('request', function ($row) {
                return $row->request ? $row->request : '';
            });
            $table->addColumn('request_type_name', function ($row) {
                return $row->request_type ? $row->request_type->name : '';
            });

            $table->editColumn('facility_type', function ($row) {
                return $row->facility_type ? $row->facility_type : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('specific_concern', function ($row) {
                return $row->specific_concern ? $row->specific_concern : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case', 'request_type']);

            return $table->make(true);
        }

        return view('admin.caseRequests.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $request_types = RequestType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseRequests.create', compact('cases', 'request_types'));
    }

    public function store(StoreCaseRequestRequest $request)
    {
        $caseRequest = CaseRequest::create($request->all());

        return to_route('admin.case-requests.index');
    }

    public function edit(CaseRequest $caseRequest)
    {
        abort_if(Gate::denies('case_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $request_types = RequestType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseRequest->load('case', 'request_type');

        return view('admin.caseRequests.edit', compact('caseRequest', 'cases', 'request_types'));
    }

    public function update(UpdateCaseRequestRequest $request, CaseRequest $caseRequest)
    {
        $caseRequest->update($request->all());

        return to_route('admin.case-requests.index');
    }

    public function show(CaseRequest $caseRequest)
    {
        abort_if(Gate::denies('case_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseRequest->load('case', 'request_type');

        return view('admin.caseRequests.show', compact('caseRequest'));
    }

    public function destroy(CaseRequest $caseRequest)
    {
        abort_if(Gate::denies('case_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseRequest->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseRequestRequest $request)
    {
        CaseRequest::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
