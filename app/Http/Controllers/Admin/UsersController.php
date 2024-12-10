<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Enum\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Bank;
use App\Models\City;
use App\Models\commissionSettings;
use App\Models\Country;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;


class UsersController extends Controller
{
    use CsvImportTrait;

//    public function index(UserDataTable $dataTable, Request $request)
//    {
//        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        return $dataTable->render('admin.users.index');
//    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['roles']);
            // search inputs
            if(isset($request->search_status) && $request->search_status != 'all'){
                $query->where('status',$request->search_status);
            }
            if(isset($request->search_input)){
                $search_input = $request->search_input;
                $query->where('created_at','LIKE','%'.$search_input.'%');
                $query->orWhere('name','LIKE','%'.$search_input.'%');
                $query->orWhere('email','LIKE','%'.$search_input.'%');
                $query->orWhereHas('roles', function ($query_roles) use ($search_input){
                    $query_roles->where('name','LIKE','%'.$search_input.'%');
                });
            }
            $query->select(sprintf('%s.*', (new User())->table));
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name               = 'user';
                $permission_name    = 'user';
                $except             = [''];
                $active             = $row->status->value !== 0;

                if ($row->hasRole('Admin')) {
                    $except = ['show', 'remove', 'destroy'];
                }

                if ($active){
                    $except = ['destroy'];
                }

                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'active'
                ));
            });
            $table->editColumn('roles.name', function ($row){
                return $row->roles->first()?$row->roles->first()->name:"";
            });
            $table->editColumn('status', function ($row) {
                $status_name = $row->status->getName();
                $status_class = ($status_name == 'Active') ? 'green' : 'muted';
                return '<b class="text-'.$status_class.'">'.$status_name.'</b>';
            });
            $table->rawColumns(['actions','placeholder','roles.name','status']);
            return $table->make(true);
        }

        return view('admin.users.index');
    }

    public function store(StoreUserRequest $request)
    {

        $request_data               = $request->except('city','state','country','roles','bank', 'username');
        $request_data['city_id']    = $request->city;
        $request_data['state_id']   = $request->state;
        $request_data['country_id'] = $request->country;
        $request_data['bank_id']    = $request->bank;

        $user = User::create($request_data);
        $user->roles()->sync($request->input('roles', []));

        return to_route('admin.users.index')->with('message','Create User Successfully.');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('name', 'id');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $banks = Bank::pluck('name','id')->prepend(trans('global.pleaseSelect'),'');

        $commission_settings = commissionSettings::pluck('class','id')->prepend(trans('global.pleaseSelect'),'');

        return view('admin.users.create', compact('cities', 'countries', 'roles', 'states', 'banks', 'commission_settings'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('name', 'id');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $banks = Bank::pluck('name','id')->prepend(trans('global.pleaseSelect'),'');

        $commission_settings = commissionSettings::pluck('class','id')->prepend(trans('global.pleaseSelect'),'');

        $user->load('roles', 'city', 'state', 'country', 'bank');

        return view('admin.users.edit', compact('cities', 'countries', 'roles', 'states', 'user', 'banks', 'commission_settings'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $request_data = $request->except('city','state','country','roles', 'bank', 'username');
        $request_data['city_id'] = $request->city;
        $request_data['state_id'] = $request->state;
        $request_data['country_id'] = $request->country;
        $request_data['bank_id'] = $request->bank;

        $user->update($request_data);
        $user->roles()->sync($request->input('roles', []));

        return to_route('admin.users.index')->with('message','Edit User Successfully.');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles', 'city', 'state', 'country', 'bank');

        return view('admin.users.show', compact('user'));
    }

     public function destroy(User $user)
     {
         abort_if(Gate::denies('user_delete_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

         $user->delete();

         return redirect()->back();
     }

    public function remove(User $user)
    {
        abort_if(Gate::denies('user_inactive_2') || $user->name === 'Super Admin', Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->update([
            'status' => Status::Inactive,
        ]);

        return redirect()->back();
    }

    public function restore(User $user)
    {
        abort_if(Gate::denies('user_active_2') || $user->name === 'Super Admin', Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->update([
            'status' => Status::Active,
        ]);

        return redirect()->back();
    }

    // public function massDestroy(MassDestroyUserRequest $request)
    // {
    //     User::whereIn('id', request('ids'))->delete();

    //     return response()->noContent(Response::HTTP_NO_CONTENT);
    // }
}
