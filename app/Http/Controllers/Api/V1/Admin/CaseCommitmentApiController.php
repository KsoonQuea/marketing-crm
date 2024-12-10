<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseCommitmentRequest;
use App\Http\Requests\UpdateCaseCommitmentRequest;
use App\Http\Resources\Admin\CaseCommitmentResource;
use App\Models\CaseCommitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCommitmentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_commitment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCommitmentResource(CaseCommitment::with(['case'])->get());
    }

    public function store(StoreCaseCommitmentRequest $request)
    {
        $caseCommitment = CaseCommitment::create($request->all());

        return (new CaseCommitmentResource($caseCommitment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseCommitment $caseCommitment)
    {
        abort_if(Gate::denies('case_commitment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCommitmentResource($caseCommitment->load(['case']));
    }

    public function update(UpdateCaseCommitmentRequest $request, CaseCommitment $caseCommitment)
    {
        $caseCommitment->update($request->all());

        return (new CaseCommitmentResource($caseCommitment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseCommitment $caseCommitment)
    {
        abort_if(Gate::denies('case_commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCommitment->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
