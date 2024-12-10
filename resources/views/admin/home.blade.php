<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
        <style>
            /* old */
            .square {
                height: 15px;
                width: 15px;
                background-color: #b2e7ff;
                border-radius: 4px;
            }
            .square:hover {
                background-color: #2198c3;
            }
            * {
                box-sizing: border-box;
            }
            .fg--search {
                background: white;
                position: relative;
                width: 200px;
            }
            .fg--search input {
                width: 100%;
                padding: 2px;
                border-radius: 10px;
            }
            .fg--search button {
                background: transparent;
                border: none;
                cursor: pointer;
                display: inline-block;
                font-size: 20px;
                position: absolute;
                top: 0;
                right: 0;
                z-index: 2;
            }
            .fg--search input:focus+button .fa-search {
                color: blue;
            }
            .text-symbol{
                font-size:0.5em;
                color:#5d5d5d;
            }/* dashboard card css */
            .text-value{ color:#2198c3; }
            .vertical-middle{ vertical-align: middle!important; }
            .chart-content-font{ font-weight: 400; font-size:0.6em; text-align: left; }
            .chart-content-font .value{ font-size:1.2em; }
            .media-body span{ font-size:0.9em; }
            /* new */
            .card-media-title{ font-size:0.8em!important; }
            .card-value{ font-size:0.7em!important; }
            .counter-title{ font-size:0.6em!important; }
            .counter{ font-weight: 600!important; }
            .btn-view-more{
                /*border:1px solid red!important;*/
                font-size:0.7em!important;
                text-align: right!important;
                padding:0!important;
                padding-bottom:5px!important;
            }
            .apexcharts-legend-text{
                padding-left: 5px;
            }
            .apexcharts-title-text{
                font-weight: bold;
            }

        </style>
    @endpush
    <x-admin.breadcrumb>
    <x-slot:breadcrumb_title><h3>Dashboard YYYYYYYYYYY</h3></x-slot:breadcrumb_title>
    <li class="breadcrumb-item active">Dashboard XXX</li>
    </x-admin.breadcrumb>
    <!-- Container-fluid starts-->
    <div class="container-fluid general-widget">

        {{---------------------------------   To Do List      ---------------------------------}}
        <div class="row">
            <!-- title -->
            @canany([
    'dashboard_all_mtd_case_index_2', 'dashboard_all_pending_assessment_index_2', 'dashboard_all_pending_offer_index_2', 'dashboard_all_rework_case_index_2', 'dashboard_all_pending_approval_index_2', 'dashboard_all_pending_disbursement_index_2',
    'dashboard_personal_mtd_case_index_2', 'dashboard_personal_pending_assessment_index_2', 'dashboard_personal_pending_offer_index_2', 'dashboard_personal_rework_case_index_2', 'dashboard_personal_pending_approval_index_2', 'dashboard_personal_pending_disbursement_index_2',
    ])
            <div class="col-12 tw-mt-5"><h6>TO DO LIST BBBBBBBBBB</h6></div>
            @endcanany
            <!-- data cards -->
            {{--    All Part    --}}

            <div class="col-12 col-md-12 col-lg-12">
                <div class="d-flex flex-wrap justify-content-between">
                    {{--    All Part    --}}
                    @can('dashboard_all_mtd_case_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_all_submitted_index_2') onclick="goRouteFunc(1, 0)" @endcan>
                                <div class="bg-primary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="database"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">MTD Case Submission</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['mtd_case_submission'] }}</h4>
                                            <i class="icon-bg" data-feather="database"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_all_pending_assessment_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_all_submitted_index_2') onclick="goRouteFunc(1, 0)" @endcan>
                                <div class="bg-primary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="database"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Assessment</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_assessment'] }}</h4><i class="icon-bg" data-feather="database"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_all_pending_offer_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 1)" @endcan>
                                <div class="bg-danger b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="clipboard"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Offer</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_offer'] }}</h4><i class="icon-bg" data-feather="clipboard"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_all_rework_case_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_all_rework_index_2') onclick="goRouteFunc(2, 0)" @endcan>
                                <div class="bg-info b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="refresh-ccw"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Rework Cases jksajskajdkjd</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['rework_cases'] }}</h4><i class="icon-bg" data-feather="refresh-ccw"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_all_pending_approval_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 2)" @endcan>
                                <div class="bg-secondary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="clipboard"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Approval</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_approval'] }}</h4><i class="icon-bg" data-feather="clipboard"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_all_pending_disbursement_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 3)" @endcan>
                                <div class="bg-success b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="arrow-up-right"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Disbursement</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_disbursement'] }}</h4><i class="icon-bg" data-feather="arrow-up-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    {{--   Personal Part     --}}
                    @can('dashboard_personal_mtd_case_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_personal_submitted_index_2') onclick="goRouteFunc(1, 0)" @endcan>
                                <div class="bg-primary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="database"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">MTD Case Submission</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['mtd_case_submission'] }}</h4><i class="icon-bg" data-feather="database"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_personal_pending_assessment_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_personal_submitted_index_2') onclick="goRouteFunc(1, 0)" @endcan>
                                <div class="bg-primary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="database"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Assessment</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_assessment'] }}</h4><i class="icon-bg" data-feather="database"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_personal_pending_offer_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 0)" @endcan>
                                <div class="bg-danger b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="clipboard"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Offer</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_offer'] }}</h4><i class="icon-bg" data-feather="clipboard"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_personal_rework_case_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_personal_rework_index_2') onclick="goRouteFunc(2, 0)" @endcan>
                                <div class="bg-info b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="refresh-ccw"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Rework Cases</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['rework_cases'] }}</h4><i class="icon-bg" data-feather="refresh-ccw"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_personal_pending_approval_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 2)" @endcan>
                                <div class="bg-secondary b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="clipboard"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Approval</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_approval'] }}</h4><i class="icon-bg" data-feather="clipboard"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    @can('dashboard_personal_pending_disbursement_index_2')
                        <div class="flex_item">
                            <div class="card o-hidden border-0" @can('case_credit_index_2') onclick="goRouteFunc(3, 3)" @endcan>
                                <div class="bg-success b-r-4 card-body py-2 px-4">
                                    <div class="media static-top-widget">
                                        <div class="align-self-center text-center"><i data-feather="arrow-up-right"></i></div>
                                        <div class="media-body"><span class="m-0 card-media-title">Pending Disbursement</span>
                                            <h4 class="mb-0 counter">{{ $data['data_cards']['pending_disbursement'] }}</h4><i class="icon-bg" data-feather="arrow-up-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>

        {{---------------------------------   Achievement      ---------------------------------}}
        <div class="row">
            <div class="col-12 col-md-{{ auth()->user()->hasAnyPermission(['dashboard_bfe_view']) ? '9' : '12' }}">
                <div class="row mt-3">
                    <!-- title -->
                    @canany([
                        'dashboard_all_year_kpi_index_2', 'dashboard_all_monthly_kpi_index_2', 'dashboard_all_quarterly_kpi_index_2', 'dashboard_all_ytd_chart_one_index_2', 'dashboard_all_ytd_chart_two_index_2', 'dashboard_all_ytd_total_customer_index_2',
                        'dashboard_personal_year_kpi_index_2', 'dashboard_personal_monthly_kpi_index_2', 'dashboard_personal_quarterly_kpi_index_2', 'dashboard_personal_ytd_chart_one_index_2', 'dashboard_personal_ytd_chart_two_index_2', 'dashboard_personal_ytd_total_customer_index_2',
                    ])
                        <div class="col-12 col-md-12"><h6>ACHIEVEMENT</h6></div>
                    @endcanany

                    <!-- Year KPI -->
                    @can('dashboard_all_year_kpi_index_2')
                        <div class="col-12 col-md-12">
                            <div class="card ecommerce-widget pro-gress">
                                <div class="card-body p-3 support-ticket-font">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="f-16">FY{{date("Y")}} Group KPI</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            @can('dashboard_all_year_kpi_view_2')
                                                <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                    @csrf
                                                    {{-- <input type="hidden" name="type" value="{{ $data['achievement']['year_kpi']['type'] }}"> --}}
                                                    <input type="hidden" name="category" value="0">

                                                    <button class="btn btn-link btn-view-more">
                                                        View More <i class="fa fa-caret-right"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <h4 class="total-num">
                                                <span class="text-xs txt-primary">RM</span>
                                                <span class="txt-primary">{{number_format($data['achievement']['year_kpi']['total'],0)}}</span>
                                            </h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="text-md-end">
                                                <ul>
                                                    <li>Approved
                                                        <span class="text-xs txt-primary ms-2">RM</span>
                                                        <span class="product-stts txt-primary">{{number_format($data['achievement']['year_kpi']['approved'],0)}}</span>
                                                    </li>
                                                    <li>Balance
                                                        <span class="text-xs txt-info ms-2">RM</span>
                                                        <span class="product-stts txt-info">{{number_format($data['achievement']['year_kpi']['balance'],0)}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-showcase mt-2">
                                        <div class="progress">
                                            <div class="progress-bar {{($data['achievement']['year_kpi']['percent']>=100)?'bg-warning':'bg-primary'}} progress-bar-animated progress-bar-striped" role="progressbar" style="width:{{$data['achievement']['year_kpi']['percent']}}%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    {{-- ACHIEVEMENT CHART --}}
{{--                                    <div class="row tw-mt-5">--}}
{{--                                        <div class="col-6">--}}
{{--                                            <p class="f-16">Chart</p>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-6 text-end">--}}
{{--                                            @can('dashboard_all_year_kpi_view_2')--}}
{{--                                                <form action="{{ route('admin.dashboard-view-more') }}" method="post">--}}
{{--                                                    @csrf--}}
{{--                                                    <input type="hidden" name="type" value="{{ $data['achievement']['year_kpi']['type'] }}">--}}
{{--                                                    <input type="hidden" name="category" value="0">--}}

{{--                                                    <button class="btn btn-link btn-view-more">--}}
{{--                                                        View More <i class="fa fa-caret-right"></i>--}}
{{--                                                    </button>--}}
{{--                                                </form>--}}
{{--                                            @endcan--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div id="achievement_line_chart"></div>--}}
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can('dashboard_personal_year_kpi_index_2')
                        <div class="col-12 col-md-12">
                            <div class="card ecommerce-widget pro-gress">
                                <div class="card-body p-3 support-ticket-font">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="f-16">FY{{date("Y")}} Group KPI</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            @can('dashboard_personal_year_kpi_view_2')
                                                <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                    @csrf
                                                    {{-- <input type="hidden" name="type" value="{{ $data['achievement']['year_kpi']['type'] }}"> --}}
                                                    <input type="hidden" name="category" value="0">

                                                    <button class="btn btn-link btn-view-more">
                                                        View More <i class="fa fa-caret-right"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <h4 class="total-num">
                                                <span class="text-xs txt-primary">RM</span>
                                                <span class="txt-primary">{{number_format($data['achievement']['year_kpi']['total'],0)}}</span>
                                            </h4>
                                        </div>
                                        <div class="col-7">
                                            <div class="text-md-end">
                                                <ul>
                                                    <li>Approved
                                                        <span class="text-xs txt-primary ms-2">RM</span>
                                                        <span class="product-stts txt-primary">{{number_format($data['achievement']['year_kpi']['approved'],0)}}</span>
                                                    </li>
                                                    <li>Balance
                                                        <span class="text-xs txt-info ms-2">RM</span>
                                                        <span class="product-stts txt-info">{{number_format($data['achievement']['year_kpi']['balance'],0)}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="progress-showcase mt-2">
                                        <div class="progress">
                                            <div class="progress-bar {{($data['achievement']['year_kpi']['percent']>=100)?'bg-warning':'bg-primary'}} progress-bar-animated progress-bar-striped" role="progressbar" style="width:{{$data['achievement']['year_kpi']['percent']}}%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    {{-- ACHIEVEMENT CHART --}}
                                    <div class="row tw-mt-5">
                                        <div class="col-6">
                                            <p class="f-16">Chart</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            @can('dashboard_all_year_kpi_view_2')
                                                <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                    @csrf
                                                    {{-- <input type="hidden" name="type" value="{{ $data['achievement']['year_kpi']['type'] }}"> --}}
                                                    <input type="hidden" name="category" value="0">

                                                    <button class="btn btn-link btn-view-more">
                                                        View More <i class="fa fa-caret-right"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div id="achievement_line_chart"></div>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <!-- tab start -->
                    @php $show_personal = 1; $show_team = 0; @endphp
                    @can('dashboard_team_index_2')
                       @php $show_personal = 1;
                            if($this_team != null){ $show_team = 1; }
                       @endphp
                    @else
                        @php
                            if($salesman_leader == 1){ $show_personal = 1; $show_team = 1; }
                        @endphp
                    @endcan
                    <div class="col-12 col-md-12">
                        <ul class="nav nav-tabs nav-primary" id="warningtab" role="tablist">
                            @if($show_personal == 1)
                                <li class="nav-item">
                                    <a class="nav-link active" id="personal-tab" data-bs-toggle="pill" href="#personal" role="tab" aria-controls="personal" aria-selected="true" onclick="tabFunc(0)">
                                        Main
                                    </a>
                                </li>
                            @endif
                            @if($show_team == 1)
                                <li class="nav-item">
                                    <a class="nav-link" id="team-tab" data-bs-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false" onclick="tabFunc(1)">
                                        Team
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <!-- dashboard details part -->
                        <div class="row">
                            <div class="{{ $achievement_size }}">
                                <div class="tab-content" id="warningtabContent">
                                    @if($show_personal == 1)
                                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                        <div class="row">
                                            <!-- Monthly KPI -->
                                            <div class="col-6">
                                                @canany(['dashboard_all_monthly_kpi_index_2', 'dashboard_personal_monthly_kpi_index_2'])
                                                    <div class="card ecommerce-widget pro-gress">
                                                        <div class="card-body p-3 support-ticket-font">

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="f-16">Monthly KPI</p>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    @canany(['dashboard_all_monthly_kpi_view_2', 'dashboard_personal_monthly_kpi_view_2'])
                                                                        <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="type" value="{{ $data['achievement']['monthly_kpi']['type'] }}">
                                                                            <input type="hidden" name="category" value="1">

                                                                           <button class="btn btn-link btn-view-more">
                                                                                View More <i class="fa fa-caret-right"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endcanany
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <h6>
                                                                        <span class="text-xs txt-primary">RM</span>
                                                                        <span class="txt-primary">{{number_format($data['achievement']['monthly_kpi']['total'],0)}}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-7">
                                                                    <div class="text-md-end" style="font-size:0.8em;">
                                                                        <ul>
                                                                            <li>Approved
                                                                                <span class="text-xs txt-primary ms-2">RM</span>
                                                                                <span class="product-stts txt-primary">{{number_format($data['achievement']['monthly_kpi']['approved'],0)}}</span>
                                                                            </li>
                                                                            <li>Balance
                                                                                <span class="text-xs txt-info ms-2">RM</span>
                                                                                <span class="product-stts txt-info">{{number_format($data['achievement']['monthly_kpi']['balance'],0)}}</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-showcase mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar {{($data['achievement']['monthly_kpi']['percent']>=100)?'bg-warning':'bg-primary'}} progress-bar-animated progress-bar-striped" role="progressbar" style="width:{{$data['achievement']['monthly_kpi']['percent']}}%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcanany
                                            </div>
                                            <!-- Quarterly KPI -->
                                            <div class="col-6">
                                                @canany(['dashboard_all_quarterly_kpi_index_2', 'dashboard_personal_quarterly_kpi_index_2'])
                                                    <div class="card ecommerce-widget pro-gress">
                                                        <div class="card-body p-3 support-ticket-font">

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="f-16">Quarterly KPI</p>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    @canany(['dashboard_all_quarterly_kpi_view_2', 'dashboard_personal_quarterly_kpi_view_2'])
                                                                        <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="type" value="{{ $data['achievement']['quarterly_kpi']['type'] }}">
                                                                            <input type="hidden" name="category" value="2">

                                                                           <button class="btn btn-link btn-view-more">
                                                                                View More <i class="fa fa-caret-right"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endcanany
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <h6>
                                                                        <span class="text-xs txt-primary">RM</span>
                                                                        <span class="txt-primary">{{number_format($data['achievement']['quarterly_kpi']['total'],0)}}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="col-7">
                                                                    <div class="text-md-end" style="font-size:0.8em;">
                                                                        <ul>
                                                                            <li>Approved
                                                                                <span class="text-xs txt-primary ms-2">RM</span>
                                                                                <span class="product-stts txt-primary">{{number_format($data['achievement']['quarterly_kpi']['approved'],0)}}</span>
                                                                            </li>
                                                                            <li>Balance
                                                                                <span class="text-xs txt-info ms-2">RM</span>
                                                                                <span class="product-stts txt-info">{{number_format($data['achievement']['quarterly_kpi']['balance'],0)}}</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress-showcase mt-2">
                                                                <div class="progress">
                                                                    <div class="progress-bar {{($data['achievement']['quarterly_kpi']['percent']>=100)?'bg-warning':'bg-primary'}} progress-bar-animated progress-bar-striped" role="progressbar" style="width:{{$data['achievement']['quarterly_kpi']['percent']}}%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcanany
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- YTD Service Fee Charged vs. YTD KPI Chart part -->
                                            <div class="col-4 d-flex align-items-stretch">
                                                @canany(['dashboard_all_ytd_chart_one_index_2', 'dashboard_personal_ytd_chart_one_index_2'])
                                                    <div class="card p-0" style="width:100%;">
                                                        <div class="card-body p-3">

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="f-10">YTD Service Fee Charged vs. YTD KPI</p>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    @canany(['dashboard_all_ytd_chart_one_view_2', 'dashboard_personal_ytd_chart_one_view_2'])
                                                                        <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="type" value="{{ $data['achievement']['vs1']['type'] }}">
                                                                            <input type="hidden" name="category" value="3">

                                                                           <button class="btn btn-link btn-view-more">
                                                                                View More <i class="fa fa-caret-right"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endcanany
                                                                </div>
                                                            </div>

                                                            <div id="chart-first-main"></div>
                                                            <div class="chart-content-font">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <i class="fa fa-circle" style="color:#f27a00;"></i> <span>YTD KPI</span>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <i class="fa fa-circle" style="color:#1d73b8;"></i> <span>YTD Service Fee Charged</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcanany
                                            </div>
                                            <!-- YTD Service Fee Charged vs. YTD Collected Service Fee Chart part -->
                                            <div class="col-4 d-flex align-items-stretch">
                                                @canany(['dashboard_all_ytd_chart_two_index_2', 'dashboard_personal_ytd_chart_two_index_2'])
                                                    <div class="card p-0" style="width:100%;">
                                                        <div class="card-body p-3">

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <p class="f-10">YTD Service Fee Charged vs. YTD Collected Service Fee</p>
                                                                </div>
                                                                <div class="col-6 text-end">
                                                                    @canany(['dashboard_all_ytd_chart_two_view_2', 'dashboard_personal_ytd_chart_two_view_2'])
                                                                        <form action="{{ route('admin.dashboard-view-more') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="type" value="{{ $data['achievement']['vs2']['type'] }}">
                                                                            <input type="hidden" name="category" value="4">

                                                                           <button class="btn btn-link btn-view-more">
                                                                                View More <i class="fa fa-caret-right"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endcanany
                                                                </div>
                                                            </div>
                                                            <div id="chart-second-main"></div>
                                                            <div class="chart-content-font">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <i class="fa fa-circle" style="color:#f27a00;"></i> <span>YTD Collected Service Fee</span>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <i class="fa fa-circle" style="color:#1d73b8;"></i> <span>YTD Service Fee Charged</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcanany
                                            </div>
                                            <!-- YTD Total Customer Onboarded part -->
                                            <div class="col-4 d-flex align-items-stretch">
                                                @canany(['dashboard_all_ytd_total_customer_index_2', 'dashboard_personal_ytd_total_customer_index_2'])
                                                    <div class="card p-2" style="width:100%;">
                                                        <div class="card-body">
                                                            <div class="text-center mt-5">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="f-16">YTD Total Customer Onboarded</p>
                                                                    </div>
                                                                </div>

                                                                <h4 class="text-value customer-onboard"></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endcanany
                                            </div>

                                            <!-- Bank Approval Part -->
                                            @can('bank_approval_industry_chart')
{{--                                                <div class="col-12">--}}
{{--                                                    <div class="card">--}}
{{--                                                        <div class="p-3">--}}
{{--                                                            <p class="f-16 mb-1">Bank Approval</p>--}}
{{--                                                            <div id="bank_approval_bar_main"></div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    @livewire('admin.dashboard.industry-report')
                                                </div>

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    @livewire('admin.dashboard.industry-amount-report')
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                    @endif
                                    @if($show_team == 1)
                                    <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                                        @if($teams !== NULL)
                                        <div class="row mb-1">
                                            <div class="col-9"></div>
                                            <div class="col-3">
                                                <select class="form-control" id="team_selection">
                                                    @foreach($teams as $key => $team)
                                                    <option value="{{ $team->id }}">{{ $team->name ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <!-- status bars -->
                                            <div class="col-12 col-md-6">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body p-3 support-ticket-font">
                                                        <p class="f-16">Monthly Group KPI</p>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <h6>
                                                                    <span class="text-xs txt-primary">RM</span>
                                                                    <span class="txt-primary" id="monthly_kpi_total">{{number_format($data['team']['monthly_kpi']['total'] ?? 0,0)}}</span>
                                                                </h6>
                                                            </div>
                                                            <div class="col-7">
                                                                <div class="text-md-end" style="font-size:0.8em;">
                                                                    <ul>
                                                                        <li>Approved
                                                                            <span class="text-xs txt-primary ms-2">RM</span>
                                                                            <span class="product-stts txt-primary" id="monthly_kpi_approved">{{number_format($data['team']['monthly_kpi']['approved'] ?? 0,0)}}</span>
                                                                        </li>
                                                                        <li>Balance
                                                                            <span class="text-xs txt-info ms-2">RM</span>
                                                                            <span class="product-stts txt-info" id="monthly_kpi_balance">{{number_format($data['team']['monthly_kpi']['balance'] ?? 0,0)}}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-showcase mt-2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-animated progress-bar-striped" role="progressbar" id="monthly_kpi_gauge" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="card ecommerce-widget pro-gress">
                                                    <div class="card-body p-3 support-ticket-font">
                                                        <p class="f-16">Quarterly Group KPI</p>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <h6>
                                                                    <span class="text-xs txt-primary">RM</span>
                                                                    <span class="txt-primary" id="quarterly_kpi_total">{{number_format($data['team']['quarterly_kpi']['total'] ?? 0,0)}}</span>
                                                                </h6>
                                                            </div>
                                                            <div class="col-7">
                                                                <div class="text-md-end" style="font-size:0.8em;">
                                                                    <ul>
                                                                        <li>Approved
                                                                            <span class="text-xs txt-primary ms-2">RM</span>
                                                                            <span class="product-stts txt-primary" id="quarterly_kpi_approved">{{number_format($data['team']['quarterly_kpi']['approved'] ?? 0,0)}}</span>
                                                                        </li>
                                                                        <li>Balance
                                                                            <span class="text-xs txt-info ms-2">RM</span>
                                                                            <span class="product-stts txt-info" id="quarterly_kpi_balance">{{number_format($data['team']['quarterly_kpi']['balance'] ?? 0,0)}}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress-showcase mt-2">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-animated progress-bar-striped" id="quarterly_kpi_gauge" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- donut chart -->
                                            <div class="col-12 col-md-4">
                                                <div class="card p-0" style="height:300px;">
                                                    <div class="card-body p-3">
                                                        <p class="f-10">YTD Service Fee Charged vs. YTD KPI</p>
                                                        <div id="chart-first-team"></div>
                                                        <div class="chart-content-font">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <i class="fa fa-circle" style="color:#f27a00;"></i> <span>YTD KPI</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <i class="fa fa-circle" style="color:#1d73b8;"></i> <span>YTD Service Fee Charged</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- donut chart 2 -->
                                            <div class="col-12 col-md-4">
                                                <div class="card p-0" style="height:300px;">
                                                    <div class="card-body p-3">
                                                        <p class="f-10">YTD Service Fee Charged vs. YTD Collected Service Fee</p>
                                                        <div class="chart-second-team" id="charged-collected-team"></div>
                                                        <div class="chart-content-font">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <i class="fa fa-circle" style="color:#f27a00;"></i> <span>YTD Collected Service Fee</span>
                                                                </div>
                                                                <div class="col-6">
                                                                    <i class="fa fa-circle" style="color:#1d73b8;"></i> <span>YTD Service Fee Charged</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- YTD Total Customer Onboarded part -->
                                            <div class="col-12 col-md-4">
                                                <div class="card p-2" style="height:300px;">
                                                    <div class="card-body">
                                                        <div class="text-center mt-5">
                                                            <p class="f-16">YTD Total Customer Onboarded</p>
                                                            <h4 class="text-value customer-onboard"></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Bank Approval Part --}}
{{--                                            @can('bank_approval_industry_chart')--}}
{{--                                            <div class="col-12">--}}
{{--                                                <div class="card">--}}
{{--                                                    <div class="p-3">--}}
{{--                                                        <p class="f-16 mb-1">Bank Approval</p>--}}
{{--                                                        <div id="bank_approval_bar_team"></div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            @endcan--}}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Daily Call Log / Follow-up List -->
                            <div class="col-3">
                                @can('dashboard_all_call_log_index_2')
                                    <div class="card" style="min-height:500px;">
                                        <div class="p-3">
                                            <p class="f-16">Daily Lead Centre</p>
                                            <div class="px-2 py-1 rounded-3 bg-primary-light text-primary">{{ count($MasterCaseLists) ?? 0 }} Call List Today</div>
                                            @foreach($MasterCaseLists as $rowMCL)
                                                <div class="row pt-3">
                                                    <div class="col-10">
                                                        <label class="text-primary">{{ $rowMCL->name ?? '-' }}</label>
                                                        <div class="text-primary">{{ $rowMCL->phone ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-2 pt-3">
                                                        <div class="square" onclick="callAction({{ $rowMCL->id }})"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($MasterCaseLists && count($MasterCaseLists) > 0)
                                                <div class="pt-4">
                                                    <a href="{{ route('admin.salesman-calls.all-call.index') }}">
                                                        <div class="d-grid gap-1 tw-flex tw-justify-between pb-2 btn btn-primary">
                                                            <div>View All</div><div>></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endcan
                                @can('dashboard_personal_call_log_index_2')
                                    <div class="card" style="min-height:500px;">
                                        <div class="p-3">
                                            <p class="f-16">Daily Lead Centre</p>
                                            <div class="px-2 py-1 rounded-3 bg-primary-light text-primary">{{ count($MasterCaseLists) ?? 0 }} Call List Today</div>
                                            @foreach($MasterCaseLists as $rowMCL)
                                                <div class="row pt-3">
                                                    <div class="col-10">
                                                        <label class="text-primary">{{ $rowMCL->name ?? '-' }}</label>
                                                        <div class="text-primary">{{ $rowMCL->phone ?? '-' }}</div>
                                                    </div>
                                                    <div class="col-2 pt-3">
                                                        <div class="square" onclick="callAction({{ $rowMCL->id }})"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($MasterCaseLists && count($MasterCaseLists) > 0)
                                                <div class="pt-4">
                                                    <a href="{{ route('admin.salesman-calls.all-call.index') }}">
                                                        <div class="d-grid gap-1 tw-flex tw-justify-between pb-2 btn btn-primary">
                                                            <div>View All</div><div>></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>



                        <!-- Latest Cases Part -->
                        @can('dashboard_all_latest_case_index_2')
                            <div class="card">
                                <div class="p-3">
                                    <div class="tw-flex tw-justify-between pb-2">
                                        <p class="f-16 mb-1">Latest Cases</p>
                                        <div class="form-group mb-0 float-right">
                                            @can('dashboard_all_latest_case_view_2')
                                                <a href="{{ route('admin.case-lists.index') }}" class="show-edit-button show-edit-button-blue" style="font-size:0.9em;">
                                                    View More <i class="fa fa-caret-right"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                    <table class="table text-primary custom-table" id="case-table">
                                        <thead class="thead-bg">
                                        <tr>
                                            <th width="180">Date Created</th>
                                            <th width="200">Case Code</th>
                                            <th>Company Name</th>
                                            <th width="120">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($CaseList && count($CaseList) > 0)
                                            @foreach($CaseList as $rowCaseList)
                                                <tr>
                                                    <td>{{ $rowCaseList->created_at }}</td>
                                                    <td>{{ $rowCaseList->case_code }}</td>
                                                    <td>{{ $rowCaseList->company_name }} Loan</td>
                                                    <td>
                                                        @php
                                                            $status_name = App\Models\CaseList::STATUS_SELECT[$rowCaseList->case_status ?? 0];
                                                            $status_class =  App\Models\CaseList::STATUS_CLASSES[$rowCaseList->case_status ?? 0];
                                                        @endphp
                                                        <b class="text-{{ $status_class }}">
                                                            {{ $status_name }}
                                                        </b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">No Result.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                        @can('dashboard_personal_latest_case_index_2')
                            <div class="card">
                                <div class="p-3">
                                    <div class="tw-flex tw-justify-between pb-2">
                                        <p class="f-16 mb-1">Latest Cases</p>
                                        <div class="form-group mb-0 float-right">
                                            @can('dashboard_all_latest_case_view_2')
                                                <a href="{{ route('admin.case-lists.index') }}" class="show-edit-button show-edit-button-blue" style="font-size:0.9em;">
                                                    View More <i class="fa fa-caret-right"></i>
                                                </a>
                                            @endcan
                                        </div>
                                    </div>
                                    <table class="table text-primary custom-table" id="case-table">
                                        <thead class="thead-bg">
                                        <tr>
                                            <th width="180">Date Created</th>
                                            <th width="200">Case Code</th>
                                            <th>Company Name</th>
                                            <th width="120">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($CaseList && count($CaseList) > 0)
                                            @foreach($CaseList as $rowCaseList)
                                                <tr>
                                                    <td>{{ $rowCaseList->created_at }}</td>
                                                    <td>{{ $rowCaseList->case_code }}</td>
                                                    <td>{{ $rowCaseList->company_name }}</td>
                                                    <td>
                                                        @php
                                                            $status_name = App\Models\CaseList::STATUS_SELECT[$rowCaseList->case_status ?? 0];
                                                            $status_class =  App\Models\CaseList::STATUS_CLASSES[$rowCaseList->case_status ?? 0];
                                                        @endphp
                                                        <b class="text-{{ $status_class }}">
                                                            {{ $status_name }}
                                                        </b>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">No Result.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div id="called-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-inside-title">Phone No. Call Action</h4>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.salesman-calls.called-phone') }}">
                    @csrf
                    <div class="mb-3" id="case-log-history"></div>
                    <div class="form-group" id="remark-comment-div">
                        <span>Remark/Comment</span>
                        <textarea class="form-control form-control-sm" id="ck-editor-textarea" rows="4" name="details" style="resize:none;"></textarea>
                        <span class="text-xs text-muted">Only <b class="text-green">Interest</b> required Remark/Comment.</span>
                    </div>
                    <div class="form-group" id="customer-response-div">
                        <span>Customer Response<span class="text-danger">*</span></span><br>
                        <div class="row mx-2 mt-1">
                            @foreach(App\Models\MasterCallUserTask::RESPONSE_STATUS_SELECT as $key => $value)
                                @if($key > 0)
                                <div class="col-12 col-md-4 col-lg-2 form-check" id="div-response-input-{{$key}}">
                                    <input class="form-check-input form-check-" type="radio" name="response_status" id="flexRadioDefault{{$key}}" value="{{$key}}" required>
                                    <label class="form-check-label text-{{App\Models\MasterCallUserTask::RESPONSE_STATUS_CLASSES[$key]}}" for="flexRadioDefault{{$key}}">
                                        <b>{{ $value }}</b>
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="button-container">
                        <input type="hidden" name="id" id="input_id" value=""/>
                        <button type="submit" class="btn btn-primary" id="action-submit-btn">Submit</button>
                        <a href="#" class="cancel btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>

            <script>
                $(document).ready(function () {
                    // Achievement Line Chart
                    var line = {
                    series: [
                        {
                            name: "Case",
                            data: [10, 1300, 900, 2100, 1000, 2200, 500, 1050, 1050, 2000, 3000, 2000],
                        },
                        {
                            name: "Amount",
                            data: [1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900, 2000, 2100],
                        }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        toolbar:{
                            show: false
                        }
                    },
                    legend: {
                        markers: {
                            fillColors: ['#BFBFBF','#008FFB'],
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 10
                        },
                    },
                    markers: {
                        size: 4,
                        colors: ['#BFBFBF','#008FFB'],
                    },
                    colors: ['#BFBFBF','#008FFB'],
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight',
                        colors: ['#BFBFBF','#008FFB'],
                        width: [3, 3]
                    },
                    grid: {
                        row: {
                            colors: ['transparent'],
                            opacity: 0.1
                        },
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    }
                    };

                    var line_chart = new ApexCharts(document.querySelector("#achievement_line_chart"), line);
                    line_chart.render();});

                    // Bank Approval Bar Chart
                    var bar_chart = {
                        series: [
                            {
                                name: "Bar1",
                                data: [0, 8, 15, 18, 22]
                            },
                            {
                                name: "Bar2",
                                data: [5, 8, 10, 14, 20]
                            },
                            {
                                name: "Bar3",
                                data: [5, 4, 5, 8, 8]
                            }],
                        chart: {
                            type: 'bar',
                            height: 500,
                            zoom: {
                                enabled: false
                            },
                            toolbar:{
                                show: false
                            }
                        },
                        title: {
                            text: 'Bank Approval % by Industry',
                            align: 'center',
                            style: {
                                fontSize:  '16px',
                                fontWeight:  'bold'
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                                dataLabels: {
                                    position: 'top',
                                },
                            }
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        legend: {
                            markers: {
                                fillColors: ['#6CE5E8', '#40B9D5', '#2C8BBA'],
                            },
                            itemMargin: {
                                horizontal: 10,
                                vertical: 10
                            },
                        },
                        tooltip: {
                            shared: true,
                            intersect: false,
                        },
                        colors: ['#6CE5E8', '#40B9D5', '#2C8BBA'],
                        grid: {
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            },
                            yaxis: {
                                lines: {
                                    show: false
                                }
                            }
                        },
                        xaxis: {
                            categories: ['Contruction', 'F&B', 'Beauty', 'Automation', 'IT'],
                        },
                    };
                    var bar_chart_main = new ApexCharts(
                        document.querySelector("#bank_approval_bar_main"),
                        bar_chart
                    );
                    bar_chart_main.render();

                    var bar_chart_team = new ApexCharts(
                        document.querySelector("#bank_approval_bar_team"),
                        bar_chart
                    );
                    bar_chart_team.render();
            </script>
            <script>
                function goRouteFunc(case_type, bank_type){
                    switch (case_type) {
                        case 1:
                            window.location.href = '{{ route("admin.case-lists.submitted") }}';
                            break;

                        case 2:
                            window.location.href = '{{ route("admin.case-lists.rework") }}';
                            break;

                        case 3:
                            if(bank_type == 1){
                                window.location.href = '{{ route("admin.case-lists.credit", ['sort' => 1]) }}';
                            }
                            else if(bank_type == 2){
                                window.location.href = '{{ route("admin.case-lists.pending-result") }}';
                            }
                            else if(bank_type == 3){
                                window.location.href = '{{ route("admin.case-lists.pending-disbursement") }}';
                            }
                            break;
                    }
                }
            </script>
        <script>
            // call log functions
            function callAction(this_id){
                open_called_modal(this_id);
            }
            // modal function
            function open_called_modal(id)
            {
                $('#case-log-history').html("");
                var _token = $('meta[name="csrf-token"]').attr('content');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': _token } });
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.salesman-calls.case-log-history') }}",
                    data: {
                        id : id,
                        _token : _token
                    },
                    dataType: "JSON",
                    success: function (data) {
                        if(data.status_code == 0){
                            var tbody = '';
                            $.each(data.tbody_data, function(index, value) {
                                tbody += '<tr>';
                                tbody += '<td>'+value.created_at+'</td>';
                                tbody += '<td>'+value.details+'</td>';
                                tbody += '<td>'+value.user.name+'</td>';
                                tbody += '</tr>';
                            });
                            var thead = '<tr><th width="200">Called At</th><th>Remarks</th><th width="200">Called By</th></tr>';
                            var title = '<label>This Phone No. related Log History</label>';
                            var table_display = title+'<table class="table table-bordered table-xs"><thead>'+thead+'</thead><tbody>'+tbody+'</tbody></table>';
                            $('#case-log-history').html(table_display);
                        }
                    }
                });
                $('#input_id').val(id);
                $('#called-modal').show();
            }
            $('.cancel').click(function() {
                $(this).parent().parent().parent().parent().parent().hide();
            });
            window.onclick = function(event) {
                if(event.target.getAttribute('id') == 'called-modal'){
                    $('#called-modal').hide();
                }
            }
            // others
            $(document).ready(function () {
                //get the number of flex_item
                var flex_item_count = 1;
                var flex_item_total_count = $(".flex_item").length;

                if(flex_item_total_count == 4){
                    $(".flex_item").each(function (){
                        $(this).width('24%');
                    });
                }
                else if(flex_item_total_count == 5){
                    $(".flex_item").each(function (){
                        if(flex_item_count >= 4){
                            $(this).width('49%');
                        }
                        else {
                            $(this).width('32%');
                        }

                        flex_item_count++;
                    });
                }

                // text-editor
                CKEDITOR.replace( 'ck-editor-textarea', {
                    toolbar:[
                        { name: 'clipboard', items: [ 'Undo', 'Redo' ] },
                        { name: 'styles', items: [ 'Format', 'FontSize' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    ],
                });
                // datatable
                $('#case-table').DataTable({
                    searching: false,
                    lengthChange: false,
                    info: false,
                    paging: false,
                    order: 'asc',
                });
            });

            function tabFunc(type){
                /*
                * 0 : main
                * 1 : team
                * */

                var this_id = type === 1 ? ($('#team_selection').val() ?? 0) : 0;
                if((this_id === '' || this_id === 0) && type === 1){
                    this_id = {{ ($this_team !== NULL) ? $this_team->id : 0 }};
                }

                achievement(this_id);

            }
        </script>

        <!-- personal charts -->
        <script>
            $(document).ready(function () {
                // donut 1
                var sales_archievement_option = {
                    chart: {
                        width: 225,
                        type: 'donut',
                    },
                    labels: ['YTD Service Fee Charged','YTD KPI'],
                    series: [{{$data['achievement']['vs1']['first']}}, {{$data['achievement']['vs1']['second']}}],
                    colors:['#1d73b8','#f27a00'],
                    legend: { show: false },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: "8px",
                        }
                    },
                }
                var sales_archievement = new ApexCharts(
                    document.querySelector("#sales_archievement"),
                    sales_archievement_option
                );
                sales_archievement.render();
                // donut 2
                var charged_collected_option = {
                    chart: {
                        width: 225,
                        type: 'donut',
                    },
                    labels: ['YTD Service Fee Charged','YTD Collected Service Fee'],
                    series: [{{$data['achievement']['vs2']['first']}}, {{$data['achievement']['vs2']['second']}}],
                    colors:['#1d73b8','#f27a00'],
                    legend: { show: false },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: "8px",
                        }
                    },
                }
                var charged_collected = new ApexCharts(
                    document.querySelector("#charged_collected"),
                    charged_collected_option
                );
                charged_collected.render();
            }
{{--                @if($salesman_leader == 1)--}}
{{--                var sales_archievement_team_option = {--}}
{{--                    chart: {--}}
{{--                        width: 225,--}}
{{--                        type: 'donut',--}}
{{--                    },--}}
{{--                    labels: ['YTD Service Fee Charged','YTD KPI'],--}}
{{--                    series: [{{$data['team']['vs1']['first']}}, {{$data['team']['vs1']['second']}}],--}}
{{--                    colors:['#1d73b8','#f27a00'],--}}
{{--                    legend: { show: false },--}}
{{--                    dataLabels: {--}}
{{--                        enabled: true,--}}
{{--                        style: {--}}
{{--                            fontSize: "8px",--}}
{{--                        }--}}
{{--                    },--}}
{{--                }--}}
{{--                var sales_archievement_team = new ApexCharts(--}}
{{--                    document.querySelector("#sales-archievement-team"),--}}
{{--                    sales_archievement_team_option--}}
{{--                );--}}
{{--                sales_archievement_team.render();--}}
{{--                // donut 2--}}
{{--                var charged_collected_team_option = {--}}
{{--                    chart: {--}}
{{--                        width: 225,--}}
{{--                        type: 'donut',--}}
{{--                    },--}}
{{--                    labels: ['YTD Service Fee Charged','YTD Collected Service Fee'],--}}
{{--                    series: [{{$data['team']['vs2']['first']}}, {{$data['team']['vs2']['second']}}],--}}
{{--                    colors:['#1d73b8','#f27a00'],--}}
{{--                    legend: { show: false },--}}
{{--                    dataLabels: {--}}
{{--                        enabled: true,--}}
{{--                        style: {--}}
{{--                            fontSize: "8px",--}}
{{--                        }--}}
{{--                    },--}}
{{--                }--}}
{{--                var charged_collected_team = new ApexCharts(--}}
{{--                    document.querySelector("#charged-collected-team"),--}}
{{--                    charged_collected_team_option--}}
{{--                );--}}
{{--                charged_collected_team.render();--}}
{{--                @endif--}}
{{--            });--}}
        </script>
        <!-- teams charts &  others script -->
        <script>
            function achievement(id)
            {
                $('#monthly_kpi_gauge').removeClass('bg-warning','bg-primary');
                $('#monthly_kpi_gauge').css('width','0%');
                $('#monthly_kpi_total').html('');
                $('#monthly_kpi_approved').html('');
                $('#monthly_kpi_balance').html('');
                $('#quarterly_kpi_gauge').removeClass('bg-warning','bg-primary');
                $('#quarterly_kpi_gauge').css('width','0%');
                $('#quarterly_kpi_total').html('');
                $('#quarterly_kpi_approved').html('');
                $('#quarterly_kpi_balance').html('');
                $('#customer-onboard').html('');

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.dashboard-achievement') }}",
                    data: {
                        id: id,
                    },
                    success: function (d) {
                        console.log(d);
                        var percent_first = d.achievement.monthly_kpi.percent;
                        if(percent_first >= 100){
                            $('#monthly_kpi_gauge').addClass('bg-warning');
                        } else {
                            $('#monthly_kpi_gauge').addClass('bg-primary');
                        }
                        $('#monthly_kpi_gauge').css('width',percent_first+'%');
                        var total_month = Number(parseInt(d.achievement.monthly_kpi.total)).toLocaleString('en');
                        var approved_month =  Number(parseInt(d.achievement.monthly_kpi.approved)).toLocaleString('en');
                        var balance_month = Number(parseInt(d.achievement.monthly_kpi.balance)).toLocaleString('en');
                        $('#monthly_kpi_total').html(total_month);
                        $('#monthly_kpi_approved').html(approved_month);
                        $('#monthly_kpi_balance').html(balance_month);

                        // Quarterly Group KPI
                        var percent_second = d.achievement.quarterly_kpi.percent;
                        if(percent_second >= 100){
                            $('#quarterly_kpi_gauge').addClass('bg-warning');
                        } else {
                            $('#quarterly_kpi_gauge').addClass('bg-primary');
                        }
                        $('#quarterly_kpi_gauge').css('width',percent_second+'%');
                        var total_quarterly = Number(parseInt(d.achievement.quarterly_kpi.total)).toLocaleString('en');
                        var approved_quarterly = Number(parseInt(d.achievement.quarterly_kpi.approved)).toLocaleString('en');
                        var balance_quarterly = Number(parseInt(d.achievement.quarterly_kpi.balance)).toLocaleString('en');

                        $('#quarterly_kpi_total').html(total_quarterly);
                        $('#quarterly_kpi_approved').html(approved_quarterly);
                        $('#quarterly_kpi_balance').html(balance_quarterly);

                        // two donut chart
                        var chart_first_data_one = parseInt(d.achievement.vs1.first);
                        var chart_first_data_two = parseInt(d.achievement.vs1.second);
                        var chart_second_data_one = parseInt(d.achievement.vs2.first);
                        var chart_second_data_two = parseInt(d.achievement.vs2.second);
                        // donut 1
                        var chart_first_option = {
                            chart: {
                                width: 225,
                                type: 'donut',
                            },
                            labels: ['YTD Service Fee Charged','YTD KPI'],
                            series: [chart_first_data_one, chart_first_data_two],
                            colors:['#1d73b8','#f27a00'],
                            legend: { show: false },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: "8px",
                                }
                            },
                        }
                        var chart_first_main = new ApexCharts(
                            document.querySelector("#chart-first-main"),
                            chart_first_option
                        );
                        chart_first_main.render();

                        var chart_first_team = new ApexCharts(
                            document.querySelector("#chart-first-team"),
                            chart_first_option
                        );
                        chart_first_team.render();
                        // donut 2
                        var chart_second_option = {
                            chart: {
                                width: 225,
                                type: 'donut',
                            },
                            labels: ['YTD Service Fee Charged','YTD Collected Service Fee'],
                            series: [chart_second_data_one, chart_second_data_two],
                            colors:['#1d73b8','#f27a00'],
                            legend: { show: false },
                            dataLabels: {
                                enabled: true,
                                style: {
                                    fontSize: "8px",
                                }
                            },
                        }
                        var chart_second_main = new ApexCharts(
                            document.querySelector(".chart-second-main"),
                            chart_second_option
                        );
                        chart_second_main.render();

                        var chart_second_team = new ApexCharts(
                            document.querySelector(".chart-second-team"),
                            chart_second_option
                        );
                        chart_second_team.render();

                        // customer-onboard
                        $('.customer-onboard').html(d.achievement.customer_onboard);
                    }
                });
            }
            $('#team_selection').on('change', function (e){
                var id = $(this).val();
                achievement(id);
            });
            $(document).ready(function () {
                tabFunc(0);
            });
        </script>
    @endpush
</x-admin.app-layout>


