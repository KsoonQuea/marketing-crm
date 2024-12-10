<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFinancingInstrumentRequest;
use App\Http\Requests\StoreFinancingInstrumentRequest;
use App\Http\Requests\UpdateFinancingInstrumentRequest;
use App\Models\FinancingInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FinancingInstrumentController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('financing_instrument_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FinancingInstrument::query()->select(sprintf('%s.*', (new FinancingInstrument())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'financing_instrument_show';
                $editGate = 'financing_instrument_edit';
                $deleteGate = 'financing_instrument_delete';
                $crudRoutePart = 'financing-instruments';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('loan_product', function ($row) {
                return $row->loan_product ? $row->loan_product : '';
            });
            $table->editColumn('interest_rate', function ($row) {
                return $row->interest_rate ? $row->interest_rate : '';
            });
            $table->editColumn('tenor', function ($row) {
                return $row->tenor ? $row->tenor : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.financingInstruments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('financing_instrument_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financingInstruments.create');
    }

    public function store(StoreFinancingInstrumentRequest $request)
    {
        $financingInstrument = FinancingInstrument::create($request->all());

        return to_route('admin.financing-instruments.index');
    }

    public function edit(FinancingInstrument $financingInstrument)
    {
        abort_if(Gate::denies('financing_instrument_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financingInstruments.edit', compact('financingInstrument'));
    }

    public function update(UpdateFinancingInstrumentRequest $request, FinancingInstrument $financingInstrument)
    {
        $financingInstrument->update($request->all());

        return to_route('admin.financing-instruments.index');
    }

    public function show(FinancingInstrument $financingInstrument)
    {
        abort_if(Gate::denies('financing_instrument_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.financingInstruments.show', compact('financingInstrument'));
    }

    public function destroy(FinancingInstrument $financingInstrument)
    {
        abort_if(Gate::denies('financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financingInstrument->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyFinancingInstrumentRequest $request)
    {
        FinancingInstrument::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
