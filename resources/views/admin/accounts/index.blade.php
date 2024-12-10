<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Reimbursement Invoice</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Reimbursement Invoice</li>
        <x-slot:breadcrumb_action>
        @can('reimbursement_create_2')
            <a class="btn btn-primary" href="{{ route('admin.accounts.create') }}">
                Create Invoice
            </a>
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
                                <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button"><i class="fa fa-search me-2"></i>Search</button>
                                <button class="btn btn-light btn-sm btn-search" type="reset"><i class="fa fa-undo me-2"></i>Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered ajaxTable datatable datatable-account custom-table table-sm" style="font-size:11px;">
                    <thead class="thead-bg">
                        <tr>
                            <th width="100">Date</th>
                            <th width="100">Invoice No.</th>
                            <th width="100">Company Name</th>
                            <th>Company Address</th>
                            <th>Description</th>
                            <th> &nbsp; </th>
                        </tr>
                    </thead>
                </table>
            </div>
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
                        url: "{{ route('admin.accounts.index') }}",
                        data: function (d) {
                            d.search_input = $('#search_input').val(),
                            d.date_from = $('#date_from').val(),
                            d.date_to = $('#date_to').val()
                        }
                    },
                    columns: [
                        { data: 'date', name: 'date' },
                        { data: 'file_num', name: 'file_num' },
                        { data: 'company_name', name: 'company_name' },
                        { data: 'company_address', name: 'company_address' },
                        { data: 'description', name: 'description' },
                        { data: 'actions', name: 'actions', sortable: false, },
                    ],
                    orderCellsTop: true,
                    order: [[ 0, 'desc' ]],
                    pageLength: 10,
                };
                let table = $('.datatable-account').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function(){ table.draw(); });
            });
        </script>
    @endpush
</x-admin.app-layout>
