@extends('layouts.clean-app')
@section('content')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0;
            /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance: textfield;
            /* Firefox */
        }

        .show_increment_normal::-webkit-inner-spin-button,
        .show_increment_normal::-webkit-outer-spin-button {
            -webkit-appearance: inner-spin-button !important;
        }

        .show_increment_firefox {
            -moz-appearance: button !important;
            /* Firefox */
        }

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
            opacity: 80%;

            /*z-index: 2;*/

            /*position: absolute;*/
        }


        .percent_bg{
            background-color: #B3A369 !important;
            color: #FFFFFF !important;
            text-align: center;
            font-size: 10px;
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
            color: #A5A5A5;
        }

        .four_font_color{
            color: #002855 !important;
        }

        .fifth_font_color{
            color: #037699 !important;
        }

        .six_font_color{
            color: white !important;
        }

        .hidden-font-color{
            color: #4A5B65;
        }

        .hidden-bg-color{
            background-color: #f8f8f8;
        }

        .hidden-input-bg-color{
            background-color: #d7fafa;
        }

        .primary_bg_color{
            background-color: #05C3DD !important;
            color: white !important;
        }

        .secondary_bg_color{
            background-color: #037699 !important;
            color: white !important;
        }

        .third_bg_color{
            background-color: #002855 !important;
            color: white !important;
        }

        .four_bg_color{
            background-color: #21B9DB !important;
            color: white !important;
        }

        .fifth_bg_color{
            background-color: #012138 !important;
            color: white !important;
        }

        .six_bg_color{
            background-color: #DCEFFA !important;
        }

        .seven_bg_color{
            background-color: #B3A369 !important;
            color: white !important;
        }

        .eight_bg_color{
            background-color: #53ddf5 !important;
            color: white !important;
        }

        .nine_bg_color{
            background-color: #002855 !important;
            color: white !important;
        }

        .ten_bg_color{
            background-color: white !important;
        }

        .eleven_bg_color{
            background-color: #e0e3c3 !important;
        }

        .twelve_bg_color{
            background-color: #002855 !important;
            color: #B3A369 !important;
            font-weight: bold;
        }

        .blurry-text {
            /*background-color: black !important;*/
            text-shadow: 0 0 7px black !important;
            color: transparent !important;
        }

        #percent_formula_btn {
            display: none;
            position: fixed;
            bottom: 500px;
            right: 3px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #21B9DB;
            color: white;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .tab-pane-header {
            color: #2198c3;
            margin: 0.75em 0;
            border-left: 6px solid #2198c3;
            padding-left: 10px;
        }

        .card-header-custom{
            background-color: #21B9DB;
            color: white;
            border-radius: 5px;
            border: #21B9DB solid 1px;
            padding: 10px 15px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .default-input-field{
            border-radius: 30px;
            padding: 5px 10px;
            width: 90%;
            border: none;
        }

        .input-field-color{
            color: #002855 !important;
            font-weight: bold;
        }

        .border-normal{
            border-left: 2px solid #002855 !important;

        }

        .border-special{
            border-left: 4px solid #002855 !important;
        }

        .card-radius-left{
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .card-radius-right{
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .card-radius{
            border-radius: 5px;
        }

        .justify-content-center{
            text-align: center;
        }

        .left-menu-shadow{
            box-shadow: -5px 0 3px -20px #888888,
            5px 0 5px -3px #888888;

            font-size: 14px;
        }

        .btn-pill{
            border-radius: 30px;
        }

        .border-0{
            border: none;
        }

        .p-0{
            padding: 0;
        }

        .m-0{
            margin: 0;
        }

        .small{
            font-size: 10px;
        }

        .md-text{
            font-size: 11px;
        }

        .text-left{
            text-align: left;
        }

        .float-left{
            float: left;
        }

        .w-100{
            width: 100%;
        }.w-75{
            width: 75%;
        }.w-70{
            width: 70%;
        }.w-60{
            width: 60%;
        }.w-50{
            width: 50%;
        }.w-40{
            width: 40%;
        }.w-30{
            width: 30%;
        }.w-25{
            width: 25%;
        }

         .title{
             text-align: center;
             text-decoration: underline;
             font-weight: bold;
             font-size: 14px;
         }
    </style>

    {{--  declare input hidden  --}}
    <input class="default-input-field input-field-color number-input input_bg default_turnover_percent" id="default_turnover_percent" name="default_turnover_percent"
           onkeyup="defautPercentFunc(1)" type="hidden" value="{{ $basic_info->default_turnover_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_cogs_percent" id="default_cogs_percent" name="default_cogs_percent"
           onkeyup="defautPercentFunc(2)" type="hidden" value="{{ $basic_info->default_cogs_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_gross_profit_percent" id="default_gross_profit_percent" name="default_gross_profit_percent"
           onkeyup="defautPercentFunc(3)" type="hidden" value="{{ $basic_info->default_gross_profit_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_general_expenses_percent" id="default_general_expenses_percent" name="default_general_expenses_percent"
           onkeyup="defautPercentFunc(4)" type="hidden" value="{{ $basic_info->default_general_expenses_percent??0 }}">
    <input class="default-input-field input-field-color number-input hidden-input-bg-color default_finance_cost_percent" id="default_finance_cost_percent" name="default_finance_cost_percent"
           onkeyup="defautPercentFunc(5)" type="hidden" value="{{ $basic_info->default_finance_cost_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_inventories_percent" id="default_inventories_percent" name="default_inventories_percent"
           onkeyup="defautPercentFunc(6)" type="hidden" value="{{ $basic_info->default_inventories_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_trade_receivables_percent" id="default_trade_receivables_percent" name="default_trade_receivables_percent"
           onkeyup="defautPercentFunc(7)" type="hidden" value="{{ $basic_info->default_trade_receivables_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_trade_payables_percent" id="default_trade_payables_percent" name="default_trade_payables_percent"
           onkeyup="defautPercentFunc(8)" type="hidden" value="{{ $basic_info->default_trade_payables_percent }}">
    <input class="default-input-field input-field-color number-input input_bg default_eligibility_percent" id="default_eligibility_percent" name="default_eligibility_percent"
           onkeyup="defautPercentFunc(9)" type="hidden" value="{{ $basic_info->default_eligibility_percent }}">

    <div class="print-bg">


        <div class="print-header-logo">
            <img src="{{ asset('assets/images/financial-roadmap/nexus_letterhead.png') }}" width="50%" alt="" style="float: left">
            <br>

            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/financial-roadmap/financial_roadmap_logo.png'))) }}"
                 style="width:120px; height:auto;margin:0 auto; float: right" >
        </div>

        <br><br>

        <h5 class="title" style="margin-top: 60px">Nexus Financial Roadmap</h5>


        <div class="container" style="font-family: Roboto !important;">

            <div class="row">

                <div class="col-sm-12 col-xl-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-radius">

                                <div class="card-body">
                                    <div>
                                        <div class="row">
                                            <div class="mb-2">
                                                <table class="border-0">
                                                    <tr class="border-0 w-100">
                                                        <td class="border-0 w-25">
                                                            <label class="col-form-label pt-0 primary_font_color" for="">Company Name :</label>
                                                        </td>

                                                        <td class="border-0 w-75">
                                                            <div class="input-field-color">
                                                                {{ $basic_info->company_name }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-0 w-100">
                                                        <td class="border-0 w-25">
                                                            <label class="col-form-label pt-0 primary_font_color" for="">Business Industry :</label>
                                                        </td>

                                                        <td class="border-0 w-75" >
                                                            <div class="input-field-color">
                                                                {{ $industry_types->name }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-0 w-100">
                                                        <td class="border-0 w-25">
                                                            <label class="col-form-label pt-0 primary_font_color" for="">Contact Person :</label>
                                                        </td>

                                                        <td class="border-0 w-75">
                                                            <div class="input-field-color">
                                                                {{ $basic_info->contact_person }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-0 w-100">
                                                        <td class="border-0 w-25">
                                                            <label class="col-form-label pt-0 primary_font_color" for="">Contact Number :</label>
                                                        </td>

                                                        <td class="border-0 w-75">
                                                            <div class="input-field-color">
                                                                {{ $basic_info->contact_number }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-0 w-100">
                                                        <td class="border-0 w-25">
                                                            <label class="col-form-label pt-0 primary_font_color" for="">Email :</label>
                                                        </td>

                                                        <td class="border-0 w-75">
                                                            <div class="input-field-color">
                                                                {{ $basic_info->email }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <br>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-xl-12 mt-3">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table ml-0" >
                                                <tbody class="">
                                                <tr class="m-0 p-0">
                                                    <th class="primary_font_color text-left" rowspan="2">
                                                        <div class="md-text">STATEMENT OF COMPREHENSIVE INCOME</div>
                                                        <hr width="20%" class="float-left">
                                                        <br>
                                                        <div class="small">PROFIT & LOSS STATEMENT</div>
                                                    </th>
                                                    <th colspan="3" class="eight_bg_color card-radius-left m-0 p-0">HISTORICAL DATA</th>
                                                    <th colspan="3" class="nine_bg_color card-radius-right m-0 p-0">PROJECTION</th>
                                                </tr>

                                                <tr class="m-0 p-0">
                                                    @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                                        <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                            <div class="fifth_font_color small m-0 p-0">{{ $financial_year_arr_item }}</div>
                                                            <div class="fifth_font_color small m-0 p-0">(RM)</div>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                @foreach($roadmap_comprehensive_stt_arr['name'] as $roadmap_comprehensive_stt_arr_key => $roadmap_comprehensive_stt_arr_item)
                                                    <tr class="m-0 {{ $roadmap_comprehensive_stt_arr['hide_status'][$roadmap_comprehensive_stt_arr_key] == 1 ? 'd-none hide_item' : '' }}" style="width: 100%">
                                                        <td class="{{ $roadmap_comprehensive_stt_arr['label'][$roadmap_comprehensive_stt_arr_key] == 1 ? 'primary_bg_color fw-bold' : 'primary_font_color' }}
                                                            left-menu-shadow md-text"
                                                            style="width: 16%">
                                                            {{ $roadmap_comprehensive_stt_arr_item }}

                                                            @if($roadmap_comprehensive_stt_arr['trigger_hide_status'][$roadmap_comprehensive_stt_arr_key] == 1)
                                                                <i class="fa fa-sort-desc trigger_hide_desc" aria-hidden="true" onclick="showHideItem()" ></i>
                                                                <i class="fa fa-sort-asc trigger_hide_asc d-none" aria-hidden="true" onclick="showHideItem()"></i>
                                                            @endif

                                                        </td>

                                                        @if($roadmap_comprehensive_stt_arr['label'][$roadmap_comprehensive_stt_arr_key] == 1)
                                                            @for($i = 0; $i < 6; $i++)
                                                                <td class="{{ $i >= 3 ? 'six_bg_color' : 'input_bg' }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}
                                                                    p-0 m-0" style="width: 14%">

                                                                </td>
                                                            @endfor
                                                        @else
                                                            @for($i = 0; $i < 6; $i++)
                                                                <td class="{{ $i >= 3 ? 'six_bg_color' : 'input_bg' }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">

                                                                    <table class="border-0 m-0 p-0">
                                                                        <tr class="w-100 border-0 m-0 p-0">
                                                                            <td class="w-60 border-0 m-0 p-0">
                                                                                <span class="number-input border-0 w-100 m-0 ps-2 {{ $i >= 3 ? 'six_bg_color' : 'input_bg' }} fifth_font_color fw-bold small">
                                                                                    {{ number_format($roadmap_comprehensive_stt_arr['data'][$roadmap_comprehensive_stt_arr_key][$i], 0, '.', ',') }}
                                                                                </span>
                                                                            </td>

                                                                            <td class="w-40 border-0 m-0 p-0">
                                                                                @if($roadmap_comprehensive_stt_arr['percent_status'][$roadmap_comprehensive_stt_arr_key] == 1 || ($i >= 3 && $roadmap_comprehensive_stt_arr_item == 'Turnover') )
                                                                                    <div class="percent_bg pe-1 me-1 border-0 small w-100 p-0 m-0">
                                                                                        {{ number_format($roadmap_comprehensive_stt_arr['percent_data'][$roadmap_comprehensive_stt_arr_key][$i], 0, '.', ',') }} %
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            @endfor
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class=" mb-3 mt-3">
                        <div class="pt-3 ps-3" style="background-color: white !important;">
                            <div class="tab-pane-header text-start ">
                                <h6 class="">Chart Review</h6>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="p-2 mb-4" style="height: 400px;">
                                    <div class="" id="roadmap_business_trend">
                                        <img src="{{ $chart }}" alt="" style="height: 300px; width: 50%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table form-table-two ml-0">

                                                <tbody class="">
                                                <tr>
                                                    <td class="fifth_font_color fw-bold left-menu-shadow" rowspan="2">
                                                        <div class="md-text fifth_font_color fw-bold">STATEMENT OF FINANCIAL POSITION</div>
                                                        <hr width="20%" class="float-left fifth_font_color">
                                                        <br>
                                                        <div class="small fifth_font_color fw-bold">BALANCE SHEET STATEMENT</div>
                                                    </td>
                                                    <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                                    <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                                </tr>

                                                <tr>
                                                    @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                                        <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                            <div class="fifth_font_color fw-bold small">{{ $financial_year_arr_item }}</div>
                                                            <p class="fifth_font_color fw-bold small">(RM)</p>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                @foreach($roadmap_financial_position_stt_arr['name'] as $roadmap_financial_position_stt_arr_key => $roadmap_financial_position_stt_arr_item)
                                                    <tr class="m-0 {{ $roadmap_financial_position_stt_arr['border_top'][$roadmap_financial_position_stt_arr_key] == 1 ? 'border-2 border-dark border-bottom-0 border-start-0 border-end-0' : '' }}" style="width: 100%">
                                                        <td class="fifth_font_color left-menu-shadow md-text fw-bold {{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'fw-bold secondary_bg_color' : '' }}"
                                                            style="width: 16%">
                                                            <span class="{{ $roadmap_financial_position_stt_arr['border_top'][$roadmap_financial_position_stt_arr_key] == 1 ? 'fw-bold' : '' }}" >
                                                                {{ $roadmap_financial_position_stt_arr_item }}
                                                            </span>
                                                        </td>

                                                        @for($i = 0; $i < 6; $i++)
                                                            <td class="{{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                            {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">

                                                                <table class="border-0">
                                                                    <tr class="border-0" >
                                                                        <td class="w-60 border-0 m-0 p-0">
                                                                            <span class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                                {{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}">
                                                                                {{ number_format($roadmap_financial_position_stt_arr['data'][$roadmap_financial_position_stt_arr_key][$i], 0, '.', ',') }}
                                                                            </span>
                                                                        </td>

                                                                        <td class="w-40 border-0 m-0 p-0">
                                                                            @if($roadmap_financial_position_stt_arr['percent_status'][$roadmap_financial_position_stt_arr_key] == 1)
                                                                                <div class="percent_bg pe-1 me-1 border-0 small w-100 p-0 m-0">
                                                                                    {{ number_format($roadmap_comprehensive_stt_arr['percent_data'][$roadmap_comprehensive_stt_arr_key][$i], 0, '.', ',') }} %
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
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
                    </div>

                    <br>

                    <div class="col-sm-12">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table form-table-two ml-0">

                                                <tbody class="">
                                                <tr>
                                                    <td class="left-menu-shadow four_font_color fw-bold" style="vertical-align: text-top" rowspan="2">
                                                        <div class="md-text fw-bold">STATEMENT OF CASH FLOW</div>
                                                    </td>
                                                    <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                                    <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                                </tr>

                                                <tr>
                                                    @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                                        <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                            <div class="fifth_font_color fw-bold small">{{ $financial_year_arr_item }}</div>
                                                            <div class="fifth_font_color fw-bold small">(RM)</div>
                                                        </th>
                                                    @endforeach
                                                </tr>

                                                @foreach($roadmap_cash_flow_arr['name'] as $roadmap_cash_flow_arr_key => $roadmap_cash_flow_arr_item)
                                                    <tr style="width: 100%">
                                                        <td style="width: 16%" class="four_font_color md-text fw-bold left-menu-shadow">{{ $roadmap_cash_flow_arr_item }}</td>

                                                        @for($i = 0; $i < 6; $i++)
                                                            @if($i > 2)
                                                                <td class=" {{ ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                                    <span class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small">
                                                                        -
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td class=" {{ ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                                    <span class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small">
                                                                        {{ number_format($roadmap_cash_flow_arr['data'][$roadmap_cash_flow_arr_key][$i], 0, '.', ',') }}
                                                                    </span>
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
                    </div>

                    <br>

                    <div class="col-sm-12 mb-5">
                        <div class="card card-radius">
                            <div class="card-body p-0">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table form-table-two ml-0">
                                                <tbody class="">
                                                <tr>
                                                    <td class="fifth_bg_color left-menu-shadow" rowspan="2">
                                                        <div class="md-text fw-bold">FINANCIAL POSITION</div>
                                                    </td>
                                                    <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                                    <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                                </tr>

                                                <tr>
                                                    @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                                        <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                            <div class="fifth_font_color fw-bold small">{{ $financial_year_arr_item }}</div>
                                                            <div class="fifth_font_color fw-bold small">(RM)</div>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                @foreach($roadmap_financial_position_arr['name'] as $roadmap_financial_position_arr_key => $roadmap_financial_position_arr_item)
                                                    <tr class="m-0 {{ $roadmap_financial_position_arr['top_line'][$roadmap_financial_position_arr_key] == 1 ? 'border-bottom-0 border-end-0 border-start-0 border-dark border-2' : '' }}" style="width: 100%">
                                                        <td class="fifth_bg_color md-text {{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'fw-bold ' : '' }} left-menu-shadow" style="width: 16%">
                                                            {{ $roadmap_financial_position_arr_item }}
                                                        </td>

                                                        @for($i = 0; $i < 6; $i++)

                                                            @if($roadmap_financial_position_arr['col_block'][$roadmap_financial_position_arr_key] == 1 && ( $i == 0 || $i == 1 ))
                                                                <td class="{{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                                    <span class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                        {{ $roadmap_financial_position_arr['summary'][$roadmap_financial_position_arr_key] == 1 ? 'six_font_color' : 'fifth_font_color' }}">
                                                                        -
                                                                    </span>
                                                                </td>
                                                            @else
                                                                <td class="{{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' :
                                                                ( $roadmap_financial_position_arr['summary'][$roadmap_financial_position_arr_key] == 1 ? 'eleven_bg_color' :($i >= 3 ? 'six_bg_color' : 'input_bg') )  }}
                                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                                    <span class="number-input border-0 w-100 m-0 ps-2 fw-bold small
                                                                        {{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'six_font_color' : 'fifth_font_color' }}">
                                                                        {{ $roadmap_financial_position_arr['data'][$roadmap_financial_position_arr_key][$i] }}
                                                                    </span>
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

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(".hide_item").hide();

    </script>
@endpush
