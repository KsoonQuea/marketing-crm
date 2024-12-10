<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseCreditCheckRequest;
use App\Http\Requests\StoreCaseCreditCheckRequest;
use App\Http\Requests\UpdateCaseCreditCheckRequest;
use App\Models\CaseCreditCheck;
use App\Models\CaseCreditCheckType;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseCreditCheckController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_credit_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseCreditCheck::with(['case', 'credit_check'])->select(sprintf('%s.*', (new CaseCreditCheck())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_credit_check_show';
                $editGate = 'case_credit_check_edit';
                $deleteGate = 'case_credit_check_delete';
                $crudRoutePart = 'case-credit-checks';

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

            $table->addColumn('credit_check_name', function ($row) {
                return $row->credit_check ? $row->credit_check->name : '';
            });

            $table->editColumn('finding', function ($row) {
                return $row->finding ? $row->finding : '';
            });
            $table->editColumn('migration', function ($row) {
                return $row->migration ? $row->migration : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case', 'credit_check']);

            return $table->make(true);
        }

        return view('admin.caseCreditChecks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_credit_check_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $credit_checks = CaseCreditCheckType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseCreditChecks.create', compact('cases', 'credit_checks'));
    }

    public function store(StoreCaseCreditCheckRequest $request)
    {
        $caseCreditCheck = CaseCreditCheck::create($request->all());

        return to_route('admin.case-credit-checks.index');
    }

    public function edit(CaseCreditCheck $caseCreditCheck)
    {
        abort_if(Gate::denies('case_credit_check_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $credit_checks = CaseCreditCheckType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseCreditCheck->load('case', 'credit_check');

        return view('admin.caseCreditChecks.edit', compact('caseCreditCheck', 'cases', 'credit_checks'));
    }

    public function update(UpdateCaseCreditCheckRequest $request, CaseCreditCheck $caseCreditCheck)
    {
        $caseCreditCheck->update($request->all());

        return to_route('admin.case-credit-checks.index');
    }

    public function show(CaseCreditCheck $caseCreditCheck)
    {
        abort_if(Gate::denies('case_credit_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCreditCheck->load('case', 'credit_check');

        return view('admin.caseCreditChecks.show', compact('caseCreditCheck'));
    }

    public function destroy(CaseCreditCheck $caseCreditCheck)
    {
        abort_if(Gate::denies('case_credit_check_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCreditCheck->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCreditCheckRequest $request)
    {
        CaseCreditCheck::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
