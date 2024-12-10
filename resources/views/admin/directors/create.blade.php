<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.create') }} {{ trans('cruds.director.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.directors.index') }}">{{ trans('cruds.director.title_singular') }}
                {{ trans('global.list') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.create') }} {{ trans('cruds.director.title_singular') }}
        </li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.directors.store") }}" enctype="multipart/form-data">
                    @csrf
                    <h4 class="card-title">Personal Information</h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="name">{{ trans('cruds.director.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name') }}">
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="ic">{{ trans('cruds.director.fields.ic') }}</label>
                            <input class="form-control {{ $errors->has('ic') ? 'is-invalid' : '' }}" type="text" name="ic" id="ic" value="{{ old('ic') }}">
                            @if($errors->has('ic'))
                            <div class="invalid-feedback">
                                {{ $errors->first('ic') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.ic_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="email">{{ trans('cruds.director.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}">
                            @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="phone">{{ trans('cruds.director.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone">
                            @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>{{ trans('cruds.director.fields.gender') }}</label>
                            <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                                <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Director::GENDER_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('gender') === (string) $key ? 'selected' : '' }}>{{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.gender_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>{{ trans('cruds.director.fields.marital_status') }}</label>
                            <select class="form-control select2 {{ $errors->has('marital_status') ? 'is-invalid' : '' }}" name="marital_status" id="marital_status">
                                <option value disabled {{ old('marital_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Director::MARITAL_STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('marital_status') === (string) $key ? 'selected' : '' }}>
                                    {{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('marital_status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('marital_status') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.marital_status_helper') }}</span>
                        </div>
                    </div>
                    <h4 class="card-title mt-3">Personal Address</h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="address_1">{{ trans('cruds.director.fields.address_1') }}</label>
                            <input class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}" type="text" name="address_1" id="address_1" value="{{ old('address_1') }}">
                            @if($errors->has('address_1'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address_1') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.address_1_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="address_2">{{ trans('cruds.director.fields.address_2') }}</label>
                            <input class="form-control {{ $errors->has('address_2') ? 'is-invalid' : '' }}" type="text" name="address_2" id="address_2" value="{{ old('address_2') }}">
                            @if($errors->has('address_2'))
                            <div class="invalid-feedback">
                                {{ $errors->first('address_2') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.address_2_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="postcode">{{ trans('cruds.director.fields.postcode') }}</label>
                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}"
                                type="text" name="postcode" id="postcode" value="{{ old('postcode') }}">
                            @if($errors->has('postcode'))
                            <div class="invalid-feedback">
                                {{ $errors->first('postcode') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.postcode_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="city">{{ trans('cruds.director.fields.city') }}</label>
                            <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city" id="city">
                                @foreach($cities as $id => $entry)
                                <option value="{{ $id }}" {{ (old('city') === $id) ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('city') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="state">{{ trans('cruds.director.fields.state') }}</label>
                            <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state">
                                @foreach($states as $id => $entry)
                                <option value="{{ $id }}" {{ (old('state') === $id) ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('state'))
                            <div class="invalid-feedback">
                                {{ $errors->first('state') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.state_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-3">
                            <label for="country">{{ trans('cruds.director.fields.country') }}</label>
                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country" id="country">
                                @foreach($countries as $id => $entry)
                                <option value="{{ $id }}" {{ (old('country') === $id) ? 'selected' : '' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('country'))
                            <div class="invalid-feedback">
                                {{ $errors->first('country') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.director.fields.country_helper') }}</span>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.directors.index') }}" class="ms-3 btn btn-light">
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
    </script>
    @endpush
</x-admin.app-layout>
