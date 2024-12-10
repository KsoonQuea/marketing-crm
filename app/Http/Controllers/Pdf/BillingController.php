<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\CaseDirectorCommitment;
use App\Models\CaseDisburse;
use App\Models\CaseList;
use App\Models\Invoice;
use App\Models\Proformas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function generateInvoice(Request $request)
    {
        ini_set('memory_limit', '512M');
        $preview = 0;
        $case_id = $request->case_id;
        $platform = $request->platform;
        $invoice_type = $request->invoiceType; // 0 = proforma, 1 = invoice
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        if($request->invoiceType == NULL){
            return back()->withErrors('Invalid Invoice!');
        } else {
            if ($invoice_type == 0) {
                // Proforma Invoice
                $caseList = CaseList::find($case_id);
                $caseDirectorCommitment = CaseDirectorCommitment::where('case_id',$case_id)
                    //->where('primary_type',1)
                    ->groupBy('director_id')->first();
                $proforma = Proformas::where('case_id',$case_id)->first();
                $proforma_content = [
                    'invoice_no' => $proforma->file_num ?? '',
                    'date' => $proforma->date ?? '',
                    'term' => '-',
                ];
                $caseDisbursement = CaseDisburse::find($platform);
                $pdf->loadView('admin.caseLists.print.billing-proforma', compact(
                    'preview','caseList','proforma_content','caseDirectorCommitment','caseDisbursement','proforma'
                ),[],'UTF-8');
                $pdf_name = 'Proforma'.date("Ymdhis");
            } else if($invoice_type == 1){
                // Invoice
                $caseList = CaseList::find($case_id);
                $invoice = Invoice::where('case_id',$case_id)->first();
                $caseDirectorCommitment = CaseDirectorCommitment::where('case_id',$case_id)->groupBy('director_id')->first();
                $caseDisbursement = CaseDisburse::find($platform);
                $pdf->loadView('admin.caseLists.print.billing-invoice', compact(
                    'preview','caseList','invoice','caseDirectorCommitment','caseDisbursement'
                ),[],'UTF-8');
                $pdf_name = 'Invoice'.date("Ymdhis");
            }
        }
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download($pdf_name.'.pdf');
    }
}
