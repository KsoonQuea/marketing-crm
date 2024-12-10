<!-- step-four -->
<h6 class="card-title">Directors' Commitment</h6>

@php
    $total_bankStt = 0;
@endphp

@foreach($final_director_commitment_array as $final_director_commitment_array_key => $final_director_commitment_array_item)
    <div class="card" x-data="director_commitment_exist({{$final_director_commitment_array_key}})">
        <div class="card-header bank-card-header py-1 px-3">
            <div class="row">
                <div class="col-12 col-md-8 pt-1">
                    <label for="">{{ trans('cruds.caseDirectorCommitment.fields.director_name') }} :</label>
                    {{--                    {{ dd($final_director_commitment_array_key) }}--}}
                    <span>{{ $final_director_commitment_array[$final_director_commitment_array_key]["name"].' ('. $final_director_commitment_array[$final_director_commitment_array_key]["ic"] .')' }}</span>

                    <input type="hidden" name="hidden_director_id[{{ $final_director_commitment_array_key }}]" value="{{ $final_director_commitment_array[$final_director_commitment_array_key]["id"] }}">
                    <input type="hidden" name="hidden_director_name[{{ $final_director_commitment_array_key }}]" value="{{ $final_director_commitment_array[$final_director_commitment_array_key]["name"] }}">
                    <input type="hidden" name="hidden_director_ic[{{ $final_director_commitment_array_key }}]" value="{{ $final_director_commitment_array[$final_director_commitment_array_key]["ic"] }}">
                </div>
                <div class="col-12 col-md-4">
                    <button type="button" class="btn btn-sm float-right p-1 removeCard"><i class="fa fa-times fa-lg text-white"></i></button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="font-weight-light" style="font-size: 0.9em">Commitment from CCRIS</span>
                </div>
            </div>
        </div>
        <div class="card-body p-0 bank-card-border">
            <table class="table-bordered w-100 addable-form-table">
                <thead class="text-center">
                <tr>
                    <th width="68">#</th>
                    <th width="150">{{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}</th>
                    <th>{{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}</th>
                    <th>{{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}</th>
                    <th>{{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($final_director_commitment_array[$final_director_commitment_array_key]["hl"] as $hl_key => $hl_item)
                    <tr>
                        <td class="p-0">
                            <button type="button" class="btn btn-danger btn-small removeTable"><i class="fa fa-times"></i></button>
                            <input type="hidden" value="{{ $final_director_commitment_array_key }}">
                        </td>
                        <td><input type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_hl-'+ {{$final_director_commitment_array_key}}" name="director_commitment_hl[{{$final_director_commitment_array_key}}][]" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["hl"][$hl_key], 0, '.', ',') }}"></td>
                        <td><input type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_pl-'+ {{$final_director_commitment_array_key}}" name="director_commitment_pl[{{$final_director_commitment_array_key}}][]" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["pl"][$hl_key], 0, '.', ',') }}"></td>
                        <td><input type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_hp-'+ {{$final_director_commitment_array_key}}" name="director_commitment_hp[{{$final_director_commitment_array_key}}][]" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["hp"][$hl_key], 0, '.', ',') }}"></td>
                        <td><input type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_cc-'+ {{$final_director_commitment_array_key}}" name="director_commitment_cc[{{$final_director_commitment_array_key}}][]" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["cc"][$hl_key], 0, '.', ',') }}"></td>
                    </tr>
                @endforeach
                <template x-for="(record, row) in records" :key="row">
                    <tr>
                        <td class="p-0"><button type="button" class="btn btn-danger btn-small" @click="removeRow({{$final_director_commitment_array_key}},row); $nextTick(() => updateTotalCommitment({{$final_director_commitment_array_key}}))"><i class="fa fa-times"></i></button></td>
                        <td><input x-model="record.director_commitment_hl" type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_hl-'+ {{$final_director_commitment_array_key}}"></td>
                        <td><input x-model="record.director_commitment_pl" type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_pl-'+ {{$final_director_commitment_array_key}}"></td>
                        <td><input x-model="record.director_commitment_hp" type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_hp-'+ {{$final_director_commitment_array_key}}"></td>
                        <td><input x-model="record.director_commitment_cc" type="text" step="0.01" @keyup="updateTotalCommitment({{$final_director_commitment_array_key}})" class="w-100 border-0" :class= "'director_commitment_cc-'+ {{$final_director_commitment_array_key}}"></td>
                    </tr>
                </template>
                <tr>
                    <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100" @click="addNewRow({{$final_director_commitment_array_key}}); $nextTick(() => resetNameField({{$final_director_commitment_array_key}}))">Add New Row</button></td>
                </tr>
                </tbody>
                <tfoot class="bg-light">
                <tr class="border-top">
                    <th width="68" class="p-0 text-dark">Sub Total:</th>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_hl" :class= "'total_director_commitment_hl-'+ {{$final_director_commitment_array_key}}" name="total_director_commitment_hl[{{$final_director_commitment_array_key}}]" id="total_director_commitment_hl-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["total_hl"], 0, '.', ',') }}"></td>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_pl" :class= "'total_director_commitment_pl-'+ {{$final_director_commitment_array_key}}" name="total_director_commitment_pl[{{$final_director_commitment_array_key}}]" id="total_director_commitment_pl-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["total_pl"], 0, '.', ',') }}"></td>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_hp" :class= "'total_director_commitment_hp-'+ {{$final_director_commitment_array_key}}" name="total_director_commitment_hp[{{$final_director_commitment_array_key}}]" id="total_director_commitment_hp-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["total_hp"], 0, '.', ',') }}"></td>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_cc" :class= "'total_director_commitment_cc-'+ {{$final_director_commitment_array_key}}" name="total_director_commitment_cc[{{$final_director_commitment_array_key}}]" id="total_director_commitment_cc-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["total_cc"], 0, '.', ',') }}"></td>
                </tr>
                <tr>
                    <td colspan="4" class="ps-0 text-dark"><b>Interest per annum:</b></td>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark director_commitment_cc_charge" :class= "'director_commitment_cc_charge-'+ {{$final_director_commitment_array_key}}" name="director_commitment_cc_charge[{{$final_director_commitment_array_key}}]" id="director_commitment_cc_charge-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["total_cc_charge"], 0, '.', ',') }}"></td>
                </tr>
                <tr>
                    <th class="p-0 text-dark">Total:</th>
                    <td><input type="text" readonly class="text-input-class bg-light text-dark final_total_director_commitment" :class= "'final_total_director_commitment-'+ {{$final_director_commitment_array_key}}" name="final_total_director_commitment[{{$final_director_commitment_array_key}}]" id="final_total_director_commitment-{{$final_director_commitment_array_key}}" value="{{ number_format($final_director_commitment_array[$final_director_commitment_array_key]["sub_total"], 0, '.', ',') }}"></td>
                    <td colspan="3"></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @php
        $total_bankStt += 1;
    @endphp
@endforeach

<div x-data="director_commitment()">
    <template x-for="(directorCommitment, card) in directorCommitments" :key="card">
        <div class="card">
            <div class="card-header bank-card-header py-1 px-3">
                <div class="row">
                    <div class="col-12 col-md-8 pt-1">
                        <label for="">{{ trans('cruds.caseDirectorCommitment.fields.director_name') }} :</label>
                        <span x-text='directorCommitment.template_director_name'></span>

                        <input type="hidden" name="hidden_director_id[]"    x-model="directorCommitment.director_id"    :class= "'hidden_director_id-' + card  + '_' + {{$total_bankStt}}">
                        <input type="hidden" name="hidden_director_name[]"  x-model="directorCommitment.director_name"  :class= "'hidden_director_name-' + card  + '_' + {{$total_bankStt}}">
                        <input type="hidden" name="hidden_director_ic[]"    x-model="directorCommitment.director_ic"    :class= "'hidden_director_ic-' + card  + '_' + {{$total_bankStt}}">
                        <input type="hidden" name="hidden_director_phone[]" x-model="directorCommitment.director_phone" :class= "'hidden_director_phone-' + card  + '_' + {{$total_bankStt}}">
                        <input type="hidden" name="hidden_director_kyc[]"   x-model="directorCommitment.director_kyc"   :class= "'hidden_director_kyc-' + card  + '_' + {{$total_bankStt}}">
                    </div>
                    <div class="col-12 col-md-4">
                        <button type="button" class="btn btn-sm float-right p-1" @click="removeCard(card); $nextTick(() => updateAllFinalDirectorCommitment());"><i class="fa fa-times fa-lg text-white"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="font-weight-light" style="font-size: 0.9em">Commitment from CCRIS</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 bank-card-border">
                <table class="table-bordered w-100 addable-form-table">
                    <thead class="text-center">
                    <tr>
                        <th width="68">#</th>
                        <th width="150">{{ trans('cruds.caseDirectorCommitment.fields.house_loan') }}</th>
                        <th>{{ trans('cruds.caseDirectorCommitment.fields.personal_loan') }}</th>
                        <th>{{ trans('cruds.caseDirectorCommitment.fields.hire_purchase') }}</th>
                        <th>{{ trans('cruds.caseDirectorCommitment.fields.credit_card_limit') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template x-for="(record, row) in directorCommitment.records" :key="row">
                        <tr>
                            <td class="p-0"><button type="button" class="btn btn-danger btn-small" @click="removeRow(card,row); $nextTick(() => updateTotalCommitment(card)); $nextTick(() => updateAllFinalDirectorCommitment())"><i class="fa fa-times"></i></button></td>
                            <td><input x-model="record.director_commitment_hl" type="text" step="0.01" @keyup="updateTotalCommitment(card); $nextTick(() => updateAllFinalDirectorCommitment())" class="w-100 border-0" :class= "'director_commitment_hl-' + card + '_' + {{$total_bankStt}}"></td>
                            <td><input x-model="record.director_commitment_pl" type="text" step="0.01" @keyup="updateTotalCommitment(card); $nextTick(() => updateAllFinalDirectorCommitment())" class="w-100 border-0" :class= "'director_commitment_pl-' + card + '_' + {{$total_bankStt}}"></td>
                            <td><input x-model="record.director_commitment_hp" type="text" step="0.01" @keyup="updateTotalCommitment(card); $nextTick(() => updateAllFinalDirectorCommitment())" class="w-100 border-0" :class= "'director_commitment_hp-' + card + '_' + {{$total_bankStt}}"></td>
                            <td><input x-model="record.director_commitment_cc" type="text" step="0.01" @keyup="updateTotalCommitment(card); $nextTick(() => updateAllFinalDirectorCommitment())" class="w-100 border-0" :class= "'director_commitment_cc-' + card + '_' + {{$total_bankStt}}"></td>
                        </tr>
                    </template>
                    <tr>
                        <td class="p-0" colspan="5"><button type="button" class="btn btn-primary float-end w-100" @click="addNewRow(card); $nextTick(() => resetNameField(card))">Add New Row</button></td>
                    </tr>
                    </tbody>
                    <tfoot class="bg-light">
                    <tr class="border-top">
                        <th width="68" class="p-0 text-dark">Sub Total:</th>
                        <td><input x-model="directorCommitment.total_director_commitment_hl" type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_hl" :class= "'total_director_commitment_hl-' + card  + '_' + {{$total_bankStt}}"></td>
                        <td><input x-model="directorCommitment.total_director_commitment_pl" type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_pl" :class= "'total_director_commitment_pl-' + card  + '_' + {{$total_bankStt}}"></td>
                        <td><input x-model="directorCommitment.total_director_commitment_hp" type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_hp" :class= "'total_director_commitment_hp-' + card  + '_' + {{$total_bankStt}}"></td>
                        <td><input x-model="directorCommitment.total_director_commitment_cc" type="text" readonly class="text-input-class bg-light text-dark total_director_commitment_cc" :class= "'total_director_commitment_cc-' + card  + '_' + {{$total_bankStt}}"></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td><input x-model="directorCommitment.director_commitment_cc_charge" type="text" readonly class="text-input-class bg-light text-dark director_commitment_cc_charge" :class= "'director_commitment_cc_charge-' + card  + '_' + {{$total_bankStt}}"></td>
                    </tr>
                    <tr>
                        <th class="p-0 text-dark">Total:</th>
                        <td><input x-model="directorCommitment.final_total_director_commitment" type="text" readonly class="text-input-class bg-light text-dark final_total_director_commitment" :class= "'final_total_director_commitment-' + card  + '_' + {{$total_bankStt}}"></td>
                        <td colspan="3"></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </template>
    <h6 class="card-title mt-4">Add Directors' Commitment</h6>
    <div class="row">
        <div class="form-group col-12 col-md-4 col-lg-3 mb-2">
            <label class="form-top-label">Name</label>
            <input id="director_commitment_director" type="text" name="director_commitment_director" placeholder="" class="form-control" onkeyup="presetDirector()" onchange="presetDirector()" autocomplete="off">
        </div>
        <div class="form-group col-12 col-md-4 col-lg-3 mb-2">
            <label class="form-top-label">IC</label>
            <input id="director_commitment_id" type="hidden" name="director_commitment_id" placeholder="IC" class="form-control">
            <input id="director_commitment_ic" type="text" name="director_commitment_ic" placeholder="" class="form-control only-number ic">
        </div>
        <div class="form-group col-12 col-md-4 col-lg-3 mb-2">
            <label class="form-top-label">Phone</label>
            <input id="director_commitment_id" type="hidden" name="director_commitment_phone" placeholder="Phone" class="form-control">
            <input id="director_commitment_phone" type="text" name="director_commitment_phone" placeholder="" class="form-control only-number phone">
        </div>
        <div class="col-12 col-md-2 col-lg-2 mb-2 pt-1">
            <button type="button" class="btn btn-md btn-primary mt-4" id="add_bankStt" @click="addNewCard(); $nextTick(() => resetNameField(i-1))">Add</button>
        </div>
    </div>
    <table class="table-bordered w-100 form-table mt-3">
        <tr>
            <td class="w-50"><b>Total Director commitment :</b></td>
            <td class="bg-light"><input type="text" step="0.01" value="0" name="all_final_total_director_commitment" id="all_final_total_director_commitment" readonly class="text-input-class bg-light text-dark"></td>
        </tr>
    </table>
</div>

<!-- submit form button -->
<br>
<hr class="mt-3">

<button type="button" class="btn btn-primary-light btnPrevious">
    <i class="fa fa-chevron-left" aria-hidden="true"></i>
    Previous</button>

<button type="button" class="btn btn-primary-light btnNext">
    Next
    <i class="fa fa-chevron-right" aria-hidden="true"></i>
</button>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script>
        function uploadFinalTotal_director_cmmt(){
            var all_final_total_director_commitment  = 0

            $('.final_total_director_commitment').each(function(item, key){
                all_final_total_director_commitment  += parseFloat($(this).val()) ? parseFloat($(this).val().replace(/,/g, '')) : 0;
            });

            $("#all_final_total_director_commitment").val(addCommasWithinDecimal(all_final_total_director_commitment.toString()));
            $("#cash_flow_director_commitment_total").val($("#all_final_total_director_commitment").val());

            cashFlowCalculate();
        }

        $( document ).ready(function() {
            uploadFinalTotal_director_cmmt()
        });

        $('.removeCard').on("click", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().parent().parent().remove()

            uploadFinalTotal_director_cmmt()
        })

        $('.removeTable').on("click", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent().parent().remove()

            var card = $(this).parent().children('input').val()

            let total_director_commitment_hl    = 0;
            let total_director_commitment_pl    = 0;
            let total_director_commitment_hp    = 0;
            let total_director_commitment_cc    = 0;

            $('.director_commitment_hl-'+card).each(function(key){
                var hl      = $(".director_commitment_hl-"+card)[key].value
                var pl      = $(".director_commitment_pl-"+card)[key].value
                var hp      = $(".director_commitment_hp-"+card)[key].value
                var cc      = $(".director_commitment_cc-"+card)[key].value

                var hl_float        = parseFloat(hl) ? parseFloat(hl.replace(/,/g, '')) : 0
                var pl_float        = parseFloat(pl) ? parseFloat(pl.replace(/,/g, '')) : 0
                var hp_float        = parseFloat(hp) ? parseFloat(hp.replace(/,/g, '')) : 0
                var cc_float        = parseFloat(cc) ? parseFloat(cc.replace(/,/g, '')) : 0

                total_director_commitment_hl    += hl_float;
                total_director_commitment_pl    += pl_float;
                total_director_commitment_hp    += hp_float;
                total_director_commitment_cc    += cc_float;

                $(".director_commitment_hl-"+card)[key].value   = addCommas(hl_float.toString())
                $(".director_commitment_pl-"+card)[key].value   = addCommas(pl_float.toString())
                $(".director_commitment_hp-"+card)[key].value   = addCommas(hp_float.toString())
                $(".director_commitment_cc-"+card)[key].value   = addCommas(cc_float.toString())
            });

            $('#total_director_commitment_hl-'+card).val(addCommasWithinDecimal(total_director_commitment_hl.toString()));
            $('#total_director_commitment_pl-'+card).val(addCommasWithinDecimal(total_director_commitment_pl.toString()));
            $('#total_director_commitment_hp-'+card).val(addCommasWithinDecimal(total_director_commitment_hp.toString()));
            $('#total_director_commitment_cc-'+card).val(addCommasWithinDecimal(total_director_commitment_cc.toString()));

            var director_commitment_cc_charge = total_director_commitment_cc * 5 /100
            $('#director_commitment_cc_charge-'+card).val(addCommasWithinDecimal(director_commitment_cc_charge.toString()));

            var final_total_director_commitment   = total_director_commitment_hl + total_director_commitment_pl + total_director_commitment_hp + director_commitment_cc_charge
            $('#final_total_director_commitment-'+card).val(addCommasWithinDecimal(final_total_director_commitment.toString()));

            $(this).parent().parent().remove()

            uploadFinalTotal_director_cmmt()
        })

        function director_commitment() {

            return {
                directorCommitments: [],
                i:0,

                addNewCard() {
                    var id      = $("#director_commitment_id").val();
                    var name    = $("#director_commitment_director").val();
                    var ic      = $("#director_commitment_ic").val();
                    var phone   = $("#director_commitment_phone").val();

                    this.directorCommitments.push({
                        template_director_name: name + ' (IC: ' + ic + ')'  + ' (Phone: ' + phone + ')',
                        director_id: id,
                        director_name: name,
                        director_ic: ic,
                        director_phone: phone,
                        director_kyc: phone,
                        records: [
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                            {
                                director_commitment_hl: 0,
                                director_commitment_pl: 0,
                                director_commitment_hp: 0,
                                director_commitment_cc: 0,
                            },
                        ]
                    });

                    this.i++

                    $("#director_commitment_director").val('')
                    $("#director_commitment_ic").val('');
                    $("#director_commitment_id").val('');
                    $("#director_commitment_phone").val('');
                },
                addNewCardFromKYC(content) {
                    $("#director_commitment_director").val(content.director_name)
                    $("#director_commitment_ic").val(content.director_ic);
                    $("#director_commitment_id").val('');
                    $("#director_commitment_phone").val(content.director_phone);
                },
                removeCard(card) {
                    this.directorCommitments.splice(card, 1);
                    this.updateAllFinalDirectorCommitment()
                },
                addNewRow(card) {
                    console.log(this.directorCommitments[card]['records']);
                    this.directorCommitments[card]['records'].push({
                        director_commitment_hl: 0,
                        director_commitment_pl: 0,
                        director_commitment_hp: 0,
                        director_commitment_cc: 0,
                    });
                },
                removeRow(card, index) {
                    this.directorCommitments[card]['records'].splice(index, 1);
                    this.updateTotalCommitment(card)
                },
                updateTotalCommitment(card){
                    let total_director_commitment_hl    = 0;
                    let total_director_commitment_pl    = 0;
                    let total_director_commitment_hp    = 0;
                    let total_director_commitment_cc    = 0;

                    this.directorCommitments[card]['records'].forEach(function(item, key){
                        var hl_float        = parseFloat(item.director_commitment_hl) ? parseFloat(item.director_commitment_hl.replace(/,/g, '')) : 0
                        var pl_float        = parseFloat(item.director_commitment_pl) ? parseFloat(item.director_commitment_pl.replace(/,/g, '')) : 0
                        var hp_float        = parseFloat(item.director_commitment_hp) ? parseFloat(item.director_commitment_hp.replace(/,/g, '')) : 0
                        var cc_float        = parseFloat(item.director_commitment_cc) ? parseFloat(item.director_commitment_cc.replace(/,/g, '')) : 0

                        total_director_commitment_hl    += hl_float;
                        total_director_commitment_pl    += pl_float;
                        total_director_commitment_hp    += hp_float;
                        total_director_commitment_cc    += cc_float;

                        item.director_commitment_hl   = addCommas(hl_float.toString())
                        item.director_commitment_pl   = addCommas(pl_float.toString())
                        item.director_commitment_hp   = addCommas(hp_float.toString())
                        item.director_commitment_cc   = addCommas(cc_float.toString())
                    });

                    this.directorCommitments[card].total_director_commitment_hl   = addCommasWithinDecimal(total_director_commitment_hl.toString())
                    this.directorCommitments[card].total_director_commitment_pl   = addCommasWithinDecimal(total_director_commitment_pl.toString())
                    this.directorCommitments[card].total_director_commitment_hp   = addCommasWithinDecimal(total_director_commitment_hp.toString())
                    this.directorCommitments[card].total_director_commitment_cc   = addCommasWithinDecimal(total_director_commitment_cc.toString())

                    var director_commitment_cc_charge = total_director_commitment_cc * 5 /100
                    this.directorCommitments[card].director_commitment_cc_charge   = addCommasWithinDecimal(director_commitment_cc_charge.toString())

                    this.directorCommitments[card].final_total_director_commitment   = addCommasWithinDecimal((total_director_commitment_hl + total_director_commitment_pl + total_director_commitment_hp + director_commitment_cc_charge).toString())

                    this.updateAllFinalDirectorCommitment()
                },
                updateAllFinalDirectorCommitment(){
                    var all_final_total_director_commitment  = 0

                    $('.final_total_director_commitment').each(function(item, key){
                        all_final_total_director_commitment  += parseFloat($(this).val()) ? parseFloat($(this).val().replace(/,/g, '')) : 0;
                    });

                    $("#all_final_total_director_commitment").val(addCommasWithinDecimal(all_final_total_director_commitment.toString()));
                    $("#cash_flow_director_commitment_total").val($("#all_final_total_director_commitment").val());

                    cashFlowCalculate();

                    // format re-declare
                    formatter_init();
                },
                resetNameField(card){
                    var new_card = parseInt(card) + {{$total_bankStt ?? 0}};
                    var new_card_title = card + '_' + {{$total_bankStt ?? 0}};

                    $(".hidden_director_id-"+new_card_title).attr('name', 'hidden_director_id['+ new_card +']')
                    $(".hidden_director_name-"+new_card_title).attr('name', 'hidden_director_name['+ new_card +']')
                    $(".hidden_director_ic-"+new_card_title).attr('name', 'hidden_director_ic['+ new_card +']')
                    $(".hidden_director_phone-"+new_card_title).attr('name', 'hidden_director_phone['+ new_card +']')

                    $(".director_commitment_hl-"+new_card_title).attr('name', 'director_commitment_hl['+ new_card +'][]')
                    $(".director_commitment_pl-"+new_card_title).attr('name', 'director_commitment_pl['+ new_card +'][]')
                    $(".director_commitment_hp-"+new_card_title).attr('name', 'director_commitment_hp['+ new_card +'][]')
                    $(".director_commitment_cc-"+new_card_title).attr('name', 'director_commitment_cc['+ new_card +'][]')

                    $(".total_director_commitment_hl-"+new_card_title).attr('name', 'total_director_commitment_hl['+ new_card +']')
                    $(".total_director_commitment_pl-"+new_card_title).attr('name', 'total_director_commitment_pl['+ new_card +']')
                    $(".total_director_commitment_hp-"+new_card_title).attr('name', 'total_director_commitment_hp['+ new_card +']')
                    $(".total_director_commitment_cc-"+new_card_title).attr('name', 'total_director_commitment_cc['+ new_card +']')
                    $(".director_commitment_cc_charge-"+new_card_title).attr('name', 'director_commitment_cc_charge['+ new_card +']')
                    $(".final_total_director_commitment-"+new_card_title).attr('name', 'final_total_director_commitment['+ new_card +']')
                },
            }
        }

        function director_commitment_exist() {
            return {
                records: [],
                addNewRow(card) {
                    this.records.push({
                        director_commitment_hl: 0,
                        director_commitment_pl: 0,
                        director_commitment_hp: 0,
                        director_commitment_cc: 0,
                    });
                },
                removeRow(card, index) {
                    this.records.splice(index, 1);
                },
                updateTotalCommitment(card){
                    let total_director_commitment_hl    = 0;
                    let total_director_commitment_pl    = 0;
                    let total_director_commitment_hp    = 0;
                    let total_director_commitment_cc    = 0;

                    $('.director_commitment_hl-'+card).each(function(key){
                        var hl      = $(".director_commitment_hl-"+card)[key].value
                        var pl      = $(".director_commitment_pl-"+card)[key].value
                        var hp      = $(".director_commitment_hp-"+card)[key].value
                        var cc      = $(".director_commitment_cc-"+card)[key].value

                        var hl_float        = parseFloat(hl) ? parseFloat(hl.replace(/,/g, '')) : 0
                        var pl_float        = parseFloat(pl) ? parseFloat(pl.replace(/,/g, '')) : 0
                        var hp_float        = parseFloat(hp) ? parseFloat(hp.replace(/,/g, '')) : 0
                        var cc_float        = parseFloat(cc) ? parseFloat(cc.replace(/,/g, '')) : 0

                        total_director_commitment_hl    += hl_float;
                        total_director_commitment_pl    += pl_float;
                        total_director_commitment_hp    += hp_float;
                        total_director_commitment_cc    += cc_float;

                        $(".director_commitment_hl-"+card)[key].value   = addCommas(hl_float.toString())
                        $(".director_commitment_pl-"+card)[key].value   = addCommas(pl_float.toString())
                        $(".director_commitment_hp-"+card)[key].value   = addCommas(hp_float.toString())
                        $(".director_commitment_cc-"+card)[key].value   = addCommas(cc_float.toString())
                    });

                    $('#total_director_commitment_hl-'+card).val(addCommasWithinDecimal(total_director_commitment_hl.toString()));
                    $('#total_director_commitment_pl-'+card).val(addCommasWithinDecimal(total_director_commitment_pl.toString()));
                    $('#total_director_commitment_hp-'+card).val(addCommasWithinDecimal(total_director_commitment_hp.toString()));
                    $('#total_director_commitment_cc-'+card).val(addCommasWithinDecimal(total_director_commitment_cc.toString()));

                    var director_commitment_cc_charge = total_director_commitment_cc * 5 /100
                    $('#director_commitment_cc_charge-'+card).val(addCommasWithinDecimal(director_commitment_cc_charge.toString()));

                    var final_total_director_commitment   = total_director_commitment_hl + total_director_commitment_pl + total_director_commitment_hp + director_commitment_cc_charge
                    $('#final_total_director_commitment-'+card).val(addCommasWithinDecimal(final_total_director_commitment.toString()));

                    this.updateAllFinalDirectorCommitment()
                },
                updateAllFinalDirectorCommitment(){
                    var all_final_total_director_commitment  = 0

                    $('.final_total_director_commitment').each(function(item, key){
                        console.log($(this).val())
                        all_final_total_director_commitment  += parseFloat($(this).val()) ? parseFloat($(this).val().replace(/,/g, '')) : 0;
                    });

                    $("#all_final_total_director_commitment").val(addCommasWithinDecimal(all_final_total_director_commitment.toString()));
                    $("#cash_flow_director_commitment_total").val($("#all_final_total_director_commitment").val());

                    cashFlowCalculate();
                    // format re-declare
                    formatter_init();
                },
                resetNameField(card){
                    $(".hidden_director_id-"+card).attr('name', 'hidden_director_id['+ card +']')
                    $(".hidden_director_name-"+card).attr('name', 'hidden_director_name['+ card +']')
                    $(".hidden_director_ic-"+card).attr('name', 'hidden_director_ic['+ card +']')
                    $(".hidden_director_phone-"+card).attr('name', 'hidden_director_phone['+ card +']')

                    $(".director_commitment_hl-"+card).attr('name', 'director_commitment_hl['+ card +'][]')
                    $(".director_commitment_pl-"+card).attr('name', 'director_commitment_pl['+ card +'][]')
                    $(".director_commitment_hp-"+card).attr('name', 'director_commitment_hp['+ card +'][]')
                    $(".director_commitment_cc-"+card).attr('name', 'director_commitment_cc['+ card +'][]')

                    $(".total_director_commitment_hl-"+card).attr('name', 'total_director_commitment_hl['+ card +']')
                    $(".total_director_commitment_pl-"+card).attr('name', 'total_director_commitment_pl['+ card +']')
                    $(".total_director_commitment_hp-"+card).attr('name', 'total_director_commitment_hp['+ card +']')
                    $(".total_director_commitment_cc-"+card).attr('name', 'total_director_commitment_cc['+ card +']')
                    $(".director_commitment_cc_charge-"+card).attr('name', 'director_commitment_cc_charge['+ card +']')
                    $(".final_total_director_commitment-"+card).attr('name', 'final_total_director_commitment['+ card +']')
                }
            }
        }
    </script>
@endpush
