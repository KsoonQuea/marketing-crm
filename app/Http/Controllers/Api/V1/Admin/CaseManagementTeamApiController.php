<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCaseManagementTeamRequest;
use App\Http\Requests\UpdateCaseManagementTeamRequest;
use App\Http\Resources\Admin\CaseManagementTeamResource;
use App\Models\CaseManagementTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CaseManagementTeamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('case_management_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseManagementTeamResource(CaseManagementTeam::with(['case'])->get());
    }

    public function store(StoreCaseManagementTeamRequest $request)
    {
        $caseManagementTeam = CaseManagementTeam::create($request->all());

        return (new CaseManagementTeamResource($caseManagementTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CaseManagementTeam $caseManagementTeam)
    {
        abort_if(Gate::denies('case_management_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CaseManagementTeamResource($caseManagementTeam->load(['case']));
    }

    public function update(UpdateCaseManagementTeamRequest $request, CaseManagementTeam $caseManagementTeam)
    {
        $caseManagementTeam->update($request->all());

        return (new CaseManagementTeamResource($caseManagementTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CaseManagementTeam $caseManagementTeam)
    {
        abort_if(Gate::denies('case_management_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $caseManagementTeam->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
