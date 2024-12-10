<x-admin.app-layout>
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.edit') }} {{ trans('cruds.caseList.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a
                href="{{ route('admin.case-lists.index') }}">{{ trans('cruds.caseList.title_singular') }}
                {{ trans('global.list') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.caseList.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route("admin.case-lists.update", [$caseList->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label class="required"
                                        for="case_code">{{ trans('cruds.caseList.fields.case_code') }}</label>
                                    <input class="form-control {{ $errors->has('case_code') ? 'is-invalid' : '' }}"
                                        type="text" name="case_code" id="case_code"
                                        value="{{ old('case_code', $caseList->case_code) }}" required>
                                    @if($errors->has('case_code'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('case_code') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.case_code_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="company_name">{{ trans('cruds.caseList.fields.company_name') }}</label>
                                    <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}"
                                        type="text" name="company_name" id="company_name"
                                        value="{{ old('company_name', $caseList->company_name) }}">
                                    @if($errors->has('company_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('company_name') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.company_name_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label class="required"
                                        for="incorporation_date">{{ trans('cruds.caseList.fields.incorporation_date') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('incorporation_date') ? 'is-invalid' : '' }}"
                                        type="date" name="incorporation_date" id="incorporation_date"
                                        value="{{ old('incorporation_date', $caseList->incorporation_date) }}" required>
                                    @if($errors->has('incorporation_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('incorporation_date') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.incorporation_date_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="required"
                                        for="applicaion_date">{{ trans('cruds.caseList.fields.applicaion_date') }}</label>
                                    <input
                                        class="form-control {{ $errors->has('applicaion_date') ? 'is-invalid' : '' }}"
                                        type="date" name="applicaion_date" id="applicaion_date"
                                        value="{{ old('applicaion_date', $caseList->applicaion_date) }}" required>
                                    @if($errors->has('applicaion_date'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('applicaion_date') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.applicaion_date_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="salesmen">{{ trans('cruds.caseList.fields.salesman') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('salesmen') ? 'is-invalid' : '' }}"
                                        name="salesmen" id="salesmen">
                                        @foreach($users as $id => $salesman)
                                        <option value="{{ $id }}"
                                            {{ (old('salesmen') == $id ? old('salesmen') : $caseList->salesman->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $salesman }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('salesmen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('salesmen') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.salesman_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="bfe">{{ trans('cruds.caseList.fields.bfe') }}</label>
                                    <input class="form-control {{ $errors->has('bfe') ? 'is-invalid' : '' }}"
                                        type="text" name="bfe" id="bfe" value="{{ old('bfe', $caseList->bfe) }}">
                                    @if($errors->has('bfe'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('bfe') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.bfe_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label for="business_bg">{{ trans('cruds.caseList.fields.business_bg') }}</label>
                                    <input class="form-control {{ $errors->has('business_bg') ? 'is-invalid' : '' }}"
                                        type="text" name="business_bg" id="business_bg"
                                        value="{{ old('business_bg', $caseList->business_bg) }}">
                                    @if($errors->has('business_bg'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('business_bg') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.business_bg_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label for="remark">{{ trans('cruds.caseList.fields.remark') }}</label>
                                    <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}"
                                        type="text" name="remark" id="remark"
                                        value="{{ old('remark', $caseList->remark) }}">
                                    @if($errors->has('remark'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('remark') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.remark_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label for="director">{{ trans('cruds.caseList.fields.director') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all"
                                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all"
                                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <input class="form-control {{ $errors->has('director') ? 'is-invalid' : '' }}"
                                        type="text" name="director" id="director"
                                        value="{{ old('director', $caseList->director) }}">
                                    @if($errors->has('director'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('director') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.director_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label for="industry_type">{{ trans('cruds.caseList.fields.industry_type') }}</label>
                                    <input class="form-control {{ $errors->has('industry_type') ? 'is-invalid' : '' }}"
                                        type="text" name="industry_type" id="industry_type"
                                        value="{{ old('industry_type', $caseList->industry_type) }}">
                                    @if($errors->has('industry_type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('industry_type') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.industry_type_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-12">
                                    <label for="application_type">{{ trans('cruds.caseList.fields.application_type') }}</label>
                                    <div style="padding-bottom: 4px">
                                        <span class="btn btn-info btn-xs select-all"
                                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                        <span class="btn btn-info btn-xs deselect-all"
                                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                    </div>
                                    <input class="form-control {{ $errors->has('application_type') ? 'is-invalid' : '' }}"
                                        type="text" name="application_type" id="application_type"
                                        value="{{ old('application_type', $caseList->application_type) }}">
                                    @if($errors->has('application_type'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('application_type') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.application_type_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="address_1">{{ trans('cruds.caseList.fields.address_1') }}</label>
                                    <input class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}"
                                        type="text" name="address_1" id="address_1"
                                        value="{{ old('address_1', $caseList->address_1) }}">
                                    @if($errors->has('address_1'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address_1') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.address_1_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="address_2">{{ trans('cruds.caseList.fields.address_2') }}</label>
                                    <input class="form-control {{ $errors->has('address_2') ? 'is-invalid' : '' }}"
                                        type="text" name="address_2" id="address_2"
                                        value="{{ old('address_2', $caseList->address_2) }}">
                                    @if($errors->has('address_2'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('address_2') }}
                                    </div>
                                    @endif
                                    <span
                                        class="help-block">{{ trans('cruds.caseList.fields.address_2_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="postcode">{{ trans('cruds.caseList.fields.postcode') }}</label>
                                    <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}"
                                        type="text" name="postcode" id="postcode"
                                        value="{{ old('postcode', $caseList->postcode) }}">
                                    @if($errors->has('postcode'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('postcode') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.postcode_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="city_id">{{ trans('cruds.caseList.fields.city') }}</label>
                                    <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                        name="city_id" id="city_id">
                                        @foreach($cities as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ (old('city_id') ? old('city_id') : $caseList->city->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('city'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('city') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.city_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label for="state_id">{{ trans('cruds.caseList.fields.state') }}</label>
                                    <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}"
                                        name="state_id" id="state_id">
                                        @foreach($states as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ (old('state_id') ? old('state_id') : $caseList->state->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('state'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('state') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.state_helper') }}</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label for="country_id">{{ trans('cruds.caseList.fields.country') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                        name="country_id" id="country_id">
                                        @foreach($countries as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ (old('country_id') ? old('country_id') : $caseList->country->id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $entry }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('country'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('country') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.country_helper') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-12">
                                    <label for="status">{{ trans('cruds.caseList.fields.status') }}</label>
                                    <select
                                        class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                        name="status" id="status">
                                        <option value="0" {{ old('status',$caseList->status)==0 ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="1" {{ old('status',$caseList->status)==1 ? 'selected' : '' }}>
                                            Rejected</option>
                                        <option value="2" {{ old('status',$caseList->status)==2 ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                    @if($errors->has('status'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('status') }}
                                    </div>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.caseList.fields.status_helper') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $(".select2").select2();

    </script>
    @endpush
</x-admin.app-layout>
