<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use App\Models\CaseCommitment;
use App\Models\CaseFinancial;
use App\Models\CaseFinancingInstrument;
use App\Models\CaseGearingView;
use App\Models\CaseList;
use App\Models\CashFlowView;

class CaseController extends Controller
{
    public function __construct($case_id)
    {
        $this->case_id = $case_id;
    }

    // incomplete
    public function credit_report(){
        $case_id = $this->case_id;

    }

    public function dsr(){
        $case_id = $this->case_id;
        $cc = CaseCommitment::select('final_total')->where('case_id',$case_id)->first();
        $commitment_as_per_ccris = ($cc->final_total ?? 0)*12;
        $e75 = CaseFinancingInstrument::where('case_id',$case_id)->where('financing_instrument_id','!=',7)->sum('commitments') ?? 0;
        $e80 = CaseFinancingInstrument::where('case_id',$case_id)->where('financing_instrument_id',7)->sum('commitments') ?? 0;
        $cf = CaseFinancial::select('ebitda')->where('case_id',$case_id)->where('group_id',1)->first();
        $latest_ebitda = $cf->ebitda ?? 0;
        $total_financing_commitment = ($e75*12)+$e80;
        $data = [
            'case_id' => $case_id,
            'latest_ebitda' => $latest_ebitda,
            'commitment_as_per_ccris' => $commitment_as_per_ccris,
            'total_financing_commitment' => $total_financing_commitment,
        ];
        return $data;
    }

    public function pcr(){
        $case_id = $this->case_id;
        $cfi = CaseFinancingInstrument::where('case_id', $case_id)->where('financing_instrument_id', '!=', 7)->first();
        $cfi_capboost = CaseFinancingInstrument::where('case_id', $case_id)->where('financing_instrument_id',7)->first();

        $dsr_array = $this->dsr();
        $case_gearing = CaseGearingView::all()->where('case_id', $case_id)->first();
        $cash_flow = CashFlowView::all()->where('case_id', $case_id)->first();
        $caseList = CaseList::find($case_id);

        $new_financing_amount = ($cfi?->total_proposed_limit)+($cfi_capboost?->total_proposed_limit);
        $E75 = $cfi->total_commitments ?? 0;
        $E80 = $cfi_capboost->total_commitments ?? 0;
        $D41 = $dsr_array['commitment_as_per_ccris'] ?? 0;
        $D42 = $caseList->dsr_bankStt_commitment ?? 0;
        $D43 = ($E75*12)+$E80; // total_financing_commitment or nfc_per_annum
        $C62 = ($case_gearing->new_financing_amount ?? 0)-($caseList->gearing_redemtion ?? 0);
        $D40 = $dsr_array['latest_ebitda'] ?? 0;
        $combine_D412 = $D41+$D42;
        $combine_D4123 = $D41+$D42+$D43;
        $D44 = ($combine_D4123>0) ? ($D40/$combine_D4123) : 0;
        $H50 = ($cash_flow->bankStt_month??0) * 12;
        $I51 = ($caseList->cash_flow_factor ?? 0);
        $I52 = ($combine_D4123>0) ? ($H50*($I51/100)/$combine_D4123) : 0;
        $C59 = ($caseList->gearing_borrow ?? 0);
        $C63 = ($case_gearing->total_tnw ?? 0);
        $C64 = ($C63>0) ? ($C62/$C63) : 0;
        $data = [
            'new_financing_amount' => $new_financing_amount,
            'nfc_per_annum' => $D43,
            'new_total_annual_commitment' => $combine_D4123,
            'new_total_borrowings' => $C62,
            'dsr_financial_report_current' => ($combine_D412>0) ? ($D40/$combine_D412) : 0,
            'dsr_financial_report_new' => $D44,
            'dsr_bank_statement_current' => ($combine_D412>0) ? (($H50*($I51/100))/$combine_D412) : 0,
            'dsr_bank_statement_new' => $I52,
            'dsr_gearing_current' => ($C63>0) ? $C59/$C63 : 0,
            'dsr_gearing_new' => $C64,
        ];
        return $data;
    }

    public function views(){
        // case_gearing_views
        // case_new_financing_instrument_views
        // cash_flow_views
        // credit_reports
        // dsr_views
    }
}
