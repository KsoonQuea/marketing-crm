<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Collection Report</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Collection Report</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_pdf') }}">
                        @csrf
                        <input type="hidden" name="pdf_type" value="2">
                        <input type="hidden" name="pdf_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="pdf_this_month" value="{{ $this_month }}">
                        <input type="hidden" class="report-html" name="pdf_report_html">
                        @can('collection_report_pdf_2')
                            <button class="btn btn-primary" id="pdf-btn">PDF</button>
                        @endcan
                    </form>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_excel') }}">
                        @csrf
                        <input type="hidden" name="excel_type" value="2">
                        <input type="hidden" name="table_row" class="table_row"  value="1">
                        <input type="hidden" name="excel_this_year" value="{{ $this_year }}">
                        <input type="hidden" name="excel_this_month" value="{{ $this_month }}">
                        <input type="hidden" class="report-html" name="excel_report_html">
                        @can('collection_report_excel_2')
                            <button class="btn btn-secondary" id="excel-btn">Excel</button>
                        @endcan
                    </form>
                </div>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>
        <style>
            .vertical-align-center{
                vertical-align: auto !important;
                text-align: center !important;
            }

            .hori-align-center{
                text-align: center;
            }
        </style>

    <div class="card">
        <div class="card-body p-2">
            <div class="search-div">
                <form method="get" action="{{ route('admin.report.collection_index') }}">
                    <div class="row">
{{--                        <div class="col-12 col-md-3 pe-0">--}}
{{--                            <input type="text" name="search_input" id="search_input" class="form-control form-control-sm" placeholder="Search field here...">--}}
{{--                        </div>--}}
                        <div class="col-12 col-md-3 pe-0">
                            <select class="form-control form-control-sm" id="search_year" name="search_year">
                                <option value="all">All Year</option>
                                @for($year = $ym_setting->start_year; $year <= $ym_setting->this_year+1; $year++)
                                    <option value="{{ $year }}" {{ $year == $this_year ? 'selected' : '' }} >
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-12 col-md-3 pe-0">
                            <select class="form-control form-control-sm" id="search_month" name="search_month">
                                <option value="all">All Month</option>
                                @foreach($month as $month_item)
                                    <option value="{{ $month_item->month }}" {{ $month_item->month == $this_month ? 'selected' : '' }}>
                                        {{ $month_item->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-1 pe-0">

                        </div>

                        <div class="col-12 col-md-5">
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
                    <table class="table-bordered ajaxTable datatable datatable-data custom-table table-sm w-100 collection_report">
                        <thead>
                        <tr class="collection_report">
                            <th class="vertical-align-center" rowspan="2">NO.</th>
                            <th class="vertical-align-center" rowspan="2">NAME</th>
                            <th class="vertical-align-center" rowspan="2">APPROVAL AMOUNT</th>
                            <th class="vertical-align-center" rowspan="2">FEE</th>
                            <th class="vertical-align-center" rowspan="2">BD</th>
                            <th class="vertical-align-center" rowspan="2">BANKER</th>
                            <th class="vertical-align-center" rowspan="2">APPROVAL DATE</th>

                            <th class="hori-align-center collect-profoma" colspan="2" style=" background-color: #ddebf7">PROFOMA</th>
                            <th class="hori-align-center collect-invoice" colspan="2" style=" background-color: #e2efda">INVOICE</th>
                            <th class="hori-align-center collect-payment" colspan="2" style=" background-color: #fce4d6">PAYMENT</th>
                            <th class="vertical-align-center" rowspan="2">Paid Amount</th>
                            <th class="vertical-align-center sh-color" rowspan="2">Payment Status</th>
                        </tr>

                        <tr class="collection_report">
                            <th class="hori-align-center collect-profoma" style=" background-color: #ddebf7">DATE</th>
                            <th class="hori-align-center collect-profoma" style=" background-color: #ddebf7">INV NO</th>
                            <th class="hori-align-center collect-invoice" style=" background-color: #e2efda">DATE</th>
                            <th class="hori-align-center collect-invoice" style=" background-color: #e2efda">INV NO</th>
                            <th class="hori-align-center collect-payment" style=" background-color: #fce4d6">DATE</th>
                            <th class="hori-align-center collect-payment" style=" background-color: #fce4d6">OR NO</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($collectionReport as $collectionReport_key => $collectionReport_item)

                            @php
                                $or_query = \App\Models\Payments::select(['date', 'or'])->where('case_disburse_detail_id', $collectionReport_item->case_disburse_detail_id)->orderBy('date', 'desc')->orderBy('id', 'desc')->first();
                                $payment_count    = \App\Models\Payments::where('case_disburse_detail_id', $collectionReport_item->case_disburse_detail_id)->where('status', '1')->count();
                                $payment_sum      = \App\Models\Payments::where('case_disburse_detail_id', $collectionReport_item->case_disburse_detail_id)->where('status', '1')->sum('paid_amount');

                                /*
                                 * 0: Haven't
                                 * 1: Part Payment
                                 * 2: Fully Payment
                                 * */

                                if ($payment_count == 0){
                                    $payment_status    = 0;
                                }
                                else{
                                    if ($payment_sum >= $collectionReport_item->fee){
                                        $payment_status    = 2;
                                    }
                                    else{
                                        $payment_status = 1;
                                    }
                                }
                            @endphp

                            <tr class="vertical-align-center">
                                <td>{{ $collectionReport_key + 1 }}</td>
                                <td>{{ $collectionReport_item->client }}</td>
                                <td>{{ money_num_format($collectionReport_item->approved_amount) }}</td>
                                <td>{{ money_num_format($collectionReport_item->fee) }}</td>
                                <td>{{ $collectionReport_item->bfe_name }}</td>
                                <td>{{ $collectionReport_item->bank.' - '.$collectionReport_item->banker_name }}</td>
                                <td>{{ $collectionReport_item->approval_date }}</td>
                                <td class="collect-profoma">{{ $collectionReport_item->pro_date }}</td>
                                <td class="collect-profoma">{{ $collectionReport_item->pro_no }}</td>
                                <td class="collect-invoice">{{ $collectionReport_item->inv_date }}</td>
                                <td class="collect-invoice">{{ $collectionReport_item->inv_no }}</td>
                                <td class="collect-payment">{{ $or_query->date ?? '' }}</td>
                                <td class="collect-payment">{{ $or_query->or ?? '' }}</td>
                                <td class="bg-light {{ $payment_status == 2 ? 'text-success' : ($payment_status == 1 ? 'text-info' : 'font-info') }}" style="background-color: rgb(230,237,239);">
                                    {{ money_num_format($payment_sum) }}
                                </td>
                                <td class="bg-light fw-bold {{ $payment_status == 2 ? 'text-success' : ($payment_status == 1 ? 'text-info' : 'font-info') }}" style="background-color: rgb(230,237,239); color:
                                {{ $payment_status == 2 ? 'mediumspringgreen' : "" }}
                                {{ $payment_status == 1 ? 'deepskyblue' : "" }}
                                {{ $payment_status == 0 ? "dimgrey" : "" }} ;">
                                    {{ $payment_status == 2 ? 'Fully Paid' : "" }}
                                    {{ $payment_status == 1 ? 'Part Paid' : "" }}
                                    {{ $payment_status == 0 ? "Haven't" : "" }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="13"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="collect-total">{{ money_num_format($total_approval_amounts) }}</td>
                            <td class="collect-total">{{ money_num_format($total_fees) }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="13"></td>
                        </tr>
                        </tbody>
                    </table>
                    {{--                <p class="tw-text-rose-500 tw-my-3">** Please take note, care sdn bhd is CTOS report. So no need update in this collection report</p>--}}
                </div>
            </div>
        </div>
    </div>
        @push('scripts')
            <script>
                $(document).ready(function (){
                    $('.report-html').val($('#report-table').html());
                    $('.table_row').val($('#report-table tr:not(.conclusion_tr)').length);
                });
            </script>
        @endpush
</x-admin.app-layout>
