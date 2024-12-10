<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserTeamRequest;
use App\Http\Requests\StoreUserTeamRequest;
use App\Http\Requests\UpdateUserTeamRequest;
use App\Models\User;
use App\Models\UserTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserTeamController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserTeam::with(['team_lead', 'team_members'])->select(sprintf('%s.*', (new UserTeam())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_team_show';
                $editGate = 'user_team_edit';
                $deleteGate = 'user_team_delete';
                $crudRoutePart = 'user-teams';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->addColumn('team_lead_name', function ($row) {
                return $row->team_lead ? $row->team_lead->name : '';
            });

            $table->editColumn('team_member', function ($row) {
                $labels = [];
                foreach ($row->team_members as $team_member) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $team_member->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'team_lead', 'team_member']);

            return $table->make(true);
        }

        return view('admin.userTeams.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team_leads = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $team_members = User::pluck('name', 'id');

        return view('admin.userTeams.create', compact('team_leads', 'team_members'));
    }

    public function store(StoreUserTeamRequest $request)
    {
        $userTeam = UserTeam::create($request->all());
        $userTeam->team_members()->sync($request->input('team_members', []));

        return to_route('admin.user-teams.index');
    }

    public function edit(UserTeam $userTeam)
    {
        abort_if(Gate::denies('user_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team_leads = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $team_members = User::pluck('name', 'id');

        $userTeam->load('team_lead', 'team_members');

        return view('admin.userTeams.edit', compact('team_leads', 'team_members', 'userTeam'));
    }

    public function update(UpdateUserTeamRequest $request, UserTeam $userTeam)
    {
        $userTeam->update($request->all());
        $userTeam->team_members()->sync($request->input('team_members', []));

        return to_route('admin.user-teams.index');
    }

    public function show(UserTeam $userTeam)
    {
        abort_if(Gate::denies('user_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userTeam->load('team_lead', 'team_members');

        return view('admin.userTeams.show', compact('userTeam'));
    }

    public function destroy(UserTeam $userTeam)
    {
        abort_if(Gate::denies('user_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userTeam->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyUserTeamRequest $request)
    {
        UserTeam::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
