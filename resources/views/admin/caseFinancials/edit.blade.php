@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseFinancial.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-financials.update", [$caseFinancial->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="current_asset">{{ trans('cruds.caseFinancial.fields.current_asset') }}</label>
                <input class="form-control {{ $errors->has('current_asset') ? 'is-invalid' : '' }}" type="number" name="current_asset" id="current_asset" value="{{ old('current_asset', $caseFinancial->current_asset) }}" step="0.01">
                @if($errors->has('current_asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_asset') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.current_asset_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="non_current_asset">{{ trans('cruds.caseFinancial.fields.non_current_asset') }}</label>
                <input class="form-control {{ $errors->has('non_current_asset') ? 'is-invalid' : '' }}" type="number" name="non_current_asset" id="non_current_asset" value="{{ old('non_current_asset', $caseFinancial->non_current_asset) }}" step="0.01">
                @if($errors->has('non_current_asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('non_current_asset') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.non_current_asset_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="director_asset">{{ trans('cruds.caseFinancial.fields.director_asset') }}</label>
                <input class="form-control {{ $errors->has('director_asset') ? 'is-invalid' : '' }}" type="number" name="director_asset" id="director_asset" value="{{ old('director_asset', $caseFinancial->director_asset) }}" step="0.01">
                @if($errors->has('director_asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('director_asset') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.director_asset_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="related_customer_asset">{{ trans('cruds.caseFinancial.fields.related_customer_asset') }}</label>
                <input class="form-control {{ $errors->has('related_customer_asset') ? 'is-invalid' : '' }}" type="number" name="related_customer_asset" id="related_customer_asset" value="{{ old('related_customer_asset', $caseFinancial->related_customer_asset) }}" step="0.01">
                @if($errors->has('related_customer_asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('related_customer_asset') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.related_customer_asset_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="customer_asset">{{ trans('cruds.caseFinancial.fields.customer_asset') }}</label>
                <input class="form-control {{ $errors->has('customer_asset') ? 'is-invalid' : '' }}" type="number" name="customer_asset" id="customer_asset" value="{{ old('customer_asset', $caseFinancial->customer_asset) }}" step="0.01">
                @if($errors->has('customer_asset'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_asset') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.customer_asset_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="current_liabilities">{{ trans('cruds.caseFinancial.fields.current_liabilities') }}</label>
                <input class="form-control {{ $errors->has('current_liabilities') ? 'is-invalid' : '' }}" type="number" name="current_liabilities" id="current_liabilities" value="{{ old('current_liabilities', $caseFinancial->current_liabilities) }}" step="0.01">
                @if($errors->has('current_liabilities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('current_liabilities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.current_liabilities_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="non_current_liabilities">{{ trans('cruds.caseFinancial.fields.non_current_liabilities') }}</label>
                <input class="form-control {{ $errors->has('non_current_liabilities') ? 'is-invalid' : '' }}" type="number" name="non_current_liabilities" id="non_current_liabilities" value="{{ old('non_current_liabilities', $caseFinancial->non_current_liabilities) }}" step="0.01">
                @if($errors->has('non_current_liabilities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('non_current_liabilities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.non_current_liabilities_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="director_liabilities">{{ trans('cruds.caseFinancial.fields.director_liabilities') }}</label>
                <input class="form-control {{ $errors->has('director_liabilities') ? 'is-invalid' : '' }}" type="number" name="director_liabilities" id="director_liabilities" value="{{ old('director_liabilities', $caseFinancial->director_liabilities) }}" step="0.01">
                @if($errors->has('director_liabilities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('director_liabilities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.director_liabilities_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="related_customer_liabilities">{{ trans('cruds.caseFinancial.fields.related_customer_liabilities') }}</label>
                <input class="form-control {{ $errors->has('related_customer_liabilities') ? 'is-invalid' : '' }}" type="number" name="related_customer_liabilities" id="related_customer_liabilities" value="{{ old('related_customer_liabilities', $caseFinancial->related_customer_liabilities) }}" step="0.01">
                @if($errors->has('related_customer_liabilities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('related_customer_liabilities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.related_customer_liabilities_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="customer_liabilities">{{ trans('cruds.caseFinancial.fields.customer_liabilities') }}</label>
                <input class="form-control {{ $errors->has('customer_liabilities') ? 'is-invalid' : '' }}" type="number" name="customer_liabilities" id="customer_liabilities" value="{{ old('customer_liabilities', $caseFinancial->customer_liabilities) }}" step="0.01">
                @if($errors->has('customer_liabilities'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer_liabilities') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.customer_liabilities_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="loan_n_hp">{{ trans('cruds.caseFinancial.fields.loan_n_hp') }}</label>
                <input class="form-control {{ $errors->has('loan_n_hp') ? 'is-invalid' : '' }}" type="number" name="loan_n_hp" id="loan_n_hp" value="{{ old('loan_n_hp', $caseFinancial->loan_n_hp) }}" step="0.01">
                @if($errors->has('loan_n_hp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loan_n_hp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.loan_n_hp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="share_capital">{{ trans('cruds.caseFinancial.fields.share_capital') }}</label>
                <input class="form-control {{ $errors->has('share_capital') ? 'is-invalid' : '' }}" type="number" name="share_capital" id="share_capital" value="{{ old('share_capital', $caseFinancial->share_capital) }}" step="0.01">
                @if($errors->has('share_capital'))
                    <div class="invalid-feedback">
                        {{ $errors->first('share_capital') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.share_capital_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="revenue">{{ trans('cruds.caseFinancial.fields.revenue') }}</label>
                <input class="form-control {{ $errors->has('revenue') ? 'is-invalid' : '' }}" type="number" name="revenue" id="revenue" value="{{ old('revenue', $caseFinancial->revenue) }}" step="0.01">
                @if($errors->has('revenue'))
                    <div class="invalid-feedback">
                        {{ $errors->first('revenue') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.revenue_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sales_cost">{{ trans('cruds.caseFinancial.fields.sales_cost') }}</label>
                <input class="form-control {{ $errors->has('sales_cost') ? 'is-invalid' : '' }}" type="number" name="sales_cost" id="sales_cost" value="{{ old('sales_cost', $caseFinancial->sales_cost) }}" step="0.01">
                @if($errors->has('sales_cost'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sales_cost') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.sales_cost_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="finance_cost">{{ trans('cruds.caseFinancial.fields.finance_cost') }}</label>
                <input class="form-control {{ $errors->has('finance_cost') ? 'is-invalid' : '' }}" type="number" name="finance_cost" id="finance_cost" value="{{ old('finance_cost', $caseFinancial->finance_cost) }}" step="0.01">
                @if($errors->has('finance_cost'))
                    <div class="invalid-feedback">
                        {{ $errors->first('finance_cost') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.finance_cost_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="depreciation">{{ trans('cruds.caseFinancial.fields.depreciation') }}</label>
                <input class="form-control {{ $errors->has('depreciation') ? 'is-invalid' : '' }}" type="number" name="depreciation" id="depreciation" value="{{ old('depreciation', $caseFinancial->depreciation) }}" step="0.01">
                @if($errors->has('depreciation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('depreciation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.depreciation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="profit">{{ trans('cruds.caseFinancial.fields.profit') }}</label>
                <input class="form-control {{ $errors->has('profit') ? 'is-invalid' : '' }}" type="number" name="profit" id="profit" value="{{ old('profit', $caseFinancial->profit) }}" step="0.01">
                @if($errors->has('profit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.profit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tax">{{ trans('cruds.caseFinancial.fields.tax') }}</label>
                <input class="form-control {{ $errors->has('tax') ? 'is-invalid' : '' }}" type="number" name="tax" id="tax" value="{{ old('tax', $caseFinancial->tax) }}" step="0.01">
                @if($errors->has('tax'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tax') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.tax_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="financial_date">{{ trans('cruds.caseFinancial.fields.financial_date') }}</label>
                <input class="form-control date {{ $errors->has('financial_date') ? 'is-invalid' : '' }}" type="text" name="financial_date" id="financial_date" value="{{ old('financial_date', $caseFinancial->financial_date) }}">
                @if($errors->has('financial_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('financial_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseFinancial.fields.financial_date_helper') }}</span>
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