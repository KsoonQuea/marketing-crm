<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Notification Lists</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Notification Lists</li>
        <x-slot:breadcrumb_action>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                <thead class="thead-bg">
                <tr>
                    <th width="180">Created At</th>
                    <th>Title</th>
                    <th>Case Code</th>
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
                        url: "{{ route('admin.notification.index') }}",
                        data: function (d) {
                            d.search_status = $('#search_status').val(),
                                d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'created_at',   name: 'created_at' },
                        { data: 'title',        name: 'title' },
                        { data: 'case_code',    name: 'case_code' },
                        { data: 'case_status',  name: 'case_status' },
                        { data: 'actions',      name: '{{ trans('global.actions') }}',sortable:false }
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
