<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseListRequest;
use App\Http\Requests\UpdateCaseListRequest;
use App\Http\Resources\Admin\CaseListResource;
use App\Models\CaseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseListsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_list_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseListResource(CaseList::with(['salesman', 'directors', 'industry_type', 'application_types', 'city', 'state', 'country'])->get());
    }

    public function store(StoreCaseListRequest $request)
    {
        $caseList = CaseList::create($request->all());
        $caseList->directors()->sync($request->input('directors', []));
        $caseList->application_types()->sync($request->input('application_types', []));

        return (new CaseListResource($caseList))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseList $caseList)
    {
        abort_if(Gate::denies('case_list_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseListResource($caseList->load(['salesman', 'directors', 'industry_type', 'application_types', 'city', 'state', 'country']));
    }

    public function update(UpdateCaseListRequest $request, CaseList $caseList)
    {
        $caseList->update($request->all());
        $caseList->directors()->sync($request->input('directors', []));
        $caseList->application_types()->sync($request->input('application_types', []));

        return (new CaseListResource($caseList))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseList $caseList)
    {
        abort_if(Gate::denies('case_list_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseList->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
