@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.state.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.states.update", [$state->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.state.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $state->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="postcode_format">{{ trans('cruds.state.fields.postcode_format') }}</label>
                <input class="form-control {{ $errors->has('postcode_format') ? 'is-invalid' : '' }}" type="text" name="postcode_format" id="postcode_format" value="{{ old('postcode_format', $state->postcode_format) }}">
                @if($errors->has('postcode_format'))
                    <div class="invalid-feedback">
                        {{ $errors->first('postcode_format') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.postcode_format_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_postcode">{{ trans('cruds.state.fields.other_postcode') }}</label>
                <input class="form-control {{ $errors->has('other_postcode') ? 'is-invalid' : '' }}" type="text" name="other_postcode" id="other_postcode" value="{{ old('other_postcode', $state->other_postcode) }}">
                @if($errors->has('other_postcode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('other_postcode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.other_postcode_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.state.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="number" name="status" id="status" value="{{ old('status', $state->status) }}" step="1">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.state.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ (old('country_id') ? old('country_id') : $state->country->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.state.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection