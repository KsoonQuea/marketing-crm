<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFinancingInstrumentRequest;
use App\Http\Requests\UpdateFinancingInstrumentRequest;
use App\Http\Resources\Admin\FinancingInstrumentResource;
use App\Models\FinancingInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class FinancingInstrumentApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('financing_instrument_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancingInstrumentResource(FinancingInstrument::all());
    }

    public function store(StoreFinancingInstrumentRequest $request)
    {
        $financingInstrument = FinancingInstrument::create($request->all());

        return (new FinancingInstrumentResource($financingInstrument))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FinancingInstrument $financingInstrument)
    {
        abort_if(Gate::denies('financing_instrument_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FinancingInstrumentResource($financingInstrument);
    }

    public function update(UpdateFinancingInstrumentRequest $request, FinancingInstrument $financingInstrument)
    {
        $financingInstrument->update($request->all());

        return (new FinancingInstrumentResource($financingInstrument))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FinancingInstrument $financingInstrument)
    {
        abort_if(Gate::denies('financing_instrument_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $financingInstrument->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
