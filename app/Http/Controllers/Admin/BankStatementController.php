<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBankStatementRequest;
use App\Http\Requests\StoreBankStatementRequest;
use App\Http\Requests\UpdateBankStatementRequest;
use App\Models\Bank;
use App\Models\BankStatement;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BankStatementController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('bank_statement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BankStatement::with(['bank', 'case'])->select(sprintf('%s.*', (new BankStatement())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'bank_statement_show';
                $editGate = 'bank_statement_edit';
                $deleteGate = 'bank_statement_delete';
                $crudRoutePart = 'bank-statements';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->addColumn('bank_name', function ($row) {
                return $row->bank ? $row->bank->name : '';
            });

            $table->addColumn('case_case_code', function ($row) {
                return $row->case ? $row->case->case_code : '';
            });

            $table->editColumn('bank_owner', function ($row) {
                return $row->bank_owner ? $row->bank_owner : '';
            });
            $table->editColumn('bank_account', function ($row) {
                return $row->bank_account ? $row->bank_account : '';
            });
            $table->editColumn('credit', function ($row) {
                return $row->credit ? $row->credit : '';
            });
            $table->editColumn('debit', function ($row) {
                return $row->debit ? $row->debit : '';
            });
            $table->editColumn('month_end_balance', function ($row) {
                return $row->month_end_balance ? $row->month_end_balance : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'bank', 'case']);

            return $table->make(true);
        }

        return view('admin.bankStatements.index');
    }

    public function create()
    {
        abort_if(Gate::denies('bank_statement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banks = Bank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bankStatements.create', compact('banks', 'cases'));
    }

    public function store(StoreBankStatementRequest $request)
    {
        $bankStatement = BankStatement::create($request->all());

        return to_route('admin.bank-statements.index');
    }

    public function edit(BankStatement $bankStatement)
    {
        abort_if(Gate::denies('bank_statement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banks = Bank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bankStatement->load('bank', 'case');

        return view('admin.bankStatements.edit', compact('bankStatement', 'banks', 'cases'));
    }

    public function update(UpdateBankStatementRequest $request, BankStatement $bankStatement)
    {
        $bankStatement->update($request->all());

        return to_route('admin.bank-statements.index');
    }

    public function show(BankStatement $bankStatement)
    {
        abort_if(Gate::denies('bank_statement_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankStatement->load('bank', 'case');

        return view('admin.bankStatements.show', compact('bankStatement'));
    }

    public function destroy(BankStatement $bankStatement)
    {
        abort_if(Gate::denies('bank_statement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bankStatement->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyBankStatementRequest $request)
    {
        BankStatement::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
