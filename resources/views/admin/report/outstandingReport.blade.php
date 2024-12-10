<x-admin.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Debtor Outstanding Report</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Debtor Outstanding Report</li>
        <x-slot:breadcrumb_action>
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_pdf') }}">
                        @csrf
                        <input type="hidden" name="pdf_type" value="3">
                        <input type="hidden" name="pdf_date_type" value="{{ $date_type }}">
                        <input type="hidden" name="pdf_date_from" value="{{ $date_from }}">
                        <input type="hidden" name="pdf_date_to" value="{{ $date_to }}">
                        <input type="hidden" class="report-html" name="pdf_report_html">
                        @can('outstanding_report_pdf_2')
                            <button class="btn btn-primary" id="pdf-btn">PDF</button>
                        @endcan
                    </form>
                </div>
                <div class="col-lg-6">
                    <form method="post" action="{{ route('admin.report.generate_excel') }}">
                        @csrf
                        <input type="hidden" name="excel_type" value="3">
                        <input type="hidden" name="table_row" class="table_row"  value="1">
                        <input type="hidden" name="excel_date_type" value="{{ $date_type }}">
                        <input type="hidden" name="excel_date_from" value="{{ $date_from }}">
                        <input type="hidden" name="excel_date_to" value="{{ $date_to }}">
                        <input type="hidden" class="report-html" name="excel_report_html">
                        @can('outstanding_report_excel_2')
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
                <form method="get" action="{{ route('admin.report.outstanding_index') }}">
                    <div class="row">
                        <div class="col-12 col-md-2 pe-0">
                            <select class="form-control form-control-sm" id="search_date_type" name="search_date_type">
                                <option value="1" {{ $date_type == 1 ? 'selected' : '' }}>Invoice Date</option>
                                <option value="2" {{ $date_type == 2 ? 'selected' : '' }}>Payment Date</option>
                                <option value="3" {{ $date_type == 3 ? 'selected' : '' }}>SST Paid date</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="search_date_from" name="search_date_from" value="{{$date_from}}" placeholder="Date From">
                        </div>
                        <div class="col-12 col-md-2 pe-0">
                            <input class="datepicker-here digits form-control form-control-sm" type="text" data-language="en" id="search_date_to" name="search_date_to" value="{{$date_to}}" placeholder="Date To">
                        </div>

                        <div class="col-12 col-md-2 pe-0">

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
                        <thead class="tw-text-center">
                        <tr>
                            <th colspan="9"></th>
                            <th colspan="4" style="text-align: left">PAYMENT RECEIVED</th>
                        </tr>
                        </thead>
                        <thead class="thead-bg tw-text-center tw-align-middle">
                        <tr>
                            <th>DATE</th>
                            <th>INV NO</th>
                            <th>PARTICULAR</th>
                            <th>FEE</th>
                            <th>SST</th>
                            <th>DISB</th>
                            <th>TOTAL</th>
                            <th>Paid Amount</th>
                            <th class="" style="border-right: black solid 4px !important;">Payment Status</th>

                            <th>DATE</th>
                            <th>CHEQUE NO</th>
                            <th>OR</th>
                            <th>SST PAID</th>
                        </tr>
                        </thead>
                        <tbody class="tw-text-center tw-align-middle">
                        @foreach($outstandingReport as $outstandingReport_key => $outstandingReport_item)
                            @php
                                switch ($date_type){
                                    case 1: case 3:
                                        $payment            = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->get();
                                        $payment_all_count  = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->count();
                                        $payment_count      = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->count();
                                        $payment_sum        = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->sum('paid_amount');
                                        break;

                                    case 2:
                                        $payment            = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->whereBetween('date',  [$date_from, $date_to])->get();
                                        $payment_all_count  = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->whereBetween('date',  [$date_from, $date_to])->count();
                                        $payment_count      = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->whereBetween('date',  [$date_from, $date_to])->count();
                                        $payment_sum        = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->whereBetween('date',  [$date_from, $date_to])->sum('paid_amount');
                                        break;

                                    /*case 3:
                                        $payment            = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->whereBetween('sst_paid_date',  [$date_from, $date_to])->get();
                                        $payment_all_count  = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->whereBetween('sst_paid_date',  [$date_from, $date_to])->count();
                                        $payment_count      = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->whereBetween('sst_paid_date',  [$date_from, $date_to])->count();
                                        $payment_sum        = \App\Models\Payments::where('case_disburse_detail_id', $outstandingReport_item->case_disburse_detail_id)->where('status', '1')->whereBetween('sst_paid_date',  [$date_from, $date_to])->sum('paid_amount');
                                        break;*/
                                }

                                $payment_all_count = $payment_all_count === 0 ? 1 : $payment_all_count;

                                if ($payment_count == 0){
                                    $payment_status    = 0;
                                }
                                else{
                                    if ($payment_sum >= $outstandingReport_item->fee){
                                        $payment_status    = 2;
                                    }
                                    else{
                                        $payment_status = 1;
                                    }
                                }
                            @endphp
                            <tr>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ $outstandingReport_item->inv_date }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ $outstandingReport_item->inv_no }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ $outstandingReport_item->particular }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ money_num_format($outstandingReport_item->fee ?? 0) }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ money_num_format($outstandingReport_item->sst ?? 0) }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ money_num_format($outstandingReport_item->disb ?? 0) }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle">{{ money_num_format($outstandingReport_item->total ?? 0) }}</td>
                                <td rowspan="{{ $payment_all_count }}" style="vertical-align: middle" class="bg-light {{ $payment_status == 2 ? 'text-success' : ($payment_status == 1 ? 'text-info' : 'font-info') }}" style="background-color: rgb(230,237,239);">
                                    {{ money_num_format($payment_sum) }}
                                </td>
                                <td rowspan="{{ $payment_all_count }}"
                                    class="bg-light fw-bold {{ $payment_status == 2 ? 'text-success' : ($payment_status == 1 ? 'text-info' : 'font-info') }}"
                                    style="border-right: black solid 4px !important; vertical-align: middle; background-color: rgb(230,237,239); color:
                                    {{ $payment_status == 2 ? 'mediumspringgreen' : "" }}
                                    {{ $payment_status == 1 ? 'deepskyblue' : "" }}
                                    {{ $payment_status == 0 ? "dimgrey" : "" }} ;
                                    ">
                                    {{ $payment_status == 2 ? 'Fully Paid' : "" }}
                                    {{ $payment_status == 1 ? 'Part Paid' : "" }}
                                    {{ $payment_status == 0 ? "Haven't" : "" }}
                                </td>

                                @forelse($payment as $payment_key => $payment_item)
                                    @if($payment_key == 0)
                                        <td>{{ $payment_item->date }}</td>
                                        <td>{{ $payment_item->cheque_no }}</td>
                                        <td>{{ $payment_item->or }}</td>
                                        <td rowspan="{{ $payment_all_count }}" class="{{ !$outstandingReport_item->sst_paid_date ? 'removeable' : '' }}" style="vertical-align: middle">
                                            {!!   $outstandingReport_item->sst_paid_date ??
                                                '<a class="btn btn-xs btn-info text-white editSales">
                                                    <input type="hidden" id="detail_id" value="'.$outstandingReport_item->case_disburse_detail_id.'">
                                                    <input type="hidden" id="inv_no" value="'.$outstandingReport_item->inv_no.'">
                                                    <input type="hidden" id="particular" value="'.$outstandingReport_item->particular.'">
                                                    <i class="fa fa-edit fa-lg" title="edit"></i>
                                                </a>'
                                            !!}
                                        </td>
                                    @else
                                        <tr>
                                            <td>{{ $payment_item->date }}</td>
                                            <td>{{ $payment_item->cheque_no }}</td>
                                            <td>{{ $payment_item->or }}</td>
                                        </tr>
                                    @endif

                                    @empty
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                @endforelse
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                            <td class="collect-total">{{ money_num_format($total_fees??0) }}</td>
                            <td class="collect-total">{{ money_num_format($total_ssts??0) }}</td>
                            <td class="collect-total">{{ money_num_format($total_disbs??0) }}</td>
                            <td class="collect-total tw-mr-10" style="border-top: 2px solid ;border-bottom: 4px double ;text-align: center;">{{ money_num_format($total_totals??0) }}</td>
                            <td colspan="2" style="border-right: black solid 4px !important;"></td>
                            <td colspan="4"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="6" style="border-right: black solid 4px !important;"></td>
                            <td colspan="4"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <div id="editSalesModal" class="modal">
            <div class="modal-content tw-my-16 tw-mx-auto">
                <div class="modal-header">
                    <h4 class="modal-inside-title">Add SST Paid Date</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route("admin.report.outstanding_modal.update") }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="disburse_detail_id" id="disburse_detail_id">

                        <div id="sst_paid_date_area"></div>

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

                $(document).ready(function (){

                    var clone = $('.removeable').children().clone();

                    $('.removeable').empty();

                    $('.report-html').val($('#report-table').html());
                    $('.table_row').val($('#report-table tr:not(.conclusion_tr)').length);

                    $('.removeable').each(function (key, item){
                        item.append(clone[key]);
                    });

                    $('.editSales').click(function(event) {

                        var detail_id   = $(this).children('#detail_id').val();

                        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                        $.ajax({
                            type: "POST", //HTTP POST Method
                            url: "{{ route('admin.report.outstanding_modal') }}",
                            data: { //Passing data
                                detail_id: detail_id,
                            },
                            success: function (result) {
                                var decode_result = JSON.parse(result);

                                var particular      = decode_result.particular ?? "";
                                var inv_no          = decode_result.inv_no ?? "";
                                var sst_paid_date   = decode_result.sst_paid_date ?? "";

                                var html =
                                    '<h6 class="card-title mb-3">'+ particular +' - '+ inv_no +'</h6> ' +
                                    '<div class="form-group col-12 col-md-3"> ' +
                                    '<label class="required" for="paydate1">SST Paid Date</label> ' +
                                    '<input class="form-control datepicker-new" type="text" name="sst_paid_date" id="sst_paid_date" value="'+ sst_paid_date +'" data-language="en" placeholder="YYYY-MM-DD"> ' +
                                    '<span class="help-block"></span> ' +
                                    '</div>';

                                $('#sst_paid_date_area').html(html);
                                $('#disburse_detail_id').val(decode_result.disburse_detail_id);

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
                });
            </script>
        @endpush
</x-admin.app-layout>
