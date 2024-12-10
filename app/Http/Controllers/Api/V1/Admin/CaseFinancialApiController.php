<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseFinancialRequest;
use App\Http\Requests\UpdateCaseFinancialRequest;
use App\Http\Resources\Admin\CaseFinancialResource;
use App\Models\CaseFinancial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseFinancialApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_financial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseFinancialResource(CaseFinancial::all());
    }

    public function store(StoreCaseFinancialRequest $request)
    {
        $caseFinancial = CaseFinancial::create($request->all());

        return (new CaseFinancialResource($caseFinancial))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseFinancial $caseFinancial)
    {
        abort_if(Gate::denies('case_financial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseFinancialResource($caseFinancial);
    }

    public function update(UpdateCaseFinancialRequest $request, CaseFinancial $caseFinancial)
    {
        $caseFinancial->update($request->all());

        return (new CaseFinancialResource($caseFinancial))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseFinancial $caseFinancial)
    {
        abort_if(Gate::denies('case_financial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseFinancial->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
