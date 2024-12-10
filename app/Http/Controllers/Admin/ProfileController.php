<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\User;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileController extends Controller
{
    use CsvImportTrait;
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('name', 'id');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user = User::where('id', '=', $id)->first();

        $user->load('roles', 'city', 'state', 'country');

        return view('admin.profile.edit', compact('cities', 'countries', 'roles', 'states', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, User $user,$id)
    {
        $user = User::where('id', '=', $id)->first();


        if(($request->oldpassword || $request->newpassword ||$request->twopassword) !=null){
            if(Hash::check($request->oldpassword, $user->password)){
                if(!is_null($request->newpassword) && ($request->newpassword == $request->twopassword) && !is_null($request->twopassword)){
                    $request_data = $request->except('roles','oldpassword','newpassword','twopassword','avatar');
                    $request_data['password'] = $request->newpassword;
                    $user->update($request_data);
                    // $user->addFromMediaLibraryRequest($request->avatar)->toMediaCollection('avatar');
                    if (isset($request->avatar)) {
                        if (isset($user->avatar)){
                            $user->clearMediaCollection('avatar');
                        }
                        $user->addMedia(storage_path('tmp/uploads/' . $request->avatar))->toMediaCollection('avatar');
                    }

                    return to_route('admin.index');
                }
                return redirect()->back()->with('new_password_error', 'Password is not tally !')->withInput();
            }else{
                return redirect()->back()->with('old_password_error', 'Incorrect Old Password !')->withInput();
            }
        }
        $request_data = $request->except('roles','oldpassword','newpassword','twopassword','avatar');
        $request_data['password'] = $user->password;
        $user->update($request_data);
        // $user->addFromMediaLibraryRequest($request->avatar)->toMediaCollection('avatar');

        if (isset($request->avatar)) {
            if (isset($user->avatar)){
                $user->clearMediaCollection('avatar');
            }
            $user->addMedia(storage_path('tmp/uploads/' . $request->avatar))->toMediaCollection('avatar');
        }


        return to_route('admin.index')->with('message','Update Profile successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
