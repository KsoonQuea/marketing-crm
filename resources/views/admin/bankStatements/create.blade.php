@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.bankStatement.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bank-statements.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="bank_id">{{ trans('cruds.bankStatement.fields.bank') }}</label>
                <select class="form-control select2 {{ $errors->has('bank') ? 'is-invalid' : '' }}" name="bank_id" id="bank_id">
                    @foreach($banks as $id => $entry)
                        <option value="{{ $id }}" {{ old('bank_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('bank'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.bank_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.bankStatement.fields.case') }}</label>
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
                <span class="help-block">{{ trans('cruds.bankStatement.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_owner">{{ trans('cruds.bankStatement.fields.bank_owner') }}</label>
                <input class="form-control {{ $errors->has('bank_owner') ? 'is-invalid' : '' }}" type="text" name="bank_owner" id="bank_owner" value="{{ old('bank_owner', '') }}">
                @if($errors->has('bank_owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.bank_owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_account">{{ trans('cruds.bankStatement.fields.bank_account') }}</label>
                <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}" type="text" name="bank_account" id="bank_account" value="{{ old('bank_account', '') }}">
                @if($errors->has('bank_account'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_account') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.bank_account_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit">{{ trans('cruds.bankStatement.fields.credit') }}</label>
                <input class="form-control {{ $errors->has('credit') ? 'is-invalid' : '' }}" type="number" name="credit" id="credit" value="{{ old('credit', '0.00') }}" step="0.01">
                @if($errors->has('credit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.credit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="debit">{{ trans('cruds.bankStatement.fields.debit') }}</label>
                <input class="form-control {{ $errors->has('debit') ? 'is-invalid' : '' }}" type="number" name="debit" id="debit" value="{{ old('debit', '0.00') }}" step="0.01">
                @if($errors->has('debit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('debit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.debit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="month_end_balance">{{ trans('cruds.bankStatement.fields.month_end_balance') }}</label>
                <input class="form-control {{ $errors->has('month_end_balance') ? 'is-invalid' : '' }}" type="number" name="month_end_balance" id="month_end_balance" value="{{ old('month_end_balance', '0.00') }}" step="0.01">
                @if($errors->has('month_end_balance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('month_end_balance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.bankStatement.fields.month_end_balance_helper') }}</span>
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