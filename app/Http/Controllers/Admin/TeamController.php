<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TeamDataTable;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('team_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if ($request->ajax()) {
            $query = Team::with(['team_lead','users']);
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->where('created_at','LIKE','%'.$search_input.'%');
                $query->orWhere('name','LIKE','%'.$search_input.'%');
                $query->orWhereHas('team_lead', function ($queryTeamLead) use ($search_input){
                    $queryTeamLead->where('name','LIKE','%'.$search_input.'%');
                });
                $query->orWhereHas('users', function ($queryTeamLead) use ($search_input){
                    $queryTeamLead->where('name','LIKE','%'.$search_input.'%');
                });
            }
            $query->select(sprintf('%s.*', (new Team())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'team';
                $permission_name = 'team';
                $except = ['show'];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
            });
            $table->addColumn('members', function ($row){
                $members = [];
                foreach($row->users as $rowUser){
                    array_push($members,$rowUser->name);
                }
                return implode(", ",$members);
            });
            $table->rawColumns(['actions','placeholder','members']);
            return $table->make(true);
        }
        return view('admin.teams.index');
    }

    public function create(): Factory|View
    {
        abort_if(Gate::denies('team_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = DB::table('users')
        ->join('model_has_roles','users.id','=','model_id')
        ->where('role_id','=','3')
        ->where('model_type','=','App\Models\User')
        ->pluck('name', 'id');

        $sales_manager = DB::table('users')
            ->join('model_has_roles','users.id','=','model_id')
            ->where('role_id','=','4')
            ->where('model_type','=','App\Models\User')
            ->pluck('name', 'id');

        return view('admin.teams.create', compact('users', 'sales_manager'));
    }

    public function check(Request $request)
    {
        $name = $request->leader;
        $users= DB::table('users')
        ->join('model_has_roles','users.id','=','model_id')
        ->where('role_id','=','3')
        ->where('model_type','=','App\Models\User')
        ->pluck('name', 'id');
        foreach($users as $id => $u){
            if($id == $name){
                unset($users[$id]);
            }
        }
        return response()->json($users->all());
    }

    public function store(StoreTeamRequest $request): RedirectResponse
    {
        $request_data = $request->except('leadername','member');
        $request_data['team_lead_id'] = $request->leadername;
        $team = Team::create($request_data);
        $team->users()->attach($request->input('member', []));
        return to_route('admin.teams.index')->with('message','Create Team Successfully.');
    }

    public function edit(Team $team): Factory|View
    {
        abort_if(Gate::denies('team_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users          = User::getUserViaRole(3)->pluck('name', 'id');
        $sales_manager  = User::getUserViaRole(4)->pluck('name', 'id');
        $team_id        = $team->id;
        $teammate       = User::whereHas('teams', function ($query) use ($team_id){
                                $query->where('id',$team_id);
                            })->get()->pluck('id')->toArray();
//        $teammate_array = array();
//        foreach($teammate as $t){
//            array_push($teammate_array, $t->id );
//        }

        return view('admin.teams.edit', compact('team','users','teammate', 'sales_manager'));
    }

    public function update(UpdateTeamRequest $request, Team $team): RedirectResponse
    {
        $request_data = $request->except('leadername','member');
        $request_data['team_lead_id'] = $request->leadername;
        $team->update($request_data);
        $team->users()->sync($request->input('member', []));

        return to_route('admin.teams.index')->with('message','Edit Team Successfully.');
    }

    public function show(Team $team): Factory|View
    {
        abort_if(Gate::denies('team_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $team->load('teamUsers');

        return view('admin.teams.show', compact('team'));
    }

    public function destroy(Team $team)
    {
        abort_if(Gate::denies('team_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->delete();

        return redirect()->back();
    }
}
