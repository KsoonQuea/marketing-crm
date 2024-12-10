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
                        <th>SST NO :</th>
                        <td>W10-2201-32100024</td>
                    </tr>
                    <tr>
                        <th>INVOICE : &nbsp;</th>
                        <td>
                            @if($invoice && ($invoice->file_num == '' || $invoice->file_num == NULL) && $preview == 1)
                                <form method="POST" action="{{ route('admin.agreement-billing.invoice.generate-no') }}">
                                    @csrf
                                    <input type="hidden" name="case_id"     value="{{ $caseList->id }}"/>
                                    <input type="hidden" name="invoice_id"  value="{{ $invoice->id }}"/>
                                    @can('case_agmt_generate_inv_code_2')
                                        <button type="submit" name="auto_generate" value="1" class="btn btn-xs btn-primary submit-btn">
                                            <i class="fa fa-cog me-2"></i>
                                            Auto Generate
                                        </button>
                                        <button type="button" value="1" class="btn btn-xs btn-danger reuse-btn">
                                            <i class="fa fa-undo me-2"></i>
                                            Re-use
                                        </button>
                                        <div class="reuse-div row">
                                            <div class="col-8">
                                                <input type="text" class="form-control form-control-sm" name="reuse_no" id="reuse_no" value=""/>
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" name="reuse" value="1" class="btn btn-xs btn-primary">Save</button>
                                            </div>
                                            <div class="col-2">
                                                <button type="button" name="cancel_reuse" value="1" class="btn btn-xs btn-danger cancel-reuse">Cancel</button>
                                            </div>
                                        </div>
                                    @else
                                        <span>-</span>
                                    @endcan
                                </form>
                            @else
                                {{ $invoice->file_num ?? '-' }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>DATE :</th>
                        <td>{{ $invoice->date ? (date("d/m/Y",strtotime($invoice->date))) : '-' }}</td>
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
                                <form action="{{ route('admin.agreement-billing.invoice.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="case_id" value="{{ $caseList->id }}"/>
                                    <textarea class="form-control pull-right" name="description" style="resize:none;" rows="3" cols="12">{{ $invoice->description ?? '' }}</textarea>
                                    <div class="pull-right tw-pt-2">
                                        <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                        <button type="button" class="btn btn-xs btn-light btn-cancel">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class="description-span">
                            {!! $invoice->description ?? '-' !!}
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
                        <td style="width:50%;"></td>
                        <td style="width:50%;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="width:50%;">Sub Total (Excluding SST)</td>
                                    <td class="text-center" style="width:42%;">{{ number_format($approved_amount??0,2) }}</td>
                                    <td style="width:8%;"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">SST 6%</td>
                                    <td class="border-bottom-line text-center">{{ number_format($approved_sst??0,2) }}</td>
                                    <td class="border-bottom-line"></td>
                                </tr>
                                <tr>
                                    <td class="border-bottom-line">Total (Inclusive of SST)</td>
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
    <div>
</div>
<script>
    $(function (){
        $('.description-span').show();
        $('.description-textarea').hide();
        $('.btn-cancel').on('click', function(e){
            $('.description-span').toggle();
            $('.description-textarea').toggle();
        });
        $('.reuse-div').hide();
        $('.reuse-btn').on('click', function(e){
            $('.submit-btn').hide();
            $('.reuse-btn').hide();
            $('.reuse-div').show();
            $('#reuse_no').prop('required', true);
        });
        $('.cancel-reuse').on('click', function(e){
            $('.submit-btn').show();
            $('.reuse-btn').show();
            $('#reuse_no').removeAttr('required');
            $('.reuse-div').hide();
        });
    });
    function editTextarea()
    {
        $('.description-span').toggle();
        $('.description-textarea').toggle();
    }
</script>
