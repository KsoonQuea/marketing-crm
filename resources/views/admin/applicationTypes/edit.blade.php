<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.edit') }} {{ trans('cruds.applicationType.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.application-types.index') }}">
                {{ trans('cruds.applicationType.title_singular') }} {{ trans('global.list') }}
            </a>
        </li>
        <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.applicationType.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.application-types.update", [$applicationType->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-12 col-md-8">
                            <label class="required" for="name">{{ trans('cruds.applicationType.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $applicationType->name) }}" required>
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.applicationType.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required"
                                for="name">{{ trans('cruds.applicationType.fields.status') }}</label>
                                <select class="form-control select2" name="status">
                                    @foreach(array_column(\App\Enum\Status::cases(), 'name', 'value') as $skey => $svalue)
                                        <option value="{{ $skey }}" {{ $applicationType->status->value == $skey ? 'selected' : '' }}>{{ $svalue }}</option>
                                    @endforeach
                                </select>
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.requestType.fields.status_helper') }}</span>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.application-types.index') }}" class="btn btn-light ms-2">Cancel</a>
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
