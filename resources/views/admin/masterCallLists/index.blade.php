<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Master Call List</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Master Call List</li>
        <x-slot:breadcrumb_action>
            <!-- left access -->
            @can('call_master_separate_2')
                <a class="btn btn-dark-gradien me-3 separate-modal-btn" href="javascript:void(0);">
                    Separate Phone No.
                </a>
            @endcan

            @can('call_master_excel_create_2')
                <a class="btn btn-primary" href="{{ route('admin.master-call-lists.create') }}">
                    Add Master Call List
                </a>
            @endcan
            <!-- left access -->
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
                            <select class="form-control form-control-sm" id="search_status">
                                <option value="all">All Status</option>
                                @foreach(App\Models\MasterCallList::STATUS_SELECT as $key => $name)
                                    <option value="{{$key}}">{{$name}}</option>
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
                                <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="button"><i class="fa fa-search me-2"></i>Search</button>
                                <button class="btn btn-light btn-sm btn-search" type="reset"><i class="fa fa-undo me-2"></i>Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
            <table class="table table-bordered ajaxTable datatable datatable-MasterCallList custom-table table-sm" style="font-size:11px;">
                <thead class="thead-bg">
                    <tr>
                        <th width="100">Added At</th>
                        <th width="100">Leads Description</th>
                        <th width="100">Company Name</th>
                        <th>Address</th>
                        <th>Business Activities</th>
                        <th width="50">Revenue</th>
                        <th width="250">Director Info</th>
                        <th width="50">Status</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="separate-modal" class="modal">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.master-call-lists.seperate-phone') }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-inside-title">Separate Phone No. to Salesman</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>To Salesman(s)</label>
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <label>
                                    <input type="checkbox" id="check-all" value="1"/>
                                    <span class="text-primary">Check All</span>
                                </label>
                            </div>
                            @foreach($users as $user)
                            <div class="col-6 col-md-2">
                                <label>
                                    <input type="checkbox" class="" name="users_id[]" value="{{ $user->id }}"/>
                                    <span class="">{{ $user->name }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Phone No. for each salesman</label>
                        <input type="number" class="form-control" name="amount" min="1" max="999" value="1" required>
                        <span class="tw-text-sm tw-text-red-500">*Minimum 1</span>
                    </div>
                    <div class='button-container'>
                        <button type="submit" class='btn btn-primary'>Submit</button>
                        <button type="button" class="cancel btn btn-light">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- ./modal -->

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
                        url: "{{ route('admin.master-call-lists.index') }}",
                        data: function (d) {
                            d.search_status = $('#search_status').val(),
                            d.search_input = $('#search_input').val(),
                            d.date_from = $('#date_from').val(),
                            d.date_to = $('#date_to').val()
                        }
                    },
                    columns: [
                        { data: 'created_at', name: 'created_at' },
                        { data: 'batch.description', name: 'batch.description' },
                        { data: 'company_name', name: 'company_name' },
                        { data: 'company_address', name: 'company_address' },
                        { data: 'company_description', name: 'company_description' },
                        { data: 'revenue', name: 'revenue' },
                        { data: 'name', name: 'name' },
                        { data: 'status', name: 'status' },
                    ],
                    orderCellsTop: true,
                    order: [[ 0, 'desc' ]],
                    pageLength: 10,
                };
                let table = $('.datatable-MasterCallList').DataTable(dtOverrideGlobals);
                $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
                $("#search-btn").click(function(){ table.draw(); });

                // function of modal
                $('.separate-modal-btn').click(function (e){
                    $('#separate-modal').show();
                });
                $('.cancel').click(function() {
                    $(this).parent().parent().parent().parent().parent().hide();
                });
                window.onclick = function(event) {
                    if(event.target.getAttribute('id') == 'separate-modal'){
                        $('#separate-modal').hide();
                    }
                }
                // checkbox
                $('#check-all').on('click', function (){
                    $('input[name="users_id[]"]').prop('checked', this.checked);
                });
            });
        </script>
    @endpush
</x-admin.app-layout>



