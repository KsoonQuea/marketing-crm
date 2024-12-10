@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.caseGearing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.case-gearings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="borrow_item">{{ trans('cruds.caseGearing.fields.borrow_item') }}</label>
                <input class="form-control {{ $errors->has('borrow_item') ? 'is-invalid' : '' }}" type="text" name="borrow_item" id="borrow_item" value="{{ old('borrow_item', '') }}">
                @if($errors->has('borrow_item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('borrow_item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseGearing.fields.borrow_item_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="borrow_price">{{ trans('cruds.caseGearing.fields.borrow_price') }}</label>
                <input class="form-control {{ $errors->has('borrow_price') ? 'is-invalid' : '' }}" type="number" name="borrow_price" id="borrow_price" value="{{ old('borrow_price', '0') }}" step="0.01">
                @if($errors->has('borrow_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('borrow_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseGearing.fields.borrow_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="financing_amount">{{ trans('cruds.caseGearing.fields.financing_amount') }}</label>
                <input class="form-control {{ $errors->has('financing_amount') ? 'is-invalid' : '' }}" type="number" name="financing_amount" id="financing_amount" value="{{ old('financing_amount', '0') }}" step="0.01">
                @if($errors->has('financing_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('financing_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseGearing.fields.financing_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_redemtion">{{ trans('cruds.caseGearing.fields.bank_redemtion') }}</label>
                <input class="form-control {{ $errors->has('bank_redemtion') ? 'is-invalid' : '' }}" type="number" name="bank_redemtion" id="bank_redemtion" value="{{ old('bank_redemtion', '0') }}" step="0.01">
                @if($errors->has('bank_redemtion'))
                    <div class="invalid-feedback">
                        {{ $errors->first('bank_redemtion') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseGearing.fields.bank_redemtion_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date">{{ trans('cruds.caseGearing.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.caseGearing.fields.date_helper') }}</span>
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