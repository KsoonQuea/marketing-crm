@include('admin.caseLists.print.components.style')
<div id="pdf-div">
    <!-- Header -->
    <div class="w-full">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/financial-roadmap/nexus_letterhead.png'))) }}"
             style="width:115%; height:auto; margin:0 auto; filter: blur(24px) !important;">
    </div>
    <div style="margin-left:10px; margin-right:10px;">
        <!-- Company & Proforma Info -->
        <div class="row w-full">
            <div class="column" style="width: 60%;">
                <table>
                    <tr>
                        <th>
                            @if($preview_type == 1)
                                {{ $data['company_name'] }}
                            @else
                                <input type="text" name="company_name" class="form-control form-control-sm" placeholder="Company Name" value="{{ old('company_name', isset($invoice) ? $invoice->company_name : '') }}"/>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <td>
                            @if($preview_type == 1)
                                {{ $data['company_address_1'] }} <br>
                                {{ $data['company_address_2'] }} <br>
                                {{ $data['company_address_3'] }}
                            @else
                                <input type="text" name="company_address_1" class="form-control form-control-sm" placeholder="Address 1" maxlength="80" value="{{ old('company_address_1', isset($invoice) ? $invoice->company_address_1 : '') }}"/>
                                <input type="text" name="company_address_2" class="form-control form-control-sm tw-mt-0.5" placeholder="Address 2" maxlength="80" value="{{ old('company_address_2', isset($invoice) ? $invoice->company_address_2 : '') }}"/>
                                <input type="text" name="company_address_3" class="form-control form-control-sm tw-mt-0.5" placeholder="Address 3"  maxlength="80" value="{{ old('company_address_3', isset($invoice) ? $invoice->company_address_3 : '') }}"/>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="column" style="width: 40%;">
                <table>
                    <tr>
                        <th >SST NO :</th>
                        <td >W10-2201-32100024</td>
                    </tr>
                    <tr>
                        <th>INVOICE : &nbsp;</th>
                        <td>
                            @if($preview_type == 1)
                            {{ $other_data['file_num'] }}
                            @elseif($preview_type == 2)
                                <input type="hidden" name="selection" value="3"/>
                                <input type="hidden" name="file_num" value="{{ $invoice->file_num }}"/>
                                {{ $invoice->file_num }}
                            @else
                                <div style="">
                                    <div style="width:100%;">
                                        <label><input type="radio" name="selection" onchange="invoiceAction()" value="1" checked/> Auto Generate</label> &nbsp;
                                        <label><input type="radio" name="selection" onchange="invoiceAction()" value="2"/> Re-use</label>
                                    </div>
                                    <div style="width:100%;">
                                        <input type="text" id="inv_no_input" name="re_use_inv_no" class="form-control form-control-sm" value="{{ $auto_generate['inv_no'] }}" required/>
                                    </div>
                                    <input type="hidden" name="auto_generate_inv_no" value="{{ $auto_generate['inv_no'] }}"/>
                                    <input type="hidden" name="auto_generate_running_no" value="{{ $auto_generate['running_no'] }}"/>
                                    &nbsp; &nbsp;
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>DATE :</th>
                        <td>
                            @if($preview_type == 1)
                                {{ $data['date'] }}
                            @else
                                <input type="text" name="date" class="keyup_datepicker form-control form-control-sm datepicker-here text-input-class digits" placeholder="YYYY-MM-DD" data-language="en" value="{{ old('date', isset($invoice) ? $invoice->date : '') }}"/>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>TERM :</th>
                        <td>7 Days</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Attn & Tel -->
        <div class="row w-full">
            <div class="column" style="width: 50%;">
                <table>
                    <tr>
                        <th>Attn :</th>
                        <td>
                            @if($preview_type == 1)
                                {{ $data['contact_person'] }}
                            @else
                                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', isset($invoice) ? $invoice->contact_person : '') }}"/>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tel :</th>
                        <td>
                            @if($preview_type == 1)
                                {{ $data['contact_phone'] }}
                            @else
                                <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', isset($invoice) ? $invoice->contact_phone : '') }}"/>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Description -->
        <div class="w-full">
            <table class="w-full" style="margin:25px 0;">
                <tr class="border-tr">
                    <th style="width: 70%;padding-left:10px;">Description</th>
                    <th style="width: 30%;text-align: center;">Amount</th>
                </tr>
                <tr>
                    <td style="padding:8px;">
                        @if($preview_type == 1)
                            <div class="description-span">{{ $data['description'] }}</div>
                        @else
                            <textarea class="form-control pull-right" name="description" style="resize:none;" rows="3" cols="12">{{ $invoice->description ?? '' }}</textarea>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($preview_type == 1)
                            {{ number_format($data['service_fee'],2) }}
                        @else
                            <input type="text" class="form-control text-center bank-stt-input" name="service_fee" id="service_fee" style="height:68px;" oninput="calculation()" min="0" value="{{ old('service_fee', isset($invoice) ? $invoice->service_fee : 0) }}"/>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div style="width:100%; height:630px; position:relative;">
            <!-- cal -->
            <div class="w-full" style="margin-top:300px; position:absolute;">
                <div class="w-full">
                    <div style="padding-left:10px; font-weight:bold;">RINGGIT MALAYSIA : <span id="number-word-span" style="font-weight: bold;">{{ ($preview_type == 1 || $preview_type == 2) ? $other_data['number_word'] : 'ZERO'}}</span> ONLY.</div>
                    <div class="border-bottom-line w-full"></div>
                </div>
                <table class="w-full">
                    <tr style="width:100%;">
                        <td style="width:50%;">
                            @if($preview_type != 1)
                                <div id="no-printable" style="float:right;padding-right:15px;">
                                    <label><input type="radio" name="sst_status" onchange="calculation()" value="1" checked/> Include SST</label><br>
                                    <label><input type="radio" name="sst_status" onchange="calculation()" value="0"/> Exclude SST</label>
                                </div>
                            @endif
                        </td>
                        <td style="width:50%;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="width:50%;">Sub Total (Excluding SST)</td>
                                    <td class="text-center" id="sub-total-span" style="width:42%;">{{ ($preview_type == 1 || $preview_type == 2) ? number_format($other_data['service_fee'],2) : '0.00'}}</td>
                                    <td style="width:8%;"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">SST 6%</td>
                                    <td class="border-bottom-line text-center" id="sst-span">{{ ($preview_type == 1 || $preview_type == 2) ? number_format($other_data['sst_amount'],2) : '0.00'}}</td>
                                    <td class="border-bottom-line"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">Total (Inclusive of SST)</td>
                                    <td class="border-bottom-line text-center" id="total-span">{{ ($preview_type == 1 || $preview_type == 2) ? number_format($other_data['total_amount'],2) : '0.00'}}</td>
                                    <td class="border-bottom-line"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line" colspan="3"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- noted -->
            <div class="w-full" style="position:absolute; bottom:0;">
                <table class="w-full">
                    <tr class="w-full">
                        <td colspan="2">Note:</td>
                    </tr>
                    <tr class="w-full">
                        <td colspan="2">All cheques must be crossed and</td>
                    </tr>
                    <tr class="w-full">
                        <td colspan="2">made payable to</td>
                    </tr>
                    <tr class="w-full">
                        <td colspan="2"><b>Nexus Capital Sdn Bhd</b></td>
                    </tr>
                    <tr class="w-full">
                        <td colspan="2"><b>CIMB Bank : 8010 6502 38</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>(Computer generated billing, no signature is required)</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function bankSttFormat(str){
        var negative = 0;
        if (str.toString().indexOf(')') > -1 || str.toString().indexOf('-') > -1) {
            negative = 1;
        }
        var new_str = str.replace('(','').replace(')','').replace('-',''); // remove negative symbol
        var value = new_str.toString().split('.');
        var front_val = value[0].replace(/^0+/, '').replace(/\D/g, "").replace(/,/g, ''); // remove , / only allow number
        var final = front_val.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        if(value.length > 1){
            var decimal = value[1];
            if($.isNumeric(decimal) == true){
                final += '.'+(decimal.substring(0,2)); //replace(/^0+/, '')
            }
        }
        var display;
        if(negative > 0){ display = '('+final+')'; } else { display = final; }
        return display;
    }
    $('.bank-stt-input').on('input', function (e){
        var value       = $(this).val();
        var value_arr   = $(this).val().split('.');

        if (value.charAt(value.length - 1) != '.'){
            $(this).val(bankSttFormat(value));
        }
        else {
            if (value_arr[1] != ''){
                $(this).val(bankSttFormat(value));
            }
        }

        if ((value.charAt(value.length - 2) + value.charAt(value.length - 1)) == '..'){
            $(this).val(value.substring(0, value.length-1));
        }

    });

    // Convert numbers to words
    // copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
    // permission to use this Javascript on your web page is granted
    // provided that all of the code (including this copyright notice) is
    // used exactly as shown (you can change the numbering system if you wish)

    // American Numbering System
    var th = ['', 'thousand', 'million', 'billion', 'trillion'];
    // uncomment this line for English Number System
    // var th = ['','thousand','million', 'milliard','billion'];

    var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function toWords(s) {

        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s)) return 'not a number';
        var x = s.indexOf('.');
        console.log(x);
        var fulllength=s.length;

        if (x == -1) x = s.length;
        if (x > 15) return 'too big';
        var startpos=fulllength-(fulllength-x-1);
        var n = s.split('');

        var str = '';
        var str1 = ''; //i added another word called cent
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';

                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }

        var num_arr = s.split('.');

        // if (x != s.length) {
        if (num_arr[1] > 0) {

            str += 'and '; //i change the word point to and
            str1 += 'cents '; //i added another word called cent
            //for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ' ;
            var j=startpos;

            for (var i = j; i < fulllength; i++) {

                if ((fulllength - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';

                        sk = 1;
                    }
                } else if (n[i] != 0) {

                    str += dg[n[i]] + ' ';
                    if ((fulllength - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((fulllength - i) % 3 == 1) {

                    if (sk) str += th[(fulllength - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
        }
        var result=str.replace(/\s+/g, ' ') + str1;
        //return str.replace(/\s+/g, ' ');
        $('.res').text(result);
        return result; //i added the word cent to the last part of the return value to get desired output

    }

    function number2text(value) {
        var fraction = Math.round(frac(value)*100);
        var f_text  = "";

        if(fraction > 0) {
            f_text = "AND "+convert_number(fraction)+" PAISE";
        }

        return convert_number(value)+" RUPEE "+f_text+" ONLY";
    }

    function frac(f) {
        return f % 1;
    }

    function convert_number(number)
    {
        if ((number < 0) || (number > 999999999))
        {
            return "NUMBER OUT OF RANGE!";
        }
        var Gn = Math.floor(number / 10000000);  /* Crore */
        number -= Gn * 10000000;
        var kn = Math.floor(number / 100000);     /* lakhs */
        number -= kn * 100000;
        var Hn = Math.floor(number / 1000);      /* thousand */
        number -= Hn * 1000;
        var Dn = Math.floor(number / 100);       /* Tens (deca) */
        number = number % 100;               /* Ones */
        var tn = Math.floor(number / 10);
        var one = Math.floor(number % 10);
        var res = "";

        if (Gn>0)
        {
            res += (convert_number(Gn) + " CRORE");
        }
        if (kn>0)
        {
            res += (((res=="") ? "" : " ") +
                convert_number(kn) + " LAKH");
        }
        if (Hn>0)
        {
            res += (((res=="") ? "" : " ") +
                convert_number(Hn) + " THOUSAND");
        }

        if (Dn)
        {
            res += (((res=="") ? "" : " ") +
                convert_number(Dn) + " HUNDRED");
        }

        var ones = Array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX","SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN","FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTEEN","NINETEEN");
        var tens = Array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY","SEVENTY", "EIGHTY", "NINETY");

        if (tn>0 || one>0)
        {
            if (!(res==""))
            {
                res += " AND ";
            }
            if (tn < 2)
            {
                res += ones[tn * 10 + one];
            }
            else
            {
                res += tens[tn];
                if (one>0)
                {
                    res += ("-" + ones[one]);
                }
            }
        }

        if (res=="")
        {
            res = "zero";
        }
        return res;
    }

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }

    function invoiceAction(){
        var type = document.querySelector('input[name="selection"]:checked').value;
        var display = '';
        if(type == 1){ // auto generated
            $('.reuse-div').hide();
            display = $('input[name="auto_generate_inv_no"]').val();
            $('#inv_no_input').prop('disabled', true);
        } else { // reuse
            $('.reuse-div').show();
            display = '';
            $('#inv_no_input').prop('disabled', false);
        }
        $('#inv_no_input').val(display);
    }
    function calculation(){
        var value = parseFloat(document.getElementById('service_fee').value) ? parseFloat(document.getElementById('service_fee').value.replace(/,/g, '')) : 0;
        var sub_total = value.toFixed(2);
        var sst = 0.00;
        var sst_status = document.querySelector('input[name="sst_status"]:checked').value;
        if(sst_status == 1){ sst = value*0.06; }
        sst = sst.toFixed(2);
        var sum = parseFloat(sub_total)+parseFloat(sst);
        var total = sum.toFixed(2);
        $('#sub-total-span').html(numberWithCommas(sub_total));
        $('#sst-span').html(numberWithCommas(sst));
        $('#total-span').html(numberWithCommas(total));
        var words = toWords(total);
        var uppercase_words = words.toUpperCase();
        $('#number-word-span').html(uppercase_words);
    }

    $(document).ready(function (){
        $('.reuse-div').hide();
        $('#inv_no_input').prop('disabled', true);
        calculation();
    })
</script>
@endpush



