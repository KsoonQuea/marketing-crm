@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseFinancial.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-financials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.current_asset') }}
                        </th>
                        <td>
                            {{ $caseFinancial->current_asset }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.non_current_asset') }}
                        </th>
                        <td>
                            {{ $caseFinancial->non_current_asset }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.director_asset') }}
                        </th>
                        <td>
                            {{ $caseFinancial->director_asset }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.related_customer_asset') }}
                        </th>
                        <td>
                            {{ $caseFinancial->related_customer_asset }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.customer_asset') }}
                        </th>
                        <td>
                            {{ $caseFinancial->customer_asset }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.current_liabilities') }}
                        </th>
                        <td>
                            {{ $caseFinancial->current_liabilities }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.non_current_liabilities') }}
                        </th>
                        <td>
                            {{ $caseFinancial->non_current_liabilities }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.director_liabilities') }}
                        </th>
                        <td>
                            {{ $caseFinancial->director_liabilities }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.related_customer_liabilities') }}
                        </th>
                        <td>
                            {{ $caseFinancial->related_customer_liabilities }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.customer_liabilities') }}
                        </th>
                        <td>
                            {{ $caseFinancial->customer_liabilities }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.loan_n_hp') }}
                        </th>
                        <td>
                            {{ $caseFinancial->loan_n_hp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.share_capital') }}
                        </th>
                        <td>
                            {{ $caseFinancial->share_capital }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.revenue') }}
                        </th>
                        <td>
                            {{ $caseFinancial->revenue }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.sales_cost') }}
                        </th>
                        <td>
                            {{ $caseFinancial->sales_cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.finance_cost') }}
                        </th>
                        <td>
                            {{ $caseFinancial->finance_cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.depreciation') }}
                        </th>
                        <td>
                            {{ $caseFinancial->depreciation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.profit') }}
                        </th>
                        <td>
                            {{ $caseFinancial->profit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.tax') }}
                        </th>
                        <td>
                            {{ $caseFinancial->tax }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseFinancial.fields.financial_date') }}
                        </th>
                        <td>
                            {{ $caseFinancial->financial_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-financials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection