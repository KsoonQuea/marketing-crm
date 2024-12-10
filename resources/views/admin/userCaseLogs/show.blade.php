@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userCaseLog.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-case-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userCaseLog.fields.user') }}
                        </th>
                        <td>
                            {{ $userCaseLog->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userCaseLog.fields.case') }}
                        </th>
                        <td>
                            {{ $userCaseLog->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userCaseLog.fields.case_stage') }}
                        </th>
                        <td>
                            {{ $userCaseLog->case_stage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userCaseLog.fields.action_status') }}
                        </th>
                        <td>
                            {{ $userCaseLog->action_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userCaseLog.fields.action_remark') }}
                        </th>
                        <td>
                            {{ $userCaseLog->action_remark }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-case-logs.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection