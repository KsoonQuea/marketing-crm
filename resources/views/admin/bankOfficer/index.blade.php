<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.bankOfficer.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.bankOfficer.title_singular') }} {{ trans('global.list') }}</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-primary" href="{{ route('admin.bank-officers.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.bankOfficer.title_singular') }}
                    </a>
                </div>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-4 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
{{--                        <div class="col-12 col-md-4 pe-0">--}}
{{--                            <select class="form-control form-control-sm" id="search_status">--}}
{{--                                <option value="all">All Status</option>--}}
{{--                                <option value="1">Active</option>--}}
{{--                                <option value="0">Inactive</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="col-12 col-md-4 pe-0"></div>
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
                        <th>IC</th>
                        <th>Bank Name</th>
                        <th>Bank Account</th>
                        <th>Commission</th>
{{--                        <th>Status</th>--}}
{{--                        <th width="20">&nbsp;</th>--}}
                        <th width="20">&nbsp;</th>
                    </tr>
                </thead>
{{--                <tbody>--}}
{{--                    <tr>--}}
{{--                        <td class="">2022</td>--}}
{{--                        <td class="">Test</td>--}}
{{--                        <td class="">Test</td>--}}
{{--                        <td class="">Test</td>--}}
{{--                        <td class="">Test</td>--}}
{{--                        <td class="">Active</td>--}}
{{--                        <td class="">--}}
{{--                            <a class="btn btn-xs btn-primary tw-py-2" href="{{ route('admin.bank-officer.show') }}">--}}
{{--                                <i class="fa fa-eye fa-lg" title="view"></i>--}}
{{--                            </a>--}}
{{--                            --}}{{-- <a class="btn btn-xs btn-info text-white" href="{{ route('admin.bank-officer.edit') }}">--}}
{{--                                <i class="fa fa-edit fa-lg" title="edit"></i>--}}
{{--                            </a> --}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <form action="" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" class="tw-inline-block">--}}
{{--                                <button class="btn btn-xs btn-danger" type="submit">--}}
{{--                                    <i class="fa fa-times-circle fa-lg" title="inactive"></i>--}}
{{--                                </button>--}}
{{--                            </form>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                </tbody>--}}
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
                        url: "{{ route('admin.bank-officers.index') }}",
                        data: function (d) {
                            d.search_input = $('#search_input').val()
                        }
                    },
                    columns: [
                        { data: 'created_at', name: 'created_at' },
                        { data: 'name', name: 'name' },
                        { data: 'ic', name: 'ic' },
                        { data: 'bank.name', name: 'bank_id' },
                        { data: 'bank_account', name: 'bank_account' },
                        { data: 'commission', name: 'commission' },
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
