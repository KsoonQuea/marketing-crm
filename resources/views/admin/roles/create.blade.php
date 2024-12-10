<x-admin.app-layout>
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">{{ trans('cruds.role.title_singular') }} {{ trans('global.list') }}</a></li>
        <li class="breadcrumb-item active">{{ trans('global.create') }} {{ trans('cruds.role.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.roles.store") }}" enctype="multipart/form-data" class="form theme-form">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                        @if($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="tw-grid tw-gap-4 tw-gap-y-6 tw-grid-cols-1 sm:tw-grid-cols-3 md:tw-grid-cols-3 xl:tw-grid-cols-5 tw-mt-10">
                        @foreach($permissionGroups as $permissionGroup)
                            <div>
                                <h5 class="tw-text-sm tw-mb-4">
                                    <label class="d-block" for="chk-ani-{{ $loop->index }}">
                                        <input class="checkbox_animated parentRole" id="chk-ani-{{ $loop->index }}" type="checkbox"> {{ $permissionGroup->name }}
                                    </label>
                                </h5>
                                <ul>
                                    @foreach($permissionGroup->permissions as $permission)
                                        <li class="tw-text-xs tw-flex tw-items-center tw-ml-4 tw-my-2">
                                            <label class="d-block" for="chk-ani-{{ $loop->index }}">
                                                <input class="checkbox_animated" @checked(in_array($permission->id, old('permissions', []))) name="permissions[]" value="{{ $permission->id }}"  id="chk-ani-{{ $loop->index }}" type="checkbox"> <span class="tw-pl-2">{{ str($permission->name)->title()->replace('_',' ')->after($permissionGroup->name) }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function() {
                $('.parentRole').on('change', function () {
                    let checkboxes = $(this).parent().parent().siblings('ul').children('li').children('label').children('input')
                    if(this.checked) {
                        checkboxes.each(function (i, item) {
                            $(item).prop('checked', true)
                        })
                    } else {
                        checkboxes.each(function (i, item) {
                            $(item).prop('checked', false)
                        })
                    }
                });
            });
        </script>
    @endpush
</x-admin.app-layout>

