<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Add Master Call List</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.master-call-lists.index') }}">Master Call List</a>
        </li>
        <li class="breadcrumb-item active">
            Add Master Call List
        </li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body pt-4">
                        <form method="POST" action="{{ route('admin.master-call-lists.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label class="required" for="excel">Upload Excel File</label>
                                    <input class="form-control {{ $errors->has('excel') ? 'is-invalid' : '' }}"
                                        type="file" name="csv_file" id="csv_file" value="{{ old('excel') }}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                    <span class="text-muted" style="font-size:0.9em;font-weight: 400;">*Only accept .csv / .txt format.</span>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label class="mb-3">&nbsp;</label><br>
                                    <a href="{{asset('assets/document/sample_master_call_list.csv')}}">
                                        <i class="fa fa-download me-2"></i>
                                        Download CSV Sample
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12 col-md-6">
                                    <label class="required" for="description">Leads Description</label>
                                    <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                                        type="text" name="description" id="description"
                                        value="{{ old('description') }}">
                                    @if ($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-primary" type="submit">
                                    Submit
                                </button>
                                <a href="{{ route('admin.master-call-lists.index') }}" class="ms-3 btn btn-light">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script></script>
    @endpush
</x-admin.app-layout>
