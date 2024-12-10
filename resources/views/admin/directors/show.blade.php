<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick-theme.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.show') }} {{ trans('cruds.director.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.directors.index') }}">{{ trans('cruds.director.title_singular') }}
                {{ trans('global.list') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.director.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <div class="pro-group pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 col-md-9">
                                    <h5 class="card-title">Personal Information</h5>
                                </div>
                                <div class="col-12 col-md-3 mb-0">
                                    <div class="form-group mb-0 float-right">
                                        <a href="{{ route('admin.directors.edit',$director->id) }}" class="show-edit-button show-edit-button-blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Name</span>
                                    <div class="show-value">
                                        {{ $director->name ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">IC</span>
                                    <div class="show-value">
                                        {{ $director->ic ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Phone</span>
                                    <div class="show-value">
                                        {{ $director->phone ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Email</span>
                                    <div class="show-value">
                                        {{ $director->email ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Gender</span>
                                    <div class="show-value">
                                        {{ App\Models\Director::GENDER_SELECT[$director->gender] ?? '-' }}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Marital Status</span>
                                    <div class="show-value">
                                        {{ App\Models\Director::MARITAL_STATUS_SELECT[$director->marital_status] ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <h5 class="card-title">Personal Address</h5>
                        <div class="row">
                            <div class="form-group col-12 col-md-12 mb-3">
                                <span class="show-title">Address</span>
                                <div class="show-value">
                                    {{ $director->address_1 ?? '-' }} <br>
                                    {{ $director->address_2 }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <span class="show-title">Postcode</span>
                                <div class="show-value">
                                    {{ $director->postcode ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3 mb-3">
                                <span class="show-title">City</span>
                                <div class="show-value">
                                    {{ $director->city->name ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <span class="show-title">State</span>
                                <div class="show-value">
                                    {{ $director->state->name ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <span class="show-title">Country</span>
                                <div class="show-value">
                                    {{ $director->country->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
