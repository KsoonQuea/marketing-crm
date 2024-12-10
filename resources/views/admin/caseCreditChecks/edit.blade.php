@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseCreditCheck.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-credit-checks.update", [$caseCreditCheck->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseCreditCheck.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseCreditCheck->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCreditCheck.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit_check_id">{{ trans('cruds.caseCreditCheck.fields.credit_check') }}</label>
                <select class="form-control select2 {{ $errors->has('credit_check') ? 'is-invalid' : '' }}" name="credit_check_id" id="credit_check_id">
                    @foreach($credit_checks as $id => $entry)
                        <option value="{{ $id }}" {{ (old('credit_check_id') ? old('credit_check_id') : $caseCreditCheck->credit_check->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('credit_check'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit_check') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCreditCheck.fields.credit_check_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="finding">{{ trans('cruds.caseCreditCheck.fields.finding') }}</label>
                <input class="form-control {{ $errors->has('finding') ? 'is-invalid' : '' }}" type="text" name="finding" id="finding" value="{{ old('finding', $caseCreditCheck->finding) }}">
                @if($errors->has('finding'))
                    <div class="invalid-feedback">
                        {{ $errors->first('finding') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCreditCheck.fields.finding_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="migration">{{ trans('cruds.caseCreditCheck.fields.migration') }}</label>
                <input class="form-control {{ $errors->has('migration') ? 'is-invalid' : '' }}" type="text" name="migration" id="migration" value="{{ old('migration', $caseCreditCheck->migration) }}">
                @if($errors->has('migration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('migration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCreditCheck.fields.migration_helper') }}</span>
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