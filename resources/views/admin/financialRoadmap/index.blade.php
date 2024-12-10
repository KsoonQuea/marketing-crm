<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <div class="row">
                <div class="col-12">
                    <h3>Financial Roadmap <span class="small h6">{{ $financialRoadmap_page == 0 ? '(all)' : ( $financialRoadmap_page == 1 ? '(pending)' : '(confirm)' ) }}</span> </h3>
                </div>
            </div>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Financial Roadmap</li>

        <x-slot:breadcrumb_action>
            @can('finRoadmap_generate_2')
                <a href="{{ route('user.index', ['encode_code' => str_replace( '/', '_', \Illuminate\Support\Facades\Hash::make(Auth::user()->id)), 'id' => Auth::user()->id] ) }}"
                   target="_blank">
                    <button class="btn btn-primary">Generate Financial Roadmap</button>
                </a>
            @endcan
        </x-slot:breadcrumb_action>

    </x-admin.breadcrumb>

        <div id="changeStatusModal" class="modal">

            <div class="modal-content w-50">
                <div class="modal-header">
                    <h4 class="modal-inside-title">Change Status</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.financial-roadmaps.update_status') }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <div class="mt-2">
                                    <b>Status : </b>
                                </div>
                            </div>
                            <div class="col-6 modal_select">
                                <input type="hidden" name="finRm_id" id="finRm_id">

                                <select name="finRm_status" id="finRm_status" class="select2">
                                    @foreach($financialRoadmap_status as $financialRoadmap_status_key => $financialRoadmap_status_item )
                                        <option value="{{ $financialRoadmap_status_key }}" >{{ $financialRoadmap_status_item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="button-container mt-3 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-3">Submit</button>
                            <button type="button" class="cancel btn btn-primary-light">Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-3 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <select class="form-control form-control-sm" id="search_status">
                                <option value="all">All Status</option>
                                @foreach (App\Models\CaseList::STATUS_SELECT as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="date_from" name="date_from" placeholder="Date From">
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="date_to" name="date_to" placeholder="Date To">
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
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Referred By</th>
                    <th width="100">Status</th>
                    <th width="60">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    @push('scripts')
            <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
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
                        url: "{{ $financialRoadmap_page == 0 ? route('admin.financial_roadmap.index') : ( $financialRoadmap_page == 1 ? route('admin.financial_roadmap.pending_index') : route('admin.financial_roadmap.confirm_index') ) }}",
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
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'contact_person',
                            name: 'contact_person'
                        },
                        {
                            data: 'contact_number',
                            name: 'contact_number'
                        },
                        {
                            data: 'user_id',
                            name: 'user_id'
                        },
                        {
                            data: 'financial_roadmap_status',
                            name: 'financial_roadmap_status'
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

            //Modal part start
            function showFinRoadmapStatusModal(finRm_id, finRm_status){
                $("#finRm_id").val(finRm_id);

                $("#finRm_status").val(finRm_status).change();

                $("#changeStatusModal").show();
            }

            $('.cancel').click(function() {
                $(this).parent().parent().parent().parent().parent().hide();
            });

            //add select2
            $(".select2").select2();
        </script>
    @endpush
</x-admin.app-layout>
