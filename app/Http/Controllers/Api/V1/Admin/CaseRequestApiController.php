<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseRequestRequest;
use App\Http\Requests\UpdateCaseRequestRequest;
use App\Http\Resources\Admin\CaseRequestResource;
use App\Models\CaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseRequestApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseRequestResource(CaseRequest::with(['case', 'request_type'])->get());
    }

    public function store(StoreCaseRequestRequest $request)
    {
        $caseRequest = CaseRequest::create($request->all());

        return (new CaseRequestResource($caseRequest))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseRequest $caseRequest)
    {
        abort_if(Gate::denies('case_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseRequestResource($caseRequest->load(['case', 'request_type']));
    }

    public function update(UpdateCaseRequestRequest $request, CaseRequest $caseRequest)
    {
        $caseRequest->update($request->all());

        return (new CaseRequestResource($caseRequest))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseRequest $caseRequest)
    {
        abort_if(Gate::denies('case_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseRequest->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
