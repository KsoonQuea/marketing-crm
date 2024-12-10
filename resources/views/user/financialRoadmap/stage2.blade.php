<x-user.app-layout>
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-form.css') }}">
        <style>
            /* old */
            .select2 + .select2-container .select2-selection {
                border-radius: 60px !important;
                background-color: #E5F9FC !important;
            }

            /* Input field */
            .select2 .select2-selection__rendered {
                color: #002855 !important;
                font-weight: bold !important;
            }

            /* Search field */
            .select2-search input {
                background-color: #E5F9FC
            }

            .input_bg{
                background-color: #E5F9FC !important;
            }

            .percent_bg{
                background-color: #B3A369 !important;
                color: #FFFFFF !important;
                font-weight: bold;
                text-align: center;
                font-size: 12px;
                border-radius: 30px;
            }

            .card-radius{
                border-radius: 5px !important;
            }

            .primary_font_color{
                color: #05C3DD !important;
            }

            .secondary_font_color{
                color: #21B9DB !important;
            }

            .third_font_color{
                color: #A5A5A5 !important;
            }

            .four_font_color{
                color: #002855 !important;
            }

            .fifth_font_color{
                color: #037699 !important;
            }

            .six_font_color{
                color: #FFFFFF !important;
            }

            .primary_bg_color{
                background-color: #05C3DD !important;
                color: white;
            }

            .secondary_bg_color{
                background-color: #037699 !important;
                color: white;
            }

            .third_bg_color{
                background-color: #002855 !important;
                color: white;
            }

            .four_bg_color{
                background-color: #21B9DB !important;
                color: white !important;
            }

            .fifth_bg_color{
                background-color: #012138 !important;
                color: white;
            }

            .blurry-text {
                text-shadow: 0 0 7px black !important;
                color: transparent !important;
            }

            .input-field-color{
                color: #0a1520 !important;
                font-weight: bold !important;
            }
        </style>
    @endpush

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12 col-xl-3">
                <h4 class="primary_font_color"><b>Financial Roadmap</b></h4>
                <p class="third_font_color">Basic Information</p>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-radius">

                            <div class="card-body">
                                <form class="theme-form">
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Company Name</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="company_name" name="company_name" type="text" value="{{ $basic_info->company_name }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Business Industry</label>
                                        <select class="select2" name="business_industry" id="business_industry" disabled>
                                            @foreach($industry_types as $id => $industry_type)
                                                <option value="{{ $id }}"{{ (old('business_industry') === $id) ? 'selected' : '' }} {{ $basic_info->business_industry == $id ? 'selected' : '' }}>
                                                    {{ $industry_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Person</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_person" name="contact_person" type="text" value="{{ $basic_info->contact_person }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Number</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_number" name="contact_number" type="text" value="{{ $basic_info->contact_number }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Email</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="email" name="email" type="text" value="{{ $basic_info->email }}" readonly>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-9">
                <div class="row">
                    <div class="col-3">
                        <h4 class="secondary_font_color">Financial Year</h4>
                        <p class="third_font_color">Please key in the data below</p>
                    </div>

                    <div class="col-9">
                        <div class="row">
                            <div class="col-3"></div>

                            @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                @if($financial_year_arr_key < 3)
                                    <div class="col-3">
                                        <input type="hidden" name="financial_year[{{ $financial_year_arr_key }}]" value="{{ $financial_year_arr_item }}">
                                        <h5 class="secondary_font_color">{{ $financial_year_arr_item }}</h5>
                                        <p class="secondary_font_color">(RM)</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="col-sm-12">
                    <div class="card card-radius">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-3 primary_bg_color card-radius m-0 pt-3 ml-3">
                                    <h6>STATEMENT OF COMPREHENSIVE INCOME</h6>
                                    <hr width="20%" style="height: 2px">
                                    <small>PROFIT & LOSS STATEMENT</small>
                                </div>
                                <div class="col-9 p-l-0">
                                    <table class="table form-table-two ml-0">
                                        <tbody class="">
                                        @foreach($comprehensive_arr['name'] as $comprehensive_arr_key => $comprehensive_arr_item)
                                            <tr class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }} m-0 w-100" style="width: 100%">
                                                <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'primary_font_color' }} w-25" style="width: 25%">{{ $comprehensive_arr_item }}</td>

                                                @for($i = 0; $i < 3; $i++)

                                                    @if($i % 2 == 0)
                                                        <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }} w-25" style="width: 25%">

                                                            <div class="row">
                                                                <div class="col-7 p-0 m-0">
                                                                    <input type="text"
                                                                           class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                            {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }}"
                                                                           name="{{ $comprehensive_arr['id'][$comprehensive_arr_key] }}[{{ $i }}]" id="{{ $comprehensive_arr['id'][$comprehensive_arr_key].'-'.$i }}"
                                                                           value="{{ number_format($comprehensive_arr['data'][$comprehensive_arr_key][$i], 0, '.', ',') }}" readonly >
                                                                </div>

                                                                <div class="col-5 p-0 m-0">
                                                                    @if($comprehensive_arr['percent_status'][$comprehensive_arr_key] == 1)
                                                                        <div class="percent_bg pe-1 me-1">
                                                                            <input type="text"
                                                                                   onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '."'". $comprehensive_arr['id'][$comprehensive_arr_key]."'" .')' }}"
                                                                                   class="border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $comprehensive_arr['percent_status_id'][$comprehensive_arr_key] }}{{'['.$i.']'}}"
                                                                                   id="{{ $comprehensive_arr['percent_status_id'][$comprehensive_arr_key].'-'.$i }}" value="" readonly > %
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="w-25" style="width: 25%">

                                                            <div class="row">
                                                                <div class="col-7 p-0 m-0">
                                                                    <input type="text"
                                                                           class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                            {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }}"
                                                                           name="{{ $comprehensive_arr['id'][$comprehensive_arr_key] }}[{{ $i }}]" id="{{ $comprehensive_arr['id'][$comprehensive_arr_key].'-'.$i }}"
                                                                           value="{{ number_format($comprehensive_arr['data'][$comprehensive_arr_key][$i], 0, '.', ',') }}" readonly >
                                                                </div>

                                                                <div class="col-5 p-0 m-0">
                                                                    @if($comprehensive_arr['percent_status'][$comprehensive_arr_key] == 1)
                                                                        <div class="percent_bg pe-1 me-1">
                                                                            <input type="text"
                                                                                   onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '."'". $comprehensive_arr['id'][$comprehensive_arr_key]."'" .')' }}"
                                                                                   class="border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $comprehensive_arr['percent_status_id'][$comprehensive_arr_key] }}{{'['.$i.']'}}"
                                                                                   id="{{ $comprehensive_arr['percent_status_id'][$comprehensive_arr_key].'-'.$i }}" value="" readonly > %
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif

                                                @endfor
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card card-radius">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-3 secondary_bg_color card-radius m-0 pt-3 ml-3">
                                    <h6>STATEMENT OF FINANCIAL POSITION</h6>
                                    <hr width="20%" style="height: 2px">
                                    <small>BALANCE SHEET STATEMENT</small>
                                </div>
                                <div class="col-9 p-l-0">
                                    <table class="table form-table-two">
                                        <tbody>
                                        @foreach($financial_position_arr['name'] as $financial_position_arr_key => $financial_position_arr_item)
                                            <tr class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }}" style="width: 100%">
                                                <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'primary_font_color' }} w-25" style="width: 25%">{{ $financial_position_arr_item }}</td>

                                                @for($i = 0; $i < 3; $i++)

                                                    @if($i % 2 == 0)
                                                        <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }} w-25" style="width: 25%">
                                                            <div class="row">
                                                                <div class="col-7 p-0 m-0">
                                                                    <input type="text"
                                                                           class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                            {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }}"
                                                                           name="{{ $financial_position_arr['id'][$financial_position_arr_key] }}[{{ $i }}]" id="{{ $financial_position_arr['id'][$financial_position_arr_key].'-'.$i }}"
                                                                           value="{{ number_format($financial_position_arr['data'][$financial_position_arr_key][$i], 0, '.', ',') }}" readonly >
                                                                </div>

                                                                <div class="col-5 p-0 m-0">
                                                                    @if($financial_position_arr['percent_status'][$financial_position_arr_key] == 1)
                                                                        <div class="percent_bg pe-1 me-1">
                                                                            <input type="text"
                                                                                   onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '."'". $financial_position_arr['id'][$financial_position_arr_key]."'" .')' }}"
                                                                                   class="border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $financial_position_arr['percent_status_id'][$financial_position_arr_key] }}{{'['.$i.']'}}"
                                                                                   id="{{ $financial_position_arr['percent_status_id'][$financial_position_arr_key].'-'.$i }}" value="" readonly > %
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="w-25" style="width: 25%">

                                                            <div class="row">
                                                                <div class="col-7 p-0 m-0">
                                                                    <input type="text"
                                                                           class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                            {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }}"
                                                                           name="{{ $financial_position_arr['id'][$financial_position_arr_key] }}[{{ $i }}]" id="{{ $financial_position_arr['id'][$financial_position_arr_key].'-'.$i }}"
                                                                           value="{{ number_format($financial_position_arr['data'][$financial_position_arr_key][$i], 0, '.', ',') }}" readonly >
                                                                </div>

                                                                <div class="col-5 p-0 m-0">
                                                                    @if($financial_position_arr['percent_status'][$financial_position_arr_key] == 1)
                                                                        <div class="percent_bg pe-1 me-1">
                                                                            <input type="text"
                                                                                   onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '."'". $financial_position_arr['id'][$financial_position_arr_key]."'" .')' }}"
                                                                                   class="border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $financial_position_arr['percent_status_id'][$financial_position_arr_key] }}{{'['.$i.']'}}"
                                                                                   id="{{ $financial_position_arr['percent_status_id'][$financial_position_arr_key].'-'.$i }}" value="" readonly > %
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </td>
                                                    @endif

                                                @endfor
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card card-radius">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-3 third_bg_color card-radius m-0 pt-3 ml-3" >
                                    <h6>STATEMENT OF CASH FLOW</h6>
                                </div>
                                <div class="col-9 p-l-0">
                                    <table class="table form-table-two">
                                        <tbody>
                                        @foreach($cash_flow_arr['name'] as $cash_flow_arr_key => $cash_flow_arr_item)
                                            <tr class="w-100" style="width: 100%">
                                                <td class="w-25 primary_font_color" style="width: 25%">{{ $cash_flow_arr_item }}</td>

                                                @for($i = 0; $i < 3; $i++)

                                                    @if($i % 2 == 0)
                                                        <td class="input_bg w-25" style="width: 25%">
                                                            <div class="d-flex">
                                                                <div class="p-0 w-50">
                                                                    <input type="text" class="number-input border-0 w-100 m-0 fifth_font_color fw-bold small input_bg {{ $cash_flow_arr['id'][$cash_flow_arr_key].'_class' }}" value="{{ number_format($cash_flow_arr['data'][$cash_flow_arr_key][$i], 0, '.', ',') }}"
                                                                           name="{{ $cash_flow_arr['id'][$cash_flow_arr_key] }}[{{ $i }}]" id="{{ $cash_flow_arr['id'][$cash_flow_arr_key].'-'.$i }}" readonly>
                                                                </div>
                                                                <div class="p-0 w-50"></div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td class="w-25" style="width: 25%">
                                                            <div class="d-flex">
                                                                <div class="p-0 w-50">
                                                                    <input type="text" class="number-input border-0 w-100 m-0 fifth_font_color fw-bold small {{ $cash_flow_arr['id'][$cash_flow_arr_key].'_class' }}" value="{{ number_format($cash_flow_arr['data'][$cash_flow_arr_key][$i], 0, '.', ',') }}"
                                                                           name="{{ $cash_flow_arr['id'][$cash_flow_arr_key] }}[{{ $i }}]" id="{{ $cash_flow_arr['id'][$cash_flow_arr_key].'-'.$i }}" readonly>
                                                                </div>
                                                                <div class="p-0 w-50"></div>
                                                            </div>
                                                        </td>
                                                    @endif

                                                @endfor
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-sm-12">
                        <hr>

                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-3 fifth_bg_color card-radius m-0 pt-3 ml-3" >
                                        <h6>FINANCIAL POSITION</h6>
                                    </div>
                                    <div class="col-9 p-l-0">
                                        <table class="table form-table-two">
                                            <tbody>
                                            <tr class="w-100">
                                                <td class="w-25 primary_font_color fw-bold">Capacity (DSR)</td>

                                                @for($i = 0; $i < 3; $i++)

                                                    @if($i % 2 == 0)
                                                        <td class="input_bg w-25">
                                                            <input type="text" class="number-input border-0 blurry-text input_bg" name="dsr[{{ $i }}]" id="dsr-{{ $i }}" value="0">
                                                        </td>
                                                    @else
                                                        <td class="w-25">
                                                            <input type="text" class="number-input border-0 blurry-text" name="dsr[{{ $i }}]" id="dsr-{{ $i }}" value="0">
                                                        </td>
                                                    @endif

                                                @endfor
                                            </tr>
                                            <tr class="w-100">
                                                <td class="w-25 primary_font_color fw-bold">Capital (Gearing)</td>

                                                @for($i = 0; $i < 3; $i++)

                                                    @if($i % 2 == 0)
                                                        <td class="input_bg w-25">
                                                            <input type="text" class="number-input border-0 blurry-text input_bg" name="gearing[{{ $i }}]" id="gearing-{{ $i }}" value="0">
                                                        </td>
                                                    @else
                                                        <td class="w-25">
                                                            <input type="text" class="number-input border-0 blurry-text" name="gearing[{{ $i }}]" id="gearing-{{ $i }}" value="0">
                                                        </td>
                                                    @endif

                                                @endfor
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

            <div class="mb-4 mt-3 card p-3">
                <div class="card-title text-start">
                    <h6>Chart Review</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-6">
                            <div class="d-flex justify-content-center" style="width: 100%">
                                <div class="flot-chart-placeholder d-none d-sm-none d-md-none d-lg-none d-xl-none d-xxl-block" id=""
                                     style="height: 250px; width: 40%; background-color: #c4def1; margin-top: 50px; margin-left: 50%; position: absolute; z-index: 2; filter: blur(7px)"></div>

                                <div class="flot-chart-placeholder d-none d-sm-none d-md-none d-lg-none d-xl-block d-xxl-none" id=""
                                     style="height: 250px; width: 40%; background-color: #c4def1; margin-top: 50px; margin-left: 50%; position: absolute; z-index: 2; filter: blur(7px)"></div>

                                <div class="flot-chart-placeholder d-none d-sm-none d-md-none d-lg-block d-xl-none d-xxl-none" id=""
                                     style="height: 250px; width: 60%; background-color: #c4def1; margin-top: 50px; margin-left: 80%; position: absolute; z-index: 2; filter: blur(7px)"></div>

                                <div class="flot-chart-placeholder d-none d-sm-none d-md-block d-lg-none d-xl-none d-xxl-none" id=""
                                     style="height: 250px; width: 80%; background-color: #c4def1; margin-top: 50px; margin-left: 110%; position: absolute; z-index: 2; filter: blur(7px)"></div>

{{--                                <div class="flot-chart-placeholder d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none" id=""--}}
{{--                                     style="height: 250px; width: 120%; background-color: #c4def1; margin-top: 50px; margin-left: 130%; position: absolute; z-index: 2; filter: blur(7px)"></div>--}}

                                <div class="flot-chart-placeholder d-none d-md-flex justify-content-center" id="report_chart"></div>
                            </div>
                        </div>
                        <div class="col-3">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    @push('scripts')
        <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
            <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();

            //apex chart
            var options = {
                series: [{
                    name: 'Turnover',
                    data: [{{ $turnover_arr_text }}],
                }, {
                    name: 'Profit Before Tax',
                    data: [{{ $profit_bfr_tax_arr_text }}]
                }, {
                    name: 'Profit After Tax',
                    data: [{{ $profit_aft_tax_arr_text }}]
                }],
                chart: {
                    stacked: true,
                    type: 'bar',
                    height: 350,
                    width: 600 ,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [{{ $financial_year_arr_text }}],
                },
                title: {
                    text: 'Business Trend',
                    align: 'center',
                },
                yaxis: {
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#report_chart"), options);
            chart.render();

            var blur_chart = new ApexCharts(document.querySelector("#report_chart_blur"), options);
            blur_chart.render();

            //calculation start
            $( document ).ready(function() {
                for (var i = 0; i < 3; i++){
                    //area 1
                    var turnover            = parseFloat(recoverNumberFormat($("#turnover-"+ i).val() ?? 0));
                    var cogs                = parseFloat(recoverNumberFormat($("#cogs-"+ i).val() ?? 0));
                    var gross_profit        = parseFloat(recoverNumberFormat($("#gross_profit-"+ i).val() ?? 0));
                    var profit_bfr_tax      = parseFloat(recoverNumberFormat($("#profit_bfr_tax-"+ i).val() ?? 0));
                    var tax                 = parseFloat(recoverNumberFormat($("#tax-"+ i).val() ?? 0));
                    var profit_aft_tax      = parseFloat(recoverNumberFormat($("#profit_aft_tax-"+ i).val() ?? 0));

                    var cogs_percent            = cogs / turnover * 100;
                    var gross_profit_percent    = gross_profit / turnover * 100;
                    var profit_bfr_tax_percent  = profit_bfr_tax / turnover * 100;
                    var tax_percent             = tax / turnover * 100;
                    var profit_aft_tax_percent  = profit_aft_tax / turnover * 100;

                    $("#cogs_percent-"+ i).val(addCommasWithinDecimal(cogs_percent.toFixed(2).toString()));
                    $("#gross_profit_percent-"+ i).val(addCommasWithinDecimal(gross_profit_percent.toFixed(2).toString()));
                    $("#profit_bfr_tax_percent-"+ i).val(addCommasWithinDecimal(profit_bfr_tax_percent.toFixed(2).toString()));
                    $("#tax_percent-"+ i).val(addCommasWithinDecimal(tax_percent.toFixed(2).toString()));
                    $("#profit_aft_tax_percent-"+ i).val(addCommasWithinDecimal(profit_aft_tax_percent.toFixed(2).toString()));

                    //area 2
                    var inventories         = parseFloat(recoverNumberFormat($("#inventories-"+ i).val() ?? 0));
                    var trade_receivables   = parseFloat(recoverNumberFormat($("#trade_receivables-"+ i).val() ?? 0));
                    var trade_payables      = parseFloat(recoverNumberFormat($("#trade_payables-"+ i).val() ?? 0));

                    var inventories_percent             = inventories / cogs * 100;
                    var trade_receivables_percent       = trade_receivables / cogs * 100;
                    var trade_payables_percent          = trade_payables / cogs * 100;

                    $("#inventories_percent-"+ i).val(addCommasWithinDecimal(inventories_percent.toFixed(2).toString()));
                    $("#trade_receivables_percent-"+ i).val(addCommasWithinDecimal(trade_receivables_percent.toFixed(2).toString()));
                    $("#trade_payables_percent-"+ i).val(addCommasWithinDecimal(trade_payables_percent.toFixed(2).toString()));

                    //dsr
                    var depreciation_expenses   = parseFloat(recoverNumberFormat($("#depreciation_expenses-"+ i).val() ?? 0));
                    var finance_cost            = parseFloat(recoverNumberFormat($("#finance_cost-"+ i).val() ?? 0));
                    var annual_debts            = parseFloat(recoverNumberFormat($("#annual_debts-"+ i).val() ?? 0));

                    var dsr = ( depreciation_expenses + finance_cost + profit_bfr_tax) / annual_debts;

                    $("#dsr-"+ i).val(addCommasWithinDecimal(dsr.toFixed(2).toString()));

                    //gearing
                    var share_capital       = parseFloat(recoverNumberFormat($("#share_capital-"+ i).val() ?? 0));
                    var retained_earnings   = parseFloat(recoverNumberFormat($("#retained_earnings-"+ i).val() ?? 0));

                    var gearing = share_capital / (share_capital + retained_earnings);

                    $("#gearing-"+ i).val(addCommasWithinDecimal(gearing.toFixed(2).toString()));

                    //Highlight DSR
                    var dsr = $("#dsr-"+ i);
                    var dsr_val = parseFloat(dsr.val());

                    if (dsr_val >= 1.6){
                        dsr.attr('style', 'background-color: #6bcf7a !important')
                        dsr.parent().attr('style', 'background-color: #6bcf7a !important')

                        // dsr.addClass('bg-success')
                        // dsr.parent().addClass('bg-success')
                    }
                    else if(dsr_val < 1.6 && dsr_val >= 1){
                        dsr.attr('style', 'background-color: #fcda51 !important')
                        dsr.parent().attr('style', 'background-color: #fcda51 !important')

                        // dsr.addClass('bg-warning')
                        // dsr.parent().addClass('bg-warning')
                    }
                    else {
                        dsr.attr('style', 'background-color: #f26360 !important')
                        dsr.parent().attr('style', 'background-color: #f26360 !important')

                        // dsr.addClass('bg-danger')
                        // dsr.parent().addClass('bg-danger')
                    }

                    //Highlight Gearing
                    var gearing     = $("#gearing-"+ i);
                    var gearing_val = parseFloat(gearing.val());

                    if (gearing_val <= 4){
                        gearing.attr('style', 'background-color: #6bcf7a !important')
                        gearing.parent().attr('style', 'background-color: #6bcf7a !important')

                        // gearing.addClass('bg-success')
                        // gearing.parent().addClass('bg-success')
                    }
                    else if(gearing_val > 4 && gearing_val <= 5){
                        gearing.attr('style', 'background-color: #fcda51 !important')
                        gearing.parent().attr('style', 'background-color: #fcda51 !important')

                        // gearing.addClass('bg-warning')
                        // gearing.parent().addClass('bg-warning')
                    }
                    else {
                        gearing.attr('style', 'background-color: #f26360 !important')
                        gearing.parent().attr('style', 'background-color: #f26360 !important')

                        // gearing.addClass('bg-danger')
                        // gearing.parent().addClass('bg-danger')
                    }
                }

            });
        </script>
    @endpush
</x-user.app-layout>


