@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseGearing.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-gearings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseGearing.fields.borrow_item') }}
                        </th>
                        <td>
                            {{ $caseGearing->borrow_item }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseGearing.fields.borrow_price') }}
                        </th>
                        <td>
                            {{ $caseGearing->borrow_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseGearing.fields.financing_amount') }}
                        </th>
                        <td>
                            {{ $caseGearing->financing_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseGearing.fields.bank_redemtion') }}
                        </th>
                        <td>
                            {{ $caseGearing->bank_redemtion }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseGearing.fields.date') }}
                        </th>
                        <td>
                            {{ $caseGearing->date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-gearings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection