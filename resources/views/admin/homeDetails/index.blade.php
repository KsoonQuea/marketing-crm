<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ $title }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                <thead class="thead-bg">
                <tr>
                    <th width="180">Created At</th>
                    <th>Case Code</th>
                    <th>Company Name</th>
                    <th>Approved Amount</th>
                    <th>Service Fee Amount</th>
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
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: "POST",
                        url: "{{ route('admin.dashboard-view-more') }}",
                        data: {
                            type: {{ $type }},
                            category: {{ $category }},
                        },
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
                            data: 'approved_amount',
                            name: 'approved_amount'
                        },
                        {
                            data: 'service_fee_amount',
                            name: 'service_fee_amount'
                        },
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
