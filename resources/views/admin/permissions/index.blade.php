<x-admin.app-layout>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.permission.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.permission.title_singular') }} {{ trans('global.list') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 2xl:tw-grid-cols-5 tw-gap-4 tw-gap-y-0">
                    @foreach($permissionGroups as $permissionGroup)
                        <div class="card">
                            <div class="card-header px-2 py-1" style="border-bottom: 1px solid #e6edef;">
                                <h6 class="tw-text-sm lg:tw-text-base mb-0">
                                    {{ $permissionGroup->name }}
                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="row browse">
                                    <div class="browse-articles">
                                        <ul>
                                            @foreach($permissionGroup->permissions as $permission)
                                                <li class="tw-my-9">
                                                    <h5><i data-feather="lock"></i>{{ str($permission->name)->title()->replace('_',' ')->after($permissionGroup->name) }}</h5>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    @endpush
</x-admin.app-layout>
