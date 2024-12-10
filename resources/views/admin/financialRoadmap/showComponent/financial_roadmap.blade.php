<style>
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

    .left-menu-shadow{
        box-shadow: -5px 0 3px -20px #888888,
        5px 0 5px -3px #888888;

        font-size: 14px;
    }

    /*.updateModal{*/
    /*    display: none;*/
    /*}*/
</style>

{{-- Trigger Modal --}}
<button type="button" class="" id="percent_formula_btn" onclick="showModal()"><i class="fa fa-align-justify" aria-hidden="true"></i></button>

{{-- Modal --}}
<div id="updateModal" class="modal">

    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-inside-title">Projection Calculator</h4>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center">

                <div>
                    <div class="row">
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">Turnover expect to increase :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_turnover_percent" id="default_turnover_percent" name=""
                                       onkeyup="defautPercentFunc(1)" type="text" value="{{ $basic_info->default_turnover_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">COGS :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_cogs_percent" id="default_cogs_percent" name=""
                                       onkeyup="defautPercentFunc(2)" type="text" value="{{ $basic_info->default_cogs_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">Gross Profit Margin :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_gross_profit_percent" id="default_gross_profit_percent" name=""
                                       onkeyup="defautPercentFunc(3)" type="text" value="{{ $basic_info->default_gross_profit_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">General / Administration Expenses :</label>
                            <i class="fa fa-sort-desc trigger_hide_desc" aria-hidden="true" onclick="showHideItem()" ></i>
                            <i class="fa fa-sort-asc trigger_hide_asc d-none" aria-hidden="true" onclick="showHideItem()"></i>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_general_expenses_percent" id="default_general_expenses_percent" name=""
                                       onkeyup="defautPercentFunc(4)" type="text" value="{{ $basic_info->default_general_expenses_percent??0 }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom hidden-bg-color d-none hide_item">
                            <label class="col-form-label pt-0 hidden-font-color" for="">Finance Cost :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom hidden-bg-color d-none hide_item">
                            <div class="btn-pill hidden-input-bg-color input-field-color">
                                <input class="default-input-field input-field-color number-input hidden-input-bg-color default_finance_cost_percent" id="default_finance_cost_percent" name=""
                                       onkeyup="defautPercentFunc(5)" type="text" value="{{ $basic_info->default_finance_cost_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">Inventories (from COGS) :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_inventories_percent" id="default_inventories_percent" name=""
                                       onkeyup="defautPercentFunc(6)" type="text" value="{{ $basic_info->default_inventories_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">Trade Receivables (from Sales) :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_trade_receivables_percent" id="default_trade_receivables_percent" name=""
                                       onkeyup="defautPercentFunc(7)" type="text" value="{{ $basic_info->default_trade_receivables_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <label class="col-form-label pt-0 primary_font_color" for="">Trade Payables (from COGS) :</label>
                        </div>
                        <div class="mb-1 pb-1 col-xl-6 border-bottom">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_trade_payables_percent" id="default_trade_payables_percent" name=""
                                       onkeyup="defautPercentFunc(8)" type="text" value="{{ $basic_info->default_trade_payables_percent }}"> %
                            </div>
                        </div>

                        <div class="mb-1 col-xl-6">
                            <label class="col-form-label pt-0 primary_font_color" for="">Working Capital Eligibility :</label>
                        </div>
                        <div class="mb-1 col-xl-6">
                            <div class="btn-pill input_bg input-field-color">
                                <input class="default-input-field input-field-color number-input input_bg default_eligibility_percent" id="default_eligibility_percent" name=""
                                       onkeyup="defautPercentFunc(9)" type="text" value="{{ $basic_info->default_eligibility_percent }}"> %
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="button-container mt-3 d-flex justify-content-center">
                <button type="button" class="cancel btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('admin.financial_roadmap.update', $financialRoadmap) }}" method="post" id="mainForm">
    @method('PUT')
    @csrf
    <input type="hidden" id="chartImg" name="chartImg">
    <input type="hidden" id="chartImg_status" name="chartImg_status" value="0">

    <div class="row">
        <div class="col-9">
            <h4 class="primary_font_color"><b>Financial Roadmap</b></h4>
            <p class="third_font_color">Basic Information</p>
        </div>
        <div class="col-3 float-end">
                <input type="hidden" id="chart_uri">

                <a onclick="storeChartImgFunc()" href="javascript:void(0);" class="btn btn-secondary btn-sm float-end">
                    <i class="fa fa-download"></i>
                    Download as PDF
                </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-xl-3">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-radius">
                        <div class="card-header-custom">
                            Company Information
                        </div>

                        <div class="card-body">
                            <div>
                                <div class="row">
                                    <div class="mb-2">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Company Name</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="company_name" name="company_name" type="text" value="{{ $basic_info->company_name }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Business Industry</label>
                                        <select class="select2" name="business_industry" id="business_industry" disabled>
                                            @foreach($industry_types as $id => $industry_type)
                                                <option value="{{ $id }}"{{ (old('business_industry') === $id) ? 'selected' : '' }} {{ $basic_info->business_industry == $id ? 'selected' : '' }}>
                                                    {{ $industry_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Person</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_person" name="contact_person" type="text" value="{{ $basic_info->contact_person }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Number</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_number" name="contact_number" type="text" value="{{ $basic_info->contact_number }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Email</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="email" name="email" type="text" value="{{ $basic_info->email }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xl-9">
            <div class="row">
                <div class="col-12">
                    <div class="card card-radius">
                        <div class="card-header-custom">
                            Projection Calculator
                        </div>

                        <div class="card-body" id="trigger_div">
                            <div>
                                <div class="row">
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Turnover expect to increase :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_turnover_percent" id="default_turnover_percent" name="default_turnover_percent"
                                                   onkeyup="defautPercentFunc(1)" type="text" value="{{ $basic_info->default_turnover_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">COGS :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_cogs_percent" id="default_cogs_percent" name="default_cogs_percent"
                                                   onkeyup="defautPercentFunc(2)" type="text" value="{{ $basic_info->default_cogs_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Gross Profit Margin :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_gross_profit_percent" id="default_gross_profit_percent" name="default_gross_profit_percent"
                                                   onkeyup="defautPercentFunc(3)" type="text" value="{{ $basic_info->default_gross_profit_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">General / Administration Expenses :</label>
                                        <i class="fa fa-sort-desc trigger_hide_desc" aria-hidden="true" onclick="showHideItem()" ></i>
                                        <i class="fa fa-sort-asc trigger_hide_asc d-none" aria-hidden="true" onclick="showHideItem()"></i>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_general_expenses_percent" id="default_general_expenses_percent" name="default_general_expenses_percent"
                                                   onkeyup="defautPercentFunc(4)" type="text" value="{{ $basic_info->default_general_expenses_percent??0 }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom hidden-bg-color d-none hide_item">
                                        <label class="col-form-label pt-0 hidden-font-color" for="">Finance Cost :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom hidden-bg-color d-none hide_item">
                                        <div class="btn-pill hidden-input-bg-color input-field-color">
                                            <input class="default-input-field input-field-color number-input hidden-input-bg-color default_finance_cost_percent" id="default_finance_cost_percent" name="default_finance_cost_percent"
                                                   onkeyup="defautPercentFunc(5)" type="text" value="{{ $basic_info->default_finance_cost_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Inventories (from COGS) :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_inventories_percent" id="default_inventories_percent" name="default_inventories_percent"
                                                   onkeyup="defautPercentFunc(6)" type="text" value="{{ $basic_info->default_inventories_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Trade Receivables (from Sales) :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_trade_receivables_percent" id="default_trade_receivables_percent" name="default_trade_receivables_percent"
                                                   onkeyup="defautPercentFunc(7)" type="text" value="{{ $basic_info->default_trade_receivables_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Trade Payables (from COGS) :</label>
                                    </div>
                                    <div class="mb-1 pb-1 col-xl-6 border-bottom">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_trade_payables_percent" id="default_trade_payables_percent" name="default_trade_payables_percent"
                                                   onkeyup="defautPercentFunc(8)" type="text" value="{{ $basic_info->default_trade_payables_percent }}"> %
                                        </div>
                                    </div>

                                    <div class="mb-1 col-xl-6">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Working Capital Eligibility :</label>
                                    </div>
                                    <div class="mb-1 col-xl-6">
                                        <div class="btn-pill input_bg input-field-color">
                                            <input class="default-input-field input-field-color number-input input_bg default_eligibility_percent" id="default_eligibility_percent" name="default_eligibility_percent"
                                                   onkeyup="defautPercentFunc(9)" type="text" value="{{ $basic_info->default_eligibility_percent }}"> %
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

<div class="col-sm-12 col-xl-12 mt-3">

    <div class="row">
        <div class="col-sm-12">
            <div class="card card-radius">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table form-table-two ml-0" >
                                    <thead>
                                    <tr>
                                        <td class="primary_font_color fw-bold left-menu-shadow" rowspan="2">
                                            <h6>STATEMENT OF COMPREHENSIVE INCOME</h6>
                                            <hr width="20%" style="height: 2px">
                                            <small>PROFIT & LOSS STATEMENT</small>
                                        </td>
                                        <th colspan="3" class="eight_bg_color text-center card-radius-left">HISTORICAL DATA</th>
                                        <th colspan="3" class="nine_bg_color text-center card-radius-right">PROJECTION</th>
                                    </tr>

                                    <tr>
                                        @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                            <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                <h6 class="fifth_font_color fw-bold">{{ $financial_year_arr_item }}</h6>
                                                <p class="fifth_font_color fw-bold">(RM)</p>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody class="">
                                    @foreach($roadmap_comprehensive_stt_arr['name'] as $roadmap_comprehensive_stt_arr_key => $roadmap_comprehensive_stt_arr_item)
                                        <tr class="m-0 {{ $roadmap_comprehensive_stt_arr['hide_status'][$roadmap_comprehensive_stt_arr_key] == 1 ? 'd-none hide_item' : '' }}" style="width: 100%">
                                            <td class="{{ $roadmap_comprehensive_stt_arr['label'][$roadmap_comprehensive_stt_arr_key] == 1 ? 'primary_bg_color fw-bold' : 'primary_font_color' }}
                                                left-menu-shadow"
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
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">

                                                    </td>
                                                @endfor
                                            @else
                                                @for($i = 0; $i < 6; $i++)
                                                    <td class="{{ $i >= 3 ? 'six_bg_color' : 'input_bg' }}
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">

                                                        <div class="row">
                                                            <div class="col-7 p-0 m-0">
                                                                <input type="text"
                                                                       onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '. "'".$roadmap_comprehensive_stt_arr['id'][$roadmap_comprehensive_stt_arr_key]."'" .')' }}"
                                                                       class="number-input border-0 w-100 m-0 ps-2 {{ $i >= 3 ? 'six_bg_color' : 'input_bg' }} fifth_font_color fw-bold small
                                                                        {{ $roadmap_comprehensive_stt_arr['id'][$roadmap_comprehensive_stt_arr_key].'_class' }}"
                                                                       name="{{ $roadmap_comprehensive_stt_arr['id'][$roadmap_comprehensive_stt_arr_key] }}[{{ $i }}]" id="{{ $roadmap_comprehensive_stt_arr['id'][$roadmap_comprehensive_stt_arr_key].'-'.$i }}"
                                                                       value="{{ number_format($roadmap_comprehensive_stt_arr['data'][$roadmap_comprehensive_stt_arr_key][$i], 0, '.', ',') }}">
                                                            </div>

                                                            <div class="col-5 p-0 m-0">
                                                                @if($roadmap_comprehensive_stt_arr['percent_status'][$roadmap_comprehensive_stt_arr_key] == 1 || ($i >= 3 && $roadmap_comprehensive_stt_arr_item == 'Turnover') )
                                                                    <div class="percent_bg pe-1 me-1">
                                                                        <input type="text" onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '. "'".$roadmap_comprehensive_stt_arr['id'][$roadmap_comprehensive_stt_arr_key]."'" .')' }}"
                                                                               class=" border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $roadmap_comprehensive_stt_arr['percent_status_id'][$roadmap_comprehensive_stt_arr_key] }}{{'['.$i.']'}}"
                                                                               id="{{ $roadmap_comprehensive_stt_arr['percent_status_id'][$roadmap_comprehensive_stt_arr_key].'-'.$i }}" value="" > %
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
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

        <div class=" mb-3 mt-3">
            <div class="pt-3 ps-3" style="background-color: white !important;">
                <div class="tab-pane-header text-start ">
                    <h6 class="">Chart Review</h6>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="p-2 mb-4" style="height: 400px; width: 70%">
                        <div class="" id="roadmap_business_trend"></div>
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
                                    <thead>
                                    <tr>
                                        <td class="fifth_font_color fw-bold left-menu-shadow" rowspan="2">
                                            <h6>STATEMENT OF FINANCIAL POSITION</h6>
                                            <hr width="20%" style="height: 2px">
                                            <small>BALANCE SHEET STATEMENT</small>
                                        </td>
                                        <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                        <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                    </tr>

                                    <tr>
                                        @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                            <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                <h6 class="fifth_font_color fw-bold">{{ $financial_year_arr_item }}</h6>
                                                <p class="fifth_font_color fw-bold">(RM)</p>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody class="">
                                    @foreach($roadmap_financial_position_stt_arr['name'] as $roadmap_financial_position_stt_arr_key => $roadmap_financial_position_stt_arr_item)
                                        <tr class="m-0 {{ $roadmap_financial_position_stt_arr['border_top'][$roadmap_financial_position_stt_arr_key] == 1 ? 'border-2 border-dark border-bottom-0 border-start-0 border-end-0' : '' }}" style="width: 100%">
                                            <td class="fifth_font_color left-menu-shadow {{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'fw-bold secondary_bg_color' : '' }}"
                                                style="width: 16%">
                                                <span class="{{ $roadmap_financial_position_stt_arr['border_top'][$roadmap_financial_position_stt_arr_key] == 1 ? 'fw-bold' : '' }}" >
                                                    {{ $roadmap_financial_position_stt_arr_item }}
                                                </span>
                                            </td>

                                            @for($i = 0; $i < 6; $i++)
                                                <td class="{{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">

                                                <div class="row">
                                                    <div class="col-7 p-0 m-0">
                                                        <input type="text"
                                                               onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '."'". $roadmap_financial_position_stt_arr['id'][$roadmap_financial_position_stt_arr_key]."'" .')' }}"
                                                               class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                {{ $roadmap_financial_position_stt_arr['highlightable'][$roadmap_financial_position_stt_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}"
                                                               name="{{ $roadmap_financial_position_stt_arr['id'][$roadmap_financial_position_stt_arr_key] }}[{{ $i }}]" id="{{ $roadmap_financial_position_stt_arr['id'][$roadmap_financial_position_stt_arr_key].'-'.$i }}"
                                                               value="{{ number_format($roadmap_financial_position_stt_arr['data'][$roadmap_financial_position_stt_arr_key][$i], 0, '.', ',') }}" >
                                                    </div>

                                                    <div class="col-5 p-0 m-0">
                                                        @if($roadmap_financial_position_stt_arr['percent_status'][$roadmap_financial_position_stt_arr_key] == 1)
                                                            <div class="percent_bg pe-1 me-1">
                                                                <input type="text"
                                                                       onkeyup="{{ $i < 3  ? 'percentFunc(2)' : 'projectionPercentFunc(2, '."'". $roadmap_financial_position_stt_arr['id'][$roadmap_financial_position_stt_arr_key]."'" .')' }}"
                                                                       class="border-0 percent_bg number-decimal-input w-75 ms-0 p-0" name="{{ $roadmap_financial_position_stt_arr['percent_status_id'][$roadmap_financial_position_stt_arr_key] }}{{'['.$i.']'}}"
                                                                       id="{{ $roadmap_financial_position_stt_arr['percent_status_id'][$roadmap_financial_position_stt_arr_key].'-'.$i }}" value="" > %
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
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

        <div class="col-sm-12">
            <div class="card card-radius">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table form-table-two ml-0">
                                    <thead>
                                    <tr>
                                        <td class="left-menu-shadow four_font_color fw-bold" style="vertical-align: text-top" rowspan="2">
                                            <h6>STATEMENT OF CASH FLOW</h6>
                                        </td>
                                        <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                        <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                    </tr>

                                    <tr>
                                        @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                            <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                <h6 class="fifth_font_color fw-bold">{{ $financial_year_arr_item }}</h6>
                                                <p class="fifth_font_color fw-bold">(RM)</p>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody class="">

                                    @foreach($roadmap_cash_flow_arr['name'] as $roadmap_cash_flow_arr_key => $roadmap_cash_flow_arr_item)
                                        <tr style="width: 100%">
                                            <td style="width: 16%" class="four_font_color fw-bold left-menu-shadow">{{ $roadmap_cash_flow_arr_item }}</td>

                                            @for($i = 0; $i < 6; $i++)

                                                @if($i > 2)
                                                    <td class=" {{ ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                        <input type="text"
                                                               onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '."'". $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key]."'" .')' }}"
                                                               class="number-input border-0 {{ $i >= 3 ? 'six_bg_color' : 'input_bg' }} {{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key].'_class' }}
                                                                   w-100 m-0 ps-2 fifth_font_color fw-bold small"
                                                               value="-" readonly
                                                               name="{{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key] }}[{{ $i }}]" id="{{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key].'-'.$i }}">
                                                    </td>
                                                @else
                                                    <td class=" {{ ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                        <input type="text"
                                                               onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '."'". $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key]."'" .')' }}"
                                                               class="number-input border-0 {{ $i >= 3 ? 'six_bg_color' : 'input_bg' }} {{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key].'_class' }}
                                                                   w-100 m-0 ps-2 fifth_font_color fw-bold small"
                                                               value="{{ number_format($roadmap_cash_flow_arr['data'][$roadmap_cash_flow_arr_key][$i], 0, '.', ',') }}"
                                                               name="{{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key] }}[{{ $i }}]" id="{{ $roadmap_cash_flow_arr['id'][$roadmap_cash_flow_arr_key].'-'.$i }}">
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

        <div class="col-sm-12 mb-5">
            <div class="card card-radius">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table form-table-two ml-0">
                                    <thead>
                                    <tr>
                                        <td class="fifth_bg_color left-menu-shadow" rowspan="2">
                                            <h6>FINANCIAL POSITION</h6>
                                        </td>
                                        <th colspan="3" class="eight_bg_color text-center">HISTORICAL DATA</th>
                                        <th colspan="3" class="nine_bg_color text-center">PROJECTION</th>
                                    </tr>

                                    <tr>
                                        @foreach($financial_year_arr as $financial_year_arr_key => $financial_year_arr_item)
                                            <th class="fifth_font_color {{ $financial_year_arr_key == 3 ? 'border-special' : ($financial_year_arr_key == 0 ? '' : 'border-normal' ) }}">
                                                <h6 class="fifth_font_color fw-bold">{{ $financial_year_arr_item }}</h6>
                                                <p class="fifth_font_color fw-bold">(RM)</p>
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody class="">
                                    @foreach($roadmap_financial_position_arr['name'] as $roadmap_financial_position_arr_key => $roadmap_financial_position_arr_item)
                                        <tr class="m-0 {{ $roadmap_financial_position_arr['top_line'][$roadmap_financial_position_arr_key] == 1 ? 'border-bottom-0 border-end-0 border-start-0 border-dark border-2' : '' }}" style="width: 100%">
                                            <td class="fifth_bg_color {{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'fw-bold ' : '' }} left-menu-shadow" style="width: 16%">
                                                {{ $roadmap_financial_position_arr_item }}
                                            </td>

                                            @for($i = 0; $i < 6; $i++)

                                                @if($roadmap_financial_position_arr['col_block'][$roadmap_financial_position_arr_key] == 1 && ( $i == 0 || $i == 1 ))
                                                    <td class="{{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg') }}
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                        <input type="text"
                                                               onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '."'".$roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key]."'".')' }}"
                                                               class=" border-0 {{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' : ($i >= 3 ? 'six_bg_color' : 'input_bg')  }}
                                                                   w-100 m-0 ps-2 fifth_font_color fw-bold small"
                                                               name="{{ $roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key] }}[{{ $i }}]"
                                                               id="{{ $roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key].'-'.$i }}"
                                                               value="-" readonly>
                                                    </td>
                                                @else
                                                    <td class="{{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' : ( $roadmap_financial_position_arr['summary'][$roadmap_financial_position_arr_key] == 1 ? 'eleven_bg_color' :($i >= 3 ? 'six_bg_color' : 'input_bg') )  }}
                                                    {{ $i == 3 ? 'border-special' : ($i == 0 ? '' : 'border-normal' ) }}" style="width: 14%">
                                                        <input type="text"
                                                               onkeyup="{{ $i < 3  ? 'percentFunc(1)' : 'projectionPercentFunc(1, '."'".$roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key]."'".')' }}"
                                                               class="number-input border-0 w-100 m-0 ps-2 fifth_font_color fw-bold small
                                                                {{ $roadmap_financial_position_arr['highlightable'][$roadmap_financial_position_arr_key] == 1 ? 'seven_bg_color' : ( $roadmap_financial_position_arr['summary'][$roadmap_financial_position_arr_key] == 1 ? 'eleven_bg_color' :($i >= 3 ? 'six_bg_color' : 'input_bg') ) }}"
                                                               name="{{ $roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key] }}[{{ $i }}]"
                                                               id="{{ $roadmap_financial_position_arr['id'][$roadmap_financial_position_arr_key].'-'.$i }}"
                                                               value="{{ $roadmap_financial_position_arr['data'][$roadmap_financial_position_arr_key][$i] }}">
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


            <div class="d-flex justify-content-center d-none hide_item my-3" style="background-color: white">
                <div class="form-group table-responsive mt-4 mb-3">
                    <h5 class="tab-pane-header">New Financing Instruments</h5>

                    <table class="table table-bordered form-table-two card-radius">
                        <tbody class="edit-tbody">
                        <tr>
                            <th class="primary_bg_color" >{{ trans('cruds.financingInstrument.fields.loan_product') }}</th>
                            <th class="primary_bg_color" >{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</th>
                            <th class="primary_bg_color" >{{ trans('cruds.financingInstrument.fields.interest_rate') }}</th>
                            <th class="primary_bg_color" >{{ trans('cruds.financingInstrument.fields.tenor') }}</th>
                            <th class="primary_bg_color" >{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
                            <th class="primary_bg_color" >{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
                        </tr>

                        @foreach($roadmap_financingInstruments as $financingInstrument_value => $financingInstrument_item)
                            <tr>
                                <input type="hidden" name="financingInstrument_id[]" id="financingInstrument_id_loan-{{ $financingInstrument_value }}" value="{{ $financingInstrument_item->id }}">
                                <th class="primary_font_color" >{{ checkNULL($financingInstrument_item->loan_product) }}</th>
                                <td>
                                    <input type="text" class="text-input-class border-0 financingInstrument_proposed_limit_loan primary_font_color"
                                           name="financingInstrument_proposed_limit[]" id="financingInstrument_proposed_limit_loan-{{ $financingInstrument_value }}"
                                           onkeyup="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor }}, 0, {{ $financingInstrument_item->tenor_type }})"
                                           value="{{ $financingInstrument_item->proposed_limit }}">
                                </td>
                                <td>
                                    <input type="number" class="text-input-class border-0 show_increment_firefox show_increment_normal primary_font_color" name="financingInstrument_interest_rate[]"
                                           id="financingInstrument_interest_rate_loan-{{ $financingInstrument_value }}"
                                           onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor }}, 0, {{ $financingInstrument_item->tenor_type }})"
                                           value="{{ number_format($financingInstrument_item->interest_rate, '3') }}" step="0.001"></td>
                                <td>
                                    @if($financingInstrument_item->tenor_type == 0)
                                        <input type="text" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor }}, 0, {{ $financingInstrument_item->tenor_type }})" readonly
                                               class="text-input-class border-0 primary_font_color" value="{{ $financingInstrument_item->tenor_name }}">
                                    @elseif($financingInstrument_item->tenor_type == 1)
                                        <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor }}, 0, {{ $financingInstrument_item->tenor_type }})"
                                               class="text-input-class w-25 show_increment_firefox show_increment_normal border-0 primary_font_color" value="{{ number_format($financingInstrument_item->tenor,0, ',', '.') }}">
                                        <span class="primary_font_color">years</span>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" name="financingInstrument_commitments[]" id="financingInstrument_commitment_loan-{{ $financingInstrument_value }}"
                                           class="financingInstrument_commitment_loan text-input-class border-0 primary_font_color" value="{{ $financingInstrument_item->commitments }}" readonly>
                                </td>
                                <td>
                                    <input type="text" name="new_financingInstrument_commitments[]" id="new_financingInstrument_commitment_loan-{{ $financingInstrument_value }}"
                                           class="new_financingInstrument_commitment_loan text-input-class border-0 primary_font_color" value="{{ $financingInstrument_item->new_commitments }}" readonly></td>
                            </tr>
                        @endforeach

                        <tr>
                            <th class="twelve_bg_color">Total:</th>
                            <td class="twelve_bg_color"><input type="text" name="financingInstrument_total_propose_loan" id="financingInstrument_total_propose_loan" class="border-0 twelve_bg_color" readonly></td>
                            <td class="twelve_bg_color" colspan="2"></td>
                            <td class="twelve_bg_color"><input type="text" name="financingInstrument_total_commitments_loan" id="financingInstrument_total_commitment_loan" class="border-0 twelve_bg_color" readonly></td>
                            <td class="twelve_bg_color"><input type="text" name="new_financingInstrument_total_commitments_loan" id="new_financingInstrument_total_commitment_loan" class="border-0 twelve_bg_color" readonly></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-sm btn-light me-3" onclick="showHideItem()"><i class="fa fa-eye" aria-hidden="true"></i></button>
                <button type="submit" class="btn btn-primary float-end">Save</button>
            </div>

        </div>

    </div>
</div>
</form>

@push('scripts')
    <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var chart;
        var chart_render;

        function formulaFunction(x, y, c, type){
            /** formula:
             * 1: y = ((x / c) - 1) * 100
             * 2: y = 100x / c
             * 3: y = x / c
             * 4: x = ((y / 100) + 1) * c
             * 5: x = yc / 100
             * 6: x = yc
             * 7: z = y - c
             * 8: z = x - y - c
             * 9: z = ( 600000 * 17%) + ( (x-600000) * 24%)
             * **/

            switch (type){
                case 1:
                    y = ((x / c) - 1) * 100

                    return y;
                case 2:
                    y = y = 100 * x / c

                    return y;
                case 3:
                    y = x / c;

                    return y;
                case 4:
                    x = ((y / 100) + 1) * c

                    return x;
                case 5:
                    x = y * c / 100

                    return x;
                case 6:
                    x = y * c;

                    return x;

                case 7:
                    var z = y - c;

                    return z;

                case 8:
                    var z = x - y - c;

                    return z;

                case 9:
                    var z = ( 600000 * 17 / 100) + ( (x-600000) * 24 / 100);

                    return z;

                case 10:
                    var z = y + c;

                    return z;
            }
        }

        function roadmapChartFunc(){
            //make the data
            var turnover_arr        = [];
            var cogs_arr            = [];
            var gross_profit_arr    = [];

            $(".rm_turnover_class").each(function (key, item){
                turnover_arr.push( parseFloat(recoverNumberFormat($(this).val())) );
                cogs_arr.push( parseFloat(recoverNumberFormat($(".rm_cogs_class")[key].value)) );
                gross_profit_arr.push( parseFloat(recoverNumberFormat($(".rm_gross_profit_class")[key].value)) );
            });

            //roadmap chart
            var options = {
                legend: {
                    labels: {
                        colors: '#202020',
                        fontWeight: 'bold',
                        useSeriesColors: false
                    },
                },
                series: [{
                    name: 'Turnover',
                    data: turnover_arr,
                }, {
                    name: 'COGS / COS',
                    data: cogs_arr,
                }, {
                    name: 'Gross Profit',
                    data: gross_profit_arr,
                }],
                colors: [
                    '#002855',
                    '#05C3DD',
                    '#B3A369'
                ],
                chart: {
                    stacked: true,
                    type: 'bar',
                    height: '100%',
                    width: '100%'
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
                    categories: [ {{ $financial_year_arr_text }} ],
                    margin: 0,
                    offsetX: 0,
                    offsetY: 0,
                },
                title: {
                    text: 'Business Trend',
                    align: 'center',
                    margin: 0,
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        color: '#05C3DD',
                        fontWeight:  900,
                        fontSize:  '20px',
                    }
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

            chart = new ApexCharts(document.querySelector("#roadmap_business_trend"), options);
            chart_render = chart.render();
        }

        function storeChartImgFunc(){
            chart_render.then(() => {
                window.setTimeout(function() {
                    chart.dataURI().then((uri) => {

                        var image   = new Image();
                        var src     = uri.imgURI;

                        image.src   = src;

                        $.ajaxSetup({
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                        });
                        $.ajax({
                            type: "POST",
                            url: "{{ route('admin.financial-roadmaps.print.generate-roadmaps-chart', [$financialRoadmap]) }}",
                            data: {
                                image: src,
                            },
                            success: function (result) {
                                console.log(result);
                                $("#chartImg").val(result);
                                $("#chartImg_status").val(1);
                                $("#mainForm").submit();
                            }
                        }, 1000);
                    })
                })
            })
        }

        function defautPercentFunc(num){
            //declare percent variable
            var default_turnover_percent            = 0;
            var default_cogs_percent                = 0;
            var default_gross_profit_percent        = 0;
            var default_general_expenses_percent    = 0;
            var default_finance_cost_percent        = 0;
            var default_inventories_percent         = 0;
            var default_trade_receivables_percent   = 0;
            var default_trade_payables_percent      = 0;
            var default_eligibility_percent         = 0;

            //make the fields as same variable
            $(".default_turnover_percent").keyup(function (){
                default_turnover_percent = $(this).val();

                $(".default_turnover_percent").val(default_turnover_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_cogs_percent").keyup(function (){
                default_cogs_percent = $(this).val();

                $(".default_cogs_percent").val(default_cogs_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_gross_profit_percent").keyup(function (){
                default_gross_profit_percent = $(this).val();

                $(".default_gross_profit_percent").val(default_gross_profit_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_general_expenses_percent").keyup(function (){
                default_general_expenses_percent = $(this).val();

                $(".default_general_expenses_percent").val(default_general_expenses_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_finance_cost_percent").keyup(function (){
                default_finance_cost_percent = $(this).val();

                $(".default_finance_cost_percent").val(default_finance_cost_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_inventories_percent").keyup(function (){
                default_inventories_percent = $(this).val();

                $(".default_inventories_percent").val(default_inventories_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_trade_receivables_percent").keyup(function (){
                default_trade_receivables_percent = $(this).val();

                $(".default_trade_receivables_percent").val(default_trade_receivables_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_trade_payables_percent").keyup(function (){
                default_trade_payables_percent = $(this).val();

                $(".default_trade_payables_percent").val(default_trade_payables_percent);

                projectionPercentFunc(0, 'none');
            });

            $(".default_eligibility_percent").keyup(function (){
                default_eligibility_percent = $(this).val();

                $(".default_eligibility_percent").val(default_eligibility_percent);

                projectionPercentFunc(0, 'none');
            });
        }

        function percentFunc(status){
            // status 0: default percent input
            // status 1: number input
            // status 2: percent input

            //declare variable
            //area 4 variable
            var default_eligibility_percent         = parseFloat(recoverNumberFormat($(".default_eligibility_percent").val()));

            for (var i = 0; i < 3; i++) {
                if (status == 1){
                    //area 1
                    var turnover            = parseFloat(recoverNumberFormat($("#rm_turnover-" + i).val() ?? 0));
                    var cogs                = parseFloat(recoverNumberFormat($("#rm_cogs-" + i).val() ?? 0));
                    var gross_profit        = parseFloat(recoverNumberFormat($("#rm_gross_profit-" + i).val() ?? 0));
                    var general_expenses    = parseFloat(recoverNumberFormat($("#rm_general_expenses-" + i).val() ?? 0));
                    var profit_bfr_tax      = parseFloat(recoverNumberFormat($("#rm_profit_bfr_tax-" + i).val() ?? 0));
                    var tax                 = parseFloat(recoverNumberFormat($("#rm_tax-" + i).val() ?? 0));
                    var profit_aft_tax      = parseFloat(recoverNumberFormat($("#rm_profit_aft_tax-" + i).val() ?? 0));

                    var cogs_percent                = cogs                  / turnover * 100;
                    var gross_profit_percent        = gross_profit          / turnover * 100;
                    var general_expenses_percent    = general_expenses      / turnover * 100;
                    var profit_bfr_tax_percent      = profit_bfr_tax        / turnover * 100;
                    var tax_percent                 = tax                   / turnover * 100;
                    var profit_aft_tax_percent      = profit_aft_tax        / turnover * 100;

                    $("#rm_cogs_percent-" + i)              .val(addCommasWithinDecimal(cogs_percent.toFixed(2).toString()));
                    $("#rm_gross_profit_percent-" + i)      .val(addCommasWithinDecimal(gross_profit_percent.toFixed(2).toString()));
                    $("#rm_general_expenses_percent-" + i)  .val(addCommasWithinDecimal(general_expenses_percent.toFixed(2).toString()));
                    $("#rm_profit_bfr_tax_percent-" + i)    .val(addCommasWithinDecimal(profit_bfr_tax_percent.toFixed(2).toString()));
                    $("#rm_tax_percent-" + i)               .val(addCommasWithinDecimal(tax_percent.toFixed(2).toString()));
                    $("#rm_profit_aft_tax_percent-" + i)    .val(addCommasWithinDecimal(profit_aft_tax_percent.toFixed(2).toString()));

                    //area 2
                    var inventories         = parseFloat(recoverNumberFormat($("#rm_inventories-" + i).val() ?? 0));
                    var trade_receivables   = parseFloat(recoverNumberFormat($("#rm_trade_receivables-" + i).val() ?? 0));
                    var trade_payables      = parseFloat(recoverNumberFormat($("#rm_trade_payables-" + i).val() ?? 0));

                    var inventories_percent         = inventories           / cogs * 100;
                    var trade_receivables_percent   = trade_receivables     / cogs * 100;
                    var trade_payables_percent      = trade_payables        / cogs * 100;

                    $("#rm_inventories_percent-" + i)       .val(addCommasWithinDecimal(inventories_percent.toFixed(2).toString()));
                    $("#rm_trade_receivables_percent-" + i) .val(addCommasWithinDecimal(trade_receivables_percent.toFixed(2).toString()));
                    $("#rm_trade_payables_percent-" + i)    .val(addCommasWithinDecimal(trade_payables_percent.toFixed(2).toString()));
                }
                else if (status == 2){
                    //area 1
                    var cogs_percent                = (($("#rm_cogs_percent-" + i).val() ?? 0));
                    var gross_profit_percent        = (($("#rm_gross_profit_percent-" + i).val() ?? 0));
                    var general_expenses_percent    = (($("#rm_general_expenses_percent-" + i).val() ?? 0));
                    var profit_bfr_tax_percent      = (($("#rm_profit_bfr_tax_percent-" + i).val() ?? 0));
                    var tax_percent                 = (($("#rm_tax_percent-" + i).val() ?? 0));
                    var profit_aft_tax_percent      = (($("#rm_profit_aft_tax_percent-" + i).val() ?? 0));

                    var turnover                    = parseFloat(recoverNumberFormat($("#rm_turnover-" + i).val() ?? 0));

                    var cogs                = cogs_percent              * turnover / 100;
                    var gross_profit        = gross_profit_percent      * turnover / 100;
                    var general_expenses    = general_expenses_percent  * turnover / 100;
                    var profit_bfr_tax      = profit_bfr_tax_percent    * turnover / 100;
                    var tax                 = tax_percent               * turnover / 100;
                    var profit_aft_tax      = profit_aft_tax_percent    * turnover / 100;

                    $("#rm_cogs-" + i)              .val((addCommasWithinDecimal(cogs.toFixed(0).toString())));
                    $("#rm_gross_profit-" + i)      .val((addCommasWithinDecimal(gross_profit.toFixed(0).toString())));
                    $("#rm_general_expenses-" + i)  .val((addCommasWithinDecimal(general_expenses.toFixed(0).toString())));
                    $("#rm_profit_bfr_tax-" + i)    .val((addCommasWithinDecimal(profit_bfr_tax.toFixed(0).toString())));
                    $("#rm_tax-" + i)               .val((addCommasWithinDecimal(tax.toFixed(0).toString())));
                    $("#rm_profit_aft_tax-" + i)    .val((addCommasWithinDecimal(profit_aft_tax.toFixed(0).toString())));

                    //area 2 - percent
                    var inventories_percent         = parseFloat(recoverNumberFormat($("#rm_inventories_percent-" + i).val() ?? 0));
                    var trade_receivables_percent   = parseFloat(recoverNumberFormat($("#rm_trade_receivables_percent-" + i).val() ?? 0));
                    var trade_payables_percent      = parseFloat(recoverNumberFormat($("#rm_trade_payables_percent-" + i).val() ?? 0));

                    var cogs                        = parseFloat(recoverNumberFormat($("#rm_cogs-" + i).val() ?? 0));

                    var rm_inventories              = inventories_percent * cogs / 100;
                    var rm_trade_receivables        = trade_receivables_percent * cogs / 100;
                    var rm_trade_payables           = trade_payables_percent * cogs / 100;

                    $("#rm_inventories-" + i)           .val(parseFloat(addCommasWithinDecimal(rm_inventories.toFixed(2).toString())));
                    $("#rm_trade_receivables-" + i)     .val(parseFloat(addCommasWithinDecimal(rm_trade_receivables.toFixed(2).toString())));
                    $("#rm_trade_payables-" + i)        .val(parseFloat(addCommasWithinDecimal(rm_trade_payables.toFixed(2).toString())));
                }

                //area 2 - total
                var inventories         = parseFloat(recoverNumberFormat($("#rm_inventories-" + i).val() ?? 0));
                var trade_receivables   = parseFloat(recoverNumberFormat($("#rm_trade_receivables-" + i).val() ?? 0));
                var trade_payables      = parseFloat(recoverNumberFormat($("#rm_trade_payables-" + i).val() ?? 0));

                var facility_required   = inventories + trade_receivables - trade_payables

                $("#rm_facilities_required-" + i).val(addCommasWithinDecimal(facility_required.toFixed(2).toString()));

                // bfr edit
{{--                @if($has_been_edit_status == 0)--}}

                var turnover                        = parseFloat(recoverNumberFormat($('#rm_turnover-' + i ).val()));
                var new_working_capital_eligibility = default_eligibility_percent * turnover;

                var rm_depreciation_expenses        = parseFloat(recoverNumberFormat($('#rm_depreciation_expenses-' + i ).val()));
                var rm_finance_cost                 = parseFloat(recoverNumberFormat($('#rm_finance_cost-' + i ).val()));
                var rm_profit_bfr_tax               = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax-' + i ).val()));

                var ebitda                          = rm_depreciation_expenses + rm_finance_cost + rm_profit_bfr_tax;

                $('#working_capital_eligibility-' + i ).val(addCommasWithinDecimal(new_working_capital_eligibility.toFixed(0).toString()));
                $('#ebitda-' + i ).val(addCommasWithinDecimal(ebitda.toFixed(0).toString()));

                if (i == 2){

                    for (var y = 2; y <= 5; y ++) {
                        var existing_loan                       = parseFloat(recoverNumberFormat($('#existing_loan-' + y ).val()));
                        var financing_term_loan                 = parseFloat(recoverNumberFormat($('#financing_term_loan-' + y ).val()));
                        var financing_overdraft                 = parseFloat(recoverNumberFormat($('#financing_overdraft-' + y ).val()));
                        var financing_trade_line                = parseFloat(recoverNumberFormat($('#financing_trade_line-' + y ).val()));
                        var financing_property_loan             = parseFloat(recoverNumberFormat($('#financing_property_loan-' + y ).val()));

                        var total_loan_amount                   = existing_loan + financing_term_loan + financing_overdraft + financing_trade_line + financing_property_loan;

                        var repayment_term_property_loan        = parseFloat(recoverNumberFormat($('#repayment_term_property_loan-' + y ).val())); //76
                        var repayment_od_trade                  = parseFloat(recoverNumberFormat($('#repayment_od_trade-' + y ).val())); //77
                        var repayment_term_loan                 = parseFloat(recoverNumberFormat($('#repayment_term_loan-' + y ).val())); //78
                        var repayment_overdraft                 = parseFloat(recoverNumberFormat($('#repayment_overdraft-' + y ).val())); //79
                        var repayment_trade_line                = parseFloat(recoverNumberFormat($('#repayment_trade_line-' + y ).val())); //80
                        var repayment_property_loan             = parseFloat(recoverNumberFormat($('#repayment_property_loan-' + y ).val())); //81

                        var new_repayment_term_property_loan    = repayment_term_property_loan + repayment_term_loan + repayment_property_loan;
                        var new_repayment_od_trade              = repayment_od_trade + repayment_overdraft + repayment_trade_line;

                        var annual_repayment                    = repayment_term_property_loan + repayment_od_trade + repayment_term_loan + repayment_overdraft + repayment_trade_line + repayment_property_loan;
                        var total_outstanding_loan_amount       = total_loan_amount - repayment_term_property_loan - repayment_term_loan - repayment_property_loan;

                        $('#repayment_term_property_loan-' + (y + 1) ).val(addCommasWithinDecimal(new_repayment_term_property_loan.toFixed(0).toString()));
                        $('#repayment_od_trade-' + (y + 1) ).val(addCommasWithinDecimal(new_repayment_od_trade.toFixed(0).toString()));

                        $('#total_loan_amount-' + y ).val(addCommasWithinDecimal(total_loan_amount.toFixed(0).toString()));
                        $('#annual_repayment-' + y ).val(addCommasWithinDecimal(annual_repayment.toFixed(0).toString()));
                        $('#total_outstanding_loan_amount-' + y ).val(addCommasWithinDecimal(total_outstanding_loan_amount.toFixed(0).toString()));
                        $('#existing_loan-' + (y + 1) ).val(addCommasWithinDecimal(total_outstanding_loan_amount.toFixed(0).toString()));

                        summaryFunc(y);
                    }

                }

{{--                @else--}}
{{--                //aft edit--}}

{{--                for (var i = 3; i <= 5; i ++){--}}
{{--                    //declare variable--}}
{{--                    var last_turnover                   = parseFloat(recoverNumberFormat($('#rm_turnover-' + (i-1) ).val()));--}}
{{--                    var last_retained_earnings          = parseFloat(recoverNumberFormat($('#rm_retained_earnings-' + (i-1) ).val()));--}}

{{--                    var repayment_term_property_loan    = parseFloat(recoverNumberFormat($('#repayment_term_property_loan-' + i ).val())); //76--}}
{{--                    var repayment_od_trade              = parseFloat(recoverNumberFormat($('#repayment_od_trade-' + i ).val())); //77--}}
{{--                    var repayment_term_loan             = parseFloat(recoverNumberFormat($('#repayment_term_loan-' + i ).val())); //78--}}
{{--                    var repayment_property_loan         = parseFloat(recoverNumberFormat($('#repayment_property_loan-' + i ).val())); //81--}}

{{--                    var rm_share_capital                = parseFloat(recoverNumberFormat($('#rm_share_capital-' + i ).val())); //61--}}

{{--                    //calculate--}}
{{--                    var new_turnover            = last_turnover * ( 1 + (default_turnover_percent/100) );  //26--}}
{{--                    var new_cogs                = new_turnover * (default_cogs_percent/100);  //27--}}
{{--                    var new_gross_profit        = new_turnover - new_cogs;  //28--}}
{{--                    var new_general_expenses    = new_gross_profit * default_general_expenses_percent; //30--}}
{{--                    var new_finance_cost        = (( repayment_term_property_loan +  repayment_term_loan) * default_finance_cost_percent) + repayment_od_trade + repayment_property_loan;  //32--}}
{{--                    var new_profit_bfr_tax      = new_gross_profit - new_general_expenses - new_finance_cost;  //34--}}
{{--                    var profit_bfr_tax_percent  = new_profit_bfr_tax / new_turnover;--}}
{{--                    var new_tax                 = (600000 * 17 / 100) + ( (new_profit_bfr_tax-600000) * 24 / 100);  //35--}}
{{--                    var tax_percent             = new_tax / new_turnover;--}}
{{--                    var new_profit_aft_tax      = new_profit_bfr_tax - new_tax;  //36--}}
{{--                    var profit_aft_tax_percent  = new_profit_aft_tax / new_turnover;--}}

{{--                    var new_inventories         = new_cogs * default_inventories_percent //56--}}
{{--                    var new_trade_receivables   = new_turnover * default_trade_receivables_percent //57--}}
{{--                    var new_trade_payables      = new_cogs * default_trade_payables_percent //58--}}
{{--                    var new_facilities_required = new_inventories + new_trade_receivables - new_trade_payables //59--}}
{{--                    var new_retained_earnings   = last_retained_earnings +  new_profit_aft_tax //62--}}
{{--                    var new_net_worth           = new_retained_earnings +  rm_share_capital //62--}}

{{--                    $('#rm_turnover_percent-' + i ).val(addCommasWithinDecimal(default_turnover_percent.toFixed(2).toString()));--}}
{{--                    $('#rm_cogs_percent-' + i ).val(addCommasWithinDecimal(default_cogs_percent.toFixed(2).toString()));--}}
{{--                    $('#rm_gross_profit_percent-' + i ).val(addCommasWithinDecimal(default_gross_profit_percent.toFixed(2).toString()));--}}
{{--                    $('#rm_general_expenses_percent-' + i ).val(addCommasWithinDecimal(default_general_expenses_percent.toFixed(2).toString()));--}}
{{--                    $('#rm_profit_bfr_tax_percent-' + i ).val(addCommasWithinDecimal(profit_bfr_tax_percent.toFixed(0).toString()));--}}
{{--                    $('#rm_tax_percent-' + i ).val(addCommasWithinDecimal(tax_percent.toFixed(0).toString()));--}}
{{--                    $('#rm_profit_aft_tax_percent-' + i ).val(addCommasWithinDecimal(profit_aft_tax_percent.toFixed(0).toString()));--}}
{{--                    $('#rm_inventories_percent-' + i ).val(addCommasWithinDecimal(default_inventories_percent.toFixed(0).toString()));--}}
{{--                    $('#rm_trade_receivables_percent-' + i ).val(addCommasWithinDecimal(default_trade_receivables_percent.toFixed(0).toString()));--}}
{{--                    $('#rm_trade_payables_percent-' + i ).val(addCommasWithinDecimal(default_trade_payables_percent.toFixed(0).toString()));--}}
{{--                }--}}

{{--                @endif--}}

                //dsr
                var depreciation_expenses = parseFloat(recoverNumberFormat($("#rm_depreciation_expenses-" + i).val() ?? 0));
                var finance_cost = parseFloat(recoverNumberFormat($("#rm_finance_cost-" + i).val() ?? 0));
                var annual_debts = parseFloat(recoverNumberFormat($("#rm_annual_debts-" + i).val() ?? 0));

                var dsr = (depreciation_expenses + finance_cost + profit_bfr_tax) / annual_debts;

                $("#rm_dsr-" + i).val(addCommasWithinDecimal(dsr.toFixed(2).toString()));

                //gearing
                var share_capital = parseFloat(recoverNumberFormat($("#rm_share_capital-" + i).val() ?? 0));
                var retained_earnings = parseFloat(recoverNumberFormat($("#rm_retained_earnings-" + i).val() ?? 0));

                var gearing = share_capital / (share_capital + retained_earnings);

                $("#rm_gearing-" + i).val(addCommasWithinDecimal(gearing.toFixed(2).toString()));
            }
        }

        function projectionPercentFunc(status, id){
            // status 0: default percent input
            // status 1: number input
            // status 2: percent input

            //declare variable
            //area 4 variable
            var default_eligibility_percent         = parseFloat(recoverNumberFormat($(".default_eligibility_percent").val()));

            if (status == 0){
                //area 1 variable
                var default_turnover_percent            = parseFloat(recoverNumberFormat($(".default_turnover_percent").val()));
                var default_cogs_percent                = parseFloat(recoverNumberFormat($(".default_cogs_percent").val()));
                var default_gross_profit_percent        = parseFloat(recoverNumberFormat($(".default_gross_profit_percent").val()));

                var default_general_expenses_percent    = parseFloat(recoverNumberFormat($(".default_general_expenses_percent").val()));
                var default_finance_cost_percent        = parseFloat(recoverNumberFormat($(".default_finance_cost_percent").val()));

                //area 2 variable
                var default_inventories_percent         = parseFloat(recoverNumberFormat($(".default_inventories_percent").val()));
                var default_trade_receivables_percent   = parseFloat(recoverNumberFormat($(".default_trade_receivables_percent").val()));
                var default_trade_payables_percent      = parseFloat(recoverNumberFormat($(".default_trade_payables_percent").val()));

                for (var i = 3; i <= 5; i ++){
                    //declare variable
                    var last_turnover                   = parseFloat(recoverNumberFormat($('#rm_turnover-' + (i-1) ).val()));
                    var last_retained_earnings          = parseFloat(recoverNumberFormat($('#rm_retained_earnings-' + (i-1) ).val()));

                    var repayment_term_property_loan    = parseFloat(recoverNumberFormat($('#repayment_term_property_loan-' + i ).val())); //76
                    var repayment_od_trade              = parseFloat(recoverNumberFormat($('#repayment_od_trade-' + i ).val())); //77
                    var repayment_term_loan             = parseFloat(recoverNumberFormat($('#repayment_term_loan-' + i ).val())); //78
                    var repayment_property_loan         = parseFloat(recoverNumberFormat($('#repayment_property_loan-' + i ).val())); //81

                    var rm_share_capital                = parseFloat(recoverNumberFormat($('#rm_share_capital-' + i ).val())); //61

                    //calculate
                    var new_turnover            = last_turnover * ( 1 + (default_turnover_percent/100) );  //26
                    var new_cogs                = new_turnover * (default_cogs_percent/100);  //27
                    var new_gross_profit        = new_turnover - new_cogs;  //28
                    var new_general_expenses    = new_gross_profit * default_general_expenses_percent; //30
                    var new_finance_cost        = (( repayment_term_property_loan +  repayment_term_loan) * default_finance_cost_percent) + repayment_od_trade + repayment_property_loan;  //32
                    var new_profit_bfr_tax      = new_gross_profit - new_general_expenses - new_finance_cost;  //34
                    var profit_bfr_tax_percent  = new_profit_bfr_tax / new_turnover;
                    var new_tax                 = (600000 * 17 / 100) + ( (new_profit_bfr_tax-600000) * 24 / 100);  //35
                    var tax_percent             = new_tax / new_turnover;
                    var new_profit_aft_tax      = new_profit_bfr_tax - new_tax;  //36
                    var profit_aft_tax_percent  = new_profit_aft_tax / new_turnover;

                    var new_inventories         = new_cogs * default_inventories_percent //56
                    var new_trade_receivables   = new_turnover * default_trade_receivables_percent //57
                    var new_trade_payables      = new_cogs * default_trade_payables_percent //58
                    var new_facilities_required = new_inventories + new_trade_receivables - new_trade_payables //59
                    var new_retained_earnings   = last_retained_earnings +  new_profit_aft_tax //62
                    var new_net_worth           = new_retained_earnings +  rm_share_capital //62

                    $('#rm_turnover-' + i ).val(addCommasWithinDecimal(new_turnover.toFixed(0).toString()));
                    $('#rm_turnover_percent-' + i ).val(addCommasWithinDecimal(default_turnover_percent.toFixed(2).toString()));

                    $('#rm_cogs-' + i ).val(addCommasWithinDecimal(new_cogs.toFixed(0).toString()));
                    $('#rm_cogs_percent-' + i ).val(addCommasWithinDecimal(default_cogs_percent.toFixed(2).toString()));

                    $('#rm_gross_profit-' + i ).val(addCommasWithinDecimal(new_gross_profit.toFixed(0).toString()));
                    $('#rm_gross_profit_percent-' + i ).val(addCommasWithinDecimal(default_gross_profit_percent.toFixed(2).toString()));

                    $('#rm_general_expenses-' + i ).val(addCommasWithinDecimal(new_general_expenses.toFixed(0).toString()));
                    $('#rm_general_expenses_percent-' + i ).val(addCommasWithinDecimal(default_general_expenses_percent.toFixed(2).toString()));

                    $('#rm_finance_cost-' + i ).val(addCommasWithinDecimal(new_finance_cost.toFixed(0).toString()));

                    $('#rm_profit_bfr_tax-' + i ).val(addCommasWithinDecimal(new_profit_bfr_tax.toFixed(0).toString())); //34
                    $('#rm_profit_bfr_tax_percent-' + i ).val(addCommasWithinDecimal(profit_bfr_tax_percent.toFixed(0).toString()));

                    $('#rm_tax-' + i ).val(addCommasWithinDecimal(new_tax.toFixed(0).toString()));
                    $('#rm_tax_percent-' + i ).val(addCommasWithinDecimal(tax_percent.toFixed(0).toString()));

                    $('#rm_profit_aft_tax-' + i ).val(addCommasWithinDecimal(new_profit_aft_tax.toFixed(0).toString()));
                    $('#rm_profit_aft_tax_percent-' + i ).val(addCommasWithinDecimal(profit_aft_tax_percent.toFixed(0).toString()));

                    $('#rm_inventories-' + i ).val(addCommasWithinDecimal(new_inventories.toFixed(0).toString()));
                    $('#rm_inventories_percent-' + i ).val(addCommasWithinDecimal(default_inventories_percent.toFixed(0).toString()));

                    $('#rm_trade_receivables-' + i ).val(addCommasWithinDecimal(new_trade_receivables.toFixed(0).toString()));
                    $('#rm_trade_receivables_percent-' + i ).val(addCommasWithinDecimal(default_trade_receivables_percent.toFixed(0).toString()));

                    $('#rm_trade_payables-' + i ).val(addCommasWithinDecimal(new_trade_payables.toFixed(0).toString()));
                    $('#rm_trade_payables_percent-' + i ).val(addCommasWithinDecimal(default_trade_payables_percent.toFixed(0).toString()));

                    $('#rm_facilities_required-' + i ).val(addCommasWithinDecimal(new_facilities_required.toFixed(0).toString()));

                    $('#rm_retained_earnings-' + i ).val(addCommasWithinDecimal(new_retained_earnings.toFixed(0).toString()));

                    $('#rm_net_worth-' + i ).val(addCommasWithinDecimal(new_net_worth.toFixed(0).toString()));


                }
            }
            else if (status == 1){

                for (var i = 3; i <= 5; i ++){
                    var last_turnover                   = parseFloat(recoverNumberFormat($('#rm_turnover-' + (i-1) ).val()));
                    var turnover                        = parseFloat(recoverNumberFormat($('#rm_turnover-' + i ).val()));
                    var cogs                            = parseFloat(recoverNumberFormat($('#rm_cogs-' + i ).val()));
                    var gross_profit                    = parseFloat(recoverNumberFormat($('#rm_gross_profit-' + i ).val()));
                    var rm_general_expenses             = parseFloat(recoverNumberFormat($('#rm_general_expenses-' + i ).val()));
                    var rm_profit_bfr_tax               = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax-' + i ).val()));
                    var rm_tax                          = parseFloat(recoverNumberFormat($('#rm_tax-' + i ).val()));
                    var rm_profit_aft_tax               = parseFloat(recoverNumberFormat($('#rm_profit_aft_tax-' + i ).val()));
                    var rm_inventories                  = parseFloat(recoverNumberFormat($('#rm_inventories-' + i ).val()));
                    var rm_trade_receivables            = parseFloat(recoverNumberFormat($('#rm_trade_receivables-' + i ).val()));
                    var rm_trade_payables               = parseFloat(recoverNumberFormat($('#rm_trade_payables-' + i ).val()));
                    var rm_cogs_percent                 = parseFloat(recoverNumberFormat($('#rm_cogs_percent-' + i ).val()));
                    var rm_general_expenses_percent     = parseFloat(recoverNumberFormat($('#rm_general_expenses_percent-' + i ).val()));
                    var rm_finance_cost                 = parseFloat(recoverNumberFormat($('#rm_finance_cost-' + i ).val()));
                    var rm_inventories_percent          = parseFloat(recoverNumberFormat($('#rm_inventories_percent-' + i ).val()));
                    var rm_trade_receivables_percent    = parseFloat(recoverNumberFormat($('#rm_trade_receivables_percent-' + i ).val()));
                    var rm_trade_payables_percent       = parseFloat(recoverNumberFormat($('#rm_trade_payables_percent-' + i ).val()));
                    var last_retained_earnings          = parseFloat(recoverNumberFormat($('#rm_retained_earnings-' + (i - 1) ).val()));
                    var rm_share_capital                = parseFloat(recoverNumberFormat($('#rm_share_capital-' + i ).val()));

                    var turnover_percent                = parseFloat(recoverNumberFormat($('#rm_turnover_percent-' + i ).val()));
                    var cogs_percent                    = parseFloat(recoverNumberFormat($('#rm_cogs_percent-' + i ).val()));
                    var gross_profit_percent            = parseFloat(recoverNumberFormat($('#rm_gross_profit_percent-' + i ).val()));
                    var rm_general_expenses_percent     = parseFloat(recoverNumberFormat($('#rm_general_expenses_percent-' + i ).val()));
                    var rm_profit_bfr_tax_percent       = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax_percent-' + i ).val()));
                    var rm_tax_percent                  = parseFloat(recoverNumberFormat($('#rm_tax_percent-' + i ).val()));
                    var rm_profit_aft_tax_percent       = parseFloat(recoverNumberFormat($('#rm_profit_aft_tax_percent-' + i ).val()));
                    var rm_inventories_percent          = parseFloat(recoverNumberFormat($('#rm_inventories_percent-' + i ).val()));
                    var rm_trade_receivables_percent    = parseFloat(recoverNumberFormat($('#rm_trade_receivables_percent-' + i ).val()));
                    var rm_trade_payables_percent       = parseFloat(recoverNumberFormat($('#rm_trade_payables_percent-' + i ).val()));

                    switch (id) {
                        case 'rm_turnover':
                            /** formula:
                             * y = ((x / c) - 1) * 100
                             *
                             * **/
                            var percentage = formulaFunction(turnover, 0, last_turnover, 1); // type 1, y function
                            var cogs = formulaFunction(0, rm_cogs_percent, turnover, 5); // type 5, x function
                            var gross_profit = formulaFunction(0, turnover, cogs, 7); // type 7, z function
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_turnover_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_cogs-' + i).val(addCommasWithinDecimal(cogs.toFixed(0).toString()));
                            $('#rm_gross_profit-' + i).val(addCommasWithinDecimal(gross_profit.toFixed(0).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_cogs':
                            /** formula:
                             * y = 100x / c
                             * **/
                            var percentage = formulaFunction(cogs, 0, turnover, 2); // type 2, y function
                            var gross_profit = formulaFunction(0, turnover, cogs, 7); // type 7, z function
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_cogs_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_gross_profit-' + i).val(addCommasWithinDecimal(gross_profit.toFixed(0).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_gross_profit':
                            /** formula:
                             * x = a - b
                             * y = x / a
                             * **/
                            var percentage = formulaFunction(gross_profit, 0, turnover, 3); // type 3, y function
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_gross_profit_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_general_expenses':
                            /** formula:
                             * y = x / c
                             * **/
                            var percentage = formulaFunction(rm_general_expenses, 0, gross_profit, 3); // type 3, y function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_general_expenses_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_depreciation_expenses':

                            break;

                        case 'rm_finance_cost':

                            break;

                        case 'rm_profit_bfr_tax':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_profit_bfr_tax, 0, turnover, 3); // type 3, y function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_profit_bfr_tax_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_tax':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_tax, 0, turnover, 3); // type 3, y function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_tax_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_profit_aft_tax':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_profit_aft_tax, 0, turnover, 3); // type 3, y function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_profit_aft_tax_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_inventories':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_inventories, 0, cogs, 3); // type 3, y function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_inventories_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_trade_receivables':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_trade_receivables, 0, turnover, 3); // type 3, y function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_trade_receivables_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_trade_payables':
                            /** formula:
                             * y = x / c
                             * **/

                            var percentage = formulaFunction(rm_trade_payables, 0, cogs, 3); // type 3, y function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_trade_payables_percent-' + i).val(addCommasWithinDecimal(percentage.toFixed(2).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                    }
                }

            }
            else if(status == 2){
                for (var i = 3; i <= 5; i ++){

                    var last_turnover                   = parseFloat(recoverNumberFormat($('#rm_turnover-' + (i-1) ).val()));
                    var turnover                        = parseFloat(recoverNumberFormat($('#rm_turnover-' + i ).val()));
                    var cogs                            = parseFloat(recoverNumberFormat($('#rm_cogs-' + i ).val()));
                    var gross_profit                    = parseFloat(recoverNumberFormat($('#rm_gross_profit-' + i ).val()));
                    var rm_general_expenses             = parseFloat(recoverNumberFormat($('#rm_general_expenses-' + i ).val()));
                    var rm_profit_bfr_tax               = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax-' + i ).val()));
                    var rm_tax                          = parseFloat(recoverNumberFormat($('#rm_tax-' + i ).val()));
                    var rm_profit_aft_tax               = parseFloat(recoverNumberFormat($('#rm_profit_aft_tax-' + i ).val()));
                    var rm_inventories                  = parseFloat(recoverNumberFormat($('#rm_inventories-' + i ).val()));
                    var rm_trade_receivables            = parseFloat(recoverNumberFormat($('#rm_trade_receivables-' + i ).val()));
                    var rm_trade_payables               = parseFloat(recoverNumberFormat($('#rm_trade_payables-' + i ).val()));
                    var rm_cogs_percent                 = parseFloat(recoverNumberFormat($('#rm_cogs_percent-' + i ).val()));
                    var rm_general_expenses_percent     = parseFloat(recoverNumberFormat($('#rm_general_expenses_percent-' + i ).val()));
                    var rm_finance_cost                 = parseFloat(recoverNumberFormat($('#rm_finance_cost-' + i ).val()));
                    var rm_inventories_percent          = parseFloat(recoverNumberFormat($('#rm_inventories_percent-' + i ).val()));
                    var rm_trade_receivables_percent    = parseFloat(recoverNumberFormat($('#rm_trade_receivables_percent-' + i ).val()));
                    var rm_trade_payables_percent       = parseFloat(recoverNumberFormat($('#rm_trade_payables_percent-' + i ).val()));
                    var last_retained_earnings          = parseFloat(recoverNumberFormat($('#rm_retained_earnings-' + (i - 1) ).val()));
                    var rm_share_capital                = parseFloat(recoverNumberFormat($('#rm_share_capital-' + i ).val()));

                    var rm_turnover_percent                = parseFloat(recoverNumberFormat($('#rm_turnover_percent-' + i ).val()));
                    var rm_cogs_percent                 = parseFloat(recoverNumberFormat($('#rm_cogs_percent-' + i ).val()));
                    var rm_gross_profit_percent         = parseFloat(recoverNumberFormat($('#rm_gross_profit_percent-' + i ).val()));
                    var rm_general_expenses_percent     = parseFloat(recoverNumberFormat($('#rm_general_expenses_percent-' + i ).val()));
                    var rm_profit_bfr_tax_percent       = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax_percent-' + i ).val()));
                    var rm_tax_percent                  = parseFloat(recoverNumberFormat($('#rm_tax_percent-' + i ).val()));
                    var rm_profit_aft_tax_percent       = parseFloat(recoverNumberFormat($('#rm_profit_aft_tax_percent-' + i ).val()));
                    var rm_inventories_percent          = parseFloat(recoverNumberFormat($('#rm_inventories_percent-' + i ).val()));
                    var rm_trade_receivables_percent    = parseFloat(recoverNumberFormat($('#rm_trade_receivables_percent-' + i ).val()));
                    var rm_trade_payables_percent       = parseFloat(recoverNumberFormat($('#rm_trade_payables_percent-' + i ).val()));

                    switch (id){
                        case 'rm_turnover':
                            /** formula:
                             * x = ((y / 100) + 1) * c
                             * **/
                            var value = formulaFunction(0, rm_turnover_percent, last_turnover, 4); // type 4, x function
                            var turnover = value;
                            var cogs = formulaFunction(0, rm_cogs_percent, turnover, 5); // type 5, x function
                            var gross_profit = formulaFunction(0, turnover, cogs, 7); // type 7, z function
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_turnover-' + i).val(addCommasWithinDecimal(value.toFixed(0).toString()));
                            $('#rm_cogs-' + i).val(addCommasWithinDecimal(cogs.toFixed(0).toString()));
                            $('#rm_gross_profit-' + i).val(addCommasWithinDecimal(gross_profit.toFixed(0).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_cogs':
                            /** formula:
                             * x = yc / 100
                             * **/
                            var value = formulaFunction(0, rm_cogs_percent, turnover, 5); // type 5, x function
                            var cogs = value;
                            var gross_profit = formulaFunction(0, turnover, cogs, 7); // type 7, z function
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_cogs-' + i).val(addCommasWithinDecimal(value.toFixed(0).toString()));
                            $('#rm_gross_profit-' + i).val(addCommasWithinDecimal(gross_profit.toFixed(0).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_gross_profit':
                            /** formula:
                             * x = yc
                             * **/
                            var value = formulaFunction(0, rm_gross_profit_percent, turnover, 6); // type 6, x function
                            var gross_profit = value;
                            var rm_general_expenses = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_gross_profit-' + i).val(addCommasWithinDecimal(value.toFixed(0).toString()));
                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(rm_general_expenses.toFixed(0).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_general_expenses':
                            /** formula:
                             * x = yc
                             * **/
                            var value = formulaFunction(0, rm_general_expenses_percent, gross_profit, 6); // type 6, x function
                            var rm_general_expenses = value;
                            var rm_profit_bfr_tax = formulaFunction(gross_profit, rm_general_expenses, rm_finance_cost, 8); // type 8, z function
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_general_expenses-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(rm_profit_bfr_tax.toFixed(0).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_depreciation_expenses':

                            break;

                        case 'rm_finance_cost':

                            break;

                        case 'rm_profit_bfr_tax':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_profit_bfr_tax_percent, turnover, 6); // type 6, x function
                            var rm_profit_bfr_tax = value;
                            var rm_tax = formulaFunction(rm_profit_bfr_tax, 0, turnover, 9); // type 9, z function
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_profit_bfr_tax-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_tax-' + i).val(addCommasWithinDecimal(rm_tax.toFixed(0).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_tax':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_tax_percent, turnover, 6); // type 6, x function
                            var rm_tax = value;
                            var rm_profit_aft_tax = formulaFunction(0, rm_profit_bfr_tax, rm_tax, 7); // type 7, z function
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_tax-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(rm_profit_aft_tax.toFixed(0).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_profit_aft_tax':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_profit_aft_tax_percent, turnover, 6); // type 6, x function
                            var rm_profit_aft_tax = value;
                            var rm_inventories = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_profit_aft_tax-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(rm_inventories.toFixed(0).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_inventories':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_inventories_percent, cogs, 6); // type 6, x function
                            var rm_inventories = value;
                            var rm_trade_receivables = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_inventories-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(rm_trade_receivables.toFixed(0).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_trade_receivables':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_trade_receivables_percent, turnover, 6); // type 6, x function
                            var rm_trade_receivables = value;
                            var rm_trade_payables = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_trade_receivables-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(rm_trade_payables.toFixed(0).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                        case 'rm_trade_payables':
                            /** formula:
                             * x = yc
                             * **/

                            var value = formulaFunction(0, rm_trade_payables_percent, cogs, 6); // type 6, x function
                            var rm_trade_payables = value
                            var rm_facilities_required = formulaFunction(rm_inventories, rm_trade_receivables, rm_trade_payables, 8); // type 8, z function
                            var rm_retained_earnings = formulaFunction(0, rm_profit_aft_tax, last_retained_earnings, 10); // type 10, z function
                            var rm_net_worth = formulaFunction(0, rm_retained_earnings, rm_share_capital, 10); // type 10, z function
                            var working_capital_eligibility = formulaFunction(0, default_eligibility_percent, turnover, 5); // type 5, x function

                            $('#rm_trade_payables-' + i).val(addCommasWithinDecimal(value.toFixed(2).toString()));
                            $('#rm_facilities_required-' + i).val(addCommasWithinDecimal(rm_facilities_required.toFixed(0).toString()));
                            $('#rm_retained_earnings-' + i).val(addCommasWithinDecimal(rm_retained_earnings.toFixed(0).toString()));
                            $('#rm_net_worth-' + i).val(addCommasWithinDecimal(rm_net_worth.toFixed(0).toString()));

                            $('#working_capital_eligibility-' + i).val(addCommasWithinDecimal(working_capital_eligibility.toFixed(0).toString()));

                            break;

                    }

                }
            }

            // bfr edit
{{--            @if($has_been_edit_status == 0)--}}

            for (var i = 0; i <= 5; i ++){
                var turnover                        = parseFloat(recoverNumberFormat($('#rm_turnover-' + i ).val()));
                var new_working_capital_eligibility = default_eligibility_percent * turnover;

                var rm_depreciation_expenses        = parseFloat(recoverNumberFormat($('#rm_depreciation_expenses-' + i ).val()));
                var rm_finance_cost                 = parseFloat(recoverNumberFormat($('#rm_finance_cost-' + i ).val()));
                var rm_profit_bfr_tax               = parseFloat(recoverNumberFormat($('#rm_profit_bfr_tax-' + i ).val()));

                var ebitda                          = rm_depreciation_expenses + rm_finance_cost + rm_profit_bfr_tax;

                $('#working_capital_eligibility-' + i ).val(addCommasWithinDecimal(new_working_capital_eligibility.toFixed(0).toString()));
                $('#ebitda-' + i ).val(addCommasWithinDecimal(ebitda.toFixed(0).toString()));
            }

            for (var i = 2; i <= 5; i ++){
                var existing_loan                       = parseFloat(recoverNumberFormat($('#existing_loan-' + i ).val()));
                var financing_term_loan                 = parseFloat(recoverNumberFormat($('#financing_term_loan-' + i ).val()));
                var financing_overdraft                 = parseFloat(recoverNumberFormat($('#financing_overdraft-' + i ).val()));
                var financing_trade_line                = parseFloat(recoverNumberFormat($('#financing_trade_line-' + i ).val()));
                var financing_property_loan             = parseFloat(recoverNumberFormat($('#financing_property_loan-' + i ).val()));

                var total_loan_amount                   = existing_loan + financing_term_loan + financing_overdraft + financing_trade_line + financing_property_loan;

                var repayment_term_property_loan        = parseFloat(recoverNumberFormat($('#repayment_term_property_loan-' + i ).val())); //76
                var repayment_od_trade                  = parseFloat(recoverNumberFormat($('#repayment_od_trade-' + i ).val())); //77
                var repayment_term_loan                 = parseFloat(recoverNumberFormat($('#repayment_term_loan-' + i ).val())); //78
                var repayment_overdraft                 = parseFloat(recoverNumberFormat($('#repayment_overdraft-' + i ).val())); //79
                var repayment_trade_line                = parseFloat(recoverNumberFormat($('#repayment_trade_line-' + i ).val())); //80
                var repayment_property_loan             = parseFloat(recoverNumberFormat($('#repayment_property_loan-' + i ).val())); //81

                var new_repayment_term_property_loan    = repayment_term_property_loan + repayment_term_loan + repayment_property_loan;
                var new_repayment_od_trade              = repayment_od_trade + repayment_overdraft + repayment_trade_line;

                var annual_repayment                    = repayment_term_property_loan + repayment_od_trade + repayment_term_loan + repayment_overdraft + repayment_trade_line + repayment_property_loan;
                var total_outstanding_loan_amount       = total_loan_amount - repayment_term_property_loan - repayment_term_loan - repayment_property_loan;

                $('#repayment_term_property_loan-' + (i + 1) ).val(addCommasWithinDecimal(new_repayment_term_property_loan.toFixed(0).toString()));
                $('#repayment_od_trade-' + (i + 1) ).val(addCommasWithinDecimal(new_repayment_od_trade.toFixed(0).toString()));

                $('#total_loan_amount-' + i ).val(addCommasWithinDecimal(total_loan_amount.toFixed(0).toString()));
                $('#annual_repayment-' + i ).val(addCommasWithinDecimal(annual_repayment.toFixed(0).toString()));
                $('#total_outstanding_loan_amount-' + i ).val(addCommasWithinDecimal(total_outstanding_loan_amount.toFixed(0).toString()));
                $('#existing_loan-' + (i + 1) ).val(addCommasWithinDecimal(total_outstanding_loan_amount.toFixed(0).toString()));

                summaryFunc(i);
            }

{{--            @else--}}
{{--            //aft edit--}}

{{--            for (var i = 3; i <= 5; i ++){--}}
{{--                //declare variable--}}
{{--                var last_turnover                   = parseFloat(recoverNumberFormat($('#rm_turnover-' + (i-1) ).val()));--}}
{{--                var last_retained_earnings          = parseFloat(recoverNumberFormat($('#rm_retained_earnings-' + (i-1) ).val()));--}}

{{--                var repayment_term_property_loan    = parseFloat(recoverNumberFormat($('#repayment_term_property_loan-' + i ).val())); //76--}}
{{--                var repayment_od_trade              = parseFloat(recoverNumberFormat($('#repayment_od_trade-' + i ).val())); //77--}}
{{--                var repayment_term_loan             = parseFloat(recoverNumberFormat($('#repayment_term_loan-' + i ).val())); //78--}}
{{--                var repayment_property_loan         = parseFloat(recoverNumberFormat($('#repayment_property_loan-' + i ).val())); //81--}}

{{--                var rm_share_capital                = parseFloat(recoverNumberFormat($('#rm_share_capital-' + i ).val())); //61--}}

{{--                //calculate--}}
{{--                var new_turnover            = last_turnover * ( 1 + (default_turnover_percent/100) );  //26--}}
{{--                var new_cogs                = new_turnover * (default_cogs_percent/100);  //27--}}
{{--                var new_gross_profit        = new_turnover - new_cogs;  //28--}}
{{--                var new_general_expenses    = new_gross_profit * default_general_expenses_percent; //30--}}
{{--                var new_finance_cost        = (( repayment_term_property_loan +  repayment_term_loan) * default_finance_cost_percent) + repayment_od_trade + repayment_property_loan;  //32--}}
{{--                var new_profit_bfr_tax      = new_gross_profit - new_general_expenses - new_finance_cost;  //34--}}
{{--                var profit_bfr_tax_percent  = new_profit_bfr_tax / new_turnover;--}}
{{--                var new_tax                 = (600000 * 17 / 100) + ( (new_profit_bfr_tax-600000) * 24 / 100);  //35--}}
{{--                var tax_percent             = new_tax / new_turnover;--}}
{{--                var new_profit_aft_tax      = new_profit_bfr_tax - new_tax;  //36--}}
{{--                var profit_aft_tax_percent  = new_profit_aft_tax / new_turnover;--}}

{{--                var new_inventories         = new_cogs * default_inventories_percent //56--}}
{{--                var new_trade_receivables   = new_turnover * default_trade_receivables_percent //57--}}
{{--                var new_trade_payables      = new_cogs * default_trade_payables_percent //58--}}
{{--                var new_facilities_required = new_inventories + new_trade_receivables - new_trade_payables //59--}}
{{--                var new_retained_earnings   = last_retained_earnings +  new_profit_aft_tax //62--}}
{{--                var new_net_worth           = new_retained_earnings +  rm_share_capital //62--}}

{{--                $('#rm_turnover_percent-' + i ).val(addCommasWithinDecimal(default_turnover_percent.toFixed(2).toString()));--}}
{{--                $('#rm_cogs_percent-' + i ).val(addCommasWithinDecimal(default_cogs_percent.toFixed(2).toString()));--}}
{{--                $('#rm_gross_profit_percent-' + i ).val(addCommasWithinDecimal(default_gross_profit_percent.toFixed(2).toString()));--}}
{{--                $('#rm_general_expenses_percent-' + i ).val(addCommasWithinDecimal(default_general_expenses_percent.toFixed(2).toString()));--}}
{{--                $('#rm_profit_bfr_tax_percent-' + i ).val(addCommasWithinDecimal(profit_bfr_tax_percent.toFixed(0).toString()));--}}
{{--                $('#rm_tax_percent-' + i ).val(addCommasWithinDecimal(tax_percent.toFixed(0).toString()));--}}
{{--                $('#rm_profit_aft_tax_percent-' + i ).val(addCommasWithinDecimal(profit_aft_tax_percent.toFixed(0).toString()));--}}
{{--                $('#rm_inventories_percent-' + i ).val(addCommasWithinDecimal(default_inventories_percent.toFixed(0).toString()));--}}
{{--                $('#rm_trade_receivables_percent-' + i ).val(addCommasWithinDecimal(default_trade_receivables_percent.toFixed(0).toString()));--}}
{{--                $('#rm_trade_payables_percent-' + i ).val(addCommasWithinDecimal(default_trade_payables_percent.toFixed(0).toString()));--}}
{{--            }--}}

{{--            @endif--}}
        }

        function summaryFunc(i){
            var ebitda                          = parseFloat(recoverNumberFormat($('#ebitda-' + i ).val()));
            var annual_repayment                = parseFloat(recoverNumberFormat($('#annual_repayment-' + i ).val()));
            var total_outstanding_loan_amount   = parseFloat(recoverNumberFormat($('#total_outstanding_loan_amount-' + i ).val()));
            var rm_net_worth                    = parseFloat(recoverNumberFormat($('#rm_net_worth-' + i ).val()));

            var dscr            = ebitda / annual_repayment;
            var gearing_ratio   = total_outstanding_loan_amount / rm_net_worth;

            // console.log(dscr)

            $('#dscr-' + i ).val(addCommasWithinDecimal(dscr.toFixed(3).toString()));
            $('#gearing_ratio-' + i ).val(addCommasWithinDecimal(gearing_ratio.toFixed(3).toString()));
        }

        function scrollBtnFunc(){
            $(window).scroll(function() {
                var trigger_div_top = $('#trigger_div').offset().top;

                var currentScroll = $(window).scrollTop();

                if (currentScroll >= trigger_div_top) {
                    $('#percent_formula_btn').css('display', 'block')
                }
                else {
                    $('#percent_formula_btn').css('display', 'none')
                }
            });
        }

        function showModal(){
            $("#updateModal").show()
        }

        function showHideItem(){
            if ($('.hide_item').hasClass('d-none')){
                $('.hide_item').removeClass('d-none');

                $('.trigger_hide_asc').removeClass('d-none');
                $('.trigger_hide_desc').addClass('d-none');
            }
            else {
                $('.hide_item').addClass('d-none');

                $('.trigger_hide_asc').addClass('d-none');
                $('.trigger_hide_desc').removeClass('d-none');
            }
        }

        function defaultPercentFunc(){
            var default_cogs_percent = 0
            var default_gross_profit_percent = 0
            var default_inventories_percent = 0
            var default_trade_receivables_percent = 0
            var default_trade_payables_percent = 0

            for(var i = 0; i < 3; i++ ){
                default_cogs_percent += parseFloat($("#rm_cogs_percent-" + i).val());
                default_gross_profit_percent += parseFloat($("#rm_gross_profit_percent-" + i).val());
                default_inventories_percent += parseFloat($("#rm_inventories_percent-" + i).val());
                default_trade_receivables_percent += parseFloat($("#rm_trade_receivables_percent-" + i).val());
                default_trade_payables_percent += parseFloat($("#rm_trade_payables_percent-" + i).val());
            }

            $('.default_cogs_percent').val((default_cogs_percent/i).toFixed(0).toString());
            $('.default_gross_profit_percent').val((default_gross_profit_percent/i).toFixed(0).toString());
            $('.default_inventories_percent').val((default_inventories_percent/i).toFixed(0).toString());
            $('.default_trade_receivables_percent').val((default_trade_receivables_percent/i).toFixed(0).toString());
            $('.default_trade_payables_percent').val((default_trade_payables_percent/i).toFixed(0).toString());
        }

        function financingInstrumentCalculateFunc(x, tenor_num, tenor_month, tenor_status){
            /**    LOAN     **/
            // if (tenor_status == 1){
                //declare the value
                var propose_limit   = $("#financingInstrument_proposed_limit_loan-"+x).val() ? parseInt($("#financingInstrument_proposed_limit_loan-"+x).val().replace(/,/g, '').replace('(', '').replace(')', '')) : 0


            var rate            = $("#financingInstrument_interest_rate_loan-"+x).val()
                var tenor_num       = (tenor_status == 0 ? tenor_num : $("#financingInstrument_tenor_input_loan-"+x).val())
                var tenor_month     = (tenor_status == 0 ? 12 : (tenor_status == 1 ? tenor_num * 12 : tenor_num))
                var total           = 0

                if ($("#financingInstrument_proposed_limit_loan-"+x).val().toString().includes('(')){
                    propose_limit = '-'+propose_limit
                    propose_limit = parseFloat(propose_limit.toString())
                }

                //calculate
                if (tenor_status == 0){
                    total = isNaN(propose_limit) ? '-' : (( propose_limit * tenor_num * rate/100 ) / tenor_month);
                }
                else if (tenor_status == 1){
                    total = isNaN(propose_limit) ? '-' : ((( propose_limit * tenor_num * rate/100 ) + propose_limit) / tenor_month);
                }
                else {
                    total = isNaN(propose_limit) ? '-' : (( propose_limit * (rate/100 + 1) ) / tenor_month);
                }

                $("#financingInstrument_proposed_limit_loan-"+x).val(addCommas($("#financingInstrument_proposed_limit_loan-"+x).val().toString()))
                $("#financingInstrument_commitment_loan-"+x).val(addCommasWithinDecimal(total.toFixed(2).toString()))
                $("#new_financingInstrument_commitment_loan-"+x).val(addCommasWithinDecimal((total * 12).toFixed(2).toString()))
            // }

            financingInstrumentTotalCalculateFunc()
        }

        function financingInstrumentTotalCalculateFunc(){
            var total_amount = 0

            $(".financingInstrument_proposed_limit_loan").each(function () {
                var value = 0;

                if ($(this).val().toString().includes('(')){
                    value = '-'+$(this).val();
                    value = parseFloat($(this).val().toString());
                }
                else {
                    value = $(this).val();
                }

                var amount = parseFloat(value) ? parseFloat(value.replace(/,/g, '')) : 0

                total_amount    += amount;
            })

            $("#financingInstrument_total_propose_loan").val(addCommasWithinDecimal(total_amount.toFixed(2)))

            var total_amount = 0

            $(".financingInstrument_commitment_loan").each(function () {
                var value = 0;

                if ($(this).val().toString().includes('(')){
                    value = '-'+$(this).val();
                    value = parseFloat($(this).val().toString());
                }
                else {
                    value = $(this).val();
                }

                var amount = parseFloat(value) ? parseFloat(value.replace(/,/g, '')) : 0

                total_amount    += amount;
            })

            $("#financingInstrument_total_commitment_loan").val(addCommasWithinDecimal(total_amount.toFixed(2)))

            var total_amount = 0

            $(".new_financingInstrument_commitment_loan").each(function () {
                var value = 0;

                if ($(this).val().toString().includes('(')){
                    value = '-'+$(this).val();
                    value = parseFloat($(this).val().toString());
                }
                else {
                    value = $(this).val();
                }

                var amount = parseFloat(value) ? parseFloat(value.replace(/,/g, '')) : 0

                total_amount    += amount;
            })

            $("#new_financingInstrument_total_commitment_loan").val(addCommasWithinDecimal(total_amount.toFixed(2)))
        }

        $('.cancel').click(function() {
            $(this).parent().parent().parent().parent().hide();
        });

        percentFunc(1);
        defaultPercentFunc();
        projectionPercentFunc(0, 'none');
        financingInstrumentTotalCalculateFunc();
        roadmapChartFunc()
        scrollBtnFunc();
    </script>
@endpush
