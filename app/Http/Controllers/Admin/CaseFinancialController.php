<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseFinancialRequest;
use App\Http\Requests\StoreCaseFinancialRequest;
use App\Http\Requests\UpdateCaseFinancialRequest;
use App\Models\CaseFinancial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseFinancialController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_financial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseFinancial::query()->select(sprintf('%s.*', (new CaseFinancial())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_financial_show';
                $editGate = 'case_financial_edit';
                $deleteGate = 'case_financial_delete';
                $crudRoutePart = 'case-financials';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('current_asset', function ($row) {
                return $row->current_asset ? $row->current_asset : '';
            });
            $table->editColumn('non_current_asset', function ($row) {
                return $row->non_current_asset ? $row->non_current_asset : '';
            });
            $table->editColumn('director_asset', function ($row) {
                return $row->director_asset ? $row->director_asset : '';
            });
            $table->editColumn('related_customer_asset', function ($row) {
                return $row->related_customer_asset ? $row->related_customer_asset : '';
            });
            $table->editColumn('customer_asset', function ($row) {
                return $row->customer_asset ? $row->customer_asset : '';
            });
            $table->editColumn('current_liabilities', function ($row) {
                return $row->current_liabilities ? $row->current_liabilities : '';
            });
            $table->editColumn('non_current_liabilities', function ($row) {
                return $row->non_current_liabilities ? $row->non_current_liabilities : '';
            });
            $table->editColumn('director_liabilities', function ($row) {
                return $row->director_liabilities ? $row->director_liabilities : '';
            });
            $table->editColumn('related_customer_liabilities', function ($row) {
                return $row->related_customer_liabilities ? $row->related_customer_liabilities : '';
            });
            $table->editColumn('customer_liabilities', function ($row) {
                return $row->customer_liabilities ? $row->customer_liabilities : '';
            });
            $table->editColumn('loan_n_hp', function ($row) {
                return $row->loan_n_hp ? $row->loan_n_hp : '';
            });
            $table->editColumn('share_capital', function ($row) {
                return $row->share_capital ? $row->share_capital : '';
            });
            $table->editColumn('revenue', function ($row) {
                return $row->revenue ? $row->revenue : '';
            });
            $table->editColumn('sales_cost', function ($row) {
                return $row->sales_cost ? $row->sales_cost : '';
            });
            $table->editColumn('finance_cost', function ($row) {
                return $row->finance_cost ? $row->finance_cost : '';
            });
            $table->editColumn('depreciation', function ($row) {
                return $row->depreciation ? $row->depreciation : '';
            });
            $table->editColumn('profit', function ($row) {
                return $row->profit ? $row->profit : '';
            });
            $table->editColumn('tax', function ($row) {
                return $row->tax ? $row->tax : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.caseFinancials.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_financial_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseFinancials.create');
    }

    public function store(StoreCaseFinancialRequest $request)
    {
        $caseFinancial = CaseFinancial::create($request->all());

        return to_route('admin.case-financials.index');
    }

    public function edit(CaseFinancial $caseFinancial)
    {
        abort_if(Gate::denies('case_financial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseFinancials.edit', compact('caseFinancial'));
    }

    public function update(UpdateCaseFinancialRequest $request, CaseFinancial $caseFinancial)
    {
        $caseFinancial->update($request->all());

        return to_route('admin.case-financials.index');
    }

    public function show(CaseFinancial $caseFinancial)
    {
        abort_if(Gate::denies('case_financial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseFinancials.show', compact('caseFinancial'));
    }

    public function destroy(CaseFinancial $caseFinancial)
    {
        abort_if(Gate::denies('case_financial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseFinancial->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseFinancialRequest $request)
    {
        CaseFinancial::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
