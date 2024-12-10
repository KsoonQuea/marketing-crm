@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseCashflowMonCommit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-cashflow-mon-commits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.case') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_end_bank_balances') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->avg_mon_end_bank_balances }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.avg_mon_credit_transactions') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->avg_mon_credit_transactions }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.mon_commitment') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->mon_commitment }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_for_directors') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->tot_mon_commitment_for_directors }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.tot_mon_commitment_of_directors_and_company') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->tot_mon_commitment_of_directors_and_company }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.annualized_revenue') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->annualized_revenue }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.income_factor') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->income_factor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCashflowMonCommit.fields.dsr') }}
                        </th>
                        <td>
                            {{ $caseCashflowMonCommit->dsr }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-cashflow-mon-commits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection