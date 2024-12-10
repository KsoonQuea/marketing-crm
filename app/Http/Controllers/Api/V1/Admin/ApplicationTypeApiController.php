<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationTypeRequest;
use App\Http\Requests\UpdateApplicationTypeRequest;
use App\Http\Resources\Admin\ApplicationTypeResource;
use App\Models\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ApplicationTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('application_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ApplicationTypeResource(ApplicationType::all());
    }

    public function store(StoreApplicationTypeRequest $request)
    {
        $applicationType = ApplicationType::create($request->all());

        return (new ApplicationTypeResource($applicationType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ApplicationType $applicationType)
    {
        abort_if(Gate::denies('application_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ApplicationTypeResource($applicationType);
    }

    public function update(UpdateApplicationTypeRequest $request, ApplicationType $applicationType)
    {
        $applicationType->update($request->all());

        return (new ApplicationTypeResource($applicationType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ApplicationType $applicationType)
    {
        abort_if(Gate::denies('application_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $applicationType->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
