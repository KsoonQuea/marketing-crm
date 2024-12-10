@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userTeam.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.userTeam.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userTeam.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="team_lead_id">{{ trans('cruds.userTeam.fields.team_lead') }}</label>
                <select class="form-control select2 {{ $errors->has('team_lead') ? 'is-invalid' : '' }}" name="team_lead_id" id="team_lead_id">
                    @foreach($team_leads as $id => $entry)
                        <option value="{{ $id }}" {{ old('team_lead_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('team_lead'))
                    <div class="invalid-feedback">
                        {{ $errors->first('team_lead') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userTeam.fields.team_lead_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="team_members">{{ trans('cruds.userTeam.fields.team_member') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('team_members') ? 'is-invalid' : '' }}" name="team_members[]" id="team_members" multiple>
                    @foreach($team_members as $id => $team_member)
                        <option value="{{ $id }}" {{ in_array($id, old('team_members', [])) ? 'selected' : '' }}>{{ $team_member }}</option>
                    @endforeach
                </select>
                @if($errors->has('team_members'))
                    <div class="invalid-feedback">
                        {{ $errors->first('team_members') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userTeam.fields.team_member_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection