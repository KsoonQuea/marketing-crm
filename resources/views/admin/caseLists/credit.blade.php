<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Credit Case List</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Credit Case List</li>
        <x-slot:breadcrumb_action></x-slot:breadcrumb_action>
    </x-admin.breadcrumb>

    <div class="p-0">
        <ul class="nav nav-tabs border-tab nav-secondary mb-2">
            <li class="nav-item">
                <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#all" data-count="all">
                    All
                    <span class="badge {{ creditCaseCount() == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ creditCaseCount() }}</span>
                </a>
            </li>
            @foreach($bankStatus as $rowBankStatus)
            <li class="nav-item" >
                @if($rowBankStatus->id == 2)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#agreement" data-count="{{$rowBankStatus->id}}">
                    Pending {{$rowBankStatus->name}}
                    <span class="badge {{ $totalAgreement == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalAgreement }}</span>
                    </a>
                @elseif($rowBankStatus->id == 3)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#sitevisit" data-count="{{$rowBankStatus->id}}">
                    Pending {{$rowBankStatus->name}}
                    <span class="badge {{ $totalSiteVisit == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalSiteVisit }}</span>
                    </a>
                @elseif($rowBankStatus->id == 4)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#casesubmission" data-count="{{$rowBankStatus->id}}">
                        Pending {{$rowBankStatus->name}}
                        <span class="badge {{ $totalCaseSubmission == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalCaseSubmission }}</span>
                    </a>
                @elseif($rowBankStatus->id == 5)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#approved" data-count="{{$rowBankStatus->id}}">
                        Pending {{$rowBankStatus->name}}
                        <span class="badge {{ $totalApproval == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalApproval }}</span>
                    </a>
                @elseif($rowBankStatus->id == 6)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#acceptance" data-count="{{$rowBankStatus->id}}">
                        Pending {{$rowBankStatus->name}}
                        <span class="badge {{ $totalAcceptance == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalAcceptance }}</span>
                    </a>
                @elseif($rowBankStatus->id == 7)
                    <a class="nav-link cms_tab_nav filter-status tw-text-sm" href="#disbursement" data-count="{{$rowBankStatus->id}}">
                        Pending {{$rowBankStatus->name}}
                        <span class="badge {{ $totalDisbursement == 0 ? 'badge-light text-danger' : 'badge-light text-dark' }} float-right tw-ml-2">{{ $totalDisbursement }}</span>
                    </a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form onsubmit="return false;">
                    <div class="row">
                        <div class="col-12 col-md-4 pe-0">
                            <input type="text" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">
                        </div>
                        <div class="col-12 col-md-4 pe-0">
                            <select class="form-control form-control-sm" id="search_bank_status_id">
                                <option value="all">All Status</option>
                                @foreach($bankStatus as $rowBankStatus)
                                    <option value="{{$rowBankStatus->id}}" {{ ($rowBankStatus->id == $platform_status) ? 'selected' : '' }}>Pending {{$rowBankStatus->name}}</option>
                                @endforeach
                                <option value="8">Disbursed</option>
                            </select>
                        </div>
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
            <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm" id="parent">
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
                        url: "{{ route('admin.case-lists.credit') }}",
                        data: function (d) {
                            d.search_bank_status_id = $('#search_bank_status_id').val();
                            d.search_input = $('#search_input').val();
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
                $(".filter-status").click(function(){
                    const status_count = $(this).data("count");
                    $('#search_bank_status_id').val(status_count);
                    table.draw();
                });
            });
        </script>
    @endpush
</x-admin.app-layout>
