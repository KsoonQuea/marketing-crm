<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a
            href="{{ route('admin.users.index') }}">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-title">Personal Information</h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-3">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="name"
                                   id="name" value="{{ old('name') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
{{--                        <div class="form-group col-12 col-md-3">--}}
{{--                            <label for="username">{{ trans('cruds.user.fields.username') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text"--}}
{{--                                   name="username" id="username" value="{{ old('username') }}">--}}
{{--                            @if($errors->has('username'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('username') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.username_helper') }}</span>--}}
{{--                        </div>--}}
                        <div class="form-group col-12 col-md-3">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   type="email"
                                   name="email" id="email" value="{{ old('email') }}">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label class="required"
                                   for="password">{{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   type="password"
                                   name="password" id="password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="phone"
                                   id="phone" value="{{ old('phone') }}">
                            @if($errors->has('phone'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="ic">{{ trans('cruds.user.fields.ic') }}</label>
                            <input class="form-control {{ $errors->has('ic') ? 'is-invalid' : '' }}" type="text"
                                   name="ic"
                                   id="ic" value="{{ old('ic') }}">
                            @if($errors->has('ic'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ic') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.ic_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label>{{ trans('cruds.user.fields.gender') }}</label>
                            <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                    name="gender"
                                    id="gender" value="{{ old('gender') }}">
                                <option value
                                        disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\User::GENDER_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('gender') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3 {{ $errors->has('roles') ? 'has-error' : '' }}">
                            <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                            <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}"
                                    name="roles" id="roles" value="{{ old('roles') }}" onchange="showBfeInfo()">
                                    <option value disabled {{ old('roles',null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach($roles as $id => $role)
                                    <option value="{{ $id }}"{{ old('roles') === (string) $id ? 'selected' : '' }}>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('roles'))
                                <span class="invalid-feedback">{{ $errors->first('roles') }}</span>
                            @endif
                        </div>

                        <div class="form-group col-12 col-md-3 {{ $errors->has('roles') ? 'has-error' : '' }}" id="class_div" style="display: none">
                            <label class="required" for="class_id">Class</label>
                            <select class="form-control select2 {{ $errors->has('class_id') ? 'is-invalid' : '' }}"
                                    name="class_id" id="class" value="{{ old('class_id') }}" onchange="showBfeInfo()">
                                @foreach($commission_settings as $cs_key => $cs_item)
                                    <option value="{{ $cs_key }}" {{ old('class_id') === (string) $cs_key ? 'selected' : '' }}>{{ $cs_item }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('class'))
                                <span class="invalid-feedback">{{ $errors->first('class') }}</span>
                            @endif
                        </div>

                    </div>

{{--                    <h4 class="card-title mt-4">Personal Address</h4>--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-group col-12 col-md-6">--}}
{{--                            <label for="address_1">{{ trans('cruds.user.fields.address_1') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text"--}}
{{--                                   name="address_1" id="address_1"--}}
{{--                                   value="{{ old('address_1') }}">--}}
{{--                            @if($errors->has('address_1'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('address_1') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.address_1_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-6">--}}
{{--                            <label for="address_2">{{ trans('cruds.user.fields.address_2') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('address_2') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text"--}}
{{--                                   name="address_2" id="address_2"--}}
{{--                                   value="{{ old('address_2') }}">--}}
{{--                            @if($errors->has('address_2'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('address_2') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.address_2_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-3">--}}
{{--                            <label for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text" name="postcode" id="postcode" value="{{ old('postcode') }}">--}}
{{--                            @if($errors->has('postcode'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('postcode') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.postcode_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-3">--}}
{{--                            <label for="city">{{ trans('cruds.user.fields.city') }}</label>--}}
{{--                            <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"--}}
{{--                                    name="city" id="city" value="{ old('city') }}">--}}
{{--                                @foreach($cities as $id => $entry)--}}
{{--                                    <option value="{{ $id }}"{{ old('city') === (string) $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @if($errors->has('city'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('city') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-3">--}}
{{--                            <label for="state">{{ trans('cruds.user.fields.state') }}</label>--}}
{{--                            <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}"--}}
{{--                                    name="state" id="state">--}}
{{--                                @foreach($states as $id => $entry)--}}
{{--                                    <option value="{{ $id }}" {{ old('state') === (string) $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @if($errors->has('state'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('state') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.state_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-3">--}}
{{--                            <label for="country">{{ trans('cruds.user.fields.country') }}</label>--}}
{{--                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}"--}}
{{--                                    name="country" id="country">--}}
{{--                                @foreach($countries as $id => $entry)--}}
{{--                                    <option value="{{ $id }}" {{ old('country') ===(string) $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @if($errors->has('country'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('country') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.country_helper') }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <h4 class="card-title mt-4">Bank Information</h4>--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-group col-12 col-md-4">--}}
{{--                            <label for="bank">{{ trans('cruds.user.fields.bank') }}</label>--}}
{{--                            <select class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}"--}}
{{--                                    name="bank"--}}
{{--                                    id="bank">--}}
{{--                                @foreach($banks as $id => $entry)--}}
{{--                                    <option value="{{ $id }}" {{ old('bank') === (string) $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @if($errors->has('bank'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('bank') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.bank_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-4">--}}
{{--                            <label for="bank_owner">{{ trans('cruds.user.fields.bank_owner') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('bank_owner') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text"--}}
{{--                                   name="bank_owner" id="bank_owner"--}}
{{--                                   value="{{ old('bank_owner') }}">--}}
{{--                            @if($errors->has('bank_owner'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('bank_owner') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.bank_owner_helper') }}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-4">--}}
{{--                            <label for="bank_account">{{ trans('cruds.user.fields.bank_account') }}</label>--}}
{{--                            <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}"--}}
{{--                                   type="text"--}}
{{--                                   name="bank_account" id="bank_account"--}}
{{--                                   value="{{ old('bank_account') }}">--}}
{{--                            @if($errors->has('bank_account'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('bank_account') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <span class="help-block">{{ trans('cruds.user.fields.bank_account_helper') }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="ms-3 btn btn-light">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();

            showBfeInfo();

            function showBfeInfo(){
                if ($('#roles').val() === '3') {
                    $('#class_div').show();
                }
                else {
                    $('#class_div').hide();
                }
            }
        </script>
    @endpush
</x-admin.app-layout>
