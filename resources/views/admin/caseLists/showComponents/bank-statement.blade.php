@php $permission_bank_statement = $permissions['bank_statement']; @endphp
<form method="post" action="{{ route('admin.case-lists.bankStt-edit', [$caseList->id]) }}" class="mt-0" id="bank-statement-form">
    @method('put')
    @csrf
    <div class="step-three">
        <h5 class="tab-pane-header">Bank Statement</h5>

        @php
            $total_bankStt = 0;
        @endphp

        @can('case_bankStt_edit_2')
            @foreach($bank_statements as $bank_statements_key => $bank_statements_item)
                <div class="card" x-data="bank_statement_exist({{$bank_statements_key}})">
                    <div class="card-header bank-card-header py-1 px-3">
                        <div class="row">
                            <div class="col-12 col-md-8 pt-1">
                                <label>{{ trans('cruds.bankStatement.fields.bank') }} :</label>
                                <span>{{ $bank_statements_item->bank->name.' ('.$bank_statements_item->currency.')' }}</span>
                                <input type="hidden" name="bankStt_bank_id[{{ $bank_statements_key }}]" value="{{ $bank_statements_item->bank_id }}" >
                                <input type="hidden" name="bankStt_currency[{{ $bank_statements_key }}]" value="{{ $bank_statements_item->currency }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <button type="button" class="btn btn-sm float-right p-1 removeCard {{ $caseType_class }}"><i class="fa fa-times fa-lg text-white"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 bank-card-border">
                        <table class="table-bordered w-100 addable-form-table">
                            <thead class="text-center">
                            <tr>
                                <th width="68">#</th>
                                <th width="150">Month</th>
                                <th>Credit transactions</th>
                                <th>Debit transactions</th>
                                <th>Month end balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $presetCreditTotal = 0;
                                $presetDebitTotal = 0;
                                $presetMonthTotal = 0;
                            @endphp
                            @foreach($bank_statements_credit_array[$bank_statements_key] as $bank_statements_credit_array_key => $bank_statements_credit_array_item)
                                <tr>
                                    <td class="p-0">
                                        <button type="button" class="btn btn-danger btn-small removeTable {{ $caseType_class }}"><i class="fa fa-times"></i></button>
                                        <input type="hidden" value="{{ $bank_statements_key }}">
                                    </td>
                                    <td>
                                        <input class="border-0 w-100 month-picker bold-input month-year-input bank_statement_date-{{$bank_statements_key}}" type="text" placeholder="MM YYYY" autocomplete="no"
                                               name="bank_statement_date[{{$bank_statements_key}}][]" value="{{ $bank_statements_date_array[$bank_statements_key][$bank_statements_credit_array_key] }}"/>
{{--                                        <input class="border-0 w-100 bank_statement_date month-year-input bank_statement_date-{{$bank_statements_key}}" type="month" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" placeholder="MM YYYY" name="bank_statement_date[{{$bank_statements_key}}][]" value="{{ $bank_statements_date_array[$bank_statements_key][$bank_statements_credit_array_key] }}">--}}
                                    </td>
                                    <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_credit_transaction-{{$bank_statements_key}} {{ $caseType_class }}" name="bank_statement_credit_transaction[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_credit_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                    <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_debit_transaction-{{$bank_statements_key}} {{ $caseType_class }}"  name="bank_statement_debit_transaction[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_debit_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                    <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_month_end_balance-{{$bank_statements_key}} {{ $caseType_class }}"  name="bank_statement_month_end_balance[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_month_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                </tr>
                                @php
                                    $presetCreditTotal +=  $bank_statements_credit_array[$bank_statements_key][$bank_statements_credit_array_key];
                                    $presetDebitTotal +=  $bank_statements_debit_array[$bank_statements_key][$bank_statements_credit_array_key];
                                    $presetMonthTotal +=  $bank_statements_month_array[$bank_statements_key][$bank_statements_credit_array_key];
                                @endphp
                            @endforeach
                            <template x-for="(table_field, table) in table_fields" :key="table">
                                <tr>
                                    <td class="p-0"><button type="button" class="btn btn-danger btn-small {{ $caseType_class }}" @click="removeTable({{$bank_statements_key}},table); $nextTick(() => updateAvgBankStt({{$bank_statements_key}}));"><i class="fa fa-times"></i></button></td>
                                    <td>
                                        <input type="text" class="border-0 w-100 month-picker-new month-year-input bold-input" :class="'bank_statement_date-'+ {{$bank_statements_key}}" placeholder="MM YYYY"/>
{{--                                        <input class="border-0 w-100 bank_statement_date month-year-input" :class= "'bank_statement_date-'+ {{$bank_statements_key}}" type="month" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" placeholder="MM YYYY">--}}
                                    </td>
                                    <td><input x-model="table_field.bank_statement_credit_transaction" type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class="w-100 border-0" :class= "' number-decimal-input bank_statement_credit_transaction-'+ {{$bank_statements_key}}"></td>
                                    <td><input x-model="table_field.bank_statement_debit_transaction" type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class="w-100 border-0" :class= "' number-decimal-input bank_statement_debit_transaction-'+ {{$bank_statements_key}}"></td>
                                    <td><input x-model="table_field.bank_statement_month_end_balance" type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class="w-100 border-0" :class= "' number-decimal-input bank_statement_month_end_balance-'+ {{$bank_statements_key}}"></td>
                                </tr>
                            </template>
                            <tr>
                                <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100 {{ $caseType_class }}" @click="addNewTable({{$bank_statements_key}}); $nextTick(() => resetNameField({{$bank_statements_key}})); $nextTick(() => updateAvgBankStt({{$bank_statements_key}}));">Add New Row</button></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            @php
                                $count_preset = count($bank_statements_credit_array[$bank_statements_key]);
                                $presetCreditTotal = $presetCreditTotal/$count_preset;
                                $presetDebitTotal = $presetDebitTotal/$count_preset;
                                $presetMonthTotal = $presetMonthTotal/$count_preset;
                            @endphp
                            <tr>
                                <th colspan="2">Avg Monthly</th>
                                <th class="bg-light">
                                    <input type="text" step="0.01" value="{{ number_format($presetCreditTotal, 2, '.', ',') }}" class="text-input-class bg-light text-dark avg_credit_transaction" :class= "'avg_credit_transaction-'+ {{$bank_statements_key}}" id="avg_credit_transaction-{{$bank_statements_key}}" name="avg_credit_transaction[]" readonly>
                                </th>
                                <th class="bg-light">
                                    <input type="text" step="0.01" value="{{ number_format($presetDebitTotal, 2, '.', ',') }}" class="text-input-class bg-light text-dark avg_debit_transaction" :class= "'avg_debit_transaction-'+ {{$bank_statements_key}}" id="avg_debit_transaction-{{$bank_statements_key}}" name="avg_debit_transaction[]" readonly>
                                </th>
                                <th class="bg-light">
                                    <input type="text" step="0.01" value="{{ number_format($presetMonthTotal, 2, '.', ',') }}" class="text-input-class bg-light text-dark avg_month_balance" :class= "'avg_month_balance-'+ {{$bank_statements_key}}" id="avg_month_balance-{{$bank_statements_key}}" name="avg_month_balance[]" readonly>
                                </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @php
                    $total_bankStt += 1;
                @endphp
            @endforeach

            <div x-data="bank_statement()">
                <template x-for="(card_field, card) in card_fields" :key="card">
                    <div class="card">
                        <div class="card-header bank-card-header py-1 px-3">
                            <div class="row">
                                <div class="col-12 col-md-8 pt-1">
                                    <label>{{ trans('cruds.bankStatement.fields.bank') }} :</label>
                                    <span x-text = 'template_bank'></span>
                                    <input type="hidden" name="bankStt_bank_id[]" x-model="card_field.bankStt_bank_id" :class= "'bankStt_bank_id-' + card + '_' + {{$total_bankStt}}">
                                    <input type="hidden" name="bankStt_currency[]" x-model="card_field.bankStt_currency" :class= "'bankStt_currency-' + card + '_' + {{$total_bankStt}}">
                                </div>
                                <div class="col-12 col-md-4">
                                    <button type="button" class="btn btn-sm float-right p-1 {{ $caseType_class }}" @click="removeCard(card); $nextTick(() => updateFinalTotal());"><i class="fa fa-times fa-lg text-white"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 bank-card-border">
                            <table class="table-bordered w-100 addable-form-table">
                                <thead class="text-center">
                                <tr>
                                    <th width="68">#</th>
                                    <th width="150">Month</th>
                                    <th>Credit transactions</th>
                                    <th>Debit transactions</th>
                                    <th>Month end balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template x-for="(table_field, table) in card_field.table_fields" :key="table">
                                    <tr>
                                        <td class="p-0"><button type="button" class="btn btn-danger btn-small {{ $caseType_class }}" @click="removeTable(card,table); $nextTick(() => updateAvgBankStt(card));"><i class="fa fa-times"></i></button></td>
                                        <td>
                                            <input type="text" class="border-0 w-100 month-picker-new month-year-input bold-input" :class= "'bank_statement_date-'+ card + '_' + {{$total_bankStt}}" placeholder="MM YYYY"/>
{{--                                            <input class=" border-0 w-100 bank_statement_date month-year-input" :class= "'bank_statement_date-'+ card + '_' + {{$total_bankStt}}" type="month" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" placeholder="MM YYYY">--}}
                                        </td>
                                        <td><input x-model="table_field.bank_statement_credit_transaction" type="text" step="0.01" @keyup="updateAvgBankStt(card); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 round_number" :class= "'bank_statement_credit_transaction-' + card + '_' + {{$total_bankStt}}"></td>
                                        <td><input x-model="table_field.bank_statement_debit_transaction" type="text" step="0.01" @keyup="updateAvgBankStt(card); $nextTick(() => updateFinalTotal());"  class=" number-decimal-input w-100 border-0 round_number" :class= "'bank_statement_debit_transaction-'+ card + '_' + {{$total_bankStt}}"></td>
                                        <td><input x-model="table_field.bank_statement_month_end_balance" type="text" step="0.01" @keyup="updateAvgBankStt(card); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 round_number" :class= "'bank_statement_month_end_balance-'+ card + '_' + {{$total_bankStt}}"></td>
                                    </tr>
                                </template>
                                <tr>
                                    <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100 {{ $caseType_class }}" @click="addNewTable(card); $nextTick(() => resetNameField(card))">Add New Row</button></td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="2">Avg Monthly</th>
                                    <th class="bg-light">
                                        <input type="text" step="0.01" value="0" class="text-input-class bg-light text-dark avg_credit_transaction" :class= "'avg_credit_transaction-'+ card" readonly x-model="card_field.avg_credit_transaction" name="avg_credit_transaction[]">
                                    </th>
                                    <th class="bg-light">
                                        <input type="text" step="0.01" value="0" class="text-input-class bg-light text-dark avg_debit_transaction" :class= "'avg_debit_transaction-'+ card" readonly x-model="card_field.avg_debit_transaction" name="avg_debit_transaction[]">
                                    </th>
                                    <th class="bg-light">
                                        <input type="text" step="0.01" value="0" class="text-input-class bg-light text-dark avg_month_balance" :class= "'avg_month_balance-'+ card" readonly x-model="card_field.avg_month_balance" name="avg_month_balance[]">
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </template>


                <h6 class="card-title mt-4">Add Bank Statement</h6>
                <div class="row">
                    <div class="form-group col-12 col-md-4 col-lg-3">
                        <label for="bank" class="form-top-label">{{ trans('cruds.bankStatement.fields.bank') }}</label>
                        <select class="form-control m-0 {{ $errors->has('bank') ? 'is-invalid' : '' }}" name="bank" id="bank" onchange="checkBankId()">
                            @foreach($banks as $id => $bank)
                                <option value="{{ $id }}" {{ (old('bank') === $id) ? 'selected' : '' }}>
                                    {{ $bank }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('bank'))
                            <div class="invalid-feedback">
                                {{ $errors->first('bank') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.bankStatement.fields.bank_helper') }}</span>
                    </div>
                    <div class="form-group col-12 col-md-4 col-lg-3">
                        <label for="currency" class="form-top-label">{{ trans('cruds.bankStatement.fields.currency') }}</label>
                        <input class="form-control {{ $errors->has('currency') ? 'is-invalid' : '' }} {{ $caseType_class }}" type="text" name="currency" id="currency" value="MYR">
                        @if($errors->has('currency'))
                            <div class="invalid-feedback">
                                {{ $errors->first('currency') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.bankStatement.fields.currency_helper') }}</span>
                    </div>
                    <div class="form-group col-12 col-md-2 col-lg-3">
                        <button type="button" id="bankSttAddId" class="btn btn-md btn-primary mt-4 {{ $caseType_class }}" @click="addNewCard(); $nextTick(() => resetNameField(i-1))" disabled>Add</button>
                    </div>
                </div>

            </div>
        @else
            <div>
                @foreach ($bank_statements as $bank_statements_key => $bank_statements_item)
                    <div class="card" :key="card">
                        <div class="card-header bank-card-header py-1 px-3">
                            <div class="row">
                                <div class="col-12 col-md-8 pt-1">
                                    <label>{{ trans('cruds.bankStatement.fields.bank') }} :</label>
                                    <span>{{ $bank_statements_item->bank->name.' ('.$bank_statements_item->currency.')' }}</span>
                                </div>
                                <div class="col-12 col-md-4">
                                    {{--                                <button type="button" class="btn btn-sm float-right p-1" @click="removeCard(card)"><i class="fa fa-times fa-lg text-white"></i></button>--}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 bank-card-border">
                            <table class="table-bordered w-100 addable-form-table">
                                <thead class="text-center">
                                <tr>
                                    <th width="120">#</th>
                                    <th>Month</th>
                                    <th>Credit transactions</th>
                                    <th>Debit transactions</th>
                                    <th>Month end balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $presetCreditTotal = 0;
                                    $presetDebitTotal = 0;
                                    $presetMonthTotal = 0;
                                @endphp
                                @foreach($bank_statements_credit_array[$bank_statements_key] as $bank_statements_credit_array_key => $bank_statements_credit_array_item)
                                    <tr>
                                        <td class="text-center">{{ $bank_statements_credit_array_key + 1 }}</td>
                                        <td>
                                            <input class="border-0 w-100 month-picker digits bold-input bank_statement_date-{{$bank_statements_key}}" type="text"
                                                   data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" placeholder="MM YYYY"
                                                   name="bank_statement_date[{{$bank_statements_key}}][]" value="{{ $bank_statements_date_array[$bank_statements_key][$bank_statements_credit_array_key] }}"/>
{{--                                            <input class="border-0 w-100 bank_statement_date month-year-input bank_statement_date-{{$bank_statements_key}}" type="month" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" placeholder="MM YYYY" name="bank_statement_date[{{$bank_statements_key}}][]" value="{{ $bank_statements_date_array[$bank_statements_key][$bank_statements_credit_array_key] }}">--}}
                                        </td>
                                        <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_credit_transaction-{{$bank_statements_key}}" name="bank_statement_credit_transaction[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_credit_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                        <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_debit_transaction-{{$bank_statements_key}}"  name="bank_statement_debit_transaction[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_debit_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                        <td><input type="text" step="0.01" @keyup="updateAvgBankStt({{$bank_statements_key}}); $nextTick(() => updateFinalTotal());" class=" number-decimal-input w-100 border-0 bank_statement_month_end_balance-{{$bank_statements_key}}"  name="bank_statement_month_end_balance[{{$bank_statements_key}}][]" value="{{ preset_num_decimal_format($bank_statements_month_array[$bank_statements_key][$bank_statements_credit_array_key] ?? 0) }}"></td>
                                    </tr>

                                    @php
                                        $presetCreditTotal +=  $bank_statements_credit_array[$bank_statements_key][$bank_statements_credit_array_key];
                                        $presetDebitTotal +=  $bank_statements_debit_array[$bank_statements_key][$bank_statements_credit_array_key];
                                        $presetMonthTotal +=  $bank_statements_month_array[$bank_statements_key][$bank_statements_credit_array_key];
                                    @endphp

                                @endforeach
                                @php
                                    $presetCreditTotal = $presetCreditTotal/3;
                                    $presetDebitTotal = $presetDebitTotal/3;
                                    $presetMonthTotal = $presetMonthTotal/3;
                                @endphp
                                <tr>
                                    <td colspan="2"><b>Avg Monthly</b></td>
                                    <td>
                                        <input type="text"
                                               class="text-input-class avg_credit_transaction"
                                               readonly
                                               value="{{ number_format($presetCreditTotal, 2, '.', ',') }}">
                                    </td>
                                    <td>
                                        <input type="text"
                                               class="text-input-class avg_debit_transaction"
                                               readonly
                                               value="{{ number_format($presetDebitTotal, 2, '.', ',') }}">
                                    </td>
                                    <td>
                                        <input type="text"
                                               class="text-input-class avg_month_balance"
                                               readonly
                                               value="{{ number_format($presetMonthTotal, 2, '.', ',') }}">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endcan

        <table class="table-bordered form-table w-100">
            <tr style="width: 100%">
                <td class="td-label" style="width: 20%"><b>Credit transactions :</b></td>
                <td style="width: 10%"><input type="text"
                                              class="w-100 border-0" value="0"
                                              name="final_total_credit_transaction" readonly
                                              id="final_total_credit_transaction"></td>
                <td class="td-label" style="width: 20%"><b>Debit transactions :</b></td>
                <td style="width: 10%"><input type="text"
                                              class="w-100 border-0" value="0"
                                              name="final_total_debit_transaction" readonly
                                              id="final_total_debit_transaction"></td>
                <td class="td-label" style="width: 20%"><b>Month end balance :</b></td>
                <td style="width: 10%"><input type="text"
                                              class="w-100 border-0" value="0"
                                              name="final_total_month_end_balance_transaction" readonly
                                              id="final_total_month_end_balance"></td>
            </tr>
        </table>
        @if($caseType_num != 2 && $caseType_num != 3)
        @can('case_bankStt_edit_2')
            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-sm {{ $caseType_class }}">
                    <i class="fa fa-edit me-2"></i>
                    Save & Update
                </button>
            </div>
        @endcan
        @endif
    </div>
</form>
@push('scripts')
<script>
    function checkBankId() {
        if ($('#bank').val() == 0){
            $("#bankSttAddId").attr('disabled', 'disabled');
        }
        else {
            $("#bankSttAddId").removeAttr('disabled');
        }
    }

    function uploadFinalTotal_bank_stt(){

        var final_total_credit_transaction  = 0
        var final_total_debit_transaction   = 0
        var final_total_month_end_balance   = 0

        $(".avg_credit_transaction").each(function(key){
            var credit      = $(".avg_credit_transaction")[key].value;
            var debit       = $(".avg_debit_transaction")[key].value;
            var month_end   = $(".avg_month_balance")[key].value;
            final_total_credit_transaction    += parseFloat(recoverNumberFormat(credit));
            final_total_debit_transaction     += parseFloat(recoverNumberFormat(debit));
            final_total_month_end_balance     += parseFloat(recoverNumberFormat(month_end));
            var avg_credit;
            var avg_debit;
            var avg_month_end;
            if(credit == '0'|| credit == '0.00'){ avg_credit = '0.00'; } else { avg_credit = bankSttFormat(credit); }
            if(debit == '0'|| debit == '0.00'){ avg_debit = '0.00'; } else { avg_debit = bankSttFormat(debit); }
            if(month_end == '0'|| month_end == '0.00'){ avg_month_end = '0.00'; } else { avg_month_end = bankSttFormat(month_end); }
            $('#avg_credit_transaction-'+key).val(avg_credit);
            $('#avg_debit_transaction-'+key).val(avg_debit);
            $('#avg_month_balance-'+key).val(avg_month_end);
        });

        var final_credit        =  addCommasWithinDecimal(final_total_credit_transaction.toFixed(2));
        var final_debit         =  addCommasWithinDecimal(final_total_debit_transaction.toFixed(2));
        var final_month_end     =  addCommasWithinDecimal(final_total_month_end_balance.toFixed(2));

        $("#final_total_credit_transaction").val(final_credit);
        $("#final_total_debit_transaction").val(final_debit);
        $("#final_total_month_end_balance").val(final_month_end);
    }
    function monthpickerDeclare(){
        // month picker
        $(".month-picker-new").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'mm yyyy',
            minView: 'months',
            view: 'months',
            language: 'en',
            setDate: '04 2020',
        });
    }
    function updateMonthpicker(){
        monthpickerDeclare();
        monthpickerDeclare();
    }

    $( document ).ready(function() {
        uploadFinalTotal_bank_stt();
    });

    $('.removeCard').on("click", function(e){ //user click on remove text
        e.preventDefault();
        $(this).parent().parent().parent().parent().remove();

        uploadFinalTotal_bank_stt()
    })

    $('.removeTable').on("click", function(e){ //user click on remove text
        e.preventDefault();

        $(this).parent().parent().remove();

        var card = $(this).parent().children('input').val()

        let total_bankstt_credit_transaction    = 0;
        let total_bankstt_debit_transaction     = 0;
        let total_bankstt_month_end_balance     = 0;

        $(".bank_statement_credit_transaction-"+card).each(function(key){
            var credit      = $(".bank_statement_credit_transaction-"+card)[key].value
            var debit       = $(".bank_statement_debit_transaction-"+card)[key].value
            var month_end   = $(".bank_statement_month_end_balance-"+card)[key].value

            var credit_float       = parseFloat(credit) ? parseFloat(credit.replace(/,/g, '')) : 0
            var debit_float        = parseFloat(debit) ? parseFloat(debit.replace(/,/g, '')) : 0
            var month_end_float    = parseFloat(month_end) ? parseFloat(month_end.replace(/,/g, '')) : 0

            var credit_string       = (credit ?? '0').toString()
            var debit_string        = (debit ?? '0').toString()
            var month_end_string    = (month_end ?? '0').toString()

            total_bankstt_credit_transaction    += credit_float;
            total_bankstt_debit_transaction     += debit_float;
            total_bankstt_month_end_balance     += month_end_float;

            if (credit_string.charAt(credit_string.length - 1) != '.' && debit_string.charAt(debit_string.length - 1) != '.' && month_end_string.charAt(month_end_string.length - 1) != '.'){
                $(".bank_statement_credit_transaction-"+card)[key].value    = addCommasWithinDecimal(credit_float).toString()
                $(".bank_statement_debit_transaction-"+card)[key].value     = addCommasWithinDecimal(debit_float).toString()
                $(".bank_statement_month_end_balance-"+card)[key].value     = addCommasWithinDecimal(month_end_float).toString()
            }
        });

        var length = $(".bank_statement_month_end_balance-"+card).length

        $('#avg_credit_transaction-'+card).val(addCommasWithinDecimal((total_bankstt_credit_transaction / length).toFixed(2)).toString())
        $('#avg_debit_transaction-'+card).val(addCommasWithinDecimal((total_bankstt_debit_transaction / length).toFixed(2)).toString())
        $('#avg_month_balance-'+card).val(addCommasWithinDecimal((total_bankstt_month_end_balance / length).toFixed(2)).toString())

        uploadFinalTotal_bank_stt();
    })

    function bank_statement() {
        return {
            card_fields: [],
            i: 0,
            addNewCard() {
                var bank        = $("#bank").find('option:selected').text();
                var bank_id     = $("#bank").val();
                var currency    = $("#currency").val()

                template_bank = bank + '(' + currency + ')'

                this.card_fields.push({
                    table_fields: [
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                        {
                            bank_statement_credit_transaction  : 0,
                            bank_statement_debit_transaction   : 0,
                            bank_statement_month_end_balance   : 0,
                        },
                    ],
                    bankStt_bank_id: bank_id,
                    bankStt_currency: currency,
                    avg_credit_transaction : 0,
                    avg_debit_transaction  : 0,
                    avg_month_balance      : 0,
                });

                this.i++

                $("#bank").val(0).change();
                $("#currency").val('MYR');
                updateMonthpicker();
            },
            removeCard(card) {
                this.card_fields.splice(card, 1);
                this.updateFinalTotal()
            },
            addNewTable(card) {
                this.card_fields[card]['table_fields'].push({
                    bank_statement_credit_transaction  : 0,
                    bank_statement_debit_transaction   : 0,
                    bank_statement_month_end_balance   : 0,
                });
                updateMonthpicker();
            },
            removeTable(card, index) {
                this.card_fields[card]['table_fields'].splice(index, 1);
                this.updateAvgBankStt(card);
            },
            updateAvgBankStt(card){
                let total_bankstt_credit_transaction    = 0;
                let total_bankstt_debit_transaction     = 0;
                let total_bankstt_month_end_balance     = 0;
                console.log('XD');
                this.card_fields[card]['table_fields'].forEach(function(item, key){
                    var credit_float = parseFloat(recoverNumberFormat(item.bank_statement_credit_transaction));
                    var debit_float = parseFloat(recoverNumberFormat(item.bank_statement_debit_transaction));
                    var month_end_float = parseFloat(recoverNumberFormat(item.bank_statement_month_end_balance));

                    // var credit_float       = parseFloat(item.bank_statement_credit_transaction) ? parseFloat(item.bank_statement_credit_transaction.replace(/,/g, '')) : 0
                    // var debit_float        = parseFloat(item.bank_statement_debit_transaction) ? parseFloat(item.bank_statement_debit_transaction.replace(/,/g, '')) : 0
                    // var month_end_float    = parseFloat(item.bank_statement_month_end_balance) ? parseFloat(item.bank_statement_month_end_balance.replace(/,/g, '')) : 0

                    total_bankstt_credit_transaction    += credit_float;
                    total_bankstt_debit_transaction     += debit_float;
                    total_bankstt_month_end_balance     += month_end_float;
                });

                this.card_fields[card].avg_credit_transaction   = addCommasWithinDecimal((total_bankstt_credit_transaction / this.card_fields[card]['table_fields'].length).toFixed(2)).toString()
                this.card_fields[card].avg_debit_transaction    = addCommasWithinDecimal((total_bankstt_debit_transaction / this.card_fields[card]['table_fields'].length).toFixed(2)).toString()
                this.card_fields[card].avg_month_balance        = addCommasWithinDecimal((total_bankstt_month_end_balance / this.card_fields[card]['table_fields'].length).toFixed(2)).toString()

                this.updateFinalTotal();

            },
            updateFinalTotal(){
                var final_total_credit_transaction  = 0
                var final_total_debit_transaction   = 0
                var final_total_month_end_balance   = 0

                $(".avg_credit_transaction").each(function(key){
                    var credit      = $(".avg_credit_transaction")[key].value;
                    var debit       = $(".avg_debit_transaction")[key].value;
                    var month_end   = $(".avg_month_balance")[key].value;

                    var credit_float = parseFloat(recoverNumberFormat(credit));
                    var debit_float = parseFloat(recoverNumberFormat(debit));
                    var month_end_float = parseFloat(recoverNumberFormat(month_end));

                    final_total_credit_transaction    += credit_float;
                    final_total_debit_transaction     += debit_float;
                    final_total_month_end_balance     += month_end_float;
                });

                $("#final_total_credit_transaction").val(addCommasWithinDecimal(final_total_credit_transaction.toFixed(2)).toString());
                $("#final_total_debit_transaction").val(addCommasWithinDecimal(final_total_debit_transaction.toFixed(2)).toString());
                $("#final_total_month_end_balance").val(addCommasWithinDecimal(final_total_month_end_balance.toFixed(2)).toString());
                // format re-declare
                formatter_init();
                bank_stt_formatter_init();
            },
            resetNameField(card){
                updateMonthpicker();
                var new_card = parseInt(card) + {{$total_bankStt}};
                var new_card_title = card + '_' + {{$total_bankStt}};

                $(".bankStt_bank_id-"+new_card_title).attr('name', 'bankStt_bank_id['+ new_card +']');
                $(".bankStt_currency-"+new_card_title).attr('name', 'bankStt_currency['+ new_card +']');

                $(".bank_statement_date-"+new_card_title).attr('name', 'bank_statement_date['+ new_card +'][]');
                $(".bank_statement_credit_transaction-"+new_card_title).attr('name', 'bank_statement_credit_transaction['+ new_card +'][]');
                $(".bank_statement_debit_transaction-"+new_card_title).attr('name', 'bank_statement_debit_transaction['+ new_card +'][]');
                $(".bank_statement_month_end_balance-"+new_card_title).attr('name', 'bank_statement_month_end_balance['+ new_card +'][]');

                $(".avg_credit_transaction-"+new_card_title).attr('name', 'avg_credit_transaction['+ new_card +']');
                $(".avg_debit_transaction-"+new_card_title).attr('name', 'avg_debit_transaction['+ new_card +']');
                $(".avg_month_balance-"+new_card_title).attr('name', 'avg_month_balance['+ new_card +']');
            }
        }
    }

    function bank_statement_exist(){
        return {
            table_fields: [],
            addNewTable(card) {
                this.table_fields.push({
                    bank_statement_credit_transaction  : 0,
                    bank_statement_debit_transaction   : 0,
                    bank_statement_month_end_balance   : 0,
                });
            },
            removeTable(card, index) {
                this.table_fields.splice(index, 1);

                this.updateAvgBankStt(card);
            },
            updateAvgBankStt(card){
                let total_bankstt_credit_transaction    = 0;
                let total_bankstt_debit_transaction     = 0;
                let total_bankstt_month_end_balance     = 0;

                $(".bank_statement_credit_transaction-"+card).each(function(key){
                    var credit      = $(".bank_statement_credit_transaction-"+card)[key].value;
                    var debit       = $(".bank_statement_debit_transaction-"+card)[key].value;
                    var month_end   = $(".bank_statement_month_end_balance-"+card)[key].value;

                    var credit_float = parseFloat(recoverNumberFormat(credit));
                    var debit_float = parseFloat(recoverNumberFormat(debit));
                    var month_end_float = parseFloat(recoverNumberFormat(month_end));

                    total_bankstt_credit_transaction    += credit_float;
                    total_bankstt_debit_transaction     += debit_float;
                    total_bankstt_month_end_balance     += month_end_float;
                });

                var length = $(".bank_statement_month_end_balance-"+card).length;
                $('#avg_credit_transaction-'+card).val(addCommasWithinDecimal((total_bankstt_credit_transaction / length).toFixed(2)).toString());
                $('#avg_debit_transaction-'+card).val(addCommasWithinDecimal((total_bankstt_debit_transaction / length).toFixed(2)).toString());
                $('#avg_month_balance-'+card).val(addCommasWithinDecimal((total_bankstt_month_end_balance / length).toFixed(2)).toString());
                this.updateFinalTotal();
            },
            updateFinalTotal(){
                var final_total_credit_transaction  = 0
                var final_total_debit_transaction   = 0
                var final_total_month_end_balance   = 0

                $(".avg_credit_transaction").each(function(key){
                    var credit      = $(".avg_credit_transaction")[key].value;
                    var debit       = $(".avg_debit_transaction")[key].value;
                    var month_end   = $(".avg_month_balance")[key].value;

                    var credit_float = parseFloat(recoverNumberFormat(credit));
                    var debit_float = parseFloat(recoverNumberFormat(debit));
                    var month_end_float = parseFloat(recoverNumberFormat(month_end));

                    final_total_credit_transaction    += credit_float;
                    final_total_debit_transaction     += debit_float;
                    final_total_month_end_balance     += month_end_float;
                });

                $("#final_total_credit_transaction").val(addCommasWithinDecimal(final_total_credit_transaction.toFixed(2)).toString());
                $("#final_total_debit_transaction").val(addCommasWithinDecimal(final_total_debit_transaction.toFixed(2)).toString());
                $("#final_total_month_end_balance").val(addCommasWithinDecimal(final_total_month_end_balance.toFixed(2)).toString());
                // format re-declare
                formatter_init();
                bank_stt_formatter_init();
            },
            resetNameField(card){
                updateMonthpicker();
                $(".bankStt_bank_id-"+card).attr('name', 'bankStt_bank_id['+ card +']');
                $(".bankStt_currency-"+card).attr('name', 'bankStt_currency['+ card +']');

                $(".bank_statement_date-"+card).attr('name', 'bank_statement_date['+ card +'][]');
                $(".bank_statement_credit_transaction-"+card).attr('name', 'bank_statement_credit_transaction['+ card +'][]');
                $(".bank_statement_debit_transaction-"+card).attr('name', 'bank_statement_debit_transaction['+ card +'][]');
                $(".bank_statement_month_end_balance-"+card).attr('name', 'bank_statement_month_end_balance['+ card +'][]');

                $(".avg_credit_transaction-"+card).attr('name', 'avg_credit_transaction['+ card +']');
                $(".avg_debit_transaction-"+card).attr('name', 'avg_debit_transaction['+ card +']');
                $(".avg_month_balance-"+card).attr('name', 'avg_month_balance['+ card +']');

            }
        }
    }

    $(function (e) {
        @cannot('case_bankStt_edit_2')
        $("#bank-statement-form input, #bank-statement-form select, #bank-statement-form textarea").each(function(){
            var input = $(this);
            $(this).parent().find('td:not(.td-label)').addClass("disable-div"); // disabled class to parent td
            input.prop('disabled',true);
            $('.add-row-btn').hide();
        });
        @endcannot
    });
</script>
@endpush

