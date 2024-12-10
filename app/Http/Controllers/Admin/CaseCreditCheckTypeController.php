<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CaseCreditCheckTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseCreditCheckTypeRequest;
use App\Http\Requests\StoreCaseCreditCheckTypeRequest;
use App\Http\Requests\UpdateCaseCreditCheckTypeRequest;
use App\Models\CaseCreditCheckType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseCreditCheckTypeController extends Controller
{
    use CsvImportTrait;

//    public function index(CaseCreditCheckTypeDataTable $dataTable, Request $request)
//    {
//        abort_if(Gate::denies('case_credit_check_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        return $dataTable->render('admin.caseCreditCheckTypes.index');
//    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('credit_check_type_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseCreditCheckType::select();
            // search inputs
            if (isset($request->search_status) && $request->search_status != 'all') {
                $query->where('status', $request->search_status);
            }
            if (isset($request->search_input)) {
                $search_input = $request->search_input;
                $query->where('name', 'LIKE', '%' . $search_input . '%');
            }
            $query->select(sprintf('%s.*', (new CaseCreditCheckType())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'case_credit_check_type';
                $permission_name = 'credit_check_type';
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
        return view('admin.caseCreditCheckTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('credit_check_type_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseCreditCheckTypes.create');
    }

    public function store(StoreCaseCreditCheckTypeRequest $request)
    {
        $caseCreditCheckType = CaseCreditCheckType::create($request->all());

        return to_route('admin.case-credit-check-types.index');
    }

    public function edit(CaseCreditCheckType $caseCreditCheckType)
    {
        abort_if(Gate::denies('credit_check_type_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseCreditCheckTypes.edit', compact('caseCreditCheckType'));
    }

    public function update(UpdateCaseCreditCheckTypeRequest $request, CaseCreditCheckType $caseCreditCheckType)
    {
        $caseCreditCheckType->update($request->all());

        return to_route('admin.case-credit-check-types.index');
    }

    public function show(CaseCreditCheckType $caseCreditCheckType)
    {
        abort_if(Gate::denies('case_credit_check_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseCreditCheckTypes.show', compact('caseCreditCheckType'));
    }

    public function destroy(CaseCreditCheckType $caseCreditCheckType)
    {
        abort_if(Gate::denies('credit_check_type_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCreditCheckType->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCreditCheckTypeRequest $request)
    {
        CaseCreditCheckType::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
