<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserTeamRequest;
use App\Http\Requests\UpdateUserTeamRequest;
use App\Http\Resources\Admin\UserTeamResource;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserTeamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserTeamResource(UserTeam::with(['team_lead', 'team_members'])->get());
    }

    public function store(StoreUserTeamRequest $request)
    {
        $userTeam = UserTeam::create($request->all());
        $userTeam->team_members()->sync($request->input('team_members', []));

        return (new UserTeamResource($userTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserTeam $userTeam)
    {
        abort_if(Gate::denies('user_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserTeamResource($userTeam->load(['team_lead', 'team_members']));
    }

    public function update(UpdateUserTeamRequest $request, UserTeam $userTeam)
    {
        $userTeam->update($request->all());
        $userTeam->team_members()->sync($request->input('team_members', []));

        return (new UserTeamResource($userTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserTeam $userTeam)
    {
        abort_if(Gate::denies('user_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userTeam->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
