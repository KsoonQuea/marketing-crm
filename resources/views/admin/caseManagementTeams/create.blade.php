@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.caseManagementTeam.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-management-teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseManagementTeam.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ old('case_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.caseManagementTeam.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.caseManagementTeam.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', '') }}" step="1">
                @if($errors->has('age'))
                    <div class="invalid-feedback">
                        {{ $errors->first('age') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">{{ trans('cruds.caseManagementTeam.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.caseManagementTeam.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation">{{ trans('cruds.caseManagementTeam.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}">
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="shareholding">{{ trans('cruds.caseManagementTeam.fields.shareholding') }}</label>
                <input class="form-control {{ $errors->has('shareholding') ? 'is-invalid' : '' }}" type="number" name="shareholding" id="shareholding" value="{{ old('shareholding', '') }}" step="0.01">
                @if($errors->has('shareholding'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shareholding') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.shareholding_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="responsible_area">{{ trans('cruds.caseManagementTeam.fields.responsible_area') }}</label>
                <input class="form-control {{ $errors->has('responsible_area') ? 'is-invalid' : '' }}" type="text" name="responsible_area" id="responsible_area" value="{{ old('responsible_area', '') }}">
                @if($errors->has('responsible_area'))
                    <div class="invalid-feedback">
                        {{ $errors->first('responsible_area') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.responsible_area_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="experience_year">{{ trans('cruds.caseManagementTeam.fields.experience_year') }}</label>
                <input class="form-control {{ $errors->has('experience_year') ? 'is-invalid' : '' }}" type="number" name="experience_year" id="experience_year" value="{{ old('experience_year', '') }}" step="1">
                @if($errors->has('experience_year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('experience_year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.experience_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="case_year">{{ trans('cruds.caseManagementTeam.fields.case_year') }}</label>
                <input class="form-control {{ $errors->has('case_year') ? 'is-invalid' : '' }}" type="number" name="case_year" id="case_year" value="{{ old('case_year', '') }}" step="1">
                @if($errors->has('case_year'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_year') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.case_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="director_relationship">{{ trans('cruds.caseManagementTeam.fields.director_relationship') }}</label>
                <input class="form-control {{ $errors->has('director_relationship') ? 'is-invalid' : '' }}" type="text" name="director_relationship" id="director_relationship" value="{{ old('director_relationship', '') }}">
                @if($errors->has('director_relationship'))
                    <div class="invalid-feedback">
                        {{ $errors->first('director_relationship') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseManagementTeam.fields.director_relationship_helper') }}</span>
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