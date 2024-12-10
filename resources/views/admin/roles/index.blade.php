<x-admin.app-layout>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}</li>
        <x-slot:breadcrumb_action>
            @can('role_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="{{ route('admin.roles.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.role.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row default-according style-1 faq-accordion" id="accordionoc">
            <div class="col-12">
                @foreach($roles as $role)
                    <div class="card">
                        <div class="card-header">
                            <div class="tw-flex tw-items-center tw-justify-between">
                                <span class="tw-text-base">{{ $role->name }}</span>
                                <div class="tw-flex tw-items-center tw-space-x-2">
{{--                                    @can('role_show')--}}
{{--                                        <button class="btn btn-light btn-xs hover:tw-text-white before:tw-content-none"--}}
{{--                                                data-bs-toggle="collapse" data-bs-target="#collapseicon-{{ $role->id }}"--}}
{{--                                                aria-expanded="false" aria-controls="collapseicon">--}}
{{--                                            <i class="tw-w-4" data-feather="lock"></i>--}}
{{--                                        </button>--}}
{{--                                    @endcan--}}
                                    @can('role_edit')
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"  class="btn btn-primary btn-xs">
                                        <i class="tw-w-4" data-feather="edit"></i>
                                    </a>
                                    @endcan
                                    @can('role_delete')
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="tw-w-4" data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
{{--                        <div class="collapse" id="collapseicon-{{ $role->id }}" aria-labelledby="collapseicon"--}}
{{--                             data-parent="#accordionoc">--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="tw-grid tw-gap-4 tw-gap-y-8 tw-grid-cols-2 sm:tw-grid-cols-3 md:tw-grid-cols-4 xl:tw-grid-cols-6">--}}
{{--                                    @forelse($role->permission_group as $permissionGroupName => $permissionGroup)--}}
{{--                                        <div>--}}
{{--                                            <h5>{{ $permissionGroupName }}</h5>--}}
{{--                                            <ul class="">--}}
{{--                                                @foreach($permissionGroup as $permission)--}}
{{--                                                    <li class="tw-text-xs tw-flex tw-items-center">--}}
{{--                                                        <i class="tw-w-2" data-feather="lock"></i>--}}
{{--                                                        <span class="tw-pl-2">{{ str($permission['name'])->title()->replace('_',' ')->after($permissionGroupName) }}</span>--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    @empty--}}
{{--                                        <div class="tw-col-span-6">No Permissions has been assigned.</div>--}}
{{--                                    @endforelse--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin.app-layout>
