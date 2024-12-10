<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RequestTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyRequestTypeRequest;
use App\Http\Requests\StoreRequestTypeRequest;
use App\Http\Requests\UpdateRequestTypeRequest;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RequestTypeController extends Controller
{
    use CsvImportTrait;

//    public function index(RequestTypeDataTable $dataTable, Request $request)
//    {
//        abort_if(Gate::denies('request_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        return $dataTable->render('admin.requestTypes.index');
//    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('request_type_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = RequestType::select();
            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new RequestType())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'request_type';
                $permission_name = 'request_type';
                $except = ['show'];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
            });
            $table->editColumn('status', function ($row) {
                $status = $row->status->getName();
                $class = ($status == 'Active') ? 'green' : 'muted';
                return '<b class="text-'.$class.'">'.$status.'</b>';
            });
            $table->rawColumns(['actions', 'placeholder', 'status']);
            return $table->make(true);
        }
        return view('admin.requestTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('request_type_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestTypes.create');
    }

    public function store(StoreRequestTypeRequest $request)
    {
        $requestType = RequestType::create($request->all());

        return to_route('admin.request-types.index');
    }

    public function edit(RequestType $requestType)
    {
        abort_if(Gate::denies('request_type_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestTypes.edit', compact('requestType'));
    }

    public function update(UpdateRequestTypeRequest $request, RequestType $requestType)
    {
        $requestType->update($request->all());

        return to_route('admin.request-types.index');
    }

    public function show(RequestType $requestType)
    {
        abort_if(Gate::denies('request_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.requestTypes.show', compact('requestType'));
    }

    public function destroy(RequestType $requestType)
    {
        abort_if(Gate::denies('request_type_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requestType->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyRequestTypeRequest $request)
    {
        RequestType::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
