<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <style>
            td, th{
                max-width: 500px !important;
            }
        </style>
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>{{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">{{ trans('cruds.auditLog.title_singular') }} {{ trans('global.list') }}</li>
    </x-admin.breadcrumb>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div
                         class="tw-flex tw-flex-col md:tw-flex-row tw-space-y-4 md:tw-space-y-0 tw-space-x-0 md:tw-space-x-3">
                        <input type="text" id="subject_type" class="form-control" placeholder="Search model here...">
                        <select class="form-control" id="description">
                            <option value="">All type</option>
                            <option value="audit:created">Created</option>
                            <option value="audit:updated">Updated</option>
                        </select>
                        <select class="form-control" id="user_id">
                            <option value="">All user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button"><i
                                class="fa fa-search me-2"></i>Search</button>
                        <button class="btn btn-light btn-sm btn-search" type="reset"><i
                                class="fa fa-undo me-2"></i>Clear</button>
                    </div>
                </form>
            </div>
            <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                <thead class="thead-bg">
                    <tr>
                        <th>Type</th>
                        <th>Properties</th>
                        <th>Id</th>
                        <th>Model</th>
                        <th>User</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @push('scripts')
        <script>
            // table
            $(function() {
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
                        url: "{{ route('admin.audit-logs.index') }}",
                        data: function(d) {
                            d.user_id = $('#user_id').val(),
                                d.subject_type = $('#subject_type').val(),
                                d.description = $('#description').val()
                        }
                    },
                    columns: [{
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'properties',
                            name: 'properties'
                        },
                        {
                            data: 'subject_id',
                            name: 'subject_id'
                        },
                        {
                            data: 'subject_type',
                            name: 'subject_type'
                        },
                        {
                            data: 'user_id',
                            name: 'user_id'
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
