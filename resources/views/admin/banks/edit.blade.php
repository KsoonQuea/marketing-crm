<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
        <style>
            .input-wrapper{ width:400px;margin-bottom:5px; }
            .input-wrapper input{ width: 40%;}
            .input-wrapper .remove_field{ width: 20%; padding-left:10px;}
        </style>
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Edit Platform</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.banks.index') }}">
                Platform List
            </a>
        </li>
        <li class="breadcrumb-item active">Edit Platform</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-3">
                <form method="POST" action="{{ route("admin.banks.update", [$bank->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <h6 class="card-title">Platform</h6>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label class="required" for="name">{{ trans('cruds.bank.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $bank->name) }}" required>
                            @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.bank.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="swift_code">{{ trans('cruds.bank.fields.swift_code') }}</label>
                            <input class="form-control {{ $errors->has('swift_code') ? 'is-invalid' : '' }}" type="text" name="swift_code" id="swift_code" value="{{ old('swift_code', $bank->swift_code) }}">
                            @if($errors->has('swift_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('swift_code') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.bank.fields.swift_code_helper') }}</span>
                        </div>
                    </div>
                    <h6 class="card-title">Platform Officers</h6>
                    <div>
                        <div class="platform-div">
                        @foreach($bank->officers as $officer)
                            <div class="input-wrapper">
                                <input type="text" name="officer_name[]" value="{{ $officer->name }}" placeholder="Name Here..." required/>
                                <input type="number" name="commission[]" value="{{ $officer->commission }}" placeholder="%" required/>
                                <a href="#" class="remove_field"><i class="fa fa-times"></i></a>
                            </div>
                        @endforeach
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn-secondary btn-sm" id="add-button">Add</button>
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <button class="btn btn-primary" type="submit">
                            Submit
                        </button>
                        <a href="{{ route('admin.banks.index') }}" class="btn btn-light ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(function (){
            var x = 1;
            var max_fields = 10;
            var wrapper = $(".platform-div");
            $('#add-button').on('click', function (e){
                e.preventDefault();
                var input_fields = '<div class="input-wrapper">' +
                    '<input type="text" name="officer_name[]" value="" placeholder="Name Here..." required/> ' +
                    '<input type="number" name="commission[]" value="" placeholder="%" required/> ' +
                    '<a href="#" class="remove_field"><i class="fa fa-times"></i></a>' +
                    '</div>';
                if(x < max_fields) { //max input box allowed
                    x++; //text box increment
                    $(wrapper).append(input_fields);
                }
            });
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
        });
    </script>
    @endpush
</x-admin.app-layout>
