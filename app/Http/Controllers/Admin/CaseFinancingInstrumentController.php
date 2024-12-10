<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseFinancingInstrumentRequest;
use App\Http\Requests\StoreCaseFinancingInstrumentRequest;
use App\Http\Requests\UpdateCaseFinancingInstrumentRequest;
use App\Models\CaseFinancingInstrument;
use App\Models\CaseList;
use App\Models\FinancingInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseFinancingInstrumentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_financing_instrument_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseFinancingInstrument::with(['case', 'financing_instrument'])->select(sprintf('%s.*', (new CaseFinancingInstrument())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_financing_instrument_show';
                $editGate = 'case_financing_instrument_edit';
                $deleteGate = 'case_financing_instrument_delete';
                $crudRoutePart = 'case-financing-instruments';

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

            $table->addColumn('financing_instrument_loan_product', function ($row) {
                return $row->financing_instrument ? $row->financing_instrument->loan_product : '';
            });

            $table->editColumn('proposed_limit', function ($row) {
                return $row->proposed_limit ? $row->proposed_limit : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case', 'financing_instrument']);

            return $table->make(true);
        }

        return view('admin.caseFinancingInstruments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_financing_instrument_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $financing_instruments = FinancingInstrument::pluck('loan_product', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseFinancingInstruments.create', compact('cases', 'financing_instruments'));
    }

    public function store(StoreCaseFinancingInstrumentRequest $request)
    {
        $caseFinancingInstrument = CaseFinancingInstrument::create($request->all());

        return to_route('admin.case-financing-instruments.index');
    }

    public function edit(CaseFinancingInstrument $caseFinancingInstrument)
    {
        abort_if(Gate::denies('case_financing_instrument_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $financing_instruments = FinancingInstrument::pluck('loan_product', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseFinancingInstrument->load('case', 'financing_instrument');

        return view('admin.caseFinancingInstruments.edit', compact('caseFinancingInstrument', 'cases', 'financing_instruments'));
    }

    public function update(UpdateCaseFinancingInstrumentRequest $request, CaseFinancingInstrument $caseFinancingInstrument)
    {
        $caseFinancingInstrument->update($request->all());

        return to_route('admin.case-financing-instruments.index');
    }

    public function show(CaseFinancingInstrument $caseFinancingInstrument)
    {
        abort_if(Gate::denies('case_financing_instrument_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseFinancingInstrument->load('case', 'financing_instrument');

        return view('admin.caseFinancingInstruments.show', compact('caseFinancingInstrument'));
    }

    public function destroy(CaseFinancingInstrument $caseFinancingInstrument)
    {
        abort_if(Gate::denies('case_financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseFinancingInstrument->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseFinancingInstrumentRequest $request)
    {
        CaseFinancingInstrument::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
