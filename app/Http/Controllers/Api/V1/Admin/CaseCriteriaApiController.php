<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseCriterionRequest;
use App\Http\Requests\UpdateCaseCriterionRequest;
use App\Http\Resources\Admin\CaseCriterionResource;
use App\Models\CaseCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCriteriaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_criterion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCriterionResource(CaseCriterion::with(['case', 'criteria'])->get());
    }

    public function store(StoreCaseCriterionRequest $request)
    {
        $caseCriterion = CaseCriterion::create($request->all());

        return (new CaseCriterionResource($caseCriterion))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseCriterion $caseCriterion)
    {
        abort_if(Gate::denies('case_criterion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCriterionResource($caseCriterion->load(['case', 'criteria']));
    }

    public function update(UpdateCaseCriterionRequest $request, CaseCriterion $caseCriterion)
    {
        $caseCriterion->update($request->all());

        return (new CaseCriterionResource($caseCriterion))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseCriterion $caseCriterion)
    {
        abort_if(Gate::denies('case_criterion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCriterion->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
