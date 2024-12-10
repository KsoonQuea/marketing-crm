<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseFinancingInstrumentRequest;
use App\Http\Requests\UpdateCaseFinancingInstrumentRequest;
use App\Http\Resources\Admin\CaseFinancingInstrumentResource;
use App\Models\CaseFinancingInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseFinancingInstrumentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_financing_instrument_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseFinancingInstrumentResource(CaseFinancingInstrument::with(['case', 'financing_instrument'])->get());
    }

    public function store(StoreCaseFinancingInstrumentRequest $request)
    {
        $caseFinancingInstrument = CaseFinancingInstrument::create($request->all());

        return (new CaseFinancingInstrumentResource($caseFinancingInstrument))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseFinancingInstrument $caseFinancingInstrument)
    {
        abort_if(Gate::denies('case_financing_instrument_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseFinancingInstrumentResource($caseFinancingInstrument->load(['case', 'financing_instrument']));
    }

    public function update(UpdateCaseFinancingInstrumentRequest $request, CaseFinancingInstrument $caseFinancingInstrument)
    {
        $caseFinancingInstrument->update($request->all());

        return (new CaseFinancingInstrumentResource($caseFinancingInstrument))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseFinancingInstrument $caseFinancingInstrument)
    {
        abort_if(Gate::denies('case_financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseFinancingInstrument->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
