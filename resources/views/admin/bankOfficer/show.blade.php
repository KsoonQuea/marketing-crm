<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.show') }} {{ trans('cruds.bankOfficer.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.bank-officer.index') }}">{{ trans('cruds.bankOfficer.title_singular') }}
                {{ trans('global.list') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.show') }} {{ trans('cruds.bankOfficer.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <div class="pro-group pt-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12 mb-0">
                                    <div class="form-group mb-0 float-right">
                                        <a href="#" class="show-edit-button show-edit-button-blue">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Name</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">IC</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Phone</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Email</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Bank Account</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Bank</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-4 mb-3">
                                    <span class="show-title">Commission (%)</span>
                                    <div class="show-value">
                                        -
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
