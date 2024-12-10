<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Views\CaseController;
use App\Models\CaseCallLog;
use App\Models\CaseCriterion;
use App\Models\CaseReportRecommendation;
use App\Models\creditReport;
use App\Models\dsrView;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CallRemarkHistoryPdfController extends Controller
{
    public function __invoke()
    {
        //
    }

    public function generatePDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        $query = CaseCallLog::with(['user','case']);
        // global search
        if (isset($request->search_input)) {
            $search_input = $request->search_input;
            $query->whereHas('user', function ($query_batch) use ($search_input) {
                $query_batch->where('name', 'LIKE', '%' . $search_input . '%');
            });
            $query->orWhereHas('case', function ($query_batch) use ($search_input) {
                $query_batch->where('case_code', 'LIKE', '%' . $search_input . '%');
            });
            $query->orWhere('datetime', 'LIKE', '%' . $search_input . '%');
            $query->orWhere('details', 'LIKE', '%' . $search_input . '%');
            $query->orWhere('phone', 'LIKE', '%' . $search_input . '%');
        }
        // date range
        if ($request->date_from !== null) {
            $query->whereDate('datetime', '>=', $request->date_from);
        }
        if ($request->date_to !== null) {
            $query->whereDate('datetime', '<=', $request->date_to);
        }
        $caseCallLog = $query->get();
        $type = 'portrait';
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        $pdf->loadView('admin.masterCallLists.print.remark-history-pdf', compact(
            'caseCallLog','type'
        ),[],'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('call-remark-history.pdf');
    }
}
