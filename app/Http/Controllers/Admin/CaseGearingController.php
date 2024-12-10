<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseGearingRequest;
use App\Http\Requests\StoreCaseGearingRequest;
use App\Http\Requests\UpdateCaseGearingRequest;
use App\Models\CaseGearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseGearingController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_gearing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseGearing::query()->select(sprintf('%s.*', (new CaseGearing())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_gearing_show';
                $editGate = 'case_gearing_edit';
                $deleteGate = 'case_gearing_delete';
                $crudRoutePart = 'case-gearings';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('borrow_item', function ($row) {
                return $row->borrow_item ? $row->borrow_item : '';
            });
            $table->editColumn('borrow_price', function ($row) {
                return $row->borrow_price ? $row->borrow_price : '';
            });
            $table->editColumn('financing_amount', function ($row) {
                return $row->financing_amount ? $row->financing_amount : '';
            });
            $table->editColumn('bank_redemtion', function ($row) {
                return $row->bank_redemtion ? $row->bank_redemtion : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.caseGearings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_gearing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseGearings.create');
    }

    public function store(StoreCaseGearingRequest $request)
    {
        $caseGearing = CaseGearing::create($request->all());

        return to_route('admin.case-gearings.index');
    }

    public function edit(CaseGearing $caseGearing)
    {
        abort_if(Gate::denies('case_gearing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseGearings.edit', compact('caseGearing'));
    }

    public function update(UpdateCaseGearingRequest $request, CaseGearing $caseGearing)
    {
        $caseGearing->update($request->all());

        return to_route('admin.case-gearings.index');
    }

    public function show(CaseGearing $caseGearing)
    {
        abort_if(Gate::denies('case_gearing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.caseGearings.show', compact('caseGearing'));
    }

    public function destroy(CaseGearing $caseGearing)
    {
        abort_if(Gate::denies('case_gearing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseGearing->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseGearingRequest $request)
    {
        CaseGearing::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
