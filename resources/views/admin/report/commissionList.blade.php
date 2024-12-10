<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Commission Report</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Commission Report</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_pdf') }}">
                        @csrf
                        <input type="hidden" id="pdf_type" name="pdf_type" value="1">
                        <input type="hidden" name="pdf_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="pdf_this_start_month" value="{{ $this_start_month }}">
                        <input type="hidden" name="pdf_this_end_month" value="{{ $this_end_month }}">
                        <input type="hidden" class="report-html" name="pdf_report_html">
                        @can('commission_list_pdf_2')
                            <button class="btn btn-primary" id="pdf-btn">PDF</button>
                        @endcan
                    </form>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_excel') }}">
                        @csrf
                        <input type="hidden" id="excel_type" name="excel_type" value="1">
                        <input type="hidden" name="table_row" class="table_row"  value="1">
                        <input type="hidden" name="excel_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="excel_this_start_month" value="{{ $this_start_month }}">
                        <input type="hidden" name="excel_this_end_month" value="{{ $this_end_month }}">
                        <input type="hidden" class="report-html" name="excel_report_html">
                        @can('commission_list_excel_2')
                            <button class="btn btn-secondary" id="excel-btn">Excel</button>
                        @endcan
                    </form>
                </div>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>

    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form method="get" action="{{ route('admin.report.commission_index') }}" id="cms_report_form">
                    <div class="row">
{{--                        <div class="col-12 col-md-3 pe-0">--}}
{{--                            <input type="text" name="search_input" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">--}}
{{--                        </div>--}}
                        <div class="col-12 col-md-2 pe-0">
                            <select class="form-control form-control-sm" id="search_year" name="search_year">
                                <option value="all">All Year</option>
                                @for($year = $ym_setting->start_year; $year <= $ym_setting->this_year+1; $year++)
                                    <option value="{{ $year }}" {{ $year == $this_year ? 'selected' : '' }} >
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-12 col-md-2 pe-0">
                            <select class="form-control form-control-sm" id="search_start_month" name="search_start_month" onchange="disableMonth()">
                                {{--                                <option value="all">All Month</option>--}}
                                @foreach($month as $month_item)
                                    <option value="{{ $month_item->month }}" {{ $month_item->month == $this_start_month ? 'selected' : '' }}>
                                        {{ 'From: '.$month_item->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-2 pe-0">
                            <select class="form-control form-control-sm" id="search_end_month" name="search_end_month">
                                {{--                                <option value="all">All Month</option>--}}
                                @foreach($month as $month_item)
                                    <option value="{{ $month_item->month }}" {{ $month_item->month == $this_end_month ? 'selected' : '' }} {{ $month_item->month < $this_start_month ? 'disabled' : '' }}>
                                        {{ 'To: '.$month_item->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-2 pe-0">

                        </div>

                        <input type="hidden" id="url_hash" name="url_hash" value="{{ $url_hash }}">

                        <div class="col-12 col-md-4">
                            <div class="float-end">
                                <button class="btn btn-light-blue btn-sm btn-search" id="search-btn" type="submit">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                                <button class="btn btn-light btn-sm btn-search" id="clear-btn" type="reset">
                                    <i class="fa fa-undo me-2"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="p-0">
                <ul class="nav nav-tabs border-tab nav-secondary mb-2" id="cms_tab">
                    <li class="nav-item">
                        <a class="nav-link cms_tab_nav active" id="main-tab" data-bs-toggle="pill" href="#main" role="tab"
                        aria-controls="main" aria-selected="true">
                            Main
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cms_tab_nav" id="detail-tab" data-bs-toggle="pill" href="#detail" role="tab"
                        aria-controls="detail" aria-selected="false">
                            Detail
                        </a>
                    </li>
                </ul>
                <div class="tab-content pt-0 p-3">
                    <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
                        <div id="report-table-main">
                            <div class="table-responsive">
                                <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                                    <thead class="tw-text-center tw-align-middle">
                                    <tr class="cms_report">
                                        <th rowspan="2">DATE</th>
                                        <th rowspan="2">OR NO</th>
                                        <th rowspan="2">PARTICULAR</th>
                                        <th rowspan="2">Aproval Amount</th>
                                        <th rowspan="2">INVOICE NO</th>
                                        <th rowspan="2">RM(without SST)</th>
                                        <th rowspan="2">Commission</th>
                                        <th class="com-color" colspan="2" style="border-bottom: 1px solid transparent !important;">Banker</th>
                                        <th class="com-color" colspan="2" style="border-bottom: 1px solid transparent !important;">Management</th>
                                        <th class="com-color" colspan="2" style="border-bottom: 1px solid transparent !important;">Team Lead</th>
                                        <th class="com-color" colspan="2" style="border-bottom: 1px solid transparent !important;">BFE</th>
                                    </tr>
                                    <tr class="cms_report">
                                        <th class="com-color">Person</th>
                                        <th class="com-color">Commission</th>
                                        <th class="com-color">Person</th>
                                        <th class="com-color">Commission</th>
                                        <th class="com-color">Person</th>
                                        <th class="com-color">Commission</th>
                                        <th class="com-color">Person</th>
                                        <th class="com-color">Commission</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tw-text-center tw-align-middle">
                                    @php
                                        $total_mgmt_cms           = 0;
                                        $total_team_cms           = 0;
                                        $total_commission         = 0;
                                    @endphp
                                    @foreach($commission_report as $cr_key => $cr_item)
                                        @php
                                            $mgmt_query         = \App\Models\CaseOverridings::where('case_disburse_detail_id', $cr_item->case_disburse_detail_id)->where('type', 0);
                                            $team_query         = \App\Models\CaseOverridings::where('case_disburse_detail_id', $cr_item->case_disburse_detail_id)->where('type', 1);

                                            $mgmt_stmt          = $mgmt_query->get();
                                            $team_stmt          = $team_query->get();
                                            $mgmt_count         = $mgmt_query->count();
                                            $team_count         = $team_query->count();
                                            $mgmt_cms           = $mgmt_query->sum('commission');
                                            $team_cms           = $team_query->sum('commission');
                                            $total_mgmt_cms     += $mgmt_cms;
                                            $total_team_cms     += $team_cms;

                                            if ($team_count > $mgmt_count){
                                                $row_count      = $team_count;

                                                $mgmt_row_loop  = $team_count - $mgmt_count;
                                                $team_row_loop  = 0;
                                            }
                                            else{
                                                $row_count      = $mgmt_count;

                                                $mgmt_row_loop  = 0;
                                                $team_row_loop  = $mgmt_count - $team_count;
                                            }

                                            //get the all OR and latest OR date
                                            $payments                   = \App\Models\Payments::where('case_disburse_detail_id', $cr_item->case_disburse_detail_id)->get();
                                            $payment_date               = \App\Models\Payments::where('case_disburse_detail_id', $cr_item->case_disburse_detail_id)->orderBy('id', 'desc')->orderBy('date', 'desc')->first()->date;
                                            $payment_arr                = array();

                                            foreach ($payments as $payment_item){
                                                array_push($payment_arr, $payment_item->or);
                                            }

                                            $or_sentence                = empty($payment_arr) ? null : implode(", \n", $payment_arr);

                                            //get the total commission each row
                                            $total_row_commission       = $mgmt_cms + $team_cms + $cr_item->bfe_cms + $cr_item->banker_cms;
                                            $total_commission           += $total_row_commission;
                                        @endphp

                                        <tr class="cms_report">
                                            <td rowspan="{{ $row_count }}">{{ $cr_item->or_date }}</td>
                                            <td rowspan="{{ $row_count }}">{{ $or_sentence }}</td>
                                            <td rowspan="{{ $row_count }}">{{ $cr_item->particular }}</td>
                                            <td rowspan="{{ $row_count }}">{{ money_num_format($cr_item->approved_amount) }}</td>
                                            <td rowspan="{{ $row_count }}">{{ $cr_item->inv_no }}</td>
                                            <td rowspan="{{ $row_count }}">{{ money_num_format($cr_item->service_amount) }}</td>
                                            <td rowspan="{{ $row_count }}">{{ money_num_format($total_row_commission) }}</td>
                                            <td rowspan="{{ $row_count }}" class="com-color">{{ $cr_item->banker_name ?? '-' }}</td>
                                            <td rowspan="{{ $row_count }}" class="com-color">{{ money_num_format($cr_item->banker_cms) }}</td>
                                            @foreach($mgmt_stmt as $mgmt_stmt_key => $mgmt_stmt_item)
                                                @if($mgmt_stmt_key == 0)
                                                    <td class="com-color">{{ $mgmt_stmt_item->name }}</td>
                                                    <td class="com-color">{{ money_num_format($mgmt_stmt_item->commission) }}</td>
                                        @else
                                            <tr class="cms_report">
                                                <td class="com-color">{{ $mgmt_stmt_item->name }}</td>
                                                <td class="com-color">{{ money_num_format($mgmt_stmt_item->commission) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @for($i = 0; $i < $mgmt_row_loop; $i++)
                                        <tr class="cms_report">
                                            <td class="com-color"></td>
                                            <td class="com-color"></td>
                                        </tr>
                                    @endfor

                                    @foreach($team_stmt as $team_stmt_key => $team_stmt_item)
                                        @if($team_stmt_key == 0)
                                            <td class="com-color">{{ $team_stmt_item->name }}</td>
                                            <td class="com-color">{{ money_num_format($team_stmt_item->commission) }}</td>
                                            <td rowspan="{{ $row_count }}" class="com-color">{{ $cr_item->bfe_name ?? '-' }}</td>
                                            <td rowspan="{{ $row_count }}" class="com-color">{{ money_num_format($cr_item->bfe_cms) }}</td>
                                        @else
                                            <tr class="cms_report">
                                                <td class="com-color">{{ $team_stmt_item->name }}</td>
                                                <td class="com-color">{{ money_num_format($team_stmt_item->commission) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @for($i = 0; $i < $team_row_loop; $i++)
                                        <tr class="cms_report">
                                            <td class="com-color"></td>
                                            <td class="com-color"></td>
                                        </tr>
                                        @endfor
                                        </tr>
                                        @endforeach
                                        <tr class="cms_report">
                                            <td colspan="7"></td>
                                            <td colspan="8" class="com-color"></td>
                                        <tr>
                                        <tr class="cms_report">
                                            <td colspan="5"></td>
                                            <td class="collect-total" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_service_amount) }}</td>
                                            <td class="collect-total" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_commission) }}</td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;"></td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_banker_cms) }}</td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;"></td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_mgmt_cms) }}</td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;"></td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_team_cms) }}</td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;"></td>
                                            <td class="collect-total com-color" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_bfe_cms) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                        <div id="report-table-detail">
                            <div class="table-responsive">
                                <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm" id="aaa">
                                    <thead class="tw-text-center tw-align-middle">
                                    <tr>
                                        <th>No</th>
                                        <th>Person</th>
                                        <th>Role</th>
                                        <th>Commission</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tw-text-center tw-align-middle">
                                    @foreach($commission_person_report as $cpr_key => $cpr_item)
                                        <tr>
                                            <td>{{ $cpr_key+1 }}</td>
                                            <td>{{ $cpr_item->name }}</td>
                                            <td>{{ $cpr_item->roles }}</td>
                                            <td>{{ money_num_format($cpr_item->total_cms) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="collect-total" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($commission_person_sum) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        @push('scripts')
            <script>
                //set it run as once
                var hash_block = false;

                $('.cms_report').children().css({
                    "min-width": "100px",
                    "text-align":  "center",
                    "vertical-align":  "middle",
                });

                function disableMonth(){
                    var start_month     = $('#search_start_month').val();
                    var select_block    = false;

                    $('#search_end_month option').each(function (){
                        if (parseInt($(this).val()) < start_month){
                            $('#search_end_month option[value = ' + $(this).val() + ']').attr('disabled','disabled');
                        }
                        else {
                            if (!select_block){
                                $("#search_end_month").val($(this).val());
                                select_block = true;
                            }

                            $('#search_end_month option[value = ' + $(this).val() + ']').removeAttr('disabled');
                        }
                    });
                }

                $(document).ready(function (){
                    $('#cms_tab a').click(function(e) {
                        var id = $(e.target).attr("href").substr(1);

                        $('#url_hash').val(id);

                        if (window.location.hash !== '#'+id){
                            $('#cms_report_form').submit();
                        }
                    });

                    var hash_value = $('#url_hash').val();

                    if(hash_value == 'detail'){
                        $('#pdf_type').val(5);
                        $('#excel_type').val(5);
                        var tag = 'detail';
                    }
                    else {
                        $('#pdf_type').val(4);
                        $('#excel_type').val(4);
                        var tag = 'main';
                    }

                    $('.report-html').val($('#report-table-'+tag).html());
                    $('.table_row').val($('#report-table-'+tag+' tr:not(.conclusion_tr)').length);

                    //run the function
                    window.location.hash = hash_value;
                    var hash = window.location.hash;
                    $('#cms_tab a[href="' + hash + '"]').tab('show');
                })

            </script>
        @endpush
</x-admin.app-layout>
