@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseCriterion.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-criteria.update", [$caseCriterion->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseCriterion.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseCriterion->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCriterion.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="criteria_id">{{ trans('cruds.caseCriterion.fields.criteria') }}</label>
                <select class="form-control select2 {{ $errors->has('criteria') ? 'is-invalid' : '' }}" name="criteria_id" id="criteria_id">
                    @foreach($criterias as $id => $entry)
                        <option value="{{ $id }}" {{ (old('criteria_id') ? old('criteria_id') : $caseCriterion->criteria->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('criteria'))
                    <div class="invalid-feedback">
                        {{ $errors->first('criteria') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCriterion.fields.criteria_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.caseCriterion.fields.answer') }}</label>
                <select class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" name="answer" id="answer">
                    <option value disabled {{ old('answer', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CaseCriterion::ANSWER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('answer', $caseCriterion->answer) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('answer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('answer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseCriterion.fields.answer_helper') }}</span>
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