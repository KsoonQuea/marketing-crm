@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseCallLog.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-call-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.user') }}
                        </th>
                        <td>
                            {{ $caseCallLog->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.case') }}
                        </th>
                        <td>
                            {{ $caseCallLog->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.details') }}
                        </th>
                        <td>
                            {{ $caseCallLog->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseCallLog.fields.datetime') }}
                        </th>
                        <td>
                            {{ $caseCallLog->datetime }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-call-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection