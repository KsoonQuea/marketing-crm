@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseReportRecommendation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-report-recommendations.update", [$caseReportRecommendation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseReportRecommendation.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseReportRecommendation->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseReportRecommendation.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="recommendation">{{ trans('cruds.caseReportRecommendation.fields.recommendation') }}</label>
                <textarea class="form-control {{ $errors->has('recommendation') ? 'is-invalid' : '' }}" name="recommendation" id="recommendation">{{ old('recommendation', $caseReportRecommendation->recommendation) }}</textarea>
                @if($errors->has('recommendation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('recommendation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseReportRecommendation.fields.recommendation_helper') }}</span>
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