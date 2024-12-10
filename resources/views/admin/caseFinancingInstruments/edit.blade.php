@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseFinancingInstrument.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-financing-instruments.update", [$caseFinancingInstrument->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseFinancingInstrument.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseFinancingInstrument->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancingInstrument.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="financing_instrument_id">{{ trans('cruds.caseFinancingInstrument.fields.financing_instrument') }}</label>
                <select class="form-control select2 {{ $errors->has('financing_instrument') ? 'is-invalid' : '' }}" name="financing_instrument_id" id="financing_instrument_id">
                    @foreach($financing_instruments as $id => $entry)
                        <option value="{{ $id }}" {{ (old('financing_instrument_id') ? old('financing_instrument_id') : $caseFinancingInstrument->financing_instrument->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('financing_instrument'))
                    <div class="invalid-feedback">
                        {{ $errors->first('financing_instrument') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancingInstrument.fields.financing_instrument_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="proposed_limit">{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</label>
                <input class="form-control {{ $errors->has('proposed_limit') ? 'is-invalid' : '' }}" type="number" name="proposed_limit" id="proposed_limit" value="{{ old('proposed_limit', $caseFinancingInstrument->proposed_limit) }}" step="0.01">
                @if($errors->has('proposed_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('proposed_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit_helper') }}</span>
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