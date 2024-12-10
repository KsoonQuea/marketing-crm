<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}</li>
        <x-slot:breadcrumb_action>
            @can('user_create_2')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
{{--    <div class="card" x-data="{--}}
{{--    reload() {--}}
{{--        $('#UserTable').DataTable().ajax.reload();--}}
{{--    },--}}
{{--    clear() {--}}
{{--        $($refs.search).find('input').val('')--}}
{{--        $('.searchSelect2').val(1).trigger('change');--}}
{{--    }--}}
{{--}">--}}
{{--        <div class="card-body">--}}
{{--            <div class="tw-flex tw-flex-col md:tw-flex-row tw-space-y-4 md:tw-space-y-0 tw-space-x-0 md:tw-space-x-3"--}}
{{--                 x-ref="search">--}}
{{--                <input type="text" id="uname" @keyup.enter="reload()"--}}
{{--                       class="form-control"--}}
{{--                       placeholder="Name">--}}
{{--                <input type="email" id="uemail" @keyup.enter="reload()"--}}
{{--                       class="form-control" placeholder="Email">--}}
{{--                <select class="form-control searchSelect2" id="ustatus">--}}
{{--                    @foreach(array_column(\App\Enum\Status::cases(), 'name', 'value') as $skey => $svalue)--}}
{{--                        <option value="{{ $skey }}">{{ $svalue }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                <button class="btn btn-primary" @click="reload()">Search</button>--}}
{{--                <button class="btn btn-secondary" @click="clear(); reload();">Clear</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="card">--}}
{{--        <div class="card-body">--}}
{{--            {{$dataTable->table()}}--}}
{{--        </div>--}}
{{--    </div>--}}
        <div class="card">
            <div class="card-body p-2">
                <div class="search-div">
                    <form onsubmit="return false;">
                        <div class="row">
                            <div class="col-12 col-md-4 pe-0">
                                <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                            </div>
                            <div class="col-12 col-md-4 pe-0">
                                <select class="form-control form-control-sm" id="search_status">
                                    <option value="all">All Status</option>
                                    @foreach(App\Models\User::STATUS_SELECT as $key => $name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="float-end">
                                    <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button">
                                        <i class="fa fa-search me-2"></i>Search
                                    </button>
                                    <button class="btn btn-light btn-sm btn-search" type="reset">
                                        <i class="fa fa-undo me-2"></i>Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                    <thead class="thead-bg">
                        <tr>
                            <th width="180">Created At</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="100">Status</th>
                            <th width="100">&nbsp;</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    @push('scripts')
{{--        {{$dataTable->scripts()}}--}}
{{--        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>--}}
{{--        <script>--}}
{{--            $(".searchSelect2").select2().on('select2:select', function (e) {--}}
{{--                $('#UserTable').DataTable().ajax.reload();--}}
{{--            })--}}
{{--        </script>--}}
        <script>
            // table
            $(function () {
                let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                let dtOverrideGlobals = {
                    buttons: dtButtons,
                    processing: true,
                    serverSide: true,
                    retrieve: true,
                    searching: false,
                    lengthChange: false,
                    aaSorting: [],
                    ajax: {
                        url: "{{ route('admin.users.index') }}",
                        data: function (d) {
                            d.search_status = $('#search_status').val(),
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'created_at', name: 'created_at' },
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'roles.name', name: 'roles.name',sortable:false },
                        { data: 'status', name: 'status' },
                        { data: 'actions', name: '{{ trans('global.actions') }}',sortable:false }
                    ],
                    orderCellsTop: true,
                    order: [[ 0, 'desc' ]],
                    pageLength: 10,
                };
                let table = $('.datatable-data').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function(){ table.draw(); });
            });
        </script>
    @endpush
</x-admin.app-layout>
