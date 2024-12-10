@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseCashflowMonCommit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-cashflow-mon-commits.update", [$caseCashflowMonCommit->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseCashflowMonCommit.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseCashflowMonCommit->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="avg_mon_end_bank_balances">{{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_end_bank_balances') }}</label>
                <input class="form-control {{ $errors->has('avg_mon_end_bank_balances') ? 'is-invalid' : '' }}" type="number" name="avg_mon_end_bank_balances" id="avg_mon_end_bank_balances" value="{{ old('avg_mon_end_bank_balances', $caseCashflowMonCommit->avg_mon_end_bank_balances) }}" step="0.01">
                @if($errors->has('avg_mon_end_bank_balances'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avg_mon_end_bank_balances') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_end_bank_balances_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="avg_mon_credit_transactions">{{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_credit_transactions') }}</label>
                <input class="form-control {{ $errors->has('avg_mon_credit_transactions') ? 'is-invalid' : '' }}" type="number" name="avg_mon_credit_transactions" id="avg_mon_credit_transactions" value="{{ old('avg_mon_credit_transactions', $caseCashflowMonCommit->avg_mon_credit_transactions) }}" step="0.01">
                @if($errors->has('avg_mon_credit_transactions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('avg_mon_credit_transactions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_credit_transactions_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mon_commitment">{{ trans('cruds.caseCashflowMonCommit.fields.mon_commitment') }}</label>
                <input class="form-control {{ $errors->has('mon_commitment') ? 'is-invalid' : '' }}" type="number" name="mon_commitment" id="mon_commitment" value="{{ old('mon_commitment', $caseCashflowMonCommit->mon_commitment) }}" step="0.01">
                @if($errors->has('mon_commitment'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mon_commitment') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.mon_commitment_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tot_mon_commitment_for_directors">{{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_for_directors') }}</label>
                <input class="form-control {{ $errors->has('tot_mon_commitment_for_directors') ? 'is-invalid' : '' }}" type="number" name="tot_mon_commitment_for_directors" id="tot_mon_commitment_for_directors" value="{{ old('tot_mon_commitment_for_directors', $caseCashflowMonCommit->tot_mon_commitment_for_directors) }}" step="0.01">
                @if($errors->has('tot_mon_commitment_for_directors'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tot_mon_commitment_for_directors') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_for_directors_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tot_mon_commitment_of_directors_and_company">{{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_of_directors_and_company') }}</label>
                <input class="form-control {{ $errors->has('tot_mon_commitment_of_directors_and_company') ? 'is-invalid' : '' }}" type="number" name="tot_mon_commitment_of_directors_and_company" id="tot_mon_commitment_of_directors_and_company" value="{{ old('tot_mon_commitment_of_directors_and_company', $caseCashflowMonCommit->tot_mon_commitment_of_directors_and_company) }}" step="0.01">
                @if($errors->has('tot_mon_commitment_of_directors_and_company'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tot_mon_commitment_of_directors_and_company') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_of_directors_and_company_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="annualized_revenue">{{ trans('cruds.caseCashflowMonCommit.fields.annualized_revenue') }}</label>
                <input class="form-control {{ $errors->has('annualized_revenue') ? 'is-invalid' : '' }}" type="number" name="annualized_revenue" id="annualized_revenue" value="{{ old('annualized_revenue', $caseCashflowMonCommit->annualized_revenue) }}" step="0.01">
                @if($errors->has('annualized_revenue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('annualized_revenue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.annualized_revenue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="income_factor">{{ trans('cruds.caseCashflowMonCommit.fields.income_factor') }}</label>
                <input class="form-control {{ $errors->has('income_factor') ? 'is-invalid' : '' }}" type="number" name="income_factor" id="income_factor" value="{{ old('income_factor', $caseCashflowMonCommit->income_factor) }}" step="0.01">
                @if($errors->has('income_factor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('income_factor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.income_factor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dsr">{{ trans('cruds.caseCashflowMonCommit.fields.dsr') }}</label>
                <input class="form-control {{ $errors->has('dsr') ? 'is-invalid' : '' }}" type="number" name="dsr" id="dsr" value="{{ old('dsr', $caseCashflowMonCommit->dsr) }}" step="0.01">
                @if($errors->has('dsr'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dsr') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCashflowMonCommit.fields.dsr_helper') }}</span>
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