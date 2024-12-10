@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bankStatement.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-statements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.bank') }}
                        </th>
                        <td>
                            {{ $bankStatement->bank->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.case') }}
                        </th>
                        <td>
                            {{ $bankStatement->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.bank_owner') }}
                        </th>
                        <td>
                            {{ $bankStatement->bank_owner }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.bank_account') }}
                        </th>
                        <td>
                            {{ $bankStatement->bank_account }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.credit') }}
                        </th>
                        <td>
                            {{ $bankStatement->credit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.debit') }}
                        </th>
                        <td>
                            {{ $bankStatement->debit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bankStatement.fields.month_end_balance') }}
                        </th>
                        <td>
                            {{ $bankStatement->month_end_balance }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bank-statements.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection