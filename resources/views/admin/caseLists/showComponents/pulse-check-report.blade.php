@php $permission_pcr = $permissions['pulse_check_report']; @endphp
<style>
    .able-input-color-bg{
        background-color: #fff9d8 !important;
    }
</style>
<form method="post" id="pcr-form" action="{{ route('admin.case-lists.pcrUpdate') }}">
    @csrf
    <div class="print-area" id="pcr-print-area">
        <h5 class="tab-pane-header">Nexus Financial Pulse Check Report</h5>
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td class="w-25">Company Name</td>
                    <td>{{ $credit_report->company_name ?? '' }}</td>
                </tr>
                <tr>
                    <td>Business Incorporation Date</td>
                    <td>{{ $credit_report->incorporation_date ?? '' }}</td>
                </tr>
                <tr>
                    <td>Business Industry</td>
                    <td>{{ $credit_report->business_industry ?? '' }}</td>
                </tr>
                <tr>
                    <td>Business Activity(ies)</td>
                    <td>{{ $credit_report->business_activity ?? '' }}</td>
                </tr>
                <tr>
                    <td>Business Operating Address</td>
                    <td>{{ $credit_report->address ?? '' }}</td>
                </tr>
                <tr>
                    <td>Type of Application</td>
                    <td>
                        {{ implode(', ', $credit_report_application_type) }}
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>{{ $credit_report->application_date ?? '' }}</td>
                </tr>
                <tr>
                    <td>New Financing Amount (RM)</td>
                    <td>RM {{ number_format(($pcr_display['new_financing_amount'] ?? 0),2) }}</td>
                </tr>
            </table>
        </div>

        <h5 class="tab-pane-header">Latest Year For Financial Analysis</h5>
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td colspan="2"><b>Latest Year For Financial Analysis</b></td>
                    @can('case_pcr_edit_2')
                        <td class="able-input-color-bg"><input class="{{ $caseType_class }} able-input-color-bg datepicker-here text-input-class digits keyup_datepicker" type="text" data-language="en" name="date" value="{{ old('date',($case_report_recommendation->date ?? '')) }}" placeholder="YYYY-MM-DD"></td>
                    @else
                        <td><input class="{{ $caseType_class }} datepicker-here text-input-class digits keyup_datepicker" type="text" data-language="en" name="date" value="{{ old('date',($case_report_recommendation->date ?? '')) }}" placeholder="YYYY-MM-DD" disabled></td>
                    @endcan
{{--                    <td><input class=" text-input-class digits" type="text" data-language="en" name="date" value="{{ old('date',($case_report_recommendation->date ?? '')) }}" placeholder="YYYY-MM-DD" readonly></td>--}}
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td><b>(RM)</b></td>
                </tr>
                <tr>
                    <td width="40">A) </td>
                    <td>Latest EBITDA / Income after Statutory Deductions [e.g. TAX, EPF, SOCSO etc]</td>
                    <td width="200">{{ number_format(($credit_report->a ?? 0),2) }}</td>
                </tr>
                <tr>
                    <td>B) </td>
                    <td>Latest Profit Before Tax</td>
                    <td>{{ number_format(($credit_report->b ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>C) </td>
                    <td>Latest Profit After Tax</td>
                    <td>{{ number_format(($credit_report->c ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>D) </td>
                    <td>Monthly Average Credit Transactions for latest 6 months of bank statement</td>
                    <td>{{ number_format(($credit_report->d ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>E) </td>
                    <td>Monthly Average Month-end Balance for latest 6 months of bank statement</td>
                    <td>{{ number_format(($credit_report->e ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>F) </td>
                    <td>Total Tangible Net Worth</td>
                    <td>{{ number_format(($credit_report->f ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>G) </td>
                    <td>Latest Paid-up Capital (Share Capital)</td>
                    <td>{{ number_format(($credit_report->g ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>H) </td>
                    <td>Amount due from director / related companies / customer</td>
                    <td>{{ number_format(($credit_report->h ?? 0), 2) }}</td>
                </tr>
                <tr>
                    <td>I) </td>
                    <td>Amount due to director / related companies / customer</td>
                    <td>{{ number_format(($credit_report->i ?? 0), 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="pagebreak"> </div>

        <h5 class="tab-pane-header">Company Profile Assessment</h5>
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td width="40"><b>No.</b></td>
                    <td><b>Company Profile Assessment</b></td>
                    <td width="200"><b>Yes\No\NA</b></td>
                </tr>
                @can('case_pcr_edit_2')
                    <tr>
                        <td>A) </td>
                        <td>Business is registered in Malaysia</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[0] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>B) </td>
                        <td>Business is ≥ 2 years old</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[1] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>C) </td>
                        <td>Positive CTOS (Legal Case / Bankruptcy / Winding Up)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[2] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>D) </td>
                        <td>Positive Trade Reference Check</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[3] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>E) </td>
                        <td>CCRIS Check</td>
                        <td class="bg-primary-light">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Any '3' MIA in the past 12 months?</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[4] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>More than 3 times '2' MIA in the past 6 months</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[5] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>6 times '2' MIA in past 6 months</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[6] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>CCRIS record shows legal status / AKPK / Special Attention Account</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[7] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>F) </td>
                        <td>Company with inter-company sales ≥ 40% (based on 2 years)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[8] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>G) </td>
                        <td>Consent to obtain Corporate Guarantor (CG)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0 able-input-color-bg">
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[9] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>A) </td>
                        <td>Business is registered in Malaysia</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[0] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>B) </td>
                        <td>Business is ≥ 2 years old</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[1] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>C) </td>
                        <td>Positive CTOS (Legal Case / Bankruptcy / Winding Up)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[2] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>D) </td>
                        <td>Positive Trade Reference Check</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[3] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>E) </td>
                        <td>CCRIS Check</td>
                        <td class="bg-primary-light">
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Any '3' MIA in the past 12 months?</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[4] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>More than 3 times '2' MIA in the past 6 months</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[5] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>6 times '2' MIA in past 6 months</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[6] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>CCRIS record shows legal status / AKPK / Special Attention Account</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[7] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>F) </td>
                        <td>Company with inter-company sales ≥ 40% (based on 2 years)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[8] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>G) </td>
                        <td>Consent to obtain Corporate Guarantor (CG)</td>
                        <td class="p-0 td-select">
                            <select name="assessment_answer[]" class="form-control border-0" disabled>
                                @foreach(\App\Models\CaseCriterion::ANSWER_SELECT as $val => $answer)
                                    <option value="{{ $val }}" {{($case_criterion[9] == $val) ? 'selected' : ''}}>
                                        {{ $answer }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endcan
            </table>
        </div>

        <h5 class="tab-pane-header">New Financial Position</h5>
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td width="40"><b>No.</b></td>
                    <td><b>New Financial Position</b></td>
                    <td width="200"><b>RM</b></td>
                </tr>
                <tr>
                    <td>A) </td>
                    <td>New Financing Commitment (per annum)</td>
                    <td>{{ number_format(($pcr_display['nfc_per_annum'] ?? 0)) }}</td>
                </tr>
                <tr>
                    <td>B) </td>
                    <td>New Total Annual Commitment (Current commitments + New
                        Commitments)
                    </td>
                    <td>{{ number_format(($pcr_display['new_total_annual_commitment'] ?? 0)) }}</td>
                </tr>
                <tr>
                    <td>C) </td>
                    <td>New Total Borrowings</td>
                    <td>{{ number_format(($pcr_display['new_total_borrowings'] ?? 0)) }}</td>
                </tr>
            </table>
        </div>

        <h5 class="tab-pane-header">Comparison On Financial Position</h5> &nbsp;
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td width="40"><b>No.</b></td>
                    <td><b>Item</b></td>
                    <td><b>Current Position</b></td>
                    <td><b>New position</b></td>
                </tr>
                <tr>
                    <td>A) </td>
                    <td>DSR (Financial Report)</td>
                    <td>{{ number_format($pcr_display['dsr_financial_report_current'],2) }}</td>
                    <td>{{ number_format($pcr_display['dsr_financial_report_new'],2) }}</td>
                </tr>
                <tr>
                    <td>B) </td>
                    <td>DSR (Bank Statement)</td>
                    <td>{{ number_format($pcr_display['dsr_bank_statement_current'],2) }}</td>
                    <td>{{ number_format($pcr_display['dsr_bank_statement_new'],2) }}</td>
                </tr>
                <tr>
                    <td>C) </td>
                    <td>GEARING ≤ 4X</td>
                    <td>{{ number_format($pcr_display['dsr_gearing_current'],2) }}</td>
                    <td>{{ number_format($pcr_display['dsr_gearing_new'],2) }}</td>
                </tr>
            </table>
        </div>

        <h5 class="tab-pane-header">Recommendation</h5> &nbsp;
        @can('case_pcr_edit_2')
            <textarea name="recommendation" class="form-control" cols="30" rows="4" style="resize:none;">{{ old('recommendation',($case_report_recommendation->recommendation ?? '')) }}</textarea>
        @else
            <textarea name="recommendation" class="form-control" cols="30" rows="4" style="resize:none;" disabled>{{ old('recommendation',($case_report_recommendation->recommendation ?? '')) }}</textarea>
        @endcan
    </div>
    <input type="hidden" name="case_list_id" value="{{ $caseList->id }}" />
    <!-- buttons -->
    <div class="w-full mt-3">
        @if($caseType_num != 2 && $caseType_num != 3)
        @can('case_pcr_edit_2')
            <button type="submit" class="btn btn-primary btn-sm float-left me-2 {{ $caseType_class }}">
                <i class="fa fa-arrow-up me-2"></i>
                Submit/Update
            </button>
        @endcan
        @endif
        @can('case_pcr_download_2')
                <a href="{{ route("admin.case-lists.print.generate-pcr", $caseList->id) }}" data-id="{{ $caseList->id }}" class="btn btn-secondary btn-sm float-left" id="print-pdf-btn">
                    <i class="fa fa-download"></i>
                    Download as PDF
                </a>
        @endcan
    </div>
</form>
@push('scripts')
    <script>
        {{--function downloadFile(response) {--}}
        {{--    var blob = new Blob([response], {type: 'application/pdf'})--}}
        {{--    var url = URL.createObjectURL(blob);--}}
        {{--    location.assign(url);--}}
        {{--}--}}
        {{--$('#print-pdf-btn').click(function (e){--}}
        {{--    e.preventDefault();--}}
        {{--    $('#overlay').show();--}}
        {{--    var this_id = $(this).data('id');--}}
        {{--    var url = '{{ route("admin.case-lists.print.generate-pcr", ":id") }}';--}}
        {{--    url = url.replace(':id', this_id);--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        type: "GET",--}}
        {{--        url: url,--}}
        {{--        dataType: "json",--}}
        {{--        data: {},--}}
        {{--        // success: function(data) {--}}
        {{--        //     $("#overlay").hide();--}}
        {{--        //     downloadFile(data);--}}
        {{--        // },--}}
        {{--        // error: function(){--}}
        {{--        //     $("#overlay").hide();--}}
        {{--        //     alert('Error handing here!');--}}
        {{--        // }--}}
        {{--    })--}}
        {{--    .done(downloadFile);--}}
        {{--});--}}
    </script>
@endpush
