<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseDsrRequest;
use App\Http\Requests\UpdateCaseDsrRequest;
use App\Http\Resources\Admin\CaseDsrResource;
use App\Models\CaseDsr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseDsrApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_dsr_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDsrResource(CaseDsr::with(['case'])->get());
    }

    public function store(StoreCaseDsrRequest $request)
    {
        $caseDsr = CaseDsr::create($request->all());

        return (new CaseDsrResource($caseDsr))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseDsr $caseDsr)
    {
        abort_if(Gate::denies('case_dsr_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseDsrResource($caseDsr->load(['case']));
    }

    public function update(UpdateCaseDsrRequest $request, CaseDsr $caseDsr)
    {
        $caseDsr->update($request->all());

        return (new CaseDsrResource($caseDsr))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseDsr $caseDsr)
    {
        abort_if(Gate::denies('case_dsr_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseDsr->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
