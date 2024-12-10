@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.caseDirectorCommitment.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-director-commitments.update", [$caseDirectorCommitment->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="case_id">{{ trans('cruds.caseDirectorCommitment.fields.case') }}</label>
                <select class="form-control select2 {{ $errors->has('case') ? 'is-invalid' : '' }}" name="case_id" id="case_id">
                    @foreach($cases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('case_id') ? old('case_id') : $caseDirectorCommitment->case->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('case'))
                    <div class="invalid-feedback">
                        {{ $errors->first('case') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.case_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="director_name">{{ trans('cruds.caseDirectorCommitment.fields.director_name') }}</label>
                <input class="form-control {{ $errors->has('director_name') ? 'is-invalid' : '' }}" type="text" name="director_name" id="director_name" value="{{ old('director_name', $caseDirectorCommitment->director_name) }}">
                @if($errors->has('director_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('director_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.director_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="house_loan">{{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}</label>
                <input class="form-control {{ $errors->has('house_loan') ? 'is-invalid' : '' }}" type="number" name="house_loan" id="house_loan" value="{{ old('house_loan', $caseDirectorCommitment->house_loan) }}" step="0.01">
                @if($errors->has('house_loan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('house_loan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.house_loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="personal_loan">{{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}</label>
                <input class="form-control {{ $errors->has('personal_loan') ? 'is-invalid' : '' }}" type="number" name="personal_loan" id="personal_loan" value="{{ old('personal_loan', $caseDirectorCommitment->personal_loan) }}" step="0.01">
                @if($errors->has('personal_loan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('personal_loan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.personal_loan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hire_purchase">{{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}</label>
                <input class="form-control {{ $errors->has('hire_purchase') ? 'is-invalid' : '' }}" type="number" name="hire_purchase" id="hire_purchase" value="{{ old('hire_purchase', $caseDirectorCommitment->hire_purchase) }}" step="0.01">
                @if($errors->has('hire_purchase'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hire_purchase') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.hire_purchase_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="credit_card_limit">{{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}</label>
                <input class="form-control {{ $errors->has('credit_card_limit') ? 'is-invalid' : '' }}" type="number" name="credit_card_limit" id="credit_card_limit" value="{{ old('credit_card_limit', $caseDirectorCommitment->credit_card_limit) }}" step="0.01">
                @if($errors->has('credit_card_limit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('credit_card_limit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit_helper') }}</span>
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