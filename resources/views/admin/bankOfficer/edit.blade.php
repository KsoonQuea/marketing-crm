<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Edit {{ trans('cruds.bankOfficer.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a href="{{ route('admin.bank-officers.index') }}">{{ trans('cruds.bankOfficer.title_singular') }}</a></li>
        <li class="breadcrumb-item active">Edit {{ trans('cruds.bankOfficer.title_singular') }} {{ trans('global.list') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route('admin.bank-officers.update',$bank_officer->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label class="required" for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$bank_officer->name}}" required/>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label class="required" for="ic">IC</label>
                            <input type="text" class="form-control" id="ic" name="ic" value="{{$bank_officer->ic}}" required/>
                        </div>
{{--                        <div class="form-group col-12 col-md-6">--}}
{{--                            <label class="required" for="phone">Phone</label>--}}
{{--                            <input type="text" class="form-control" id="phone" name="phone" value="" required/>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-12 col-md-6">--}}
{{--                            <label class="required" for="email">Email</label>--}}
{{--                            <input type="text" class="form-control" id="email" name="email" value="" required/>--}}
{{--                        </div>--}}

                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="bank">Bank</label>
                            <select class="form-control select_search {{ $errors->has('banks') ? 'is-invalid' : '' }}"
                                    name="banks" id="banks" value="{{ old('banks') }}">
                                    <option value disabled {{ old('banks',null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach($banks as $id => $bank)
                                    <option value="{{ $id }}"{{ $bank_officer->bank_id === $id ? 'selected' : '' }}>{{ $bank }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="bank_account">Bank Account</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" value="{{$bank_officer->bank_account}}" required/>
                        </div>
                        <div class="form-group col-12 col-md-4">
                            <label class="required" for="commission">Commission (%)</label>
                            <input type="number" class="form-control" id="commission" name="commission" value="{{$bank_officer->commission}}" min="0.0" step="0.1" required/>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.bank-officers.index') }}" class="ms-3 btn btn-light">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select_search").select2();
        </script>
    @endpush

</x-admin.app-layout>
