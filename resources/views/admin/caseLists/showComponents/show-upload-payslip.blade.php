<style>
    .document-folder-first{
        background: red;
    }
    .documents-title{
        color:#ffffff;
        padding:0.25em 1em;
        margin:5px 0 0 0;
        background-color:#2198c3;
        font-weight:600;
    }
    .document-folder-files{
        border-bottom:1px solid gray;
        background: #ffffff ;
        color:#002855 ;
        font-weight:400;
        font-size:0.9em;
        margin:0;
    }
    .document-folder-files-none{
        padding: 3px 17px!important;
        background: #f5f7fb;
        color:gray;
        font-weight:400;
        font-size:0.9em;
        margin:0;
    }
    .btn-documents{
        background:#ffffff00;
        color:#ffffff;
        margin-top:-2px!important;
        font-size:0.8em!important;
        padding: 0.375rem 0.5rem!important;
    }
    .btn-documents:hover{ color:#ffffff70!important; }
    .image_grid input:checked + .caption::after{
        color: #9bfb54!important;
        border:none!important;
        left:90%!important;
    }
    .check-color{
        /*color:black!important;*/
        font-size: 14px;
        margin-left: 15px;
    }
    .fa-check-circle-o{
        font-size: 15px;
        color: #e6e6e6;
    }
    .btn-pending{
        margin-top:-2px!important;
        font-size:0.8em!important;
        padding: 0.375rem 0.5rem!important;
        color: #000;
    }
    .btn-pending:hover{
        color: #2198c3;
    }

</style>

<div class="row">
    <div class="col-6 text-left"><h5 class="tab-pane-header">Upload Payment Proof</h5></div>
        @can('case_agmt_upload_payment_2')
            <div class="col-6 text-right my-auto"><button type="button" data-detail-id="" class="btn btn-primary btn-documents create_buttons">Create Payment</button></div>
        @endcan
</div>

<div class="p-1">
    @forelse($CaseDisburse as $rowCaseDisburse)
        <div class="pl-1">
            <div class="documents-title"> {{ $rowCaseDisburse?->bank?->name }}
                <i class="document-triangle fa fa-angle-down"></i>
                <div class="float-right">
                     @can('case_agmt_upload_payment_2')
                        <span class="text-warning w-50">{{ money_num_format($rowCaseDisburse->case_disburse_detail->payments->sum('paid_amount') ?? 0).' / '.money_num_format($rowCaseDisburse->service_fee_amount * 1.06) }}</span>
                        <button type="button" data-detail-id="{{ $rowCaseDisburse->case_disburse_detail->id }}" class="btn btn-primary btn-documents upload_buttons">
                            <i class="fa fa-upload"></i>
                        </button>
                     @endcan
                </div>
            </div>
            {{--                    <div class="tw-flex tw-justify-between payslip-check">--}}
            {{--                        <a href="#" target="_blank">--}}
            {{--                            <span class="tw-ml-4">Filename.pdf</span>--}}
            {{--                        </a>--}}
            {{--                        <button type="button" id="payslip_check" class="btn btn-pending">--}}
            {{--                            <i class="check fa fa-refresh check-color"></i>--}}
            {{--                            <span class="payslip-check-text tw-pl-1">Pending</span>--}}
            {{--                        </button>--}}
            {{--                    </div>--}}
            <div class="tw-border tw-border-solid tw-border-slate-300">
                @forelse($rowCaseDisburse->case_disburse_detail->payments as $key1 => $rowPayment)
                    @php $count = 0; @endphp
                    @foreach($rowPayment->document as $key2 => $doc)
                        @php $count++ @endphp
                    <div class="tw-flex tw-justify-between payslip-check w-full" style="border-bottom:1px solid black;">
                        <a href="{{ $doc->url }}" target="_blank" class="tw-ml-4 text-dark">{{ $doc->file_name }}</a>

                        <div style="width:300px;">
                            @can('case_agmt_remove_payment_2')
                            <button type="button" class="btn btn-pending delete-btn pull-right text-danger" data-id="{{ $rowPayment->id }}">
                                <i class="check fa fa-trash check-color"></i>
                                Delete
                            </button>
                            @endcan
                            @can('case_agmt_check_payment_2')
                                @if($rowPayment->status == 1)
                                <button type="button" class="payslip_check btn btn-pending pull-right" data-id="{{ $rowPayment->id }}" value="{{ $rowPayment->status }}">
                                    <i class="check fa fa-check-circle check-color"></i>
                                    <span class="payslip-check-text tw-pl-1">{{ \App\Models\Payments::STATUS_SELECT[$rowPayment->status] }}</span>
                                </button>
                                @else
                                <button type="button" class="update-button btn btn-pending pull-right" data-id="{{ $rowPayment->id }}" value="{{ $rowPayment->status }}">
                                    <i class="check fa fa-refresh check-color"></i>
                                    <span class="payslip-check-text tw-pl-1">{{ \App\Models\Payments::STATUS_SELECT[$rowPayment->status] }}</span>
                                </button>
                                @endif
                            @endcan
                        </div>
                    </div>
                    @endforeach
                    @if($count == 0)
                        <div class="tw-flex tw-justify-between payslip-check w-full" style="border-bottom:1px solid black;">
                            <span class="text-muted tw-ml-4">No documents found</span>
                                <div style="width:300px;">
                                    @can('case_agmt_remove_payment_2')
                                    <button type="button" class="btn btn-pending delete-btn pull-right text-danger" data-id="{{ $rowPayment->id }}">
                                        <i class="check fa fa-trash check-color"></i>
                                        Delete
                                    </button>
                                    @endcan

                                    @can('case_agmt_check_payment_2')
                                        @if($rowPayment->status == 1)
                                            <button type="button" class="payslip_check btn btn-pending pull-right" data-id="{{ $rowPayment->id }}" value="{{ $rowPayment->status }}">
                                                <i class="check fa fa-check-circle check-color"></i>
                                                <span class="payslip-check-text tw-pl-1">{{ \App\Models\Payments::STATUS_SELECT[$rowPayment->status] }}</span>
                                            </button>
                                        @else
                                            <button type="button" class="update-button btn btn-pending pull-right" data-id="{{ $rowPayment->id }}" value="{{ $rowPayment->status }}">
                                                <i class="check fa fa-refresh check-color"></i>
                                                <span class="payslip-check-text tw-pl-1">{{ \App\Models\Payments::STATUS_SELECT[$rowPayment->status] }}</span>
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                        </div>
                    @endif
                @empty
                    <p class="col-12 m-0 imageandtext image_grid case-document-container document-folder-files-none">No documents found</p>
                @endforelse
            </div>
        </div>
    @empty
        <div>No Platform choosen yet.</div>
    @endforelse
</div>

<!-- create Modal -->
<div id="uploadSlipModal" class="modal">
    <div class="modal-content tw-mx-auto tw-my-36">
        <div class="modal-header">
            <h4 class="modal-inside-title">Payment Proof Upload</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.payments.upload-payslip') }}" class="fulltime-form">
                @csrf
                <input type="hidden" name="case_id" value="{{ $caseList->id }}"/>
                <input type="hidden" name="case_disburse_detail_id" id="case_disburse_detail_id">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="mb-1">
                            <label>Cheque No.</label>
                            <input type="text" name="cheque_no" class="form-control"/>
                        </div>
                        <div class="mb-1">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control"/>
                        </div>
{{--                        <div class="mb-1">--}}
{{--                            <label>OR</label>--}}
{{--                            <input type="text" name="or" class="form-control"/>--}}
{{--                        </div>--}}
{{--                        <div class="mb-1">--}}
{{--                            <label>SST Paid Date</label>--}}
{{--                            <input type="date" name="sst_paid_date" class="form-control"/>--}}
{{--                        </div>--}}
                        <div class="">
                            <label>Paid Amount</label>
                            <input type="text" name="paid_amount" class="form-control bank-stt-input" value="0" min="0"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="document">Payment Proof</label>
                            <div class="needsclick dropzone wont_disabled" id="payslip-dropzone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="cancel btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- update Modal -->
<div id="updateSlipModal" class="modal">
    <div class="modal-content tw-mx-auto tw-my-36">
        <div class="modal-header">
            <h4 class="modal-inside-title">Payment Proof Action</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.payments.update-payslip') }}" class="fulltime-form">
                @csrf
                <input type="hidden" name="case_id" value="{{ $caseList->id }}"/>
                <input type="hidden" name="payment_id" id="payment_id">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="mb-1">
                            <label>Cheque No.</label>
                            <input type="text" id="cheque_no" name="cheque_no" class="form-control"/>
                        </div>
                        <div class="mb-1">
                            <label>Date</label>
                            <input type="date" id="date" name="date" class="form-control"/>
                        </div>
                        <div class="mb-1">
                            <label>OR</label>
                            <input type="text" id="or" name="or" class="form-control"/>
                        </div>
                        <div class="">
                            <label>Paid Amount</label>
                            <input type="text" id="paid_amount" name="paid_amount" class="form-control bank-stt-input" value="0" min="0"/>
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label for="document">Payment Proof</label>
                            <div>
                                <table class="table table-bordered table-xs">
                                    <thead>
                                        <tr>
                                            <th>Link</th>
                                        </tr>
                                    </thead>
                                    <tbody id="payslip-links"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" name="submit_btn" value="1" class="btn btn-secondary">Submit</button>
                    <button type="submit" name="done_btn" value="1" class="btn btn-primary" onclick="return confirm('Confirm to Done?');">Done</button>
                    <button type="button" class="cancel btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Payment Modal -->
<div id="createSlipModal" class="modal">
    <div class="modal-content tw-mx-auto tw-my-36">
        <div class="modal-header">
            <h4 class="modal-inside-title">Create Payment</h4>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('admin.payments.create-payslip') }}" class="fulltime-form">
                @csrf
                <input type="hidden" name="case_id" value="{{ $caseList->id }}"/>
                <input type="hidden" name="case_disburse_detail_id" id="case_disburse_detail_id">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-between text-center">
                            <div class="col-2">
                                <p class="f-w-800 mb-2">Payment Method</p>
                                <p class="btn btn-primary rounded-pill w-100">By Cheque</p>
                            </div>
                            <div class="col-2">
                                <p class="f-w-800 mb-2">Cheque No.</p>
                                <input type="text" name="cheque_no" class="btn btn-primary rounded-pill w-100"/>
                            </div>
                            <div class="col-2">
                                <p class="f-w-800 mb-2">Payment Date</p>
                                <input type="date" name="date" class="btn btn-primary rounded-pill w-100"/>
                            </div>

                                <?php $total_outstanding = 0; ?>
                                @foreach($CaseDisburse as $key => $rowCaseDisburse)
                                    <?php
                                        $total_amount = ($rowCaseDisburse->service_fee_amount * 1.06) - ($rowCaseDisburse->case_disburse_detail->payments->sum('paid_amount') ?? 0);
                                        $total_outstanding += $total_amount;
                                    ?>
                                @endforeach

                            <div class="col-2">
                                <p class="f-w-800 mb-2">Outstanding Amount</p>
                                <input type="text" name="outstanding_amount" class="btn btn-primary rounded-pill bank-stt-input w-100" value="{{$total_outstanding}}"/>
                            </div>
                            <div class="col-2">
                                <p class="f-w-800 mb-2">Payment Amount</p>
                                <input type="text" name="paid_amount" class="btn btn-primary rounded-pill bank-stt-input w-100" value="0" min="0"/>
                            </div>
                        </div>
                    </div>

                    <hr/>

                    <div class="col-12">
                        @foreach($CaseDisburse as $key => $rowCaseDisburse)
                            <input type="hidden" name="bank_id" value="{{$rowCaseDisburse->bank_id}}"/>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <p class="f-w-800 mb-2">{{ $rowCaseDisburse->bank->name }}</p>
                                </div>
                                <div class="col-10">
                                    <div class="btn btn-primary rounded-pill d-flex justify-content-between" style="cursor: default !important">
                                        <div></div>
                                        <div>{{ money_num_format($rowCaseDisburse->case_disburse_detail->payments->sum('paid_amount') ?? 0).' / '.money_num_format($rowCaseDisburse->service_fee_amount * 1.06) }}</div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <input type="text" name="bank_paid_amount[{{$rowCaseDisburse->bank_id}}]"  class="btn btn-primary rounded-pill bank-stt-input w-100" value="0" min="0"/>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-12">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="document">Payment Proof</label>
                                <div class="needsclick dropzone wont_disabled" id="payslip-all-dropzone">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="cancel btn btn-light">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script>
        // dropzone
        Dropzone.autoDiscover = false;
        var uploadedPhotoMap = {}
        var payslipDropzone = new Dropzone("div#payslip-dropzone",{
            url: '{{ route('admin.payments.storeMedia') }}',
            addRemoveLinks: true,
            maxFiles: 1,
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedPhotoMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotoMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function () {
                this.on("addedfile", function() {
                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                });
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }
                return _results;
            }
        });
    </script>
    <script>
        // dropzone
        Dropzone.autoDiscover = false;
        var uploadedPhotoMap = {}
        var payslipDropzone = new Dropzone("div#payslip-all-dropzone",{
            url: '{{ route('admin.payments.storeMedia') }}',
            addRemoveLinks: true,
            maxFiles: 1,
            maxfilesexceeded: function(file) {
                this.removeAllFiles();
                this.addFile(file);
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedPhotoMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = '';
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotoMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function () {
                this.on("addedfile", function() {
                    if (this.files[1]!=null){
                        this.removeFile(this.files[0]);
                    }
                });
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }
                return _results;
            }
        });
    </script>
    <script>
        // onload page
        $(document).ready(function() {
            $('.documents-title').click(function(e) {
                if ($(this).next().is(":visible")) {
                    $(this).next().hide();
                    $(this).find('.document-triangle').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                    $(this).next().show();
                    $(this).find('.document-triangle').removeClass('fa-angle-down').addClass('fa-angle-up');
                }
            });

            $('.case-document-container').click(function(e) {
                if (!$('#select').is(":visible")) {
                    e.preventDefault();
                    $(this).find('.document-check-box').prop('checked', !$(this).find('.document-check-box')
                        .prop('checked'));
                }
            });

            $('.upload_buttons').click(function(event) {
                var detail_id = $(this).data('detail-id');
                $('#case_disburse_detail_id').val(detail_id);
                $('#uploadSlipModal').show();
                event.stopPropagation();
            });

            $('.create_buttons').click(function(event) {
                var detail_id = $(this).data('detail-id');
                $('#case_disburse_detail_id').val(detail_id);
                $('#createSlipModal').show();
                event.stopPropagation();
            });

            $('.update-button').click(function(event) {
                var id = $(this).data('id');
                $('#payment_id').val(id);
                event.stopPropagation();
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.payments.fetch-data') }}',
                    data: { id: id, status: status },
                    success: function (result) {
                        var payment = result.payment;
                        $('#cheque_no').val(payment.cheque_no);
                        $('#date').val(payment.date);
                        $('#or').val(payment.or);
                        $('#paid_amount').val(payment.paid_amount);
                        var links = '<tr>';
                        if(result.documents.length == 0){
                            links += '<td>No Result.</td>';
                        }
                        $.each(result.documents, function(k, v) {
                            links += '<td><a href="'+v.url+'" target="_blank">'+v.file_name+'</a></td>';
                        });
                        links += '<tr>';
                        $('#payslip-links').html(links);
                        $('#updateSlipModal').show();
                    }
                });
            });

            $('.cancel').click(function() {
                $(this).parent().parent().parent().parent().parent().hide();
            });
        });

        $('.payslip_check').click(function(e) {
            var status = $(this).val();
            if(status == 0){
                var id = $(this).data('id');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.payments.update-status') }}',
                    data: { id: id, status: status }
                }).done(function () { location.reload() });
            }
        });

        $('.delete-btn').click(function(e) {
            if(confirm('Confirm to Remove?')){
                var id = $(this).data('id');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
                $.ajax({
                    method: 'POST',
                    url: '{{ route('admin.payments.remove-payment') }}',
                    data: { id: id }
                }).done(function () { location.reload() });
            }
        });
    </script>

    <script>
        $('input[name^="bank_paid_amount"]').on('input', function () {
            var total = 0;
            $('input[name^="bank_paid_amount"]').each(function () {
                var value = $(this).val().replace(',', '');
                if (value !== "") {
                    total += parseFloat(value);
                }
            });
            $('input[name="paid_amount"]').val(total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        });
    </script>
@endpush
