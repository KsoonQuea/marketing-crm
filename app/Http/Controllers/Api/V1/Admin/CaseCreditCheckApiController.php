<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseCreditCheckRequest;
use App\Http\Requests\UpdateCaseCreditCheckRequest;
use App\Http\Resources\Admin\CaseCreditCheckResource;
use App\Models\CaseCreditCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseCreditCheckApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_credit_check_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCreditCheckResource(CaseCreditCheck::with(['case', 'credit_check'])->get());
    }

    public function store(StoreCaseCreditCheckRequest $request)
    {
        $caseCreditCheck = CaseCreditCheck::create($request->all());

        return (new CaseCreditCheckResource($caseCreditCheck))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseCreditCheck $caseCreditCheck)
    {
        abort_if(Gate::denies('case_credit_check_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseCreditCheckResource($caseCreditCheck->load(['case', 'credit_check']));
    }

    public function update(UpdateCaseCreditCheckRequest $request, CaseCreditCheck $caseCreditCheck)
    {
        $caseCreditCheck->update($request->all());

        return (new CaseCreditCheckResource($caseCreditCheck))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseCreditCheck $caseCreditCheck)
    {
        abort_if(Gate::denies('case_credit_check_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseCreditCheck->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
