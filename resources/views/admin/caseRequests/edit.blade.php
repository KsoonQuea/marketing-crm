@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-requests.update", [$caseRequest->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseRequest.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseRequest->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="request">{{ trans('cruds.caseRequest.fields.request') }}</label>
                <input class="form-control {{ $errors->has('request') ? 'is-invalid' : '' }}" type="text" name="request" id="request" value="{{ old('request', $caseRequest->request) }}">
                @if($errors->has('request'))
                    <div class="invalid-feedback">
                        {{ $errors->first('request') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.request_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="request_type_id">{{ trans('cruds.caseRequest.fields.request_type') }}</label>
                <select class="form-control select2 {{ $errors->has('request_type') ? 'is-invalid' : '' }}" name="request_type_id" id="request_type_id">
                    @foreach($request_types as $id => $entry)
                        <option value="{{ $id }}" {{ (old('request_type_id') ? old('request_type_id') : $caseRequest->request_type->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('request_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('request_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.request_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="facility_type">{{ trans('cruds.caseRequest.fields.facility_type') }}</label>
                <input class="form-control {{ $errors->has('facility_type') ? 'is-invalid' : '' }}" type="text" name="facility_type" id="facility_type" value="{{ old('facility_type', $caseRequest->facility_type) }}">
                @if($errors->has('facility_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('facility_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.facility_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="amount">{{ trans('cruds.caseRequest.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $caseRequest->amount) }}" step="0.01">
                @if($errors->has('amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="specific_concern">{{ trans('cruds.caseRequest.fields.specific_concern') }}</label>
                <input class="form-control {{ $errors->has('specific_concern') ? 'is-invalid' : '' }}" type="text" name="specific_concern" id="specific_concern" value="{{ old('specific_concern', $caseRequest->specific_concern) }}">
                @if($errors->has('specific_concern'))
                    <div class="invalid-feedback">
                        {{ $errors->first('specific_concern') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseRequest.fields.specific_concern_helper') }}</span>
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