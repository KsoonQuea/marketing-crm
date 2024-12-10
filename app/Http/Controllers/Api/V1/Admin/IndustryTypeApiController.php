<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIndustryTypeRequest;
use App\Http\Requests\UpdateIndustryTypeRequest;
use App\Http\Resources\Admin\IndustryTypeResource;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class IndustryTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('industry_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IndustryTypeResource(IndustryType::all());
    }

    public function store(StoreIndustryTypeRequest $request)
    {
        $industryType = IndustryType::create($request->all());

        return (new IndustryTypeResource($industryType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(IndustryType $industryType)
    {
        abort_if(Gate::denies('industry_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IndustryTypeResource($industryType);
    }

    public function update(UpdateIndustryTypeRequest $request, IndustryType $industryType)
    {
        $industryType->update($request->all());

        return (new IndustryTypeResource($industryType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(IndustryType $industryType)
    {
        abort_if(Gate::denies('industry_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $industryType->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
