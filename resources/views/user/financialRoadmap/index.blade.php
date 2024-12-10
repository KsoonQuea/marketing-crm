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
        <form action="{{ route('user.index.store') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">

            <div class="row">
                <div class="col-sm-12 col-xl-3">
                    <h4 class="primary_font_color"><b>Financial Roadmap</b></h4>
                    <p class="third_font_color">Basic Information</p>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-radius">

                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Company Name</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="company_name" name="company_name" type="text">
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Business Industry</label>
                                        <select class="select2" name="business_industry" id="business_industry">
                                            @foreach($industry_types as $id => $industry_type)
                                                <option value="{{ $id }}"{{ (old('business_industry') === $id) ? 'selected' : '' }}>
                                                    {{ $industry_type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Person</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_person" name="contact_person" type="text">
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Contact Number</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="contact_number" name="contact_number" type="text">
                                    </div>

                                    <div class="mb-3">
                                        <label class="col-form-label pt-0 primary_font_color" for="">Email</label>
                                        <input class="form-control btn-pill input_bg input-field-color" id="email" name="email" type="text">
                                    </div>

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

                                @for($i = 0; $i < 3; $i++)

                                    <div class="col-3">
                                        <input type="hidden" name="financial_year[{{ $i }}]" value="{{ $first_year + $i }}">
                                        <h5 class="secondary_font_color">{{ $first_year + $i }}</h5>
                                        <p class="secondary_font_color">(RM)</p>
                                    </div>

                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="row">
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
                                                    <tr class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }} m-0 w-100">
                                                        <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'primary_font_color' }} w-25">{{ $comprehensive_arr_item }}</td>

                                                        @for($i = 0; $i < 3; $i++)

                                                            @if($i % 2 == 0)
                                                                <td class="{{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }} w-25">
                                                                    <input type="text" class="number-input border-0 fifth_font_color fw-bold {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : 'input_bg' }} {{ $comprehensive_arr['id'][$comprehensive_arr_key].'_class' }}"
                                                                           name="{{ $comprehensive_arr['id'][$comprehensive_arr_key] }}[{{ $i }}]" id="{{ $comprehensive_arr['id'][$comprehensive_arr_key].'-'.$i }}"
                                                                           value="0" {{ $comprehensive_arr_item == 'Gross Profit' ? 'readonly' : '' }}>
                                                                </td>
                                                            @else
                                                                <td class="w-25">
                                                                    <input type="text" class="number-input border-0 fifth_font_color fw-bold {{ $comprehensive_arr_item == 'Gross Profit' ? 'four_bg_color' : '' }} {{ $comprehensive_arr['id'][$comprehensive_arr_key].'_class' }}"
                                                                           name="{{ $comprehensive_arr['id'][$comprehensive_arr_key] }}[{{ $i }}]" id="{{ $comprehensive_arr['id'][$comprehensive_arr_key].'-'.$i }}"
                                                                           value="0" {{ $comprehensive_arr_item == 'Gross Profit' ? 'readonly' : '' }}>
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
                                                    <tr class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }} w-100">
                                                        <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'primary_font_color' }} w-25">{{ $financial_position_arr_item }}</td>

                                                        @for($i = 0; $i < 3; $i++)

                                                            @if($i % 2 == 0)
                                                                <td class="{{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }} w-25">
                                                                    <input type="text" class="number-input border-0 fifth_font_color fw-bold {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : 'input_bg' }} {{ $financial_position_arr['id'][$financial_position_arr_key].'_class' }}"
                                                                           name="{{ $financial_position_arr['id'][$financial_position_arr_key] }}[{{ $i }}]" id="{{ $financial_position_arr['id'][$financial_position_arr_key].'-'.$i }}"
                                                                           value="0" {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'readonly' : '' }}>
                                                                </td>
                                                            @else
                                                                <td class="w-25">
                                                                    <input type="text" class="number-input border-0 fifth_font_color fw-bold {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'four_bg_color' : '' }} {{ $financial_position_arr['id'][$financial_position_arr_key].'_class' }}"
                                                                           name="{{ $financial_position_arr['id'][$financial_position_arr_key] }}[{{ $i }}]" id="{{ $financial_position_arr['id'][$financial_position_arr_key].'-'.$i }}"
                                                                           value="0" {{ $financial_position_arr_item == 'Total Tangible Net Worth' ? 'readonly' : '' }}>
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
                                                    <tr class="w-100">
                                                        <td class="w-25 primary_font_color">{{ $cash_flow_arr_item }}</td>

                                                        @for($i = 0; $i < 3; $i++)

                                                            @if($i % 2 == 0)
                                                                <td class="input_bg w-25">
                                                                    <input type="text" class="number-input border-0 input_bg fifth_font_color fw-bold {{ $cash_flow_arr['id'][$cash_flow_arr_key].'_class' }}" value="0"
                                                                           name="{{ $cash_flow_arr['id'][$cash_flow_arr_key] }}[{{ $i }}]" id="{{ $cash_flow_arr['id'][$cash_flow_arr_key].'-'.$i }}">
                                                                </td>
                                                            @else
                                                                <td class="w-25">
                                                                    <input type="text" class="number-input border-0 fifth_font_color fw-bold {{ $cash_flow_arr['id'][$cash_flow_arr_key].'_class' }}" value="0"
                                                                           name="{{ $cash_flow_arr['id'][$cash_flow_arr_key] }}[{{ $i }}]" id="{{ $cash_flow_arr['id'][$cash_flow_arr_key].'-'.$i }}">
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

                    <input type="hidden" name="user_id" value="{{ $user_id }}">

                    <div class="mb-4 mt-3 text-end">
                        <button type="submit" class="btn btn-primary-light">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
        <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
        <script>
            $(".select2").select2();

            //calculation start
            $(".turnover_class, .cogs_class").keyup(function (item) {

                for (var i = 0; i < 3; i++){
                    var turnover          = parseFloat(recoverNumberFormat($("#turnover-"+ i).val() ?? 0));
                    var cogs              = parseFloat(recoverNumberFormat($("#cogs-"+ i).val() ?? 0));

                    var gross_profit      = turnover - cogs;

                    $("#gross_profit-"+ i).val(addCommasWithinDecimal(gross_profit.toString()));
                }
            });

            $(".share_capital_class, .retained_earnings_class").keyup(function (item) {

                for (var i = 0; i < 3; i++){
                    var share_capital           = parseFloat(recoverNumberFormat($("#share_capital-"+ i).val() ?? 0));
                    var retained_earnings       = parseFloat(recoverNumberFormat($("#retained_earnings-"+ i).val() ?? 0));

                    var net_worth               = share_capital + retained_earnings;

                    $("#net_worth-"+ i).val(addCommasWithinDecimal(net_worth.toString()));
                }
            });

        </script>
        <!-- bfe script -->
    @endpush
</x-user.app-layout>


