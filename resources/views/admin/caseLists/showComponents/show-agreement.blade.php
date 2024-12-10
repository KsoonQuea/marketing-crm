<div class="p-3">
    @php $permission_css = $permissions['case_status_summary']; @endphp
    <form method="post" action="{{ route('admin.case-lists.signAction') }}">
        @csrf
        <div class="row">
            <div class="col-lg-6 text-left"><h5 class="tab-pane-header float-left">Agreement</h5></div>
            <div class="col-lg-6 text-right my-auto"><a class="btn btn-primary historical_buttons">Historical Record</a></div>
        </div>

        @can('case_agmt_edit_2')
            @php
            $disable = '';
            $div = '';
            $dropzone = 'agreement-dropzone';
            $dropzone_content = '';
            $disable_click = '';
            @endphp
        @else
            @php
            $disable = 'disabled';
            $div = 'disable-div';
            $dropzone = '';
            $dropzone_content = '';
            $disable_click = 'pointer-events: none';
            @endphp
        @endcan
        @if($caseType_num == 2 || $caseType_num == 3)
            @php
                $disable_click = 'pointer-events: none';
            @endphp
        @endif
        @php
            $CaseDisburse_platform = $CaseDisburse_approved_amount = $CaseDisburse_service_percent =
            $CaseDisburse_service_fee = $CaseDisburse_date = $CaseDisburse_remark = $CaseDisburse_unique_num = '';
            if(isset($CaseDisburse) && count($CaseDisburse) > 0){
                foreach ($CaseDisburse as $key => $rowCaseDisburse){
                    $CaseDisburse_unique_num .= '<input type="hidden" name="unique_num[]" value="'. $rowCaseDisburse?->unique_num .'" />';

                    if(Illuminate\Support\Facades\Gate::check('case_agmt_edit_aprv_amount')){
                        $CaseDisburse_approved_amount   .= '<td class=""><input type="text" name="approved_amount[]" id="approved_amount'.$key.'" class="form-control border-0" value="'.number_format($rowCaseDisburse?->approved_amount).'"/></td>';
                    }
                    else {
                        $CaseDisburse_approved_amount   .= '<td class="disable-div"><input type="text" name="approved_amount[] id="approved_amount'.$key.'" class="form-control border-0" value="'.number_format($rowCaseDisburse?->approved_amount).'" readonly/></td>';
                    }

                    $CaseDisburse_platform          .= '<td class="disable-div"><input type="text" class="form-control border-0" value="'.$rowCaseDisburse?->bank?->name.'" disabled/></td>';
                    $CaseDisburse_service_percent   .= '<td><input type="number" name="service_fee_percent[]" min="0" max="100" steps="0.01" data-id="'.$key.'" class="dont-disabled service_fee_percent '. $caseType_class .'" style="width:20%;" value="'.$rowCaseDisburse?->service_fee_percent.'" '.$disable.'/>%</td>';
                    $CaseDisburse_service_fee       .= '<td class="disable-div"><input type="text" id="service_fee_amount'.$key.'" class="form-control border-0" value="'.money_num_format($rowCaseDisburse?->service_fee_amount).'" disabled/></td>';
                    $CaseDisburse_date              .= '<td class="disable-div"><input type="text" class="form-control border-0" value="'.$rowCaseDisburse?->loan_disbursement_date.'" disabled/></td>';
                    $CaseDisburse_remark            .= '<td class="p-0"><textarea name="remark[]" class="p-1 border-0 w-100" style="resize:none;" '.$disable.'>'.$rowCaseDisburse?->remark.'</textarea></td>';
                }
            } else {
                $CaseDisburse_platform = $CaseDisburse_approved_amount = $CaseDisburse_service_percent =
                $CaseDisburse_service_fee = $CaseDisburse_date = $CaseDisburse_remark = '<td></td>';

                $CaseDisburse_unique_num = '';
            }
        @endphp
        <div class="table-responsive">
            <table class="table-bordered form-table-two w-100">
                <tbody>
                <tr>
                    <td width="200"><b>Agreement Signing Date</b></td>
                    <td class="pt-2 pb-2" colspan="{{ count($CaseDisburse) }}">
                        @can('case_agmt_edit_2')
                            <input type="date" class="form-control border-0 text-center {{ $caseType_class }}" name="agreement_sign_date" value="{{ $caseList->agreement_sign_date ?? '' }}"/>
                        @else
                            <input type="date" class="form-control border-0 text-center {{ $caseType_class }}" name="agreement_sign_date" value="{{ $caseList->agreement_sign_date ?? '' }}" disabled/>
                        @endcan
                    </td>
                </tr>

                @if($check_caseDisburse_num)
                    <tr>
                        {!! $CaseDisburse_unique_num !!}
                        <td width="200"><b>Platform</b></td>
                        {!! $CaseDisburse_platform !!}
                    </tr>
                    <tr>
                        <td><b>Approved Amount (RM)</b></td>
                        {!! $CaseDisburse_approved_amount !!}
                    </tr>
                    <tr>
                        <td><b>Service Fee (%)</b></td>
                        {!! $CaseDisburse_service_percent !!}
                    </tr>
                    <tr>
                        <td><b>Service Fee Charged (RM)</b></td>
                        {!! $CaseDisburse_service_fee !!}
                    </tr>
                    <tr>
                        <td><b>Loan Disbursement Date</b></td>
                        {!! $CaseDisburse_date !!}
                    </tr>
                    <tr>
                        <td><b>Remark</b></td>
                        {!! $CaseDisburse_remark !!}
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        <br>
        <h5 class="tab-pane-header float-left">Document</h5>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 w-100">
                <div class="w-100" style="border:1px solid #e6edef;">
                    <div class="needsclick dropzone agreement-dropzone {{ $div }}" style="{{ $disable_click }}" id="agreement-dropzone">
                    </div>
                    <span class="help-block" id="error"></span>
                </div>
            </div>
        </div>
        @can('case_agmt_edit_2')
            <br><input type="hidden" class="dont-disabled" name="case_list_id" value="{{ $caseList->id }}" />
            @if($caseType_num != 2 && $caseType_num != 3)
                <div class="mt-2">
                    <button type="submit" name="update_btn" value="1" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-up me-2"></i>
                        Submit/Update
                    </button>
                </div>
            @else
                <div class="mt-2">
                    <button type="submit" name="update_after_btn" value="1" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-up me-2"></i>
                        Update
                    </button>
                </div>
            @endif
        @endcan
    </form>

    <div id="historicalRecordModal" class="modal">
        <div class="modal-content tw-mx-auto tw-my-36">
            <div class="modal-header">
                <h4 class="modal-inside-title">Historical Record</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-responsive-sm">
                            <thead>
                                <tr>
                                    <th scope="col">User</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">Edited Approved Amount (RM)</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($approved_amount_logs)
                                @foreach($approved_amount_logs as $approved_amount_log)
                                    <tr>
                                        <td>{{$approved_amount_log->user->name}}</td>
                                        <td>{{$approved_amount_log->case_disburse->bank->name}}</td>
                                        <td>{{number_format($approved_amount_log->previous_amount) .' → '. number_format($approved_amount_log->current_amount)}}</td>
                                        <td>{{$approved_amount_log->updated_at}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

            <div class="button-container mt-3">
                <button type="button" class="cancel btn btn-light">Cancel</button>
            </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
        <script>
            $('.service_fee_percent').on('input', function(e) {
                var percent = $(this).val();
                if(percent < 0 || percent > 100){ return false;}
                var key = $(this).data('id');
                var approved_amount = recoverNumberFormat($('#approved_amount'+key).val());
                var service_fee_amount = parseFloat(approved_amount*(percent/100)).toFixed(2);
                console.log(service_fee_amount);
                service_fee_amount = addCommasWithinDecimal(service_fee_amount);

                if (service_fee_amount.split('.')[1] == null){
                    service_fee_amount = service_fee_amount + '.00';
                }

                $('#service_fee_amount'+key).val(service_fee_amount);
            });
        </script>
        <script>
            Dropzone.autoDiscover = false;
            var uploadedAgreementMap= {};
            var agreementDropzone = new Dropzone("div#agreement-dropzone",{
                url: '{{ route('admin.case-lists.storeMedia') }}',
                maxFilesize: 2, // MB
                acceptedFiles: '.pdf,.png,.jpeg,.jpg',
                maxFiles: 1,
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    $('form').append('<input type="hidden" name="agreement[]" value="' + response.name + '">')
                    uploadedAgreementMap[file.name] = response.name
                },
                removedfile: function (file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedAgreementMap[file.name]
                    }
                    $('form').find('input[name="agreement[]"][value="' + name + '"]').remove()
                },
                init: function () {
                    @if (isset($agreement_document) && $agreement_document)
                    var files = {!! json_encode($agreement_document) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="agreement[]" value="' + file.file_name + '">')
                    }
                    @endif
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

                    return _results
                }
            });

            // $("#update_btn").click(function (e){
            //
            //     if($('#agreement-dropzone').valid()){
            //
            //         alert('nono');
            //
            //         e.preventDefault();
            //
            //         e.stopPropagation();
            //
            //         agreementDropzone.processQueue();
            //
            //     }
            // });

            // $("#update_btn").("click", function(e) {
            //
            //     alert('test');
            //
            //     if($('#agreement-dropzone').valid()){
            //
            //         e.preventDefault();
            //
            //         e.stopPropagation();
            //
            //         agreementDropzone.processQueue();
            //
            //     }
            // });

            $('.historical_buttons').click(function(event) {
                // var detail_id = $(this).data('detail-id');
                // $('#case_disburse_detail_id').val(detail_id);
                $('#historicalRecordModal').show();
                // event.stopPropagation();
            });
        </script>
    @endpush
</div>
