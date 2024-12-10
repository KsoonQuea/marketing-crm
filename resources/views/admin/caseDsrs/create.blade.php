@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.caseDsr.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-dsrs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseDsr.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ old('case_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ebitda">{{ trans('cruds.caseDsr.fields.ebitda') }}</label>
                <input class="form-control {{ $errors->has('ebitda') ? 'is-invalid' : '' }}" type="number" name="ebitda" id="ebitda" value="{{ old('ebitda', '') }}" step="0.01">
                @if($errors->has('ebitda'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ebitda') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.ebitda_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ccris_commitment">{{ trans('cruds.caseDsr.fields.ccris_commitment') }}</label>
                <input class="form-control {{ $errors->has('ccris_commitment') ? 'is-invalid' : '' }}" type="number" name="ccris_commitment" id="ccris_commitment" value="{{ old('ccris_commitment', '') }}" step="0.01">
                @if($errors->has('ccris_commitment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ccris_commitment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.ccris_commitment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_statement_commitment">{{ trans('cruds.caseDsr.fields.bank_statement_commitment') }}</label>
                <input class="form-control {{ $errors->has('bank_statement_commitment') ? 'is-invalid' : '' }}" type="number" name="bank_statement_commitment" id="bank_statement_commitment" value="{{ old('bank_statement_commitment', '') }}" step="0.01">
                @if($errors->has('bank_statement_commitment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_statement_commitment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.bank_statement_commitment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="new_financing_commitment">{{ trans('cruds.caseDsr.fields.new_financing_commitment') }}</label>
                <input class="form-control {{ $errors->has('new_financing_commitment') ? 'is-invalid' : '' }}" type="number" name="new_financing_commitment" id="new_financing_commitment" value="{{ old('new_financing_commitment', '') }}" step="0.01">
                @if($errors->has('new_financing_commitment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('new_financing_commitment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.new_financing_commitment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dsr">{{ trans('cruds.caseDsr.fields.dsr') }}</label>
                <input class="form-control {{ $errors->has('dsr') ? 'is-invalid' : '' }}" type="number" name="dsr" id="dsr" value="{{ old('dsr', '') }}" step="0.01">
                @if($errors->has('dsr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dsr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDsr.fields.dsr_helper') }}</span>
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