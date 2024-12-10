@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.financingInstrument.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.financing-instruments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.financingInstrument.fields.loan_product') }}
                        </th>
                        <td>
                            {{ $financingInstrument->loan_product }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.financingInstrument.fields.interest_rate') }}
                        </th>
                        <td>
                            {{ $financingInstrument->interest_rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.financingInstrument.fields.tenor') }}
                        </th>
                        <td>
                            {{ $financingInstrument->tenor }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.financing-instruments.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection