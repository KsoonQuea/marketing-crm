<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Add Management</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item">
            <a href="{{ route('admin.management.index') }}">Management List</a>
        </li>
        <li class="breadcrumb-item active">Add Management</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route("admin.management.store") }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="required" for="user_id">{{ trans('cruds.team.fields.leadername') }}</label>
                                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                                    @foreach($users as $id => $entry)
                                        <option value="{{ $id }}">{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <span class="text-danger">{{ $errors->first('user_id') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Commission Rate</label>
                                <div class="w-full h-full overflow-auto">
                                    <input type="number" class="form-control pull-left" name="commission_rate" value="{{ old('commission_rate',0.00) }}" min="0.00" step="0.01" max="100.00" style="width:80px;"/>
                                    <span class="pull-left" style="padding:0.5em 1em;">%</span>
                                </div>
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-primary" type="submit">
                                    Submit
                                </button>
                                <a href="{{ route('admin.management.index') }}" class="ms-3 btn btn-light">
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
        <script>
            $(".select2").select2();
        </script>
    @endpush
</x-admin.app-layout>
