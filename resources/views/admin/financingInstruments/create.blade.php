@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.financingInstrument.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.financing-instruments.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="loan_product">{{ trans('cruds.financingInstrument.fields.loan_product') }}</label>
                <input class="form-control {{ $errors->has('loan_product') ? 'is-invalid' : '' }}" type="text" name="loan_product" id="loan_product" value="{{ old('loan_product', '') }}">
                @if($errors->has('loan_product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loan_product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.financingInstrument.fields.loan_product_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="interest_rate">{{ trans('cruds.financingInstrument.fields.interest_rate') }}</label>
                <input class="form-control {{ $errors->has('interest_rate') ? 'is-invalid' : '' }}" type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', '') }}" step="0.01">
                @if($errors->has('interest_rate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('interest_rate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.financingInstrument.fields.interest_rate_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tenor">{{ trans('cruds.financingInstrument.fields.tenor') }}</label>
                <input class="form-control {{ $errors->has('tenor') ? 'is-invalid' : '' }}" type="text" name="tenor" id="tenor" value="{{ old('tenor', '') }}">
                @if($errors->has('tenor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tenor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.financingInstrument.fields.tenor_helper') }}</span>
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