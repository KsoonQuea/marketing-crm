@include('admin.caseLists.print.components.style')

<div id="pdf-div">
    <!-- Header -->
    <div class="w-full">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/financial-roadmap/nexus_letterhead.png'))) }}"
             style="width:115%; height:auto; margin:0 auto;">
    </div>
    <div style="margin-left:10px; margin-right:10px;">
        <!-- Company & Proforma Info -->
        <div class="row w-full">
            <div class="column" style="width: 60%;">
                <table>
                    <tr>
                        <th>{{ $caseList->company_name ?? '-' }}</th>
                    </tr>
                    <tr>
                        <td style="padding-right:80px;">{{ $caseList->address ?? '-' }}</td>
                    </tr>
                </table>
            </div>
            <div class="column" style="width: 40%;">
                <table>
                    <tr>
                        <th colspan="2">PROFORMA INVOICE</th>
                    </tr>
                    <tr>
                        <th>SST NO :</th>
                        <td>W10-2201-32100024</td>
                    </tr>
                    <tr>
                        <th>INVOICE : &nbsp;</th>
                        <td>
                            {{ $proforma_content['invoice_no'] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>DATE :</th>
                        <td>{{ $proforma_content['date'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>TERM :</th>
                        <td>{{ $proforma_content['term'] ?? '-' }}</td>
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
                        <td>{{ $caseDirectorCommitment->director_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tel :</th>
                        <td>{{ $caseDirectorCommitment->phone ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Description -->
        <div class="w-full">
            @php
                $approved_amount = $caseDisbursement ? $caseDisbursement->service_fee_amount : 0;
                $approved_sst = ($approved_amount > 0) ? ($approved_amount*0.06) : 0;
                $final_approved = $approved_amount+$approved_sst;
                if($final_approved <= 0) { $amount_word = 'ZERO'; } else { $amount_word = strtoupper(convertNumberToWord(number_format($final_approved, 2, '.'))); }
            @endphp
            <table class="w-full" style="margin:25px 0;">
                <tr class="border-tr">
                    <th style="width: 70%;padding-left:10px;">Description</th>
                    <th style="width: 30%;text-align: center;">Amount</th>
                </tr>
                <tr>
                    <td style="padding:8px;">
                        @if($caseList->case_status > 0 && $preview == 1)
                            <div class="description-textarea">
                                <form action="{{ route('admin.agreement-billing.proforma.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="case_id" value="{{ $caseList->id }}"/>
                                    <textarea class="form-control pull-right" name="description" style="resize:none;" rows="3" cols="12">{{ $proforma->description ?? '' }}</textarea>
                                    <div class="pull-right" style="padding-top:8px">
                                        <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                        <button type="button" class="btn btn-xs btn-light btn-cancel">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class="description-span">
                            {!! $proforma->description ?? '-' !!}
                            @if($caseList->case_status > 0)
                                <a href="javascript:void(0);" class="ms-2 no-print" onclick="editTextarea();"><i class="fa fa-edit text-primary"></i></a>
                            @endif
                        </div>
                    </td>
                    <td style="text-align: center;">{{ number_format($approved_amount,2) }}</td>
                </tr>
            </table>
        </div>

        <div style="width:100%; height:550px; position:relative;">
            <!-- cal -->
            <div class="w-full" style="margin-top:220px; position:absolute;">
                <div class="w-full">
                    <div style="padding-left:10px;"><b>RINGGIT MALAYSIA : {{ $amount_word }} ONLY.</b></div>
                    <div class="border-bottom-line w-full"></div>
                </div>
                <table class="w-full">
                    <tr style="width:100%;">
                        <td style="width:60%;"></td>
                        <td style="width:40%;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="width:45%;">Total</td>
                                    <td class="text-center" style="width:40%;">{{ number_format($approved_amount??0,2) }}</td>
                                    <td style="width:15%;"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">SST 6%</td>
                                    <td class="border-bottom-line text-center">{{ number_format($approved_sst??0,2) }}</td>
                                    <td class="border-bottom-line"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">SUB TOTAL (RM)</td>
                                    <td class="border-bottom-line text-center">{{ number_format($final_approved??0,2) }}</td>
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
                        <td style="width: 50%;">Note:</td>
                        <td style="width: 35%;"></td>
                        <td style="width: 15%;"></td>
                    </tr>
                    <tr class="w-full">
                        <td style="width: 50%">All cheques must be crossed and</td>
                        <td class="border-bottom-line" style="width: 45%;"></td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr class="w-full">
                        <td style="width: 50%">made payable to</td>
                        <td style="width: 35%;"><b>Acknowledge Signature</b></td>
                        <td style="width: 15%;"></td>
                    </tr>
                    <tr class="w-full">
                        <td style="width: 50%"><b>Nexus Capital Sdn Bhd</b></td>
                        <td style="width: 35%;"><b>Name :</b></td>
                        <td style="width: 15%;"></td>
                    </tr>
                    <tr class="w-full">
                        <td style="width: 50%"><b>CIMB Bank : 8010 6502 38</b></td>
                        <td style="width: 35%;"><b>Date :</b></td>
                        <td style="width: 15%;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(function (){
        $('.description-span').show();
        $('.description-textarea').hide();
        $('.btn-cancel').on('click', function(e){
            $('.description-span').toggle();
            $('.description-textarea').toggle();
        });
    });
    function editTextarea()
    {
        $('.description-span').toggle();
        $('.description-textarea').toggle();
    }
</script>
