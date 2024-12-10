<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseCashflowMonCommitRequest;
use App\Http\Requests\UpdateCaseCashflowMonCommitRequest;
use App\Http\Resources\Admin\CaseCashflowMonCommitResource;
use App\Models\CaseCashflowMonCommit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCashflowMonCommitApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCashflowMonCommitResource(CaseCashflowMonCommit::with(['case'])->get());
    }

    public function store(StoreCaseCashflowMonCommitRequest $request)
    {
        $caseCashflowMonCommit = CaseCashflowMonCommit::create($request->all());

        return (new CaseCashflowMonCommitResource($caseCashflowMonCommit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCashflowMonCommitResource($caseCashflowMonCommit->load(['case']));
    }

    public function update(UpdateCaseCashflowMonCommitRequest $request, CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        $caseCashflowMonCommit->update($request->all());

        return (new CaseCashflowMonCommitResource($caseCashflowMonCommit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseCashflowMonCommit $caseCashflowMonCommit)
    {
        abort_if(Gate::denies('case_cashflow_mon_commit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCashflowMonCommit->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
