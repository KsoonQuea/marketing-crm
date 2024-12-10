<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseCashflowMonCommitRequest;
use App\Http\Requests\StoreCaseCashflowMonCommitRequest;
use App\Http\Requests\UpdateCaseCashflowMonCommitRequest;
use App\Models\CaseCashflowMonCommit;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseCashflowMonCommitController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseCashflowMonCommit::with(['case'])->select(sprintf('%s.*', (new CaseCashflowMonCommit())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_cashflow_mon_commit_show';
                $editGate = 'case_cashflow_mon_commit_edit';
                $deleteGate = 'case_cashflow_mon_commit_delete';
                $crudRoutePart = 'case-cashflow-mon-commits';

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

            $table->editColumn('avg_mon_end_bank_balances', function ($row) {
                return $row->avg_mon_end_bank_balances ? $row->avg_mon_end_bank_balances : '';
            });
            $table->editColumn('avg_mon_credit_transactions', function ($row) {
                return $row->avg_mon_credit_transactions ? $row->avg_mon_credit_transactions : '';
            });
            $table->editColumn('mon_commitment', function ($row) {
                return $row->mon_commitment ? $row->mon_commitment : '';
            });
            $table->editColumn('tot_mon_commitment_for_directors', function ($row) {
                return $row->tot_mon_commitment_for_directors ? $row->tot_mon_commitment_for_directors : '';
            });
            $table->editColumn('tot_mon_commitment_of_directors_and_company', function ($row) {
                return $row->tot_mon_commitment_of_directors_and_company ? $row->tot_mon_commitment_of_directors_and_company : '';
            });
            $table->editColumn('annualized_revenue', function ($row) {
                return $row->annualized_revenue ? $row->annualized_revenue : '';
            });
            $table->editColumn('income_factor', function ($row) {
                return $row->income_factor ? $row->income_factor : '';
            });
            $table->editColumn('dsr', function ($row) {
                return $row->dsr ? $row->dsr : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseCashflowMonCommits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseCashflowMonCommits.create', compact('cases'));
    }

    public function store(StoreCaseCashflowMonCommitRequest $request)
    {
        $caseCashflowMonCommit = CaseCashflowMonCommit::create($request->all());

        return to_route('admin.case-cashflow-mon-commits.index');
    }

    public function edit(CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseCashflowMonCommit->load('case');

        return view('admin.caseCashflowMonCommits.edit', compact('caseCashflowMonCommit', 'cases'));
    }

    public function update(UpdateCaseCashflowMonCommitRequest $request, CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        $caseCashflowMonCommit->update($request->all());

        return to_route('admin.case-cashflow-mon-commits.index');
    }

    public function show(CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCashflowMonCommit->load('case');

        return view('admin.caseCashflowMonCommits.show', compact('caseCashflowMonCommit'));
    }

    public function destroy(CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCashflowMonCommit->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCashflowMonCommitRequest $request)
    {
        CaseCashflowMonCommit::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
