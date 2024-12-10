@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseCreditCheck.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-credit-checks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCreditCheck.fields.case') }}
                        </th>
                        <td>
                            {{ $caseCreditCheck->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCreditCheck.fields.credit_check') }}
                        </th>
                        <td>
                            {{ $caseCreditCheck->credit_check->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCreditCheck.fields.finding') }}
                        </th>
                        <td>
                            {{ $caseCreditCheck->finding }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCreditCheck.fields.migration') }}
                        </th>
                        <td>
                            {{ $caseCreditCheck->migration }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-credit-checks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection