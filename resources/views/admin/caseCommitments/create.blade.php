@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.caseCommitment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-commitments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseCommitment.fields.case') }}</label>
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
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="house_loan">{{ trans('cruds.caseCommitment.fields.house_loan') }}</label>
                <input class="form-control {{ $errors->has('house_loan') ? 'is-invalid' : '' }}" type="number" name="house_loan" id="house_loan" value="{{ old('house_loan', '0') }}" step="0.01">
                @if($errors->has('house_loan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('house_loan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.house_loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="term_loan">{{ trans('cruds.caseCommitment.fields.term_loan') }}</label>
                <input class="form-control {{ $errors->has('term_loan') ? 'is-invalid' : '' }}" type="number" name="term_loan" id="term_loan" value="{{ old('term_loan', '0') }}" step="0.01">
                @if($errors->has('term_loan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('term_loan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.term_loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hire_purchase">{{ trans('cruds.caseCommitment.fields.hire_purchase') }}</label>
                <input class="form-control {{ $errors->has('hire_purchase') ? 'is-invalid' : '' }}" type="number" name="hire_purchase" id="hire_purchase" value="{{ old('hire_purchase', '0') }}" step="0.01">
                @if($errors->has('hire_purchase'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hire_purchase') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.hire_purchase_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit_card_limit">{{ trans('cruds.caseCommitment.fields.credit_card_limit') }}</label>
                <input class="form-control {{ $errors->has('credit_card_limit') ? 'is-invalid' : '' }}" type="number" name="credit_card_limit" id="credit_card_limit" value="{{ old('credit_card_limit', '0') }}" step="0.01">
                @if($errors->has('credit_card_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit_card_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.credit_card_limit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="trade_line_limit">{{ trans('cruds.caseCommitment.fields.trade_line_limit') }}</label>
                <input class="form-control {{ $errors->has('trade_line_limit') ? 'is-invalid' : '' }}" type="number" name="trade_line_limit" id="trade_line_limit" value="{{ old('trade_line_limit', '0') }}" step="0.01">
                @if($errors->has('trade_line_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('trade_line_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCommitment.fields.trade_line_limit_helper') }}</span>
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