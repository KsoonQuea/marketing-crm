<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionGroupTitle;
use App\Models\Role;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function index(): Factory|View
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//        $roles = Role::with(['permissions'])->withCount('permissions')->get();
//        $roles->map(function ($item): void {
//            $item['permission_group'] = $item->permissions->groupBy('permission_group.name')->toArray();
//        });

        $roles = Role::withCount('permissions')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): Factory|View
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissionGroups = PermissionGroup::with('permissions')->withCount('permissions')->oldest('permissions_count')->get();

        return view('admin.roles.create', compact('permissionGroups'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());
        $role->permissions()->sync($request->input('permissions', []));

        return to_route('admin.roles.index');
    }

    public function edit(Role $role): Factory|View
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissionGroups = PermissionGroup::with('permissions')->withCount('permissions')->oldest('permissions_count')->get();
        $role->load('permissions');

        $permissionGroupsTitle          = PermissionGroupTitle::with('permission_groups')->get();

        $first_permissionGroupsTitle    = PermissionGroupTitle::with('permission_groups')->first();

        $first_permissionGroups_id      = $first_permissionGroupsTitle->permission_groups->first()->id ?? 0;

//        dd($first_permissionGroups_id);

        return view('admin.roles.edit', compact('permissionGroups', 'role', 'permissionGroupsTitle', 'first_permissionGroups_id'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());
        $role->permissions()->sync($request->input('permissions', []));

        return to_route('admin.roles.index');
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyRoleRequest $request): \Illuminate\Http\Response
    {
        Role::whereIn('id', request('ids'))->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    public function editAjax(Request $request, Role $role)
    {
        $post_id        = $request->id;
        $post_type      = $request->type;
        $post_role_id   = $request->role_id;

        $role->load('permissions');

        $permission_array = array();

        foreach($role->permissions as $permission_key => $permission_item){
            array_push($permission_array, $permission_item->id);
        }

//        dd($permission_array);

        if ($post_type == 1 ){
            $permission = Permission::where('permission_group_id', $post_id)
                ->where(function ($query){
                    $query->where('type', 2)
                        ->orWhere('type', 3)
                        ->orWhere('type', 4)
                        ->orWhere('type', 5)
                        ->orWhere('type', 6)
                        ->orWhere('type', 7)
                    ;
                })
                ->get();
        }
        else{
            $permission = Permission::where('permission_group_id', $post_id)
                ->where('type', 1)
                ->get();
        }

        $permission_details_html    = '';
        $header_block               = false;
        $type_4_check               = false;
        $permission_class           = '';

        $permission_id_arr      = array();
        $permission_type_arr    = array();

        foreach ($permission as $permission_key => $permission_item){
            /*
             * type :
             * 0 = older permission
             * 1 = non-child permission (alr removed)
             * 2 = child permission
             * 3 = sub-title
             * 4 = all type dashboard permission
             * 5 = personal type dashboard permission
             * 6 = all & personal sub-title
             * 7 = only one permission in all & personal permission
             * */

            //declare the function
            if (in_array($permission_item->id, $permission_array)){
                $checkbox_text      = 'checked';
                $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 1, 0)';

                if ($permission_item->type == 4){
                    $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 1, 4)';
                }
                elseif ($permission_item->type == 5){
                    $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 1, 5)';
                }
            }
            else{
                $checkbox_text      = '';
                $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 0, 0)';

                if ($permission_item->type == 4){
                    $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 0, 4)';
                }
                elseif ($permission_item->type == 5){
                    $onchange_item      = 'permissionChangeFunc('.$permission_item->id.', 0, 5)';
                }
            }

            //declare the header
            if (($permission_item->type == 4 || $permission_item->type == 5 || $permission_item->type == 6 || $permission_item->type == 7) && $header_block == false){
                $permission_details_html .= '
                <tr style="width: 100%">
                    <th class="m-0 p-0 ps-3 py-2" style="width: 40%">Action</th>
                    <th class="m-0 p-0 ps-3 py-2 text-center" colspan="2" style="width: 60%">Permission</th>
                </tr>
                <tr>
                    <th></th>
                    <th class="text-center">All</th>
                    <th class="text-center">Personal</th>
                </tr>';

                $header_block = true;
            }
            elseif($header_block == false){
                $permission_details_html .= '
                <tr>
                    <th class="m-0 p-0 ps-3 py-2">Action</th>
                    <th class="m-0 p-0 ps-3 py-2">Permission</th>
                </tr>';

                $header_block = true;
            }

            //make the content based on type
            if ($permission_item->type == 3){
                $permission_details_html .= '<tr><th colspan="2" class="card-title">'.$permission_item->show_name.'</th></tr>';
            }
            elseif ($permission_item->type == 6){
                $permission_details_html .= '<tr><th colspan="3" class="card-title">'.$permission_item->show_name.'</th></tr>';
            }
            elseif ($permission_item->type == 7){
                $permission_details_html .=
                '<tr>
                    <th class="m-0 p-0 ps-3 pt-2">
                        '.$permission_item->show_name.'
                    </th>

                    <td class="m-0 p-0 ps-3 pt-1 text-center">
                        <div class="media-body text-start icon-state text-center">
                            <label class="switch text-center" id="switch_group-'.$permission_item->id.'">
                                <input type="checkbox" onchange="'.$onchange_item.'" value="'.$permission_item->id.'" '.$checkbox_text.' >
                                <span class="switch-state"></span>
                            </label>
                        </div>
                    </td>
                    <td></td>
                </tr>';
            }
            elseif($permission_item->type == 4){
                $permission_details_html .=
                    '<tr style="width: 100%">
                        <th class="m-0 p-0 ps-3 pt-2" style="width: 40%">
                            '.$permission_item->show_name.'
                        </th>

                        <td class="m-0 p-0 ps-3 pt-1 text-center" style="width: 30%">
                            <div class="media-body text-start icon-state text-center">
                                <label class="switch" id="switch_group-'.$permission_item->id.'">
                                    <input type="checkbox" class="all_personal_permission" id="all_permission-'.$permission_item->id.'" onchange="'.$onchange_item.'" value="'.$permission_item->id.'" '.$checkbox_text.' >
                                    <span class="switch-state"></span>
                                </label>
                            </div>
                        </td>
                    ';
            }
            elseif($permission_item->type == 5){
                $permission_details_html .=
                    '
                        <td class="m-0 p-0 ps-3 pt-1 text-center" style="width: 30%">
                            <div class="media-body text-start icon-state text-center">
                                <label class="switch" id="switch_group-'.$permission_item->id.'">
                                    <input type="checkbox" class="all_personal_permission" id="personal_permission-'.$permission_item->id.'" onchange="'.$onchange_item.'" value="'.$permission_item->id.'" '.$checkbox_text.' >
                                    <span class="switch-state"></span>
                                </label>
                            </div>
                        </td>
                    </tr>
                    ';
            }
            else{
                $permission_details_html .=
                '<tr>
                    <th class="m-0 p-0 ps-3 pt-2">
                        '.$permission_item->show_name.'
                    </th>

                    <td class="m-0 p-0 ps-3 pt-1">
                        <div class="media-body text-start icon-state">
                            <label class="switch" id="switch_group-'.$permission_item->id.'">
                                <input type="checkbox" onchange="'.$onchange_item.'" value="'.$permission_item->id.'" '.$checkbox_text.' >
                                <span class="switch-state"></span>
                            </label>
                        </div>
                    </td>
                </tr>';
            }

            //push the array
            array_push($permission_id_arr, $permission_item->id);
            array_push($permission_type_arr, $permission_item->type);
        }

        $json_data = json_encode([
            'permission_details_html'   => $permission_details_html,
            'permission_id_arr'         => $permission_id_arr,
            'permission_type_arr'       => $permission_type_arr,
        ]);

//        dd($json_data);

        return json_encode([
            'permission_details_html'   => $permission_details_html,
            'permission_id_arr'         => $permission_id_arr,
            'permission_type_arr'       => $permission_type_arr,
        ]);
    }

    public function updateAjax(Request $request, Role $role)
    {
        $post_id            = $request->id;
        $post_type          = $request->type;
        $post_role_name     = $request->role_name;
        $permission_type    = $request->permission_type;

        if ($permission_type == 4){
            $id_item = 'all_permission-'.$post_id;
        }
        elseif ($permission_type == 5){
            $id_item = 'personal_permission-'.$post_id;
        }
        else{
            $id_item = 'normal_permission-'.$post_id;
        }

        if ($post_type == 2){
            $role->update([
                'name' => $post_role_name
            ]);
        }
        elseif ($post_type == 1){
            $role->revokePermissionTo($request->id);

            $input = '<input type="checkbox" onchange="permissionChangeFunc('.$post_id.', 0, '.$permission_type.')" id="'.$id_item.'" value="'.$post_id.'" >
            <span class="switch-state"></span>';
        }
        else{
            $role->givePermissionTo($request->id);
            $input = '<input type="checkbox" onchange="permissionChangeFunc('.$post_id.', 1, '.$permission_type.')" id="'.$id_item.'" value="'.$post_id.'" checked >
            <span class="switch-state"></span>';
        }

        return $input;
    }
}
