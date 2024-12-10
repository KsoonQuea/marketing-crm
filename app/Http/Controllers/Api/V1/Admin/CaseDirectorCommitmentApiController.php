<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseDirectorCommitmentRequest;
use App\Http\Requests\UpdateCaseDirectorCommitmentRequest;
use App\Http\Resources\Admin\CaseDirectorCommitmentResource;
use App\Models\CaseDirectorCommitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseDirectorCommitmentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_director_commitment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDirectorCommitmentResource(CaseDirectorCommitment::with(['case'])->get());
    }

    public function store(StoreCaseDirectorCommitmentRequest $request)
    {
        $caseDirectorCommitment = CaseDirectorCommitment::create($request->all());

        return (new CaseDirectorCommitmentResource($caseDirectorCommitment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseDirectorCommitment $caseDirectorCommitment)
    {
        abort_if(Gate::denies('case_director_commitment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDirectorCommitmentResource($caseDirectorCommitment->load(['case']));
    }

    public function update(UpdateCaseDirectorCommitmentRequest $request, CaseDirectorCommitment $caseDirectorCommitment)
    {
        $caseDirectorCommitment->update($request->all());

        return (new CaseDirectorCommitmentResource($caseDirectorCommitment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseDirectorCommitment $caseDirectorCommitment)
    {
        abort_if(Gate::denies('case_director_commitment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDirectorCommitment->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
