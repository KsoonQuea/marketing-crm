<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCaseCriterionRequest;
use App\Http\Requests\StoreCaseCriterionRequest;
use App\Http\Requests\UpdateCaseCriterionRequest;
use App\Models\CaseCriterion;
use App\Models\CaseList;
use App\Models\Criterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseCriteriaController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('case_criterion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseCriterion::with(['case', 'criteria'])->select(sprintf('%s.*', (new CaseCriterion())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_criterion_show';
                $editGate = 'case_criterion_edit';
                $deleteGate = 'case_criterion_delete';
                $crudRoutePart = 'case-criteria';

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

            $table->addColumn('criteria_name', function ($row) {
                return $row->criteria ? $row->criteria->name : '';
            });

            $table->editColumn('answer', function ($row) {
                return $row->answer ? CaseCriterion::ANSWER_SELECT[$row->answer] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case', 'criteria']);

            return $table->make(true);
        }

        return view('admin.caseCriteria.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_criterion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $criterias = Criterion::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseCriteria.create', compact('cases', 'criterias'));
    }

    public function store(StoreCaseCriterionRequest $request)
    {
        $caseCriterion = CaseCriterion::create($request->all());

        return to_route('admin.case-criteria.index');
    }

    public function edit(CaseCriterion $caseCriterion)
    {
        abort_if(Gate::denies('case_criterion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $criterias = Criterion::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseCriterion->load('case', 'criteria');

        return view('admin.caseCriteria.edit', compact('caseCriterion', 'cases', 'criterias'));
    }

    public function update(UpdateCaseCriterionRequest $request, CaseCriterion $caseCriterion)
    {
        $caseCriterion->update($request->all());

        return to_route('admin.case-criteria.index');
    }

    public function show(CaseCriterion $caseCriterion)
    {
        abort_if(Gate::denies('case_criterion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCriterion->load('case', 'criteria');

        return view('admin.caseCriteria.show', compact('caseCriterion'));
    }

    public function destroy(CaseCriterion $caseCriterion)
    {
        abort_if(Gate::denies('case_criterion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCriterion->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseCriterionRequest $request)
    {
        CaseCriterion::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
