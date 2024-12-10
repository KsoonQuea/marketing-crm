<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('global.edit') }} {{ trans('cruds.team.title_singular') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item"><a href="{{ route('admin.teams.index') }}">{{ trans('cruds.team.title_singular') }} {{ trans('global.list') }}</a></li>
        <li class="breadcrumb-item active">{{ trans('global.edit') }} {{ trans('cruds.team.title_singular') }}</li>
    </x-admin.breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-body p-3 pb-0">
                        <form method="POST" action="{{ route("admin.teams.update", [$team->id]) }}" enctype="multipart/form-data" class="form theme-form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $team->name) }}" required>
                                @if($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="leadername">{{ trans('cruds.team.fields.leadername') }}</label>
                                <select class="form-control select2 {{ $errors->has('leadername') ? 'is-invalid' : '' }}" name="leadername" id="leadername">
                                    @foreach($sales_manager as $id => $entry)
                                        <option value="{{ $id }}" @selected(old('team_lead_id', $team->team_lead_id) == $id)>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('leadername'))
                                    <span class="text-danger">{{ $errors->first('leadername') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.team.fields.leadername_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>Commission Rate</label>
                                <div class="w-full h-full overflow-auto">
                                    <input type="number" class="form-control pull-left" name="commission_percent" value="{{ old('commission_percent',$team->commission_percent) }}" min="0.00" step="0.01" max="100.00" style="width:80px;"/>
                                    <span class="pull-left" style="padding:0.5em 1em;">%</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="required" for="member">{{ trans('cruds.team.fields.member') }}</label>
                                <select class="form-control select2 {{ $errors->has('member') ? 'is-invalid' : '' }}" name="member[]" id="member" multiple>
                                    @foreach($users as $id => $entry)
                                        @if('leadername' !='selected' && $id != $team->team_lead_id)
                                            <option value="{{ $id }}" {{ in_array($id, $teammate) ? 'selected' : '' }}>{{ $entry }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if($errors->has('member'))
                                    <span class="text-danger">{{ $errors->first('member') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.team.fields.member_helper') }}</span>
                            </div>
                            <div class="form-group mt-4">
                                <button class="btn btn-primary" type="submit">
                                    Submit
                                </button>
                                <a href="{{ route('admin.teams.index') }}" class="ms-3 btn btn-light">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script>
        $(document).ready(function () {
            function changeLeader()
            {
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.ajax({
                    type: "POST", //HTTP POST Method
                    url: "{{ route('admin.teams.checkmember') }}",
                    data: { //Passing data
                        leader: $("#leadername").val(),
                    },
                    success: function (result) {
                        $('#member').empty();
                        $.each(result, function (key, value) {
                            if (value == 'null' || value == null) {
                                // put default value
                                $("#member").html('');
                                $('#member').append("<option value=''>Please Select</option>");
                            } else {
                                $('#member').append('<option value="' + key + '">' + value + '</option>');
                            }
                        });
                    }
                });
            }
            $("#leadername").change(function () {
                changeLeader();
            });
        });
    </script>
    @push('scripts')
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();
        </script>
    @endpush
</x-admin.app-layout>
