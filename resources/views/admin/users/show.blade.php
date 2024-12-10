<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick-theme.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.users.index') }}">{{ trans('cruds.user.title_singular') }}
                {{ trans('global.list') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.user.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header py-2 px-3 bg-primary">
                <div class="row">
                    <div class="col-12 col-md-9">
                        @foreach($user->roles as $key => $roles)
                            <h3 class="mb-0">
                                {{ $user->name }} <span style="color:#73cee2; font-size:smaller;"> - {{ $roles->name }}</span>
                            </h3>
                        @endforeach
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group mb-0 mt-1 float-right">
                            <a href="{{ route('admin.users.edit',$user->id) }}" class="show-edit-button"><i class="fa fa-edit fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <h5 class="card-title">Personal Information</h5>
                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="row">
                            <div class="form-group col-12 col-md-4 mb-3">
                                <span class="show-title">Username</span>
                                <div class="show-value">
                                    {{ $user->username ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-4 mb-3">
                                <span class="show-title">IC</span>
                                <div class="show-value">
                                    {{ $user->ic ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-4 mb-3">
                                <span class="show-title">Phone</span>
                                <div class="show-value">
                                    {{ $user->phone ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-4 mb-3">
                                <span class="show-title">Email</span>
                                <div class="show-value">
                                    {{ $user->email ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-4 mb-3">
                                <span class="show-title">Gender</span>
                                <div class="show-value">
                                    {{ App\Models\User::GENDER_SELECT[$user->gender] ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
