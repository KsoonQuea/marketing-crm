@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userCaseLog.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-case-logs.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.userCaseLog.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userCaseLog.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.userCaseLog.fields.case') }}</label>
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
                <span class="help-block">{{ trans('cruds.userCaseLog.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="case_stage">{{ trans('cruds.userCaseLog.fields.case_stage') }}</label>
                <input class="form-control {{ $errors->has('case_stage') ? 'is-invalid' : '' }}" type="number" name="case_stage" id="case_stage" value="{{ old('case_stage', '') }}" step="1">
                @if($errors->has('case_stage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case_stage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userCaseLog.fields.case_stage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action_status">{{ trans('cruds.userCaseLog.fields.action_status') }}</label>
                <input class="form-control {{ $errors->has('action_status') ? 'is-invalid' : '' }}" type="number" name="action_status" id="action_status" value="{{ old('action_status', '') }}" step="1">
                @if($errors->has('action_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userCaseLog.fields.action_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action_remark">{{ trans('cruds.userCaseLog.fields.action_remark') }}</label>
                <input class="form-control {{ $errors->has('action_remark') ? 'is-invalid' : '' }}" type="text" name="action_remark" id="action_remark" value="{{ old('action_remark', '') }}">
                @if($errors->has('action_remark'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action_remark') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userCaseLog.fields.action_remark_helper') }}</span>
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