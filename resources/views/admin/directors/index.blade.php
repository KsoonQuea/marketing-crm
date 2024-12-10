<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.director.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.director.title_singular') }} {{ trans('global.list') }}</li>
        <x-slot:breadcrumb_action>
            @can('director_create_2')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="{{ route('admin.directors.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.director.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-9 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-3">
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
                        <th>IC</th>
                        <th>Phone No.</th>
                        <th width="30">&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
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
                        url: "{{ route('admin.directors.index') }}",
                        data: function (d) {
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'created_at', name: 'created_at' },
                        { data: 'name', name: 'name' },
                        { data: 'ic', name: 'ic' },
                        { data: 'phone', name: 'phone' },
                        { data: 'actions', name: '{{ trans('global.actions') }}', sortable: false },
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
