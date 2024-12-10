<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Views\CaseController;
use App\Models\CaseCriterion;
use App\Models\CaseReportRecommendation;
use App\Models\creditReport;
use App\Models\dsrView;
//use Dompdf\Options;
//use Spatie\Browsershot\Browsershot;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function generatePDF($case_id)
    {
        ini_set('memory_limit', '512M');
        // case_criterion
        $type = 'portrait';
        $case_criterion = [];
        for($i=1;$i<=10;$i++){
            $this_criterion = CaseCriterion::where('case_id',$case_id)->where('arrange',$i)->first();
            $answer = $this_criterion ? $this_criterion->answer : '';
            array_push($case_criterion, $answer);
        }
        $credit_report = creditReport::all()->where('case_id', '=', $case_id)->first();
        $credit_report_application_type = creditReport::where('case_id', '=', $case_id)->pluck('application_type')->toArray();
        $dsr = dsrView::all()->where('case_id', '=', $case_id)->first();
        $case_report_recommendation = CaseReportRecommendation::where('case_id',$case_id)->first();
        // pcr
        $caseControllerView = new CaseController($case_id);
        $pcr_display = $caseControllerView->pcr();

        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        $pdf->loadView('admin.caseLists.print.pcr', compact(
            'credit_report',
            'credit_report_application_type',
            'case_criterion','dsr','type',
            'case_report_recommendation',
            'pcr_display'
        ),[],'UTF-8');
        $pdf->setPaper('A4', 'portrait');
//        return $pdf->render('document-pcr.pdf');
        return $pdf->download('document-pcr.pdf');
    }
}
