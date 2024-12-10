<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCaseReportRecommendationRequest;
use App\Http\Requests\StoreCaseReportRecommendationRequest;
use App\Http\Requests\UpdateCaseReportRecommendationRequest;
use App\Models\CaseList;
use App\Models\CaseReportRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CaseReportRecommendationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('case_report_recommendation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CaseReportRecommendation::with(['case'])->select(sprintf('%s.*', (new CaseReportRecommendation())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'case_report_recommendation_show';
                $editGate = 'case_report_recommendation_edit';
                $deleteGate = 'case_report_recommendation_delete';
                $crudRoutePart = 'case-report-recommendations';

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

            $table->editColumn('recommendation', function ($row) {
                return $row->recommendation ? $row->recommendation : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'case']);

            return $table->make(true);
        }

        return view('admin.caseReportRecommendations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('case_report_recommendation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.caseReportRecommendations.create', compact('cases'));
    }

    public function store(StoreCaseReportRecommendationRequest $request)
    {
        $caseReportRecommendation = CaseReportRecommendation::create($request->all());

        return to_route('admin.case-report-recommendations.index');
    }

    public function edit(CaseReportRecommendation $caseReportRecommendation)
    {
        abort_if(Gate::denies('case_report_recommendation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cases = CaseList::pluck('case_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $caseReportRecommendation->load('case');

        return view('admin.caseReportRecommendations.edit', compact('caseReportRecommendation', 'cases'));
    }

    public function update(UpdateCaseReportRecommendationRequest $request, CaseReportRecommendation $caseReportRecommendation)
    {
        $caseReportRecommendation->update($request->all());

        return to_route('admin.case-report-recommendations.index');
    }

    public function show(CaseReportRecommendation $caseReportRecommendation)
    {
        abort_if(Gate::denies('case_report_recommendation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseReportRecommendation->load('case');

        return view('admin.caseReportRecommendations.show', compact('caseReportRecommendation'));
    }

    public function destroy(CaseReportRecommendation $caseReportRecommendation)
    {
        abort_if(Gate::denies('case_report_recommendation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseReportRecommendation->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyCaseReportRecommendationRequest $request)
    {
        CaseReportRecommendation::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
