<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirectorRequest;
use App\Http\Requests\UpdateDirectorRequest;
use App\Http\Resources\Admin\DirectorResource;
use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DirectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('director_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DirectorResource(Director::with(['city', 'state', 'country'])->get());
    }

    public function store(StoreDirectorRequest $request)
    {
        $director = Director::create($request->all());

        return (new DirectorResource($director))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Director $director)
    {
        abort_if(Gate::denies('director_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DirectorResource($director->load(['city', 'state', 'country']));
    }

    public function update(UpdateDirectorRequest $request, Director $director)
    {
        $director->update($request->all());

        return (new DirectorResource($director))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Director $director)
    {
        abort_if(Gate::denies('director_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $director->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
