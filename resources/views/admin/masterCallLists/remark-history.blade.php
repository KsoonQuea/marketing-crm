<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Call Remark History</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Call Remark History</li>
        <x-slot:breadcrumb_action></x-slot:breadcrumb_action>
    </x-admin.breadcrumb>

    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form method="POST" action="{{ route('admin.master-call-lists.remark-history.generate-pdf') }}">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-3 pe-0">
                            <input type="text" id="search_input" name="search_input" class="form-control form-control-sm" placeholder="Search field here...">
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
                                <button class="btn btn-secondary btn-sm btn-search" id="pdf-btn" type="submit" ><i class="fa fa-file me-2"></i>PDF</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-bordered ajaxTable datatable datatable-MasterCallList custom-table table-sm">
                <thead class="thead-bg">
                    <tr>
                        <th width="150">Created At</th>
                        <th width="200">Company Name</th>
                        <th width="150">Response</th>
                        <th>Remarks</th>
{{--                        <th width="150">Action By</th>--}}
{{--                        <th width="100">Under Case</th>--}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>


    @push('scripts')
        <script>
            $(function () {
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
                        url: "{{ route('admin.master-call-lists.remark-history') }}",
                        data: function (d) {
                            d.search_input = $('#search_input').val(),
                            d.date_from = $('#date_from').val(),
                            d.date_to = $('#date_to').val()
                        }
                    },
                    columns: [
                        { data: 'datetime', name: 'datetime' },
                        // { data: 'user.name', name: 'user.name' },
                        { data: 'list.company_name', name: 'list.company_name' },
                        { data: 'response_status', name: 'response_status' },
                        { data: 'details', name: 'details' },
                        // { data: 'case.case_code', name: 'case.case_code' },
                    ],
                    orderCellsTop: true,
                    order: [[ 0, 'desc' ]],
                    pageLength: 10,
                };
                let table = $('.datatable-MasterCallList').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function (){ table.draw(); });
            });
        </script>
    @endpush
</x-admin.app-layout>



