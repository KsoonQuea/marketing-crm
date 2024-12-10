<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseGearingRequest;
use App\Http\Requests\UpdateCaseGearingRequest;
use App\Http\Resources\Admin\CaseGearingResource;
use App\Models\CaseGearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseGearingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_gearing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseGearingResource(CaseGearing::all());
    }

    public function store(StoreCaseGearingRequest $request)
    {
        $caseGearing = CaseGearing::create($request->all());

        return (new CaseGearingResource($caseGearing))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseGearing $caseGearing)
    {
        abort_if(Gate::denies('case_gearing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseGearingResource($caseGearing);
    }

    public function update(UpdateCaseGearingRequest $request, CaseGearing $caseGearing)
    {
        $caseGearing->update($request->all());

        return (new CaseGearingResource($caseGearing))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseGearing $caseGearing)
    {
        abort_if(Gate::denies('case_gearing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseGearing->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
