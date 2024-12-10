<style>
    /* custom loader */
    .display-div-loader{
        width:100%;
        height:300px;
        background:#2198c380;
        text-align: center;
        padding-top: 5em;
    }
    .lds-spinner {
        /*color: official;*/
        display: inline-block;
        position: relative;
        width: 80px;
        height: 80px;
    }
    .lds-spinner div {
        transform-origin: 40px 40px;
        animation: lds-spinner 1.2s linear infinite;
    }
    .lds-spinner div:after {
        content: " ";
        display: block;
        position: absolute;
        top: 3px;
        left: 37px;
        width: 6px;
        height: 18px;
        border-radius: 20%;
        background: #fff;
    }
    .lds-spinner div:nth-child(1) {
        transform: rotate(0deg);
        animation-delay: -1.1s;
    }
    .lds-spinner div:nth-child(2) {
        transform: rotate(30deg);
        animation-delay: -1s;
    }
    .lds-spinner div:nth-child(3) {
        transform: rotate(60deg);
        animation-delay: -0.9s;
    }
    .lds-spinner div:nth-child(4) {
        transform: rotate(90deg);
        animation-delay: -0.8s;
    }
    .lds-spinner div:nth-child(5) {
        transform: rotate(120deg);
        animation-delay: -0.7s;
    }
    .lds-spinner div:nth-child(6) {
        transform: rotate(150deg);
        animation-delay: -0.6s;
    }
    .lds-spinner div:nth-child(7) {
        transform: rotate(180deg);
        animation-delay: -0.5s;
    }
    .lds-spinner div:nth-child(8) {
        transform: rotate(210deg);
        animation-delay: -0.4s;
    }
    .lds-spinner div:nth-child(9) {
        transform: rotate(240deg);
        animation-delay: -0.3s;
    }
    .lds-spinner div:nth-child(10) {
        transform: rotate(270deg);
        animation-delay: -0.2s;
    }
    .lds-spinner div:nth-child(11) {
        transform: rotate(300deg);
        animation-delay: -0.1s;
    }
    .lds-spinner div:nth-child(12) {
        transform: rotate(330deg);
        animation-delay: 0s;
    }
    @keyframes lds-spinner {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
    .nested_table{
        width: 100%;
        margin-left: 50px;
    }

    .nested_table tr td{
        margin-bottom: 10px;
    }

    .nested_table tr th{
        margin-bottom: 5px;
    }

    .title_table{
        width: 90%;
        margin-left: 50px;
    }

    .title_table tr{
        width: 100%;
    }

    .title_table tr td{
        margin-left: 50px;
    }

    .title_table tr th{
        margin-left: 50px;
        border: 2px black solid;
    }

    .title_table tr .border-bottom-line{
        margin-left: 50px;
        border: 0;
        border-bottom: 1px black solid;
    }
    .text-right{
        text-align: right;
    }

    @media print {
        .no-print {
            display: none!important;
        }
    }
</style>
<div>
    @if(isset($CaseDisburse) && count($CaseDisburse) > 0)
    <form method="POST" id="generate-pdf-form" action="{{ route('admin.print.generate-invoice') }}">
        @csrf
        <div class="row pt-2">
            <div class="col-12 col-md-8 col-lg-8 row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="overflow-auto">
                        <label class="pull-left pt-1">Platform : &nbsp; </label>
                        <select class="form-control pull-left" id="platform" name="platform" style="width:200px;">
                            @foreach($CaseDisburse as $key => $rowCaseDisburse)
                                @php
                                foreach($rowCaseDisburse->details as $detail){
                                    $stage = $detail->account_stage;
                                }
                                @endphp
                            <option value="{{ $rowCaseDisburse->details->first()->id }}" data-id="{{ $stage }}">
                                {{ $rowCaseDisburse?->bank?->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="overflow-auto">
{{--                        <label class="pull-left pt-1">Type : &nbsp; </label>--}}
{{--                        <select class="form-control pull-left" id="invoiceType" name="invoiceType" style="width:200px;" onchange="invFunc()()">--}}
{{--                        </select>--}}
                        <div id="invoiceType">
                        </div>
                    </div>
                    <input type="hidden" id="case_id" name="case_id" value="{{ $caseList->id ?? 0 }}"/>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                @can('case_agmt_pi_print_2')
                    <button type="button" class="btn btn-primary pull-right" id="print-btn">
                        <i class="fa fa-print me-2"></i>Print
                    </button>
                @endcan
            </div>
        </div>
    </form>
    @endif
    <br>
    <div>
        <div class="display-div-loader">
            <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        </div>
        <div id="display-div"></div>
    </div>
</div>


@push('scripts')
    <script>
        (function($, window) {
            $.fn.replaceOptions = function(options) {
                var self, $option;

                this.empty();
                self = this;

                $.each(options, function(index, option) {
                    $option = $("<option></option>")
                        .attr("value", option.value)
                        .text(option.text);
                    self.append($option);
                });
            };
        })(jQuery, window);

        function selectInvoiceType(stage)
        {
            if(stage > 0){
                if(stage >= 2){
                    var options = '<button type="button" id="proforma_btn" class="btn tw-text-white tw-bg-violet-500 hover:tw-bg-violet-600 active:tw-bg-violet-900 focus:tw-border-indigo-900 focus:tw-border-2 focus:ring focus:tw-bg-purple-700 me-2 invoiceType_btn" onclick="invFunc(0)" autofocus>Proforma</button> ' +
                        '<button type="button" id="inv_btn" class="btn tw-text-white tw-bg-violet-500 hover:tw-bg-violet-600 active:tw-bg-violet-900 focus:tw-border-indigo-900 focus:tw-border-2 focus:ring focus:tw-bg-purple-700 invoiceType_btn" onclick="invFunc(1)">Invoice</button>';
                } else if(stage == 1){
                    var options = '<button type="button" autofocus id="proforma_btn" class="btn tw-text-white tw-bg-violet-500 hover:tw-bg-violet-600 active:tw-bg-violet-900 focus:tw-border-indigo-900 focus:tw-border-2 focus:ring focus:tw-bg-purple-700 invoiceType_btn" onclick="invFunc(0)">Proforma</button> ';
                }
                $('#invoiceType').html(options);
                $("#proforma_btn").click();
                // invFunc();
            }
        }

        function btnSelected(){
            $('.invoiceType_btn').click(function (){
                $('.invoiceType_btn').removeClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
                $(this).addClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
            });
        }

        function invFunc(invType)
        {
            $('#display-div').html('');
            $('.display-div-loader').show();
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('admin.case-lists.show-agreement.billing-ajax') }}",
                data: {
                    invoiceType: invType,
                    platform: $('#platform').val(), //case disburse details id
                    case_id: $('#case_id').val()
                },
                success: function (result) {
                    console.log(result.type);
                    if(result.type == '0' || result.type == '1'){
                        if(result.printable == '1'){
                            $('#print-btn').show();
                        } else {
                            $('#print-btn').hide();
                        }
                    } else {
                        $('#print-btn').hide();
                    }
                    $('.display-div-loader').hide();
                    $('#display-div').html(result.content);

                    if (invType == 1){
                        $('#inv_btn').addClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
                        $('#proforma_btn').removeClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
                    }
                    else {
                        $('#inv_btn').removeClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
                        $('#proforma_btn').addClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
                    }
                }
            });
        }

        $(document).ready(function() {
            $("#print-btn").click(function() {
                $( "#generate-pdf-form" ).submit();
            });

            $('.display-div-loader').hide();
            $('#display-div').html('');
            $('#platform').on('change', function(e){
                var stage = $(this).find(':selected').data("id");
                selectInvoiceType(stage);
            });
            $('#invoiceType').on('change', function(e){
                invFunc();
            });
            selectInvoiceType({{ $CaseDisburse[0]->details[0]->account_stage ?? 0 }});
            $("#proforma_btn").addClass('tw-border-indigo-900 tw-border-2 ring tw-bg-purple-700');
            // invFunc();
            btnSelected();
        });
    </script>
@endpush
