@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userTeam.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userTeam.fields.name') }}
                        </th>
                        <td>
                            {{ $userTeam->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userTeam.fields.team_lead') }}
                        </th>
                        <td>
                            {{ $userTeam->team_lead->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userTeam.fields.team_member') }}
                        </th>
                        <td>
                            @foreach($userTeam->team_members as $key => $team_member)
                                <span class="label label-info">{{ $team_member->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-teams.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection