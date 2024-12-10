<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Pending Result Case List</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Pending Result Case List</li>
        <x-slot:breadcrumb_action></x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-3 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-9">
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
                        <th width="150">Case</th>
                        <th>Company Name</th>
                        <th width="150">Bank</th>
                        <th>BFE</th>
                        <th>Branch</th>
                        <th width="150">Status</th>
                        <th width="100">Case Date</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @push('scripts')
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
                        url: "{{ route('admin.case-lists.pending-result') }}",
                        data: function (d) {
                            d.search_bank_status_id = $('#search_bank_status_id').val(),
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'case.case_code', name: 'case.case_code' },
                        { data: 'case.company_name', name: 'case.company_name' },
                        { data: 'bank.name', name: 'bank.name' },
                        { data: 'case.salesman.name', name: 'case.salesman.name' },
                        { data: 'case.case_branch', name: 'case.case_branch' },
                        { data: 'current_status', name: 'current_status' },
                        { data: 'case.created_at', name: 'case.created_at' },
                    ],
                    orderCellsTop: true,
                    order: [[ 3, 'desc' ]],
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
