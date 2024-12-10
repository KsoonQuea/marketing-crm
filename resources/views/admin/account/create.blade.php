<x-admin.app-layout>
    @include('admin.caseLists.print.components.style')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom-datatable.css') }}">

    @endpush
    <x-admin.breadcrumb>
        <x-slot:breadcrumb_title>
            <h3>Create Reimbursemnet Invoice</h3>
        </x-slot:breadcrumb_title>
        <li class="breadcrumb-item active">Create Reimbursemnet Invoice</li>
        <x-slot:breadcrumb_action>
            <div class="form-group mt-3">
                <a href="{{ route('admin.account.reimbursement_index') }}" class="ms-3 btn btn-light">
                    Cancel
                </a>
                <button class="btn btn-primary" type="submit">
                    Submit
                </button>
            </div>
        </x-slot:breadcrumb_action>
    </x-admin.breadcrumb>

    <div class="card">
        <div class="card-body p-2">
        <form method="" id="generate-pdf-form" action="">
            @csrf
            <div class="row pt-2">
                <div class="col-12 col-md-8 col-lg-8">
                    <div class="overflow-auto">
                        <label class="pull-left pt-1">Platform : &nbsp; </label>
                        <select class="form-control pull-left" id="platform" name="platform" style="width:200px;">
                            <option value="0">HLBB</option>
                            <option value="1">PBB</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-4">
                    <button type="button" class="btn btn-primary pull-right" id="print-btn">
                        <i class="fa fa-print me-2"></i>Print
                    </button>
                </div>
            </div>
        </form>
            <div id="pdf-div" class="tw-p-4">
    <!-- Header -->
    <div class="w-full">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/financial-roadmap/nexus_letterhead.png'))) }}"
             style="width:100%; height:auto;margin:0 auto;">
    </div>
    <!-- Company & Proforma Info -->
    <div class="row w-full">
        <div class="column" style="width: 60%;">
            <table>
                <tr>
                    <th class="tw-p-2">
                        <div class="editTextIcon">company_name</div>
                        <div class="inputText">
                            <form action="" method="">
                                @csrf
                                <input type="hidden" name="" value=""/>
                                <textarea class="form-control pull-right" name="company_name" style="resize:none;" rows="2" cols="">company_name</textarea>
                                <div class="pull-right tw-pt-2">
                                    <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td class="tw-p-2">
                        <div class="editTextIcon">address</div>
                        <div class="inputText">
                            <form action="" method="">
                                @csrf
                                <input type="hidden" name="" value=""/>
                                <textarea class="form-control pull-right" name="address" style="resize:none;" rows="3" cols="12">address</textarea>
                                <div class="pull-right tw-pt-2">
                                    <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </td>
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
                        <form method="" action="">
                            @csrf
                            <input type="hidden" name="case_id" value=""/>
                            <button type="submit" name="auto_generate" value="1" class="btn btn-xs btn-primary">
                                <i class="fa fa-cog me-2"></i>
                                Auto Generate
                            </button>
                            <button type="submit" name="reuse" value="1" class="btn btn-xs btn-danger">
                                <i class="fa fa-undo me-2"></i>
                                Re-use
                            </button>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>DATE :</th>
                    <td>20/2/2022</td>
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
                    <td class="tw-p-2">
                        <div class="editTextIcon">attn</div>
                        <div class="inputText">
                            <form action="" method="">
                                @csrf
                                <input type="hidden" name="" value=""/>
                                <input class="form-control pull-right" type="text" name="attn" style="resize:none;" placeholder="attn">
                                <div class="pull-right tw-pt-2">
                                    <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tel :</th>
                    <td class="tw-p-2">
                        <div class="editTextIcon">tel</div>
                        <div class="inputText">
                            <form action="" method="">
                                @csrf
                                <input type="hidden" name="" value=""/>
                                <input class="form-control pull-right" type="tel" name="tel" style="resize:none;" placeholder="tel">
                                <div class="pull-right tw-pt-2">
                                    <button type="submit" class="btn btn-xs btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
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
                <td class="tw-p-2">
                    <div class="editTextIcon">description</div>
                        <div class="inputText">
                            <form action="" method="">
                            @csrf
                            <input type="hidden" name="case_id" value=""/>
                            <textarea class="form-control pull-right" name="description" style="resize:none;" rows="3" cols="12">description</textarea>
                            <div class="pull-right tw-pt-2">
                                <button type="submit" class="btn btn-xs btn-primary">Save</button>
                            </div>
                        </form>
                        </div>
                </td>
                <td class="tw-p-2 tw-text-center">
                    <div class="editTextIcon" id="inputAmount">0.00</div>
                    <div class="inputText">
                        <form action="" method="">
                            @csrf
                            <input type="hidden" name="" value=""/>
                            <input class="form-control pull-right" type="number" name="amount" style="resize:none;" placeholder="0.00" id="amount" oninput="amountInput()">
                            <div class="pull-right tw-pt-2">
                                <button type="submit" class="btn btn-xs btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <div class="w-full">
            <div style="padding-left:10px;">
                <b>RINGGIT MALAYSIA : 
                    <b id="numWord" class="tw-uppercase">ZERO</b> ONLY.
                </b>
            </div>
            <div class="border-bottom-line w-full"></div>
        </div>
    </div>
    <!-- cal -->
    <div class="w-full" style="margin-top:30px;">
        <table class="w-full">
            <tr style="width:100%;">
                <td style="width:50%;"></td>
                <td style="width:50%;">
                    <table style="width:100%;">
                        <tr>
                            <td style="width:50%;">Sub Total (Excluding SST)</td>
                            <td class="text-center" style="width:42%;" id="number">
                                <div id="inputAmount">0.00</div>
                            </td>
                            <td style="width:8%;"></td>
                        </tr>
                        <tr>
                            <td class="border-bottom-line">
                                <div class="checkbox p-0">SST 6% 
                                    <input id="default-checkbox" type="checkbox">
                                    <label style="padding-left: 10px;" for="default-checkbox">Enable SST</label>
                                </div>
                            </td>
                            <td class="border-bottom-line text-center text" id="sst">
                                <div id="inputAmount">0.00</div>
                            </td>
                            <td class="border-bottom-line"></td>
                        </tr>
                        <tr>
                            <td class="border-bottom-line">Total (Inclusive of SST)</td>
                            <td class="border-bottom-line text-center" id="final">
                                <div id="inputAmount">0.00</div>
                            </td>
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
    <div class="w-full" style="margin-top: 80px;">
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
            var icon = document.getElementsByClassName("editTextIcon");
            var i;

            for (i = 0; i < icon.length; i++) {
            icon[i].addEventListener("click", function() {
                this.classList.toggle("hideIcon");
                var content = this.nextElementSibling;
                if (content.style.maxHeight){
                content.style.maxHeight = null;
                } else {
                content.style.maxHeight = content.scrollHeight + "px";
                } 
            });
            };
        </script>
        <script>
            var totalAmount = 0;
            function amountInput() {
                const el_amount = document.getElementById("amount");
                var keyAmount = parseFloat(el_amount.value);
                document.getElementById('inputAmount').innerHTML = keyAmount;
                totalAmount = keyAmount;
                if(document.getElementById("default-checkbox").checked){
                    var sstAmount = parseFloat((keyAmount * 0.06).toFixed(2));
                    totalAmount = sstAmount + keyAmount;
                    document.getElementById('sst').innerHTML = sstAmount;
                }
                else{
                    document.getElementById('sst').innerHTML = 0;
                }
                document.getElementById('number').innerHTML = keyAmount.toFixed(2);
                document.getElementById('final').innerHTML = totalAmount.toFixed(2);
                document.getElementById('numWord').innerHTML = window.converter.toWords(totalAmount);
            };
        </script>
    @endpush
</x-admin.app-layout>
