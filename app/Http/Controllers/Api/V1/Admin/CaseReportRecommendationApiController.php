<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseReportRecommendationRequest;
use App\Http\Requests\UpdateCaseReportRecommendationRequest;
use App\Http\Resources\Admin\CaseReportRecommendationResource;
use App\Models\CaseReportRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseReportRecommendationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_report_recommendation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseReportRecommendationResource(CaseReportRecommendation::with(['case'])->get());
    }

    public function store(StoreCaseReportRecommendationRequest $request)
    {
        $caseReportRecommendation = CaseReportRecommendation::create($request->all());

        return (new CaseReportRecommendationResource($caseReportRecommendation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseReportRecommendation $caseReportRecommendation)
    {
        abort_if(Gate::denies('case_report_recommendation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseReportRecommendationResource($caseReportRecommendation->load(['case']));
    }

    public function update(UpdateCaseReportRecommendationRequest $request, CaseReportRecommendation $caseReportRecommendation)
    {
        $caseReportRecommendation->update($request->all());

        return (new CaseReportRecommendationResource($caseReportRecommendation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseReportRecommendation $caseReportRecommendation)
    {
        abort_if(Gate::denies('case_report_recommendation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseReportRecommendation->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
