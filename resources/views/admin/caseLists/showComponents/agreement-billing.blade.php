@php $permission_css = $permissions['case_status_summary']; @endphp

<form method="post" action="{{ route('admin.case-lists.signAction') }}">
    @csrf
    <h5 class="tab-pane-header float-left">Agreement & Billing</h5>
    @php
        $CaseDisburse_platform = $CaseDisburse_approved_amount = $CaseDisburse_service_percent =
        $CaseDisburse_service_fee = $CaseDisburse_date = $CaseDisburse_remark = '';
        if(isset($CaseDisburse) && count($CaseDisburse) > 0){
            foreach ($CaseDisburse as $key => $rowCaseDisburse){
                $CaseDisburse_platform .= '<td class="disable-div"><input type="text" class="form-control border-0" value="'.$rowCaseDisburse?->bank?->name.'" disabled/></td>';
                $CaseDisburse_approved_amount .= '<td class="disable-div"><input type="text" id="approved_amount'.$key.'" class="form-control border-0" value="'.number_format($rowCaseDisburse?->approved_amount).'" disabled/></td>';
                $CaseDisburse_service_percent .= '<td><input type="number" name="service_fee_percent[]" min="0" max="100" steps="0.01" data-id="'.$key.'" class="service_fee_percent" style="width:20%;" value="'.$rowCaseDisburse?->service_fee_percent.'"/>%</td>';
                $CaseDisburse_service_fee .= '<td class="disable-div"><input type="text" id="service_fee_amount'.$key.'" class="form-control border-0" value="'.number_format($rowCaseDisburse?->service_fee_amount).'" disabled/></td>';
                $CaseDisburse_date .= '<td class="disable-div"><input type="text" class="form-control border-0" value="'.$rowCaseDisburse?->loan_disbursement_date.'" disabled/></td>';
                $CaseDisburse_remark .= '<td class="p-0"><textarea name="remark[]" class="p-1 border-0" style="resize:none;">'.$rowCaseDisburse?->remark.'</textarea></td>';
            }
        } else {
            $CaseDisburse_platform = $CaseDisburse_approved_amount = $CaseDisburse_service_percent =
            $CaseDisburse_service_fee = $CaseDisburse_date = $CaseDisburse_remark = '<td></td>';
        }
    @endphp
    <div class="table-responsive">
        <table class="table-bordered form-table-two w-100">
            <tbody>
                <tr>
                    <td></td>
                    {!! $CaseDisburse_platform !!}
                </tr>
                <tr>
                    <td width="200"><b>Agreement Signing Date</b></td>
                    <td colspan="{{ count($CaseDisburse) }}">
                        <input type="date" class="form-control border-0" name="agreement_sign_date" value="{{ $caseList->agreement_sign_date ?? '' }}"/>
                    </td>
                </tr>
                <tr>
                    <td><b>Approved Amount</b></td>
                    {!! $CaseDisburse_approved_amount !!}
                </tr>
                <tr>
                    <td><b>Service Fee (%)</b></td>
                    {!! $CaseDisburse_service_percent !!}
                </tr>
                <tr>
                    <td><b>Service Fee Charged</b></td>
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
            </tbody>
        </table>
    </div>

{{--    <h5 class="tab-pane-header float-left">Document</h5>--}}
{{--    <div class="row">--}}
{{--        <div class="col-12 col-md-6 col-lg-4">--}}
{{--            <div class="w-100" style="border:1px solid #e6edef;">--}}
{{--                <div class="needsclick dropzone agreement-dropzone" id="agreement-dropzone">--}}
{{--                </div>--}}
{{--                <span class="help-block" id="error"></span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    @if($permission_css['actions'] == 1)
        <input type="hidden" name="case_list_id" value="{{ $caseList->id }}" />
        <div class="mt-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-arrow-up me-2"></i>
                Submit/Update
            </button>
        </div>
    @endif
</form>

@push('scripts')
    <script>
        $('.service_fee_percent').on('input', function(e) {
            var percent = $(this).val();
            if(percent < 0 || percent > 100){ return false;}
            var key = $(this).data('id');
            var approved_amount = recoverNumberFormat($('#approved_amount'+key).val());
            var service_fee_amount = approved_amount*(percent/100);
            service_fee_amount = addCommasWithinDecimal(service_fee_amount);
            $('#service_fee_amount'+key).val(service_fee_amount);
        });
    </script>
@endpush
