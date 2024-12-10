<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <style>
            .vertical-middle{
                vertical-align: middle;
            }
            .hori-center{
                text-align: center;
            }
        </style>
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Commission Settings</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Commission Settings</li>
        <x-slot:breadcrumb_action>
            @can('')

            @endcan
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-primary" href="{{ route('admin.commission_settings.create') }}">
                            Add New Commission
                        </a>
                    </div>
                </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            @foreach($parent_query as $parent_query_value => $parent_query_item)
                @php
                    $child_query          = \App\Models\commissionSettingDetails::with(['commission_settings'])->where('commission_settings_id', $parent_query_item->id)->get();
                    $child_query_count    = \App\Models\commissionSettingDetails::with(['commission_settings'])->where('commission_settings_id', $parent_query_item->id)->count();
                @endphp
                <div class="card tw-p-3 tw-m-3" style="border-radius: 10px">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered custom-table table-sm">
                                    <thead class="thead-bg">
                                    <tr>
                                        <th>Class</th>
                                        <th>Monthly Target</th>
                                        <th>Quarterly Target</th>
                                        <th>Range</th>
                                        <th>Rate (%)</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="vertical-middle" rowspan="{{ $child_query_count }}">{{ $parent_query_item->class }}</td>
                                        <td class="vertical-middle" rowspan="{{ $child_query_count }}">{{ $parent_query_item->monthly_target }}</td>
                                        <td class="vertical-middle" rowspan="{{ $child_query_count }}">{{ $parent_query_item->quarterly_target }}</td>
                                        @foreach($child_query as $child_query_value => $child_query_item)
                                            @if($child_query_value == 0)
                                                <td>{{ $child_query_item->range }}</td>
                                                <td>{{ $child_query_item->rate }}</td>
                                                <td class="vertical-middle hori-center" rowspan="{{ $child_query_count }}">
                                                    <a class="btn btn-xs btn-info text-white"
                                                       href="{{ route('admin.commission_settings.edit', $parent_query_item->id) }}">
                                                        <i class="fa fa-edit fa-lg" title="edit"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <tr>
                                                    <td>{{ $child_query_item->range }}</td>
                                                    <td>{{ $child_query_item->rate }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                        url: "{{ route('admin.commission_settings.index') }}",
                        data: function (d) {
                            d.search_status = $('#search_status').val(),
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'commission_settings.class', name: 'commission_settings.class' },
                        { data: 'DT_RowData.range', name: 'monthly_target' },
                        { data: 'rate', name: 'rate' },
                        { data: 'actions', name: '{{ trans('global.actions') }}',sortable:false }
                    ],
                    orderCellsTop: true,
                    order: [[ 0, 'asc' ]],
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
