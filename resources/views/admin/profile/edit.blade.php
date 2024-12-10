<x-admin.app-layout>
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dropzone.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.edit') }} {{ trans('cruds.profile.profile') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.profile.profile') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.profile.update",Auth::user()->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h4 class="card-title">Personal Information</h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                name="name" id="name" value="{{ old('name', $user->name) }}">
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="username">{{ trans('cruds.user.fields.username') }}</label>
                            <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                                name="username" id="username" value="{{ old('username', $user->username) }}">
                            @if($errors->has('username'))
                            <div class="invalid-feedback">
                                {{ $errors->first('username') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.username_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                name="email" id="email" value="{{ old('email', $user->email) }}">
                            @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                            <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text"
                                name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
                            @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label for="ic">{{ trans('cruds.user.fields.ic') }}</label>
                            <input class="form-control ic-no-input {{ $errors->has('ic') ? 'is-invalid' : '' }}" type="text"
                                name="ic" id="ic" value="{{ old('ic', $user->ic) }}">
                            @if($errors->has('ic'))
                            <div class="invalid-feedback">
                                {{ $errors->first('ic') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.ic_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label>{{ trans('cruds.user.fields.gender') }}</label>
                            <select class="form-control select2 {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                name="gender" id="gender">
                                <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>
                                    {{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\User::GENDER_SELECT as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('gender', $user->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                {{ $errors->first('gender') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.gender_helper') }}</span>
                        </div>
                {{--    @if (Auth::user()->avatar)--}}
                {{--    <div class="form-group col-12 col-md-2">--}}
                {{--        <div class="text-center border p-2">--}}
                {{--            <img class="img-90" src="{{ Auth::user()->avatar->getUrl('preview') }}"--}}
                {{--                alt="{{ Auth::user()->name }}" />--}}
                {{--        </div>--}}
                {{--    </div>--}}
                {{--    @endif--}}
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="avatar">{{ trans('cruds.user.fields.avatar') }}</label>
                            <div class="needsclick dropzone" id="document-dropzone">
                                <div id="hid">
                                    <i class="icon-cloud-up text-primary"></i>
                                    <h6 class="m-0">Drop files here or click to upload.</h6>
                                </div>
                            </div>
                            <span class="help-block" id="error"></span>
                        </div>
                    </div>
                    <h4 class="card-title mt-3">Change Password</h4>
                    <div class="row">
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="oldpassword">{{ trans('cruds.profile.old') }}</label>
                            <input
                                class="form-control {{ ($errors->has('oldpassword') || session()->has('old_password_error')) ? 'is-invalid' : '' }}"
                                type="password" name="oldpassword" id="oldpassword">
                            @if($errors->has('oldpassword') || session()->has('old_password_error'))
                            <div class="invalid-feedback">
                                {{ $errors->first('oldpassword') }}
                            </div>
                            <div class="font-danger">
                                {{ session()->get('old_password_error') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.profile.password_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="newpassword">{{ trans('cruds.profile.new') }}</label>
                            <input
                                class="form-control {{ ($errors->has('newpassword') || session()->has('new_password_error')) ? 'is-invalid' : '' }}"
                                type="password" name="newpassword" id="newpassword">
                            @if($errors->has('newpassword') || session()->has('new_password_error'))
                            <div class="invalid-feedback">
                                {{ $errors->first('newpassword') }}
                            </div>
                            <div class="font-danger">
                                {{ session()->get('new_password_error') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.profile.password_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="twopassword">{{ trans('cruds.profile.two') }}</label>
                            <input
                                class="form-control {{ ($errors->has('twopassword') || session()->has('new_password_error')) ? 'is-invalid' : '' }}"
                                type="password" name="twopassword" id="twopassword">
                            @if($errors->has('twopassword') || session()->has('two_password_error'))
                            <div class="invalid-feedback">
                                {{ $errors->first('twopassword') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.profile.password_helper') }}</span>
                        </div>
                    </div>
                    {{--                    <h4 class="card-title mt-3">Personal Address</h4>--}}
                    {{--                    <div class="row">--}}
                    {{--                        <div class="form-group col-12 col-md-6">--}}
                    {{--                            <label for="address_1">{{ trans('cruds.user.fields.address_1') }}</label>--}}
                    {{--                            <input class="form-control {{ $errors->has('address_1') ? 'is-invalid' : '' }}"--}}
                    {{--                                   type="text"--}}
                    {{--                                   name="address_1" id="address_1"--}}
                    {{--                                   value="{{ old('address_1', $user->address_1) }}">--}}
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
                    {{--                                   value="{{ old('address_2', $user->address_2) }}">--}}
                    {{--                            @if($errors->has('address_2'))--}}
                    {{--                                <div class="invalid-feedback">--}}
                    {{--                                    {{ $errors->first('address_2') }}--}}
                    {{--                                </div>--}}
                    {{--                            @endif--}}
                    {{--                            <span class="help-block">{{ trans('cruds.user.fields.address_2_helper') }}</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    <div class="row">--}}
                    {{--                        <div class="form-group col-12 col-md-3">--}}
                    {{--                            <label for="postcode">{{ trans('cruds.user.fields.postcode') }}</label>--}}
                    {{--                            <input class="form-control {{ $errors->has('postcode') ? 'is-invalid' : '' }}"--}}
                    {{--                                   type="text"--}}
                    {{--                                   name="postcode" id="postcode" value="{{ old('postcode', $user->postcode) }}">--}}
                    {{--                            @if($errors->has('postcode'))--}}
                    {{--                                <div class="invalid-feedback">--}}
                    {{--                                    {{ $errors->first('postcode') }}--}}
                    {{--                                </div>--}}
                    {{--                            @endif--}}
                    {{--                            <span class="help-block">{{ trans('cruds.user.fields.postcode_helper') }}</span>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="form-group col-12 col-md-3">--}}
                    {{--                            <label for="city_id">{{ trans('cruds.user.fields.city') }}</label>--}}
                    {{--                            <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}"--}}
                    {{--                                    name="city_id"--}}
                    {{--                                    id="city_id">--}}
                    {{--                                @foreach($cities as $id => $entry)--}}
                    {{--                                    <option value="{{ $id }}"
                    {{ (old('city_id') ? old('city_id') : $user->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}
                    </option>--}}
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
                    {{--                            <label for="state_id">{{ trans('cruds.user.fields.state') }}</label>--}}
                    {{--                            <select class="form-control select2 {{ $errors->has('state') ? 'is-invalid' : '' }}"--}}
                    {{--                                    name="state_id"--}}
                    {{--                                    id="state_id">--}}
                    {{--                                @foreach($states as $id => $entry)--}}
                    {{--                                    <option value="{{ $id }}"
                    {{ (old('state_id') ? old('state_id') : $user->state->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}
                    </option>--}}
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
                    {{--                            <label for="country_id">{{ trans('cruds.user.fields.country') }}</label>--}}
                    {{--                            <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}"--}}
                    {{--                                    name="country_id" id="country_id">--}}
                    {{--                                @foreach($countries as $id => $entry)--}}
                    {{--                                    <option value="{{ $id }}"
                    {{ (old('country_id') ? old('country_id') : $user->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}
                    </option>--}}
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
                    {{--                    <h4 class="card-title mt-3">Bank Information</h4>--}}
                    {{--                    <div class="row">--}}
                    {{--                        <div class="form-group col-12 col-md-6">--}}
                    {{--                            <label for="bank_owner">{{ trans('cruds.user.fields.bank_owner') }}</label>--}}
                    {{--                            <input class="form-control {{ $errors->has('bank_owner') ? 'is-invalid' : '' }}"--}}
                    {{--                                   type="text"--}}
                    {{--                                   name="bank_owner" id="bank_owner"--}}
                    {{--                                   value="{{ old('bank_owner', $user->bank_owner) }}">--}}
                    {{--                            @if($errors->has('bank_owner'))--}}
                    {{--                                <div class="invalid-feedback">--}}
                    {{--                                    {{ $errors->first('bank_owner') }}--}}
                    {{--                                </div>--}}
                    {{--                            @endif--}}
                    {{--                            <span class="help-block">{{ trans('cruds.user.fields.bank_owner_helper') }}</span>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="form-group col-12 col-md-6">--}}
                    {{--                            <label for="bank_account">{{ trans('cruds.user.fields.bank_account') }}</label>--}}
                    {{--                            <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}"--}}
                    {{--                                   type="text"--}}
                    {{--                                   name="bank_account" id="bank_account"--}}
                    {{--                                   value="{{ old('bank_account', $user->bank_account) }}">--}}
                    {{--                            @if($errors->has('bank_account'))--}}
                    {{--                                <div class="invalid-feedback">--}}
                    {{--                                    {{ $errors->first('bank_account') }}--}}
                    {{--                                </div>--}}
                    {{--                            @endif--}}
                    {{--                            <span class="help-block">{{ trans('cruds.user.fields.bank_account_helper') }}</span>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" id="submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('assets/js/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone/dropzone-script.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        $(".select2").select2();

        var uploadedPhotoMap = {};
        Dropzone.options.documentDropzone = {
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                maxFiles: 1,
                url: '{{ route('admin.profile.storeMedia') }}',
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(file, response) {
                    // $('.dz-processing').remove()
                    $('#hid').addClass('d-none')
                    $('#error').hide()
                    $('form').append('<input type="hidden" name="avatar" id="avatar_form" value="' + response.name + '">')
                    uploadedPhotoMap[file.name] = response.name
                },
                removedfile: function(file) {
                    console.log(file)

                    $('#error').hide()
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedPhotoMap[file.name]
                    }
                    $('form').find('input[name="avatar"][value="' + name + '"]').remove()
                    $('#hid').removeClass('d-none')
                    $('.dz-message').hide()
                    $('.dz-message').show()
                },
                init: function() {
                    @if (isset($bonusRecord) && $bonusRecord->image)
                        var files = {!! json_encode($bonusRecord->image) !!}
                        for (var i in files) {
                            var file = files[i]
                            this.options.addedfile.call(this, file)
                            this.options.thumbnail.call(this, file, file.preview)
                            file.previewElement.classList.add('dz-complete')
                            $('form').append('<input type="hidden" name="avatar" value="' + file.file_name + '">')
                        }
                    @endif
                },
                error: function(file, response) {
                    $('#error').show()
                    error.textContent = response
                    error.style.color = "red"
                    file.previewElement.remove()

                    if ($.type(response) === 'string') {
                        var message = response //dropzone sends it's own error messages in string
                    } else {
                        var message = response.errors.file
                    }
                    file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                        node = _ref[_i]
                        _results.push(node.textContent = message)
                    }

                    return _results
                }
            }

    </script>
    @endpush
</x-admin.app-layout>
