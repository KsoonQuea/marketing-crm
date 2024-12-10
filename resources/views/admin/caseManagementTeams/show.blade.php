@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.caseManagementTeam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-management-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.case') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->case->case_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.name') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.age') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.phone') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.email') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.designation') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.shareholding') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->shareholding }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.responsible_area') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->responsible_area }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.experience_year') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->experience_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.case_year') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->case_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.caseManagementTeam.fields.director_relationship') }}
                        </th>
                        <td>
                            {{ $caseManagementTeam->director_relationship }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.case-management-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection