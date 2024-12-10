@extends('layouts.clean-app')
@section('content')
    <div class="print-bg">
        <div class="print-header-logo">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/pcr-test.png'))) }}"
                 style="width:240px; height:auto;margin:0 auto;">
        </div>
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
                    <td>YYYY-MM-DD</td>
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
{{--        <br><br><br>--}}

        <h5 class="tab-pane-header">Company Profile Assessment</h5>
        <div class="table-responsive">
            <table class="table-bordered form-table w-100">
                <tr>
                    <td width="40"><b>No.</b></td>
                    <td><b>Company Profile Assessment</b></td>
                    <td width="200"><b>Yes\No\NA</b></td>
                </tr>
                <tr>
                    <td>A) </td>
                    <td>Business is registered in Malaysia</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[0] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[0]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td>B) </td>
                    <td>Business is >= 2 years old</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[1] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[1]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td>C) </td>
                    <td>Positive CTOS (Legal Case / Bankruptcy / Winding Up)</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[2] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[2]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td>D) </td>
                    <td>Positive Trade Reference Check</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[3] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[3]] : 'NA' }}
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
                        {{ $case_criterion[4] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[4]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>More than 3 times '2' MIA in the past 6 months</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[5] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[5]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>6 times '2' MIA in past 6 months</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[6] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[6]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>CCRIS record shows legal status / AKPK / Special Attention Account</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[7] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[7]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td>F) </td>
                    <td>Company with inter-company sales >= 40% (based on 2 years)</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[8] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[8]] : 'NA' }}
                    </td>
                </tr>
                <tr>
                    <td>G) </td>
                    <td>Consent to obtain Corporate Guarantor (CG)</td>
                    <td class="p-0 td-select">
                        {{ $case_criterion[9] ? \App\Models\CaseCriterion::ANSWER_SELECT[$case_criterion[9]] : 'NA' }}
                    </td>
                </tr>
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

        <h5 class="tab-pane-header">Comparison On Financial Position</h5>
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
                    <td>GEARING {{ "<" }}= 4X</td>
                    <td>{{ number_format($pcr_display['dsr_gearing_current'],2) }}</td>
                    <td>{{ number_format($pcr_display['dsr_gearing_new'],2) }}</td>
                </tr>
            </table>
        </div>

        <h5 class="tab-pane-header">Recommendation</h5>
        <div class="textarea-div" style="font-size:11px;">{{ $case_report_recommendation->recommendation ?? '' }}</div>
    </div>
@endsection
