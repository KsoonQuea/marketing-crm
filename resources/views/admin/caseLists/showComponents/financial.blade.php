@php $permission_financial = $permissions['financial']; @endphp
<form method="post" id="financial-form-one" action="{{ route('admin.case-lists.fin-edit-part1', [$caseList->id]) }}">
    @method('put')
    @csrf
    <div class="mb-3 mt-3 table-responsive">
        <table class="table-bordered form-table-two">
            <tbody>
            <tr>
                <td><b>Financial Year</b></td>
                <td>
                    <input class="month-picker month-picker-finance form-control bold-input month-year-input {{ $caseType_class }}" type="text"
                           name="fye_date1" id="fye_date1" value="{{ $fye_1->financial_date??'' }}" placeholder="MM YYYY"/>
                </td>
                <td>
                    <input class="month-picker month-picker-finance form-control bold-input month-year-input {{ $caseType_class }}" type="text"
                           name="fye_date2" id="fye_date2" value="{{ $fye_2->financial_date??'' }}" placeholder="MM YYYY"/>
                </td>
                <td>
                    <input class="month-picker month-picker-finance form-control bold-input month-year-input {{ $caseType_class }}" type="text"
                           name="fye_date3" id="fye_date3" value="{{ $fye_3->financial_date??'' }}" placeholder="MM YYYY"/>
                </td>
            </tr>
            <tr>
                <td><b>Auditor</b></td>
                <td><input type="text" class="bold-input {{ $caseType_class }}" name="fye_auditor1" value="{{ $fye_1->auditor?? '' }}"></td>
                <td><input type="text" class="bold-input {{ $caseType_class }}" name="fye_auditor2" value="{{ $fye_2->auditor?? '' }}"></td>
                <td><input type="text" class="bold-input {{ $caseType_class }}" name="fye_auditor3" value="{{ $fye_3->auditor?? '' }}"></td>
            </tr>
            <tr>
                <td></td>
                <td><b>RM</b></td>
                <td><b>RM</b></td>
                <td><b>RM</b></td>
            </tr>
            <tr>
                <td><b>Non-Current Asset</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_asset1" value="{{ preset_num_decimal_format(($fye_1->non_current_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_asset2" value="{{ preset_num_decimal_format(($fye_2->non_current_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_asset3" value="{{ preset_num_decimal_format(($fye_3->non_current_asset ?? 0)) }}"></td>
            </tr>
            <tr>
                <td><b>Current Asset</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_asset1" value="{{ preset_num_decimal_format(($fye_1->current_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_asset2" value="{{ preset_num_decimal_format(($fye_2->current_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_asset3" value="{{ preset_num_decimal_format(($fye_3->current_asset ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Amount due from directors / related co. / customer</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_asset1" value="{{ preset_num_decimal_format(($fye_1->other_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_asset2" value="{{ preset_num_decimal_format(($fye_2->other_asset ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_asset3" value="{{ preset_num_decimal_format(($fye_3->other_asset ?? 0)) }}"></td>
            </tr>
            <tr>
                <td><b>Non-Current Liabilities</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_liability1" value="{{ preset_num_decimal_format(($fye_1->non_current_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_liability2" value="{{ preset_num_decimal_format(($fye_2->non_current_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_non_current_liability3" value="{{ preset_num_decimal_format(($fye_3->non_current_liabilities ?? 0)) }}"></td>
            </tr>
            <tr>
                <td><b>Current Liabilities</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_liability1" value="{{ preset_num_decimal_format(($fye_1->current_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_liability2" value="{{ preset_num_decimal_format(($fye_2->current_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_liability3" value="{{ preset_num_decimal_format(($fye_3->current_liabilities ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Amount due to directors / related co. / customer</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_liability1" value="{{ preset_num_decimal_format(($fye_1->other_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_liability2" value="{{ preset_num_decimal_format(($fye_2->other_liabilities ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_other_liability3" value="{{ preset_num_decimal_format(($fye_3->other_liabilities ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Current maturity LTD (Term Loan & HP)</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_maturity1" value="{{ preset_num_decimal_format(($fye_1->current_maturity ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_maturity2" value="{{ preset_num_decimal_format(($fye_2->current_maturity ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_current_maturity3" value="{{ preset_num_decimal_format(($fye_3->current_maturity ?? 0)) }}"></td>
            </tr>
            <tr>
                <td colspan="4"><b>Equity</b>
                    <input type="hidden" name="fye_equity1" value="{{ preset_num_decimal_format(($fye_1->equity ?? 0)) }}">
                    <input type="hidden" name="fye_equity2" value="{{ preset_num_decimal_format(($fye_2->equity ?? 0)) }}">
                    <input type="hidden" name="fye_equity3" value="{{ preset_num_decimal_format(($fye_3->equity ?? 0)) }}">
                </td>
            </tr>
            <tr>
                <td>Paid-up Capital (Share Capital)</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="share_capital1" name="share_capital1" onkeyup="newTnwFunc(1)" value="{{ preset_num_decimal_format(($fye_1->share_capital ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="share_capital2" name="share_capital2" onkeyup="newTnwFunc(2)" value="{{ preset_num_decimal_format(($fye_2->share_capital ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="share_capital3" name="share_capital3" onkeyup="newTnwFunc(3)" value="{{ preset_num_decimal_format(($fye_3->share_capital ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Retained earnings</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_retained_earning1" name="fye_retained_earning1" onkeyup="newTnwFunc(1)" value="{{ preset_num_decimal_format(($fye_1->retained_earnings ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_retained_earning2" name="fye_retained_earning2" onkeyup="newTnwFunc(2)" value="{{ preset_num_decimal_format(($fye_2->retained_earnings ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_retained_earning3" name="fye_retained_earning3" onkeyup="newTnwFunc(3)" value="{{ preset_num_decimal_format(($fye_3->retained_earnings ?? 0)) }}"></td>
            </tr>
            <tr class="bg-light-green">
                <td class="bg-light-green"><b>TNW</b></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green" id="fye_tnw1" name="fye_tnw1" value="{{ preset_num_decimal_format(($fye_1->tnw ?? 0)) }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green" id="fye_tnw2" name="fye_tnw2" value="{{ preset_num_decimal_format(($fye_2->tnw ?? 0)) }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green" id="fye_tnw3" name="fye_tnw3" value="{{ preset_num_decimal_format(($fye_3->tnw ?? 0)) }}" readonly></td>
            </tr>
            <tr>
                <td>Revenue</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_revenue1" name="fye_revenue1" onkeyup="grossProfitFunc(1)" value="{{ preset_num_decimal_format(($fye_1->revenue ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_revenue2" name="fye_revenue2" onkeyup="grossProfitFunc(2)" value="{{ preset_num_decimal_format(($fye_2->revenue ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_revenue3" name="fye_revenue3" onkeyup="grossProfitFunc(3)" value="{{ preset_num_decimal_format(($fye_3->revenue ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Cost of Sales / Cost of Goods Sold</td>
{{--                number-decimal-input-negative--}}
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_cost1" name="fye_cost1" onkeyup="grossProfitFunc(1)" value="{{ preset_num_decimal_format(($fye_1->sales_cost ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_cost2" name="fye_cost2" onkeyup="grossProfitFunc(2)" value="{{ preset_num_decimal_format(($fye_2->sales_cost ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_cost3" name="fye_cost3" onkeyup="grossProfitFunc(3)" value="{{ preset_num_decimal_format(($fye_3->sales_cost ?? 0)) }}"></td>
            </tr>
            <tr class="bg-light-green">
                <td class="bg-light-green"><b>Gross profit</b></td>
                @php
                    $fye_gross_profit1 = preset_num_decimal_format(($fye_1->gross_profit ?? 0), 1);
                    $fye_gross_profit2 = preset_num_decimal_format(($fye_2->gross_profit ?? 0), 1);
                    $fye_gross_profit3 = preset_num_decimal_format(($fye_3->gross_profit ?? 0), 1);
                    //if((($fye_1->revenue??0)-($fye_1->sales_cost??0)) < 0){ $fye_gross_profit1 = '('.$fye_gross_profit1.')'; }
                    //if((($fye_2->revenue??0)-($fye_2->sales_cost??0)) < 0){ $fye_gross_profit2 = '('.$fye_gross_profit2.')'; }
                    //if((($fye_3->revenue??0)-($fye_3->sales_cost??0)) < 0){ $fye_gross_profit3 = '('.$fye_gross_profit3.')'; }
                @endphp
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green" id="fye_gross_profit1" name="fye_gross_profit1" value="{{ $fye_gross_profit1 }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green" id="fye_gross_profit2" name="fye_gross_profit2" value="{{ $fye_gross_profit2 }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green   " id="fye_gross_profit3" name="fye_gross_profit3" value="{{ $fye_gross_profit3 }}" readonly></td>
            </tr>
            <tr>
                <td>Finance Cost</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_finance_cost1" name="fye_finance_cost1" onkeyup="ebitdaFunc(1)" value="{{ preset_num_decimal_format(($fye_1->finance_cost ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_finance_cost2" name="fye_finance_cost2" onkeyup="ebitdaFunc(2)" value="{{ preset_num_decimal_format(($fye_2->finance_cost ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_finance_cost3" name="fye_finance_cost3" onkeyup="ebitdaFunc(3)" value="{{ preset_num_decimal_format(($fye_3->finance_cost ?? 0)) }}"></td>
            </tr>
            <tr>
                <td>Depreciation</td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_depreciation1" name="fye_depreciation1" onkeyup="ebitdaFunc(1)" value="{{ preset_num_decimal_format(($fye_1->depreciation ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_depreciation2" name="fye_depreciation2" onkeyup="ebitdaFunc(2)" value="{{ preset_num_decimal_format(($fye_2->depreciation ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_depreciation3" name="fye_depreciation3" onkeyup="ebitdaFunc(3)" value="{{ preset_num_decimal_format(($fye_3->depreciation ?? 0)) }}"></td>
            </tr>
            <tr>
                <td><b>Profit before taxation</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_profit_bfr_tax1" name="fye_profit_bfr_tax1" onkeyup="ebitdaFunc(1)" value="{{ preset_num_decimal_format(($fye_1->profit_bfr_tax ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_profit_bfr_tax2" name="fye_profit_bfr_tax2" onkeyup="ebitdaFunc(2)" value="{{ preset_num_decimal_format(($fye_2->profit_bfr_tax ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" id="fye_profit_bfr_tax3" name="fye_profit_bfr_tax3" onkeyup="ebitdaFunc(3)" value="{{ preset_num_decimal_format(($fye_3->profit_bfr_tax ?? 0)) }}"></td>
            </tr>
            <tr>
                <td><b>Profit after taxation</b></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_profit_aft_tax1" value="{{ preset_num_decimal_format(($fye_1->profit_aft_tax ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_profit_aft_tax2" value="{{ preset_num_decimal_format(($fye_2->profit_aft_tax ?? 0)) }}"></td>
                <td><input type="text" class="number-decimal-input {{ $caseType_class }}" name="fye_profit_aft_tax3" value="{{ preset_num_decimal_format(($fye_3->profit_aft_tax ?? 0)) }}"></td>
            </tr>
            <tr class="bg-light-green">
                <td class="bg-light-green"><b>EBITDA</b></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green {{ $caseType_class }}" id="fye_ebitda1" name="fye_ebitda1" value="{{ preset_num_decimal_format(($fye_1->ebitda ?? 0)) }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green {{ $caseType_class }}" id="fye_ebitda2" name="fye_ebitda2" value="{{ preset_num_decimal_format(($fye_2->ebitda ?? 0)) }}" readonly></td>
                <td class="bg-light-green"><input type="text" class="number-decimal-input bg-light-green {{ $caseType_class }}" id="fye_ebitda3" name="fye_ebitda3" value="{{ preset_num_decimal_format(($fye_3->ebitda ?? 0)) }}" readonly></td>
            </tr>
        </table>
    </div>
    @push('scripts')
        <script>
            function newTnwFunc(x){
                var retained        = recoverNumberFormat($("#fye_retained_earning"+x).val());
                var share_capital   = recoverNumberFormat($("#share_capital"+x).val());
                retained            = isNaN(parseFloat(retained)) ? 0 : parseFloat(retained);
                share_capital       = isNaN(parseFloat(share_capital)) ? 0 : parseFloat(share_capital);
                var total           = retained + share_capital;
                var formatted       = addCommasWithinDecimal(parseFloat(total).toFixed(2).toString());
                $("#fye_tnw"+x).val(formatted)
            }

            function grossProfitFunc(x){
                var revenue     = recoverNumberFormat($("#fye_revenue"+x).val());
                var cost        = recoverNumberFormat($("#fye_cost"+x).val());
                revenue         = isNaN(parseFloat(revenue)) ? 0 : parseFloat(revenue);
                cost            = isNaN(parseFloat(cost)) ? 0 : parseFloat(cost);
                var total       = revenue + cost;
                var formatted       = addCommasWithinDecimal(parseFloat(total).toFixed(2).toString());
                $("#fye_gross_profit"+x).val(formatted);
            }

            function ebitdaFunc(x){
                var finance_cost        = recoverNumberFormat($("#fye_finance_cost"+x).val());
                var fye_depreciation    = recoverNumberFormat($("#fye_depreciation"+x).val());
                var fye_profit_bfr_tax  = recoverNumberFormat($("#fye_profit_bfr_tax"+x).val());
                finance_cost        = isNaN(parseFloat(finance_cost)) ? 0 : parseFloat(finance_cost);
                fye_depreciation    = isNaN(parseFloat(fye_depreciation)) ? 0 : parseFloat(fye_depreciation);
                fye_profit_bfr_tax  = isNaN(parseFloat(fye_profit_bfr_tax)) ? 0 : parseFloat(fye_profit_bfr_tax);
                var total       = finance_cost + fye_depreciation + fye_profit_bfr_tax;
                var formatted       = addCommasWithinDecimal(parseFloat(total).toFixed(2).toString());
                $("#fye_ebitda"+x).val(formatted)
            }
        </script>
    @endpush

    <h5 class="tab-pane-header">Commitment from CCRIS</h5>
    @can('case_financial_edit_2')
        <div class="form-group table-responsive" x-data="case_commitment()">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="68">#</th>
                        <th>{{ trans('cruds.caseCommitment.fields.house_loan') }}</th>
                        <th>{{ trans('cruds.caseCommitment.fields.term_loan') }}</th>
                        <th>{{ trans('cruds.caseCommitment.fields.hire_purchase') }}</th>
                        <th>{{ trans('cruds.caseCommitment.fields.credit_card_limit') }}</th>
                        <th>{{ trans('cruds.caseCommitment.fields.trade_line_limit') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($caseCommitment !== null && count($caseCommitment) > 0)
{{--                        @dd($caseCommitment)--}}
                        @foreach ($caseCommitment as $caseCommitment_key => $caseCommitment_item)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-danger btn-sm removeTable {{ $caseType_class }}"><i class="fa fa-times"></i></button></td>
                                <td><input type="text" name="case_commitment_houseLoan[]"       class="input-num {{ $caseType_class }} case_commitment_houseLoan"    @keyup="CCRISUpdate(); $nextTick(() => reformat());" value="{{ number_format(($caseCommitment_item->house_loan ?? 0), '2', '.', ',') }}"></td>
                                <td><input type="text" name="case_commitment_termLoan[]"        class="input-num {{ $caseType_class }} case_commitment_termLoan"     @keyup="CCRISUpdate(); $nextTick(() => reformat());" value="{{ number_format(($caseCommitment_item->term_loan ?? 0), '2', '.', ',') }}"></td>
                                <td><input type="text" name="case_commitment_hirePurchase[]"    class="input-num {{ $caseType_class }} case_commitment_hirePurchase" @keyup="CCRISUpdate(); $nextTick(() => reformat());" value="{{ number_format(($caseCommitment_item->hire_purchase ?? 0), '2', '.', ',') }}"></td>
                                <td><input type="text" name="case_commitment_cc[]"              class="input-num {{ $caseType_class }} case_commitment_cc"           @keyup="CCRISUpdate(); $nextTick(() => reformat());" value="{{ number_format(($caseCommitment_item->credit_card_limit ?? 0), '2', '.', ',') }}"></td>
                                <td><input type="text" name="case_commitment_trade_line[]"      class="input-num {{ $caseType_class }} case_commitment_trade_line"   @keyup="CCRISUpdate(); $nextTick(() => reformat());" value="{{ number_format(($caseCommitment_item->trade_line_limit ?? 0), '2', '.', ',') }}"></td>
                            </tr>
                        @endforeach
                    @else
                        @for($i = 1; $i <= 6; $i++)
                            <tr>
                                <td class="p-0"><button type="button" class="btn btn-info btn-small {{ $caseType_class }}" disabled><i class="fa fa-minus"></i></button></td>
                                <td><input type="text" name="case_commitment_houseLoan[]"       class="input-num {{ $caseType_class }} case_commitment_houseLoan"    @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                                <td><input type="text" name="case_commitment_termLoan[]"        class="input-num {{ $caseType_class }} case_commitment_termLoan"     @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                                <td><input type="text" name="case_commitment_hirePurchase[]"    class="input-num {{ $caseType_class }} case_commitment_hirePurchase" @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                                <td><input type="text" name="case_commitment_cc[]"              class="input-num {{ $caseType_class }} case_commitment_cc"           @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                                <td><input type="text" name="case_commitment_trade_line[]"      class="input-num {{ $caseType_class }} case_commitment_trade_line"   @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                            </tr>
                        @endfor
                    @endif
                    <template x-for="(field, index) in fields" :key="index">
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-danger btn-small {{ $caseType_class }}" @click="removeField(index)"><i class="fa fa-times"></i></button></td>
                            <td><input x-model="field.case_commitment_houseLoan"    type="text" name="case_commitment_houseLoan[]"      class="input-num {{ $caseType_class }} case_commitment_houseLoan"    @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                            <td><input x-model="field.case_commitment_termLoan"     type="text" name="case_commitment_termLoan[]"       class="input-num {{ $caseType_class }} case_commitment_termLoan"     @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                            <td><input x-model="field.case_commitment_hirePurchase" type="text" name="case_commitment_hirePurchase[]"   class="input-num {{ $caseType_class }} case_commitment_hirePurchase" @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                            <td><input x-model="field.case_commitment_cc"           type="text" name="case_commitment_cc[]"             class="input-num {{ $caseType_class }} case_commitment_cc"           @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                            <td><input x-model="field.case_commitment_trade_line"   type="text" name="case_commitment_trade_line[]"     class="input-num {{ $caseType_class }} case_commitment_trade_line"   @keyup="CCRISUpdate(); $nextTick(() => reformat());"></td>
                        </tr>
                    </template>
                    <tr>
                        <td class="p-0" colspan="6"><button type="button" class="btn btn-primary float-end w-100 {{ $caseType_class }}" @click="addNewField()">+ Add Row</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-light-green">
                        <th width="68">Sub-Total:</th>
                        <th><input type="text" readonly name="total_caseCommitment_hl" id="total_caseCommitment_hl" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th><input type="text" readonly name="total_caseCommitment_tl" id="total_caseCommitment_tl" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th><input type="text" readonly name="total_caseCommitment_hp" id="total_caseCommitment_hp" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th><input type="text" readonly name="total_caseCommitment_cc" id="total_caseCommitment_cc" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th><input type="text" readonly name="total_caseCommitment_trade_line" id="total_caseCommitment_trade_line" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                    </tr>
                    <tr class="bg-light-green">
                        <th colspan="4">Interest per annum:</th>
                        <th><input type="text" readonly name="total_caseCommitment_cc_charge" id="total_caseCommitment_cc_charge" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th><input type="text" readonly name="total_caseCommitment_trade_line_charge" id="total_caseCommitment_trade_line_charge" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                    </tr>
                    <tr class="bg-light-green border-top-black">
                        <th>Total :</th>
                        <th><input type="text" readonly name="final_total_caseCommitment" id="final_total_caseCommitment" class="bg-light-green {{ $caseType_class }}" value="0"></th>
                        <th colspan="4"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="mb-3 table-responsive">
            <table class="table-bordered form-table-two">
                <thead class="text-center">
                    <tr>
                        <th width="68">#</th>
                        <th>HL</th>
                        <th>TL/PL</th>
                        <th>HP</th>
                        <th>CC Limit</th>
                        <th colspan="2">OD & Trade Line Limit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($case_commitment_loop as $case_commitment_loop_item)
                        <tr>
                            <th class="p-0"></th>
                            <td><input type="text" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment_loop_item->house_loan ?? 0), '2', '.', ',') }}" readonly/></td>
                            <td><input type="text" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment_loop_item->term_loan ?? 0), '2', '.', ',') }}" readonly/></td>
                            <td><input type="text" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment_loop_item->hire_purchase ?? 0), '2', '.', ',') }}" readonly/></td>
                            <td><input type="text" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment_loop_item->credit_card_limit ?? 0), '2', '.', ',') }}" readonly/></td>
                            <td><input type="text" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment_loop_item->trade_line_limit ?? 0), '2', '.', ',') }}" readonly/></td>
                        </tr>
                    @endforeach
                    <tr class="tr-top-border">
                        <th>Sub-Total :</th>
                        <td><input type="text" readonly name="total_caseCommitment_hl" id="total_caseCommitment_hl" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->total_hl?? 0), '2', '.', ',') }}"></td>
                        <td><input type="text" readonly name="total_caseCommitment_tl" id="total_caseCommitment_tl" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->total_tl?? 0), '2', '.', ',') }}"></td>
                        <td><input type="text" readonly name="total_caseCommitment_hp" id="total_caseCommitment_hp" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->total_hp?? 0), '2', '.', ',') }}"></td>
                        <td><input type="text" readonly name="total_caseCommitment_cc" id="total_caseCommitment_cc" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->total_cc?? 0), '2', '.', ',') }}"></td>
                        <td><input type="text" readonly name="total_caseCommitment_trade_line" id="total_caseCommitment_trade_line" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->total_trade_line?? 0), '2', '.', ',') }}"></td>
                    </tr>
                    <tr>
                        <th colspan="4">Interest per annum:</th>
                        <td><input type="text" readonly name="total_caseCommitment_cc_charge" id="total_caseCommitment_cc_charge" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->cc_charge?? 0), '2', '.', ',') }}"></td>
                        <td><input type="text" readonly name="total_caseCommitment_trade_line_charge" id="total_caseCommitment_trade_line_charge" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->tl_charge?? 0), '2', '.', ',') }}"></td>
                    </tr>
                    <tr class="tr-top-border">
                        <th>Total :</th>
                        <td><input type="text" readonly name="final_total_caseCommitment" id="final_total_caseCommitment" class="input-num {{ $caseType_class }}" value="{{ number_format(($case_commitment->final_total?? 0), '2', '.', ',') }}"></td>
                        <th colspan="4"></th>
                    </tr>
                </tbody>
            </table>
        </div>
    @endcan
    @push('scripts')
        <script>
            // pre-run calculation
            function caseCommitmentCalculate(){
                // HL calculate
                var total_hl = 0
                var total_tl = 0
                var total_hp = 0
                var total_cc = 0
                var total_od = 0

                $(".case_commitment_houseLoan").each(function () {
                    var hl = recoverNumberFormat($(this).val());
                    hl = isNaN(parseFloat(hl)) ? 0 : parseFloat(hl);
                    total_hl += hl;
                })

                $(".case_commitment_termLoan").each(function () {
                    var tl = recoverNumberFormat($(this).val());
                    tl = isNaN(parseFloat(tl)) ? 0 : parseFloat(tl);
                    total_tl += tl;
                })

                $(".case_commitment_hirePurchase").each(function () {
                    var hp = recoverNumberFormat($(this).val());
                    hp = isNaN(parseFloat(hp)) ? 0 : parseFloat(hp);
                    total_hp += hp;
                })

                $(".case_commitment_cc").each(function () {
                    var cc = recoverNumberFormat($(this).val());
                    cc = isNaN(parseFloat(cc)) ? 0 : parseFloat(cc);
                    total_cc    += cc;
                })

                $(".case_commitment_trade_line").each(function () {
                    var od = recoverNumberFormat($(this).val());
                    od = isNaN(parseFloat(od)) ? 0 : parseFloat(od);
                    total_od += od;
                })

                $("#total_caseCommitment_hl").val(addCommasWithinDecimal(total_hl.toFixed(2)));
                $("#total_caseCommitment_tl").val(addCommasWithinDecimal(total_tl.toFixed(2)));
                $("#total_caseCommitment_hp").val(addCommasWithinDecimal(total_hp.toFixed(2)));
                $("#total_caseCommitment_cc").val(addCommasWithinDecimal(total_cc.toFixed(2)));
                $("#total_caseCommitment_trade_line").val(addCommasWithinDecimal(total_od.toFixed(2)));

                var total_cc_charge = total_cc * 5 / 100;
                var total_od_charge = total_od * 7 / 100 * 80 /100 / 12;
                $("#total_caseCommitment_cc_charge").val(addCommasWithinDecimal(total_cc_charge.toFixed(2)));
                $("#total_caseCommitment_trade_line_charge").val(addCommasWithinDecimal(total_od_charge.toFixed(2)));

                var final_total = total_hl + total_tl + total_hp + total_cc_charge + total_od_charge
                $("#final_total_caseCommitment").val(addCommasWithinDecimal(final_total.toFixed(2)));
                keyNumber();
                addDecimal();
            }
            $(document).ready(function() {
                caseCommitmentCalculate();
            });
            // x-data
            function case_commitment() {
                return {
                    fields: [
                        // {
                        //     case_commitment_houseLoan: 100,
                        //     case_commitment_termLoan: 0,
                        //     case_commitment_hirePurchase: 0,
                        //     case_commitment_cc: 0,
                        //     case_commitment_trade_line: 0,
                        // },
                    ],
                    addNewField() {
                        this.fields.push({
                            case_commitment_houseLoan: 0,
                            case_commitment_termLoan: 0,
                            case_commitment_hirePurchase: 0,
                            case_commitment_cc: 0,
                            case_commitment_trade_line: 0,
                        });
                    },
                    removeField(index) {
                        this.fields.splice(index, 1);
                        this.CCRISUpdate();
                    },
                    CCRISUpdate(){
                        caseCommitmentCalculate();
                    },
                    reformat(){
                        this.fields.forEach(function(item, key) {
                            item.case_commitment_houseLoan      = addCommas(item.case_commitment_houseLoan.toString());
                            item.case_commitment_termLoan       = addCommas(item.case_commitment_termLoan.toString());
                            item.case_commitment_hirePurchase   = addCommas(item.case_commitment_hirePurchase.toString());
                            item.case_commitment_cc             = addCommas(item.case_commitment_cc.toString());
                            item.case_commitment_trade_line     = addCommas(item.case_commitment_trade_line.toString());
                        });
                        formatter_init();
                    }
                }
            };

            // format input number commas and decimal(3 func)
            function keyNumber() {
                $(".input-num").on({
                    keyup: function() {
                        console.log($(this).val());
                        console.log($(this).val().indexOf('('));

                        if ($(this).val().indexOf('(') != -1 || $(this).val().indexOf(')') != -1) {
                            addDecimal($(this));
                        }
                        else {
                            addDecimal($(this));
                        }


                        console.log($(this).val());
                    },
                    blur: function() {
                        addDecimal($(this), "blur");
                    }
                });
            }

            function formatNumber(n) {
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }

            function addDecimal(input, blur) {
                var input_val = input.val();

                if (input_val.substring(0, 1) === "0") {
                    input_val = input_val.substring(1);
                }

                if (input_val === "") {
                    return ;
                }

                if (input_val.indexOf(".") >= 0) {
                    var decimal_pos = input_val.indexOf(".");
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    if (left_side === "") {
                        left_side = "0";
                    }

                    left_side = formatNumber(left_side);
                    right_side = formatNumber(right_side);

                    if (blur === "blur") {
                        right_side += "00";
                    }
                    right_side = right_side.substring(0, 2);
                    input_val = left_side + "." + right_side;

                } else {
                    input_val = formatNumber(input_val);
                    input_val = input_val;

                    if (blur === "blur") {
                        input_val += ".00";
                    }
                }
                    input.val(input_val);
            };
        </script>
    @endpush

    @if($caseType_num != 2 && $caseType_num != 3)
    @can('case_financial_edit_2')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-sm {{ $caseType_class }}">
                <i class="fa fa-edit me-2"></i>
                Save & Update
            </button>
            <hr>
        </div>
    @endcan
    @endif
</form>

<form method="post" id="financial-form-two" action="{{ route('admin.case-lists.fin-edit-part2', [$caseList->id]) }}">
    @method('PUT')
    @csrf

    {{-- dsr part --}}
    <h5 class="tab-pane-header">New DSR based on commitment as per CCRIS & Bank Statement</h5> &nbsp;
    <div class="mb-3 table-responsive">
        <table class="table-bordered form-table-two">
            <tbody class="edit-tbody">
                <tr>
                    <th width="300">Latest EBITDA</th>
                    <td><input type="text" class="{{ $caseType_class }}" min="0" id="dsr_ebitda" value="{{ number_format($dsr->latest_ebitda ?? 0, 2, '.', ',') }}" readonly></td>
                </tr>
                <tr>
                    <th>Commitment as per CCRIS</th>
                    <td><input type="text" class="{{ $caseType_class }}" min="0" id="dsr_ccris_commitment" value="{{ number_format($dsr->commitment_as_per_ccris ?? 0, 2, '.', ',') }}" readonly></td>
                </tr>
                <tr>
                    <th>Commitment as per Bank Statement</th>
                    <td><input type="text" min="0" id="dsr_bankStt_commitment" name="dsr_bankStt_commitment" class="number-decimal-input {{ $caseType_class }}" onkeyup="dsrCalculate()" value="{{ preset_num_decimal_format($caseList->dsr_bankStt_commitment ?? 0) }}"></td>
                </tr>
                <tr>
                    <th>New Financing Commitment</th>
                    <td><input type="text" class="{{ $caseType_class }}" min="0" id="dsr_financing_commitment" value="{{ number_format(($pcr_display['nfc_per_annum']??0), 2, '.', ',') }}" readonly></td>
                    {{--{{ number_format($dsr->total_financing_commitment ?? 0, 0, '.', ',') }}--}}
                </tr>
                <tr>
                    <th>DSR</th>
                    <td><input type="text" class="{{ $caseType_class }}" readonly id="dsr" value="0.00"></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- cash flow part --}}
    <h5 class="tab-pane-header">Cash flow VS monthly commitment</h5> &nbsp;
    <div class="mb-3 table-responsive">
        <table class="table-bordered form-table-two">
            <tbody class="edit-tbody">
                <tr>
                    <th style="width: 35%;">Average month end bank balances</th>
                    <td style="width: 15%;"><input type="text" class="text-input-class {{ $caseType_class }}" id="cash_flow_bankStt_month" onkeyup="cashFlowCalculate()" value="{{ number_format($cash_flow->bankStt_credit ?? 0, 2, '.', ',') }}" readonly></td>
                    <th style="width: 35%;"></th>
                    <th style="width: 15%;"></th>
                </tr>
                <tr>
                    <th>Average monthly credit trasactions</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_bankStt_credit" onkeyup="cashFlowCalculate()" value="{{ number_format($cash_flow->bankStt_month ?? 0, 2, '.', ',') }}" readonly></td>
                    <th>Annualized Revenue</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_revenue" value="0" readonly></td>
                </tr>
                <tr>
                    <th>Monthly commitment</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_case_commitment_total" onkeyup="cashFlowCalculate()" value="{{ number_format($cash_flow->case_commitment_total ?? 0, 2, '.', ',') }}" readonly></td>
                    <th>Income factor @ %</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_factor" name="cash_flow_factor" onkeyup="cashFlowCalculate()" value="{{ number_format($caseList->cash_flow_factor ?? 0, 2, '.', ',') }}"></td>
                </tr>
                <tr>
                    <th>Total monthly commitment for directors</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_director_commitment_total" onkeyup="cashFlowCalculate()" value="{{ number_format($cash_flow->director_commitment_total ?? 0, 2, '.', ',') }}" readonly></td>
                    <th>DSR</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_dsr" value="0.00" readonly></td>
                </tr>
                <tr>
                    <th>Total monthly commitment of directors and company</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="cash_flow_commitment_and_director_commitment" value="0.00" readonly></td>
                    <th></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- gearing part --}}
    <h5 class="tab-pane-header">Gearing</h5> &nbsp;
    <div class="mb-3 table-responsive">
        <table class="table-bordered form-table-two">
            <tbody class="edit-tbody">
                <tr>
                    <th>Item</th>
                    <th>O/S as @ <input type="date" name="gearing_date" class="text-input-class w-25 {{ $caseType_class }}" value="{{ $caseList->gearing_date }}"></th>
                </tr>
                <tr>
                    <th>Total Borrowings (CCRIS & BS)</th>
                    <td><input type="text" min="0" class="text-input-class number-decimal-input {{ $caseType_class }}" id="gearing_borrow" name="gearing_borrow" onkeyup="gearingCalculationFunc()" value="{{ preset_num_decimal_format($caseList->gearing_borrow ?? 0) }}"></td>
                </tr>
                <tr>
                    <th>(+) New Financing Amount</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="gearing_new_financing_amount" onkeyup="gearingCalculationFunc()" value="{{ number_format($case_gearing->new_financing_amount ?? 0, 2, '.', ',') }}" readonly>
                    </td>
                </tr>
                <tr>
                    <th>(-) Redemtion from Bank</th>
                    <td><input type="text" min="0" class="text-input-class number-decimal-input {{ $caseType_class }}" id="gearing_redemtion" name="gearing_redemtion" onkeyup="gearingCalculationFunc()" value="{{ preset_num_decimal_format($caseList->gearing_redemtion ?? 0) }}"></td>
                </tr>
                <tr>
                    <th>Sub-Total (a)</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="gearing_sub_total" onkeyup="gearingCalculationFunc()" value="0.00" readonly></td>
                </tr>
                <tr>
                    <th>Total TNW (b)</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="gearing_total_tnw" onkeyup="gearingCalculationFunc()" value="{{ number_format($case_gearing->total_tnw ?? 0 , 2, '.', ',')}}" readonly></td>
                </tr>
                <tr>
                    <th>Gearing Ratio (a) ÷ (b)</th>
                    <td><input type="text" min="0" class="text-input-class {{ $caseType_class }}" id="gearing_ratio" value="0" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- financial instruments part --}}
    <h5 class="tab-pane-header">New Financing Instruments</h5>
    <div class="form-group table-responsive">
        <table class="table-bordered form-table-two">
            <tbody class="edit-tbody">
                <tr>
                    <th>{{ trans('cruds.financingInstrument.fields.loan_product') }}</th>
                    <th>{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</th>
                    <th>{{ trans('cruds.financingInstrument.fields.interest_rate') }}</th>
                    <th>{{ trans('cruds.financingInstrument.fields.tenor') }}</th>
                    <th>{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
                </tr>
            @forelse ($case_financingInstruments_loan as $financingInstrument_value => $financingInstrument_item)
                <input type="hidden" name="financingInstrument_id[]" value="{{ $financingInstrument_item->financing_instrument->id }}">
                <input type="hidden" name="financingInstrument_edit_type[]" value="{{ $financingInstrument_item->financing_instrument->able_edit_type }}">
                <tr>
                    <td class="bold-title">
                        {{ $financingInstrument_item->financing_instrument->loan_product }}
                    </th>
                    <td>
                        <input type="text" class="{{ $caseType_class }} financingInstrument_proposed_limit_loan number-decimal-input" id="financingInstrument_proposed_limit_loan-{{ $financingInstrument_value }}" name="financingInstrument_propose_limit[]"
                               value="{{ number_format($financingInstrument_item->proposed_limit, 2, '.', ',') }}" onkeyup="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})">
                    </td>
                    <td>
                        <input type="number" class="{{ $caseType_class }} text-input-class show_increment_firefox show_increment_normal" id="financingInstrument_interest_rate_loan-{{ $financingInstrument_value }}" name="financingInstrument_interest_rate[]"
                               min="0.000" step="0.001" value="{{ number_format($financingInstrument_item->interest_rate, 3, '.', ',') }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})">
                    </td>
                    <td>
                        @if($financingInstrument_item->financing_instrument->able_edit_type == 0)
                            <input type="text" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})" readonly
                                   class="text-input-class {{ $caseType_class }}" value="{{$financingInstrument_item->financing_instrument->tenor }}">
                        @elseif($financingInstrument_item->financing_instrument->able_edit_type == 1)
                            <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})"
                                   class="text-input-class w-25 show_increment_firefox show_increment_normal {{ $caseType_class }}" value="{{ $financingInstrument_item->tenor }}">
                            years
                        @elseif($financingInstrument_item->financing_instrument->able_edit_type == 2)
                            <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})"
                                   class="text-input-class w-25 show_increment_firefox show_increment_normal {{ $caseType_class }}" value="{{ number_format($financingInstrument_item->tenor , 0, '.', ',') }}">
                            months
                        @endif
                    </td>
                    <td><input type="text" class="text-input-class number-decimal-input financingInstrument_commitment_loan {{ $caseType_class }}" id="financingInstrument_commitment_loan-{{ $financingInstrument_value }}" name="financingInstrument_commitment[]" value="{{ number_format($financingInstrument_item->commitments ?? 0,2, '.', ',') }}"></td>
                </tr>
            @empty
                @foreach($financingInstruments_loan as $financingInstrument_value => $financingInstrument_item)
                    <tr>
                        <input type="hidden" name="financingInstrument_id[]" value="{{ $financingInstrument_item->id }}">
                        <input type="hidden" name="financingInstrument_edit_type[]" value="{{ $financingInstrument_item->able_edit_type }}">
                        <th>{{ checkNULL($financingInstrument_item->loan_product) }}</th>
                        <td><input type="text" class="number-decimal-input financingInstrument_proposed_limit_loan {{ $caseType_class }}" name="financingInstrument_propose_limit[]" id="financingInstrument_proposed_limit_loan-{{ $financingInstrument_value }}" onkeyup="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="w-100 financingInstrument_proposed_limit_loan"></td>
                        <td><input type="number" class="text-input-class show_increment_firefox show_increment_normal {{ $caseType_class }}" name="financingInstrument_interest_rate[]" id="financingInstrument_interest_rate_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="w-100 show_increment_firefox show_increment_normal" value="{{ number_format($financingInstrument_item->interest_rate, '3') }}" min="0.000" step="0.001"></td>
                        <td>
                            @if($financingInstrument_item->able_edit_type == 0)
                                <input type="text" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" readonly class="text-input-class {{ $caseType_class }}" value="{{ $financingInstrument_item->tenor }}">
                            @elseif($financingInstrument_item->able_edit_type == 1)
                                <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->tenor_number }}">
                                years
                            @elseif($financingInstrument_item->able_edit_type == 2)
                                <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_loan-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->tenor_number }}">
                                months
                            @endif
                        </td>
                        <td><input type="text" name="financingInstrument_commitment[]" id="financingInstrument_commitment_loan-{{ $financingInstrument_value }}" class="{{ $caseType_class }} financingInstrument_commitment_loan text-input-class" value="0" readonly></td>
                    </tr>
                @endforeach
            @endforelse
                <tr>
                    <th>Total:</th>
                    <td><input type="text" name="financingInstrument_total_propose_loan" id="financingInstrument_total_propose_loan" class="border-0 {{ $caseType_class }}" readonly></td>
                    <td colspan="2"></td>
                    <td><input type="text" name="financingInstrument_total_commitment_loan" id="financingInstrument_total_commitment_loan" class="border-0 {{ $caseType_class }}" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- 2CapBoost -->
    <div class="form-group table-responsive">
        <table class="table-bordered form-table-two">
            <tbody class="edit-tbody">
            <tr>
                <th>CapBoost{{ trans('cruds.financingInstrument.fields.loan_product') }}</th>
                <th>CapBoost{{ trans('cruds.caseFinancingInstrument.fields.proposed_limit') }}</th>
                <th>CapBoost{{ trans('cruds.financingInstrument.fields.interest_rate') }}</th>
                <th>CapBoost{{ trans('cruds.financingInstrument.fields.tenor') }}</th>
                <th>CapBoost{{ trans('cruds.caseFinancingInstrument.fields.commitment') }}</th>
            </tr>

            @forelse ($case_financingInstruments_capboost as $financingInstrument_value => $financingInstrument_item)
                <input type="hidden" name="financingInstrument_id_capboost[]" value="{{ $financingInstrument_item->financing_instrument->id }}">
                <tr>
                    <td class="bold-title">{{ $financingInstrument_item->financing_instrument->loan_product }}</th>
                    <td><input type="text" class="financingInstrument_propose_limit_capboost {{ $caseType_class }} number-decimal-input" id="financingInstrument_proposed_limit_capboost-{{ $financingInstrument_value }}" name="financingInstrument_propose_limit_capboost[]"
                               value="{{ number_format($financingInstrument_item->proposed_limit, 2, '.', ',') }}" onkeyup="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})">
                    </td>
                    <td><input type="number" class="show_increment_firefox show_increment_normal {{ $caseType_class }}" id="financingInstrument_interest_rate_capboost-{{ $financingInstrument_value }}" name="financingInstrument_interest_rate_capboost[]"
                           min="0.000" step="0.001" value="{{ number_format($financingInstrument_item->interest_rate, 3) }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})">
                    </td>
                    <td>
                        @if($financingInstrument_item->financing_instrument->able_edit_type == 0)
                            <input type="text" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})" readonly class="text-input-class {{ $caseType_class }}" value="{{ $financingInstrument_item->financing_instrument->tenor }}">
                        @elseif($financingInstrument_item->financing_instrument->able_edit_type == 1)
                            <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->financing_instrument->tenor_number }}">
                            years
                        @elseif($financingInstrument_item->financing_instrument->able_edit_type == 2)
                            <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->financing_instrument->tenor_number }}, {{ $financingInstrument_item->financing_instrument->tenor_month }}, {{ $financingInstrument_item->financing_instrument->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->financing_instrument->tenor_number }}">
                            months
                        @endif
                    </td>
                    <td><input type="text" class="{{ $caseType_class }} text-input-class input-num financingInstrument_commitment_capboost" name="financingInstrument_commitment_capboost[]" id="financingInstrument_commitment_capboost-{{ $financingInstrument_value }}" value="{{ number_format($financingInstrument_item->commitments ?? 0, 2, '.', ',') }}"></td>
                </tr>
            @empty
                @foreach($financingInstruments_capboost as $financingInstrument_value => $financingInstrument_item)
                    <input type="hidden" name="financingInstrument_id_capboost[]" value="{{ $financingInstrument_item->id }}">
                    <tr>
                        <th>{{ checkNULL($financingInstrument_item->loan_product) }}</th>
                        <td><input type="text" class="{{ $caseType_class }} financingInstrument_propose_limit_capboost number-decimal-input" name="financingInstrument_propose_limit_capboost[]" id="financingInstrument_proposed_limit_capboost-{{ $financingInstrument_value }}" onkeyup="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="w-100 financingInstrument_proposed_limit_loan"></td>
                        <td><input type="number" class="{{ $caseType_class }} show_increment_firefox show_increment_normal" name="financingInstrument_interest_rate_capboost[]" id="financingInstrument_interest_rate_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="w-100 show_increment_firefox show_increment_normal" value="{{ number_format($financingInstrument_item->interest_rate, '3') }}" min="0.000" step="0.001"></td>
                        <td>
                            @if($financingInstrument_item->able_edit_type == 0)
                                <input type="text" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" readonly class="text-input-class {{ $caseType_class }}" value="{{ $financingInstrument_item->tenor }}">
                            @elseif($financingInstrument_item->able_edit_type == 1)
                                <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->tenor_number }}">
                                years
                            @elseif($financingInstrument_item->able_edit_type == 2)
                                <input type="number" name="financingInstrument_tenor_input[]" id="financingInstrument_tenor_input_capboost-{{ $financingInstrument_value }}" onchange="financingInstrumentCalculateFunc({{ $financingInstrument_value }}, {{ $financingInstrument_item->tenor_number }}, {{ $financingInstrument_item->tenor_month }}, {{ $financingInstrument_item->able_edit_type }})" class="{{ $caseType_class }} text-input-class w-25 show_increment_firefox show_increment_normal" value="{{ $financingInstrument_item->tenor_number }}">
                                months
                            @endif
                        </td>
                        <td><input type="text" name="financingInstrument_commitment_capboost[]" id="financingInstrument_commitment_capboost-{{ $financingInstrument_value }}" class="{{ $caseType_class }} financingInstrument_commitment_capboost text-input-class" value="0" readonly></td>
                    </tr>
                @endforeach
            @endforelse
                <tr>
                    <th>Total:</th>
                    <td><input type="text" name="financingInstrument_total_propose_capboost" id="financingInstrument_total_propose_capboost" class="border-0 {{ $caseType_class }}" readonly></td>
                    <td colspan="2"></td>
                    <td><input type="text" name="financingInstrument_total_commitment_capboost" id="financingInstrument_total_commitment_capboost" class="border-0 {{ $caseType_class }}" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>

    @if($caseType_num != 2 && $caseType_num != 3)
    @can('case_financial_credit_edit_2')
        <div class="mt-4">
            <button type="submit" class="btn btn-primary btn-sm {{ $caseType_class }}">
                <i class="fa fa-edit me-2"></i>
                Save & Update
            </button>
        </div>
    @endcan
    @endif
</form>
@push('scripts')
    <script>
        //cashFlow function run
        function cashFlowCalculate() {
            var cash_flow_bankStt_credit            = parseFloat($("#cash_flow_bankStt_credit").val()) ? parseFloat($("#cash_flow_bankStt_credit").val().replace(/,/g, '')) : 0 //E49
            var cash_flow_bankStt_month             = parseFloat($("#cash_flow_bankStt_month").val()) ? parseFloat($("#cash_flow_bankStt_month").val().replace(/,/g, '')) : 0 //E50
            var cash_flow_case_commitment_total     = parseFloat($("#cash_flow_case_commitment_total").val()) ? parseFloat($("#cash_flow_case_commitment_total").val().replace(/,/g, '')) : 0 //E51
            var cash_flow_director_commitment_total = parseFloat($("#cash_flow_director_commitment_total").val()) ? parseFloat($("#cash_flow_director_commitment_total").val().replace(/,/g, '')) : 0 //E52
            var cash_flow_factor                    = parseFloat($("#cash_flow_factor").val()) ? parseFloat($("#cash_flow_factor").val().replace(/,/g, '')) : 0

            var dsr_ccris_commitment        = parseFloat($("#dsr_ccris_commitment").val()) ? parseFloat($("#dsr_ccris_commitment").val().replace(/,/g, '')) : 0
            var dsr_bankStt_commitment      = parseFloat($("#dsr_bankStt_commitment").val()) ? parseFloat($("#dsr_bankStt_commitment").val().replace(/,/g, '')) : 0
            var dsr_financing_commitment    = parseFloat($("#dsr_financing_commitment").val()) ? parseFloat($("#dsr_financing_commitment").val().replace(/,/g, '')) : 0

            var cash_flow_case_n_director_commitment_total = cash_flow_case_commitment_total + cash_flow_director_commitment_total;
            var cash_flow_renevue   = cash_flow_bankStt_month * 12;
            var cash_flow_dsr       = (cash_flow_bankStt_credit * cash_flow_factor / 100) / (dsr_financing_commitment + dsr_ccris_commitment + dsr_bankStt_commitment)

            $("#cash_flow_factor").val(addCommasWithinDecimal(cash_flow_factor.toFixed(2)));

            $('#cash_flow_commitment_and_director_commitment').val(addCommasWithinDecimal((isNaN(cash_flow_case_n_director_commitment_total) ? 0 : cash_flow_case_n_director_commitment_total).toFixed(2)))
            $('#cash_flow_revenue').val(addCommasWithinDecimal((isNaN(cash_flow_renevue) ? 0 : cash_flow_renevue).toFixed(2)))
            $('#cash_flow_dsr').val((!isFinite(cash_flow_dsr) ? 0 : cash_flow_dsr).toFixed(2))
        }

        //gearing calculation
        function gearingCalculationFunc() {
            var gearing_borrow                  = $("#gearing_borrow").val() ? parseFloat($("#gearing_borrow").val().replace(/,/g, '').replace('(', '').replace(')', '')) : 0
            var gearing_new_financing_amount    = parseFloat($("#gearing_new_financing_amount").val()) ? parseFloat($("#gearing_new_financing_amount").val().replace(/,/g, '')) : 0
            var gearing_redemtion               = $("#gearing_redemtion").val() ? parseFloat($("#gearing_redemtion").val().replace(/,/g, '').replace('(', '').replace(')', '')) : 0
            var gearing_tnw                     = parseFloat($("#gearing_total_tnw").val()) ? parseFloat($("#gearing_total_tnw").val().replace(/,/g, '')) : 0

            if ($("#gearing_borrow").val().toString().includes('(')){
                gearing_borrow = '-'+gearing_borrow
                gearing_borrow = parseFloat(gearing_borrow.toString())
            }

            if ($("#gearing_redemtion").val().toString().includes('(')){
                gearing_redemtion = '-'+gearing_redemtion
                gearing_redemtion = parseFloat(gearing_redemtion.toString())
            }

            // $('#gearing_borrow').val(addCommasWithinDecimal(parseFloat($("#gearing_borrow").val()).toFixed(2)))
            // $('#gearing_redemtion').val(addCommasWithinDecimal(parseFloat($("#gearing_redemtion").val()).toFixed(2)))

            var sub_total = gearing_borrow + gearing_new_financing_amount - gearing_redemtion

            console.log(gearing_borrow)
            console.log(gearing_redemtion)
            console.log(sub_total)

            $('#gearing_sub_total').val(addCommasWithinDecimal((isNaN(sub_total) ? 0 : sub_total).toFixed(2)))

            var ratio = sub_total / gearing_tnw

            $('#gearing_ratio').val(isNaN(ratio) ? 0 : ratio.toFixed(2))
        }

        function gearing_financingAmtCalculate(){
            var total_propose_loan      = parseFloat($("#financingInstrument_total_propose_loan").val()) ? parseFloat($("#financingInstrument_total_propose_loan").val().replace(/,/g, '')) : 0
            var total_propose_capboost  = parseFloat($("#financingInstrument_total_propose_capboost").val()) ? parseFloat($("#financingInstrument_total_propose_capboost").val().replace(/,/g, '')) : 0

            var sum_up = addCommasWithinDecimal((total_propose_loan + total_propose_capboost).toFixed(2));
            $('#gearing_new_financing_amount').val(sum_up);
            $('#pcr_new_amount').html(sum_up);
            gearing_subTotalCalculate()
        }

        function gearing_subTotalCalculate(){
            var gearing_borrow                  = parseFloat($("#gearing_borrow").val()) ? parseFloat($("#gearing_borrow").val().replace(/,/g, '')) : 0
            var gearing_new_financing_amount    = parseFloat($("#gearing_new_financing_amount").val()) ? parseFloat($("#gearing_new_financing_amount").val().replace(/,/g, '')) : 0
            var gearing_redemtion               = parseFloat($("#gearing_redemtion").val()) ? parseFloat($("#gearing_redemtion").val().replace(/,/g, '')) : 0

            $('#gearing_sub_total').val(addCommasWithinDecimal((gearing_borrow + gearing_new_financing_amount - gearing_redemtion).toFixed(2)))

            gearing_ratioCalculate()
        }

        function gearing_ratioCalculate(){
            var gearing_sub_total    = parseFloat($("#gearing_sub_total").val()) ? parseFloat($("#gearing_sub_total").val().replace(/,/g, '')) : 0
            var gearing_total_tnw    = parseFloat($("#gearing_total_tnw").val()) ? parseFloat($("#gearing_total_tnw").val().replace(/,/g, '')) : 0

            $('#gearing_ratio').val((isNaN(gearing_sub_total / gearing_total_tnw) ? 0 : gearing_sub_total / gearing_total_tnw).toFixed(2))
        }

        //dsr function run
        function dsrCalculate() {
            var dsr_ebita                   = parseFloat($('#dsr_ebitda').val())                ? parseFloat($('#dsr_ebitda').val().replace(/,/g, ''))                  : 0
            var dsr_ccris_commitment        = parseFloat($('#dsr_ccris_commitment').val())      ? parseFloat($('#dsr_ccris_commitment').val().replace(/,/g, ''))        : 0
            var dsr_bankStt_commitment      = $('#dsr_bankStt_commitment').val()                ? parseFloat($('#dsr_bankStt_commitment').val().replace(/,/g, '').replace('(', '').replace(')', ''))      : 0
            var dsr_financing_commitment    = parseFloat($('#dsr_financing_commitment').val())  ? parseFloat($('#dsr_financing_commitment').val().replace(/,/g, ''))    : 0

            if ($("#dsr_bankStt_commitment").val().toString().includes('(')){
                dsr_bankStt_commitment = '-'+dsr_bankStt_commitment
                dsr_bankStt_commitment = parseFloat(dsr_bankStt_commitment.toString())
            }

            var dsr = dsr_ebita / (dsr_ccris_commitment + dsr_bankStt_commitment + dsr_financing_commitment)

            // $('#dsr_bankStt_commitment').val(addCommasWithinDecimal(dsr_bankStt_commitment.toFixed(2)));
            $('#dsr').val(isNaN(dsr) ? 0 : dsr.toFixed(2));
        }

        function dsr_financingCmmtCalculate(){
            // var total_propose_loan      = parseFloat($("#financingInstrument_total_propose_loan").val()) ? parseFloat($("#financingInstrument_total_propose_loan").val().replace(/,/g, '')) : 0;
            // var total_propose_capboost  = parseFloat($("#financingInstrument_total_propose_capboost").val()) ? parseFloat($("#financingInstrument_total_propose_capboost").val().replace(/,/g, '')) : 0;
            var a = parseFloat($("#financingInstrument_total_commitment_loan").val()) ? parseFloat($("#financingInstrument_total_commitment_loan").val().replace(/,/g, '')) : 0;
            var b = parseFloat($("#financingInstrument_total_commitment_capboost").val()) ? parseFloat($("#financingInstrument_total_commitment_capboost").val().replace(/,/g, '')) : 0;
            var calculate = (a*12)+b;
            var str = calculate.toFixed(2).toString().split('.');
            console.log(str);
            $('#dsr_financing_commitment').val(addCommasWithinDecimal(calculate.toFixed(2)));
            dsrCalculate();
        }

        function financingInstrumentCalculateFunc(x, tenor_num, tenor_month, tenor_status){
            /**    LOAN     **/
            if (tenor_status == 1 || tenor_status == 0){
                //declare the value
                var propose_limit   = $("#financingInstrument_proposed_limit_loan-"+x).val() ? parseFloat($("#financingInstrument_proposed_limit_loan-"+x).val().replace(/,/g, '').replace('(', '').replace(')', '')) : 0;
                var rate            = $("#financingInstrument_interest_rate_loan-"+x).val();
                var tenor_num       = (tenor_status == 0 ? tenor_num : $("#financingInstrument_tenor_input_loan-"+x).val());
                var tenor_month     = (tenor_status == 0 ? 12 : (tenor_status == 1 ? tenor_num * 12 : tenor_month));
                var total           = 0;

                if ($("#financingInstrument_proposed_limit_loan-"+x).val().toString().includes('(')){;
                    propose_limit = '-'+propose_limit;
                    propose_limit = parseFloat(propose_limit.toString());
                }

                //calculate
                if (tenor_status == 0){
                    total = isNaN(propose_limit) ? '-' : (( propose_limit * tenor_num * rate/100 ) / tenor_month);
                }
                else if (tenor_status == 1){
                    total = isNaN(propose_limit) ? '-' : ((( propose_limit * tenor_num * rate/100 ) + propose_limit) / tenor_month);
                }
                else {
                    total = isNaN(propose_limit) ? '-' : (( propose_limit * (rate/100) * tenor_month ) + propose_limit / tenor_month);
                }

                // $("#financingInstrument_proposed_limit_loan-"+x).val(addCommasWithinDecimal(propose_limit.toString()))
                $("#financingInstrument_commitment_loan-"+x).val(addCommasWithinDecimal(total.toFixed(2).toString()))
            }

            /**    CAPBOOST     **/

            if (tenor_status == 2){
                var propose_limit   = $("#financingInstrument_proposed_limit_capboost-"+x).val() ? parseFloat($("#financingInstrument_proposed_limit_capboost-"+x).val().replace(/,/g, '').replace('(', '').replace(')', '')) : 0
                var rate            = $("#financingInstrument_interest_rate_capboost-"+x).val()
                var tenor_num       = (tenor_status == 0 ? tenor_num : $("#financingInstrument_tenor_input_capboost-"+x).val())
                var tenor_month     = (tenor_status == 0 ? 12 : (tenor_status == 1 ? tenor_num * 12 : tenor_month))
                var total           = 0

                console.log('B79 : ' + propose_limit);
                console.log('C79 : ' + rate);
                console.log('month : ' + tenor_month);

                if ($("#financingInstrument_proposed_limit_capboost-"+x).val().toString().includes('(')){
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
                    total = isNaN(propose_limit) ? '-' : ((( propose_limit * (rate/100) * tenor_month ) + propose_limit) / tenor_month);
                }

                // $("#financingInstrument_propose_limit_capboost-"+x).val(addCommasWithinDecimal(propose_limit.toString()))
                $("#financingInstrument_commitment_capboost-"+x).val(addCommasWithinDecimal(total.toFixed(2).toString()))
            }

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

            $(".financingInstrument_propose_limit_capboost").each(function () {
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

            $("#financingInstrument_total_propose_capboost").val(addCommasWithinDecimal(total_amount.toFixed(2)));

            var total_amount            = 0
            var capboost_tenor_input    = $("#financingInstrument_tenor_input_capboost-0").val()

            $(".financingInstrument_commitment_capboost").each(function () {
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

            $("#financingInstrument_total_commitment_capboost").val(addCommasWithinDecimal((total_amount * capboost_tenor_input).toFixed(2)))

            dsr_financingCmmtCalculate()
            gearing_financingAmtCalculate()
        }

        // document ready
        $(document).ready(function() {
            dsrCalculate();
            cashFlowCalculate();
            gearingCalculationFunc();
            financingInstrumentTotalCalculateFunc()

            // disabled inputs
            $(function (e) {
                @cannot('case_financial_edit_2')
                $("#financial-form-one input, #financial-form-one select, #financial-form-one textarea").each(function(){
                    var input = $(this);
                    $(this).parent().find('td:not(.td-label,.bg-light-green)').addClass("disable-div"); // disabled class to parent td
                    input.prop('disabled',true);
                    $('.add-row-btn').hide();
                });
                @endcannot

                @cannot('case_financial_credit_edit_2')
                $("#financial-form-two input, #financial-form-two select, #financial-form-two textarea").each(function(){
                    var input = $(this);
                    $(this).parent().find('td:not(.td-label)').addClass("disable-div"); // disabled class to parent td
                    input.prop('disabled',true);
                    $('.add-row-btn').hide();
                });
                @endcannot
            });

            // readonly inputs
            $(function (e) {
                $("#financial-form-two input, #financial-form-two select, #financial-form-two textarea").each(function() {
                    var readonly = $(this).parent().find('input').is('[readonly]');
                    var disabled = $(this).parent().find('input').is('[disabled]');
                    if(readonly == false && disabled == false){
                        $(this).parent().find('input').addClass("able-input");
                        $(this).parent().find('input').parent('td').addClass("able-input");
                    }
                });
            });
        });
    </script>
@endpush
