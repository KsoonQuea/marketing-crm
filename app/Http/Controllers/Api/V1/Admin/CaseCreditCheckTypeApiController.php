<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseCreditCheckTypeRequest;
use App\Http\Requests\UpdateCaseCreditCheckTypeRequest;
use App\Http\Resources\Admin\CaseCreditCheckTypeResource;
use App\Models\CaseCreditCheckType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCreditCheckTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_credit_check_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCreditCheckTypeResource(CaseCreditCheckType::all());
    }

    public function store(StoreCaseCreditCheckTypeRequest $request)
    {
        $caseCreditCheckType = CaseCreditCheckType::create($request->all());

        return (new CaseCreditCheckTypeResource($caseCreditCheckType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseCreditCheckType $caseCreditCheckType)
    {
        abort_if(Gate::denies('case_credit_check_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCreditCheckTypeResource($caseCreditCheckType);
    }

    public function update(UpdateCaseCreditCheckTypeRequest $request, CaseCreditCheckType $caseCreditCheckType)
    {
        $caseCreditCheckType->update($request->all());

        return (new CaseCreditCheckTypeResource($caseCreditCheckType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseCreditCheckType $caseCreditCheckType)
    {
        abort_if(Gate::denies('case_credit_check_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCreditCheckType->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
