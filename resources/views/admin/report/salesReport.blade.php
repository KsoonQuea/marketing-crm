<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Sales Report</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Sales Report</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_pdf') }}">
                        @csrf
                        <input type="hidden" name="pdf_type" value="1">
                        <input type="hidden" name="pdf_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="pdf_this_start_month" value="{{ $this_start_month }}">
                        <input type="hidden" name="pdf_this_end_month" value="{{ $this_end_month }}">
                        <input type="hidden" class="report-html" name="pdf_report_html">
                        @can('sales_report_pdf_2')
                            <button class="btn btn-primary" id="pdf-btn">PDF</button>
                        @endcan
                    </form>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_excel') }}">
                        @csrf
                        <input type="hidden" name="excel_type" value="1">
                        <input type="hidden" name="table_row" class="table_row"  value="1">
                        <input type="hidden" name="excel_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="excel_this_start_month" value="{{ $this_start_month }}">
                        <input type="hidden" name="excel_this_end_month" value="{{ $this_end_month }}">
                        <input type="hidden" class="report-html" name="excel_report_html">
                        @can('sales_report_excel_2')
                            <button class="btn btn-secondary" id="excel-btn">Excel</button>
                        @endcan
                    </form>
                </div>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>

        <style>
            .conclusion table{
                width: 600px;
            }
        </style>

    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form method="get" action="{{ route('admin.report.sales_index') }}">
                    <div class="row">
                        <div class="col-12 col-md-2 pe-0">
                            <input type="text" name="search_input" id="search_input" class="form-control form-control-sm" value="{{ $input }}" placeholder="Search field here...">
                            <small class="text-danger text-xs">*Client, Product, Staff, Banker</small>
                        </div>
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
            <div id="report-table">
                <div class="table-responsive">
                    <table class="table table-bordered ajaxTable datatable datatable-data custom-table table-sm">
                        <thead>
                        <tr class="sales-company">
                            <th class="sc-color">Client</th>
                            <th class="sc-color">Product</th>
                            <th class="sc-color">Approval Date</th>
                            <th class="sc-color">Approval Amount</th>
                            <th class="sc-color">Rate</th>
                            <th class="sc-color">Fee</th>
                            <th class="sc-color">Inv</th>
                            <th class="sc-color">OR</th>
                            <th class="sc-color">Client Pay Date</th>
                            <th class="sc-color">Paid Amount</th>
                            <th class="sh-color">Payment Status</th>

                            <th class="scom1-color">Staff / Agent</th>
                            <th class="scom1-color">Percent</th>
                            <th class="scom1-color">Commission</th>
                            <th class="scom1-color">Pay Out Date</th>

                            <th class="sa-color">Approval</th>
                            <th class="sa-color">Percent</th>
                            <th class="sa-color">Commission</th>

                            <th class="sh-color">Holding</th>

                            <th class="scom2-color">Overriding</th>
                            <th class="scom2-color">Percent</th>
                            <th class="scom2-color">Commission</th>
                            <th class="scom2-color">Pay Out Date</th>

                            <th class="removeable"><div>&nbsp</div></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($salesReport as $salesReport_key => $salesReport_item)
                            @php
                                $payments         = \App\Models\Payments::where('case_disburse_detail_id', $salesReport_item->case_disburse_detail_id)->get();
                                $payment_count    = \App\Models\Payments::where('case_disburse_detail_id', $salesReport_item->case_disburse_detail_id)->where('status', '1')->count();
                                $payment_sum      = \App\Models\Payments::where('case_disburse_detail_id', $salesReport_item->case_disburse_detail_id)->where('status', '1')->sum('paid_amount') / 1.06;
                                $payment_arr      = array();

                                /*
                                 * 0: Haven't
                                 * 1: Part Payment
                                 * 2: Fully Payment
                                 * */

                                if ($payment_count == 0){
                                    $payment_status    = 0;
                                }
                                else{
                                    if ($payment_sum >= $salesReport_item->fee){
                                        $payment_status    = 2;
                                    }
                                    else{
                                        $payment_status = 1;
                                    }
                                }

                                foreach ($payments as $payment_item){
                                    array_push($payment_arr, $payment_item->or);
                                }

                                $or_sentence                = empty($payment_arr) ? null : implode(", \n", $payment_arr);

                                $overriding_query           = \App\Models\CaseOverridings::where('case_disburse_detail_id', $salesReport_item->case_disburse_detail_id);
                                $content                    = $overriding_query->get();
                                $rowspan_count              = $content->count() == 0 ? 1 : $content->count();

                                $total_overriding_amount    += $overriding_query->sum('commission');
                            @endphp

                            <tr class="sales-company">
                                <td rowspan="{{ $rowspan_count }}">{{ $salesReport_item->client }}</td>
                                <td rowspan="{{ $rowspan_count }}">{{ $salesReport_item->product }}</td>
                                <td rowspan="{{ $rowspan_count }}">{{ report_date_format($salesReport_item->approval_date) }}</td>
                                <td rowspan="{{ $rowspan_count }}">{{ money_num_format($salesReport_item->approved_amount) }}</td>
                                <td rowspan="{{ $rowspan_count }}">{{ money_num_format($salesReport_item->rate).' %' }}</td>
                                <td rowspan="{{ $rowspan_count }}" class="sc-color fw-bold" style="font-weight: bold">{{ money_num_format($salesReport_item->fee) }}</td>
                                <td rowspan="{{ $rowspan_count }}" class="{{ $salesReport_item->inv == null ? "sales-haven fw-bold" : "" }} "  style="{{ $salesReport_item->inv == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                    {{ $salesReport_item->inv ?? "Haven't" }}
                                </td>
                                <td rowspan="{{ $rowspan_count }}" class=" {{ $or_sentence == null ? "sales-haven fw-bold" : "" }}" style="{{ $or_sentence == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                    {{ $or_sentence ?? "Haven't" }}
                                </td>
                                <td rowspan="{{ $rowspan_count }}" class=" {{ $salesReport_item->client_pay_date == null ? "sales-haven fw-bold" : "" }}"  style="{{ $salesReport_item->client_pay_date == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                    {{ $salesReport_item->client_pay_date != null ? report_date_format($salesReport_item->client_pay_date) : "Haven't" }}
                                </td>
                                <td rowspan="{{ $rowspan_count }}" class="" style="">
                                    {{ money_num_format($payment_sum) }}
                                </td>
                                <td rowspan="{{ $rowspan_count }}" class="bg-light fw-bold {{ $payment_status == 2 ? 'text-success' : ($payment_status == 1 ? 'text-info' : 'font-info') }}" style="background-color: rgb(230,237,239); color:
                                {{ $payment_status == 2 ? 'mediumspringgreen' : "" }}
                                {{ $payment_status == 1 ? 'deepskyblue' : "" }}
                                {{ $payment_status == 0 ? "dimgrey" : "" }} ;">
                                    {{ $payment_status == 2 ? 'Fully Paid' : "" }}
                                    {{ $payment_status == 1 ? 'Part Paid' : "" }}
                                    {{ $payment_status == 0 ? "Haven't" : "" }}
                                </td>

                                <td rowspan="{{ $rowspan_count }}" >{{ $salesReport_item->bfe_name }}</td>
                                <td rowspan="{{ $rowspan_count }}" >{{ money_num_format($salesReport_item->bfe_percent).' %' }}</td>
                                <td rowspan="{{ $rowspan_count }}"  class="scom1-color fw-bold" style="font-weight: bold">{{ money_num_format($salesReport_item->bfe_commission) }}</td>
                                <td rowspan="{{ $rowspan_count }}"  class=" {{ $salesReport_item->bfe_pay_out == null ? "sales-haven fw-bold" : "" }}" style="{{ $salesReport_item->bfe_pay_out == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                    {{ $salesReport_item->bfe_pay_out != null ? report_date_format($salesReport_item->bfe_pay_out) : "Haven't" }}
                                </td>

                                <td rowspan="{{ $rowspan_count }}" >{{ $salesReport_item->banker_name }}</td>
                                <td rowspan="{{ $rowspan_count }}" >{{ money_num_format($salesReport_item->banker_percent).' %' }}</td>
                                <td rowspan="{{ $rowspan_count }}" class="sa-color fw-bold" style="font-weight: bold">{{ money_num_format($salesReport_item->banker_commission) }}</td>

                                <td rowspan="{{ $rowspan_count }}" class=" {{ $salesReport_item->banker_pay_out == null ? "sales-haven fw-bold" : "" }}" style="{{ $salesReport_item->banker_pay_out == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                {{ $salesReport_item->banker_pay_out != null ? report_date_format($salesReport_item->banker_pay_out) : "Haven't" }}
                                </th>

                                @foreach($content as $salesReportOverriding_key => $salesReportOverriding_item)

                                    @if($salesReportOverriding_key == 0)
                                        <td>{{ $salesReportOverriding_item->name }}</td>
                                        <td>{{ money_num_format($salesReportOverriding_item->commission_rate).' %' }}</td>
                                        <td class="scom2-color fw-bold" style="font-weight: bold">{{ money_num_format($salesReportOverriding_item->commission) }}</td>
                                        <td class=" {{ $salesReportOverriding_item->commission_pay_day == null ? "sales-haven fw-bold" : "" }}" style="{{ $salesReportOverriding_item->commission_pay_day == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                            {{ $salesReportOverriding_item->commission_pay_day?? "Haven't" }}
                                        </td>
                                        <td rowspan="{{ $rowspan_count }}" class="removeable">
                                            @can('sales_report_edit_2')
                                                <a class="btn btn-xs btn-info text-white editSales">
                                                    <input type="hidden" class="sales_id" value="{{ $salesReport_item->case_disburse_detail_id }}">
                                                    <i class="fa fa-edit fa-lg" title="edit"></i>
                                                </a>
                                            @endcan
                                        </td>
                            @else
                                <tr class="sales-company">
                                    <td>{{ $salesReportOverriding_item->name }}</td>
                                    <td>{{ money_num_format($salesReportOverriding_item->commission_rate).' %' }}</td>
                                    <td class="scom2-color fw-bold" style="font-weight: bold">{{ money_num_format($salesReportOverriding_item->commission) }}</td>
                                    <td class=" {{ $salesReportOverriding_item->commission_pay_day == null ? "sales-haven fw-bold" : "" }}" style="{{ $salesReportOverriding_item->commission_pay_day == null ? 'background-color: rgb(226,239,218); color: red ; font-weight: bold ;' : '' }}">
                                        {{ $salesReportOverriding_item->commission_pay_day ?? "Haven't" }}
                                    </td>
                                </tr>
                                @endif

                                @endforeach

                                </tr>
                                @endforeach
                                {{--                        <tr class="sales-company">--}}
                                {{--                            <td rowspan="2">DEAR YOU SDN BHD</td>--}}
                                {{--                            <td rowspan="2">CIMB</td>--}}
                                {{--                            <td rowspan="2">01/06/2022</td>--}}
                                {{--                            <td rowspan="2">500,000</td>--}}
                                {{--                            <td rowspan="2">3.500%</td>--}}
                                {{--                            <td class="sc-color" rowspan="2">17,500</td>--}}
                                {{--                            <td class="sales-haven" rowspan="2">Haven</td>--}}
                                {{--                            <td class="sales-haven" rowspan="2">Haven</td>--}}

                                {{--                            <td rowspan="2">Wan Teng</td>--}}
                                {{--                            <td rowspan="2">13.5%</td>--}}
                                {{--                            <td class="scom1-color" rowspan="2">2,363</td>--}}
                                {{--                            <td class="sales-haven" rowspan="2">Haven</td>--}}

                                {{--                            <td rowspan="2">Charles</td>--}}
                                {{--                            <td rowspan="2">0%</td>--}}
                                {{--                            <td class="sa-color" rowspan="2">0</td>--}}

                                {{--                            <td class="sales-haven" rowspan="2">Haven</th>--}}

                                {{--                            <td>Chloe</td>--}}
                                {{--                            <td>2%</td>--}}
                                {{--                            <td class="scom2-color">350</td>--}}
                                {{--                            <td class="sales-haven">Haven</td>--}}
                                {{--                            <td rowspan="2">--}}
                                {{--                                <a class="btn btn-xs btn-info text-white" id="editSales">--}}
                                {{--                                    <i class="fa fa-edit fa-lg"></i>--}}
                                {{--                                </a>--}}
                                {{--                            </td>--}}
                                {{--                        </tr>--}}
                                {{--                        <tr class="sales-company">--}}
                                {{--                            <td>Belinda</td>--}}
                                {{--                            <td>3%</td>--}}
                                {{--                            <td class="scom2-color">525</td>--}}
                                {{--                            <td class="sales-haven">Haven</td>--}}
                                {{--                        </tr>--}}
                                {{--                        <tr>--}}
                                {{--                            <td></td>--}}
                                {{--                        </tr>--}}
                        </tbody>
                    </table>
                </div>

                @php
                    $company_profit = $total_fees - $total_bfe_commissions - $total_banker_commissions - $total_overriding_amount;
                @endphp

                <br>
                <div class="conclusion card tw-my-8 tw-rounded-xl xl:tw-w-2/5 md:tw-w-3/5 tw-w-full float-right">
                    <div class="card-body p-2">
                        <table class="">
                            <tr class="conclusion_tr" style="width: 100%">
                                <td colspan="1" style="width: 50%"><b>Company Nett Profit : </b></td>
                                <td colspan="1">{{ money_num_format($company_profit, 1) }}</td>
                            </tr>
                            <tr class="conclusion_tr">
                                <td colspan="1"><b>Approved Amount : </b></td>
                                <td colspan="1">{{ money_num_format($total_approval_amounts, 1) }}</td>
                            </tr>
                            <tr class="conclusion_tr">
                                <td colspan="1"><b>Total Fees : </b></td>
                                <td colspan="1">{{ money_num_format($total_fees, 1) }}</td>
                            </tr>
                            <tr class="conclusion_tr">
                                <td colspan="1"><b>BFE Commission : </b></td>
                                <td colspan="1">{{ money_num_format($total_bfe_commissions, 1) }}</td>
                            </tr>
                            <tr class="conclusion_tr">
                                <td colspan="1"><b>Banker Commission : </b></td>
                                <td colspan="1">{{ money_num_format($total_banker_commissions, 1) }}</td>
                            </tr>
                            <tr class="conclusion_tr">
                                <td colspan="1"><b>Management / Team Commission : </b></td>
                                <td colspan="1">{{ money_num_format($total_overriding_amount, 1) }}</td>
                            </tr>
                        </table>
{{--                        <div class="row">--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>Company Nett Profit : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($company_profit, 1) }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>Approved Amount : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($total_approval_amounts, 1) }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>Total Fees : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($total_fees, 1) }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>BFE Commission : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($total_bfe_commissions, 1) }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>Banker Commission : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($total_banker_commissions, 1) }}</p>--}}
{{--                            </div>--}}
{{--                            <div class="col-8 col-md-9 col-lg-9 col-xl-8">--}}
{{--                                <p class="tw-w-9/12 float-right"><b>Management / Team Commission : </b></p>--}}
{{--                            </div>--}}
{{--                            <div class="col-4 col-md-3 col-lg-3 col-xl-4">--}}
{{--                                <p>{{ money_num_format($total_overriding_amount, 1) }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Sales Modal --}}
    <div id="editSalesModal" class="modal">
        <div class="modal-content tw-my-16 tw-mx-auto">
            <div class="modal-header">
                <h4 class="modal-inside-title">Edit Sales Report Detail</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route("admin.report.sales_modal.update") }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="disburse_detail_id" id="disburse_detail_id">

                    <h4 class="card-title">BFE</h4>
                    <div class="form-group col-12 col-md-3">
                        <label class="required" for="paydate1">Pay Out Date</label>
                        <div id="bfe_pay_out_area"></div>
                        <span class="help-block"></span>
                    </div>

                    <h4 class="card-title">Banker</h4>
                    <div class="form-group col-12 col-md-3">
                        <label class="required" for="holding">Holding Date</label>
                        <div id="banker_pay_out_area"></div>
                        <span class="help-block"></span>
                    </div>

                    <h4 class="card-title">Managements & Teams</h4>
                    <div id="overriding_content"></div>

                    <div class="button-container">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="#" class="cancel btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $('.sales-company').children().css({
                "min-width": "100px"
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
                var clone = $('.removeable').children().clone();

                $('.removeable').empty();

                $('.report-html').val($('#report-table').html());
                $('.table_row').val($('#report-table tr:not(.conclusion_tr)').length);

                $('.removeable').each(function (key, item){
                    item.append(clone[key]);
                });

                $('.editSales').click(function(event) {

                    var sales_id = $(this).children('input').val();

                    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                    $.ajax({
                        type: "POST", //HTTP POST Method
                        url: "{{ route('admin.report.sales_modal') }}",
                        data: { //Passing data
                            sales_id: sales_id,
                        },
                        success: function (result) {
                            var decode_result = JSON.parse(result);

                            var bfe_pay_content     = decode_result.bfe_pay_out ?? "";
                            var banker_pay_content  = decode_result.banker_pay_out ?? "";

                            var bfe_area    = '<input class="form-control datepicker-new" type="text" name="bfe_pay_out" id="bfe_pay_out" value="'+ bfe_pay_content +'" data-language="en" placeholder="YYYY-MM-DD">';
                            var banker_area = '<input class="form-control datepicker-new" type="text" name="banker_pay_out" id="banker_pay_out" value="'+ banker_pay_content +'" data-language="en" placeholder="YYYY-MM-DD">';

                            $('#bfe_pay_out_area').html(bfe_area);
                            $('#banker_pay_out_area').html(banker_area);
                            $('#disburse_detail_id').val(decode_result.disburse_detail_id);
                            $('#overriding_content').html(decode_result.html);

                            $(".datepicker-new").datepicker({
                                dateFormat: 'yyyy-mm-dd'
                            });
                        }
                    });

                    $('#editSalesModal').show();
                    event.stopPropagation();
                });
                $('.cancel').click(function() {
                    $(this).parent().parent().parent().parent().parent().hide();
                });

                // disableMonth();
            });
        </script>
            @include('admin.report.partials.reportJs')
    @endpush
</x-admin.app-layout>
