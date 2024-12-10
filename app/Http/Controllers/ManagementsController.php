<?php

namespace App\Http\Controllers;

use App\Models\Managements;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ManagementsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('management_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Managements::with(['user.roles']);
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->where('created_at','LIKE','%'.$search_input.'%');
                $query->orWhere('commission_rate','LIKE','%'.$search_input.'%');
                $query->orWhereHas('user', function ($queryUsers) use ($search_input){
                    $queryUsers->orWhereHas('roles', function ($query_roles) use ($search_input){
                        $query_roles->where('name','LIKE','%'.$search_input.'%');
                    });
                });
            }
            $query->select(sprintf('%s.*', (new Managements())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name = 'management';
                $permission_name = 'management';
                $except = ['show'];
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row'
                ));
//                $edit_url = route('admin.managements.edit',$row->id);
//                return '<a href="'.$edit_url.'" class="btn btn-xs btn-info text-white"><i class="fa fa-edit fa-lg"></i></a>';
            });
            $table->editColumn('user.name', function ($row){
                return $row->user ? $row->user->name : '';
            });
            $table->editColumn('user.roles', function ($row){
                $roles_name = '';
                foreach($row->user->roles as $role){
                    $roles_name .= $role->name;
                }
                return $roles_name;
            });
            $table->editColumn('commission_rate', function ($row){
                return number_format($row->commission_rate,2);
            });
            $table->rawColumns(['actions','placeholder']);
            return $table->make(true);
        }

        return view('admin.managements.index');
    }

    public function create()
    {
        abort_if(Gate::denies('management_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $existing_user = Managements::all()->pluck('user_id')->toArray();
        $users = User::whereHas('roles', function ($query){
            $query->where('id','!=',3);
        })->whereNotIn('id',$existing_user)->pluck('name', 'id');
        return view('admin.managements.create',compact('users'));
    }

    public function store(Request $request)
    {
        Managements::create($request->all());
        return redirect()->route('admin.management.index')->with('message','Add Management Successfully.');
    }

    public function show(Managements $managements)
    {
        //
    }

    public function edit($id)
    {
        abort_if(Gate::denies('management_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $managements = Managements::find($id);
        $existing_user = Managements::where('user_id','!=',$managements->user_id)->get()->pluck('user_id')->toArray();
        $users = User::whereHas('roles', function ($query){
            $query->where('id','!=',3);
        })->whereNotIn('id',$existing_user)->pluck('name', 'id');
        return view('admin.managements.edit',compact('managements','users'));
    }

    public function update(Request $request, $id)
    {
        Managements::find($id)->update($request->all());
        return redirect()->route('admin.management.index')->with('message','Edit Management Successfully.');
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('management_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Managements::find($id)->delete();
        return redirect()->back();
    }
}
