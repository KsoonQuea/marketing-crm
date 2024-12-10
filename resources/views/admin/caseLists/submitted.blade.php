<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Submitted Case List</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Submitted Case List</li>
        <x-slot:breadcrumb_action>
            @can('case_create_2')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <form method="post" action="{{ route('admin.case-lists.case-generate') }}" >
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                {{ trans('global.add') }} {{ trans('cruds.caseList.title_singular') }}
                            </button>
                        </form>
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
                        <div class="col-12 col-md-3 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="date_from" name="date_from" placeholder="Date From">
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="date_to" name="date_to" placeholder="Date To">
                        </div>
                        <div class="col-12 col-md-5">
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
                        <th>Case Code</th>
                        <th>Company Name</th>
                        <th>Handled By</th>
                        <th>Branch</th>
                        <th width="100">Status</th>
                        <th width="60">&nbsp;</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            // table
            $(function() {
                $(".datepicker-here").datepicker({
                    dateFormat: 'yyyy-mm-dd'
                });
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
                        url: "{{ route('admin.case-lists.submitted') }}",
                        data: function(d) {
                            d.search_status = $('#search_status').val(),
                                d.search_input = $('#search_input').val(),
                                d.date_from = $('#date_from').val(),
                                d.date_to = $('#date_to').val()
                        }
                    },
                    columns: [{
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'case_code',
                            name: 'case_code'
                        },
                        {
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'salesman.name',
                            name: 'salesman.name'
                        },
                        {
                            data: 'case_branch',
                            name: 'case_branch'
                        },
                        {
                            data: 'case_status',
                            name: 'case_status'
                        },
                        {
                            data: 'actions',
                            name: '{{ trans('global.actions') }}',
                            sortable: false
                        }
                    ],
                    orderCellsTop: true,
                    order: [
                        [0, 'desc']
                    ],
                    pageLength: 10,
                };
                let table = $('.datatable-data').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function() {
                    table.draw();
                });
            });
        </script>
    @endpush
</x-admin.app-layout>
