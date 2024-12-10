<?php

namespace App\Http\Controllers;

use App\Models\CaseDirectorCommitment;
use App\Models\CaseDisburse;
use App\Models\CaseDisburseDetails;
use App\Models\CaseList;
use App\Models\CaseOverridings;
use App\Models\Invoice;
use App\Models\Proformas;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Concerns\FromView;

class ReportController extends Controller
{
    public function sales_index(Request $request)
    {
        abort_if(Gate::denies('sales_report_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ym_setting = year_month_setting();
        $month      = month_collection();

        //get search data or ori data
        $this_year          = $request->search_year ?? $ym_setting->this_year;
        $this_start_month   = $request->search_start_month ?? $ym_setting->this_month;
        $this_end_month     = $request->search_end_month ?? $ym_setting->this_month;
        $input              = $request->search_input;

        //check the data is all or not?
        $this_year  = $this_year  == 'all' ? null   : $this_year;
        $this_start_month = $this_start_month == 'all' ? null   : $this_start_month;
        $this_end_month = $this_end_month == 'all' ? null   : $this_end_month;

        $main_query = DB::table('sales_reports')
            ->when($this_year, function ($query) use ($this_year){
                $query->where('year', $this_year);
            })
            ->when($this_start_month && $this_end_month, function ($query) use ($this_start_month, $this_end_month){
                $query->whereBetween('month', [$this_start_month, $this_end_month]);
            })
            ->when($input, function ($query) use ($input){
                $query->where('client', 'like', '%'.$input.'%')
                ->orWhere('product', 'like', '%'. $input.'%')
                ->orWhere('bfe_name', 'like', '%'. $input.'%')
                ->orWhere('banker_name', 'like', '%'. $input.'%')
                ;
            })
            ->orderBy('approval_date')
        ;

        $salesReport = $main_query->get();

        $total_approval_amounts     = $main_query->sum('approved_amount');
        $total_fees                 = $main_query->sum('fee');
        $total_bfe_commissions      = $main_query->sum('bfe_commission');
        $total_banker_commissions   = $main_query->sum('banker_commission');
        $total_overriding_amount    = 0;


        return view('admin.report.salesReport', compact('salesReport', 'total_approval_amounts', 'total_fees', 'total_bfe_commissions', 'total_banker_commissions', 'total_overriding_amount', 'month', 'ym_setting', 'this_year', 'this_start_month', 'this_end_month', 'input'));
    }

    public function collection_index(Request $request)
    {
        abort_if(Gate::denies('collection_report_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ym_setting = year_month_setting();
        $month      = month_collection();

        $this_year  = $request->search_year ?? $ym_setting->this_year;
        $this_month = $request->search_month ?? $ym_setting->this_month;
        $input      = $request->search_input;

        $this_year  = $this_year  == 'all' ? null   : $this_year;
        $this_month = $this_month == 'all' ? null   : $this_month;

        $start_date = date($this_year.'-'.$this_month.'-01');
        $end_date   = date($this_year.'-'.$this_month.'-31');
        $year_month_range   = $this_month.'-'.$this_year;

        $main_query = DB::table('collection_reports')
            ->when(($this_year && $this_month), function ($query) use ($this_year, $this_month, $year_month_range, $start_date, $end_date){
                $query->whereJsonContains('year_month_arr', $year_month_range)
                    ->orWhere(function ($query) use ($start_date, $end_date){
                        $query->where('payment_status', '0')
                            ->where('approval_date', '<=', $start_date)
                        ;
                    })
                    ->orWhere(function ($query) use ($start_date, $end_date){
                        $query->where('payment_status', '1')
                            ->where('approval_date', '<=', $start_date)
                        ;
                    })
//                    ->orWhere(function ($query) use ($start_date, $end_date){
//                        $query->where('payment_status', '0')
//                            ->whereBetween('approval_date', [$start_date, $end_date])
//                        ;
//                    })
//                    ->orWhere(function ($query) use ($start_date, $end_date){
//                        $query->where('payment_status', '1')
//                            ->whereBetween('approval_date', [$start_date, $end_date])
//                        ;
//                    })
                    ->orWhere(function ($query) use ($start_date, $end_date){
                        $query
                            ->whereBetween('approval_date', [$start_date, $end_date])
                        ;
                    })
                ;
            })
            ->when(($this_year && !$this_month), function ($query) use ($this_year, $start_date){
                $query->whereJsonContains('year_arr', $this_year)
                    ->orWhere('payment_status', '0')
                    ->orWhere('payment_status', '1')
                ;
            })
            ->when((!$this_year && $this_month), function ($query) use ($this_month, $start_date){
                $query->whereJsonContains('month_arr', $this_month)
                    ->orWhere('payment_status', '0')
                    ->orWhere('payment_status', '1')
                ;
            })
            ->orderBy('approval_date')
        ;

        $collectionReport           = $main_query->get();
        $total_approval_amounts     = $main_query->sum('approved_amount');
        $total_fees                 = $main_query->sum('fee');

        return view('admin.report.collectionReport', compact('collectionReport', 'total_approval_amounts', 'total_fees','month', 'ym_setting', 'this_year', 'this_month'));
    }

    public function outstanding_index(Request $request)
    {
        abort_if(Gate::denies('outstanding_report_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ym_setting = year_month_setting();
        $month      = month_collection();

        $date_type  = $request->search_date_type ?? 1;
        $date_from  = $request->search_date_from ?? date('Y-m-d');
        $date_to    = $request->search_date_to ?? date('Y-m-d', strtotime('+1 month')) ;

        $main_query = DB::table('outstanding_reports')
            ->when($date_from && $date_to && $date_type, function ($query) use ($date_from, $date_to, $date_type){
                switch ($date_type){
                    case 1:
                        $query->whereBetween('inv_date', [$date_from, $date_to]);
                        break;

                    case 2:
                        $query->join('payments', 'outstanding_reports.case_disburse_detail_id', '=', 'payments.case_disburse_detail_id')
                            ->whereBetween('payments.date',  [$date_from, $date_to])
                            ->groupBy('outstanding_reports.case_disburse_detail_id')
                        ;
                        break;
                    case 3:
//                        $query->join('payments', 'outstanding_reports.case_disburse_detail_id', '=', 'payments.case_disburse_detail_id')
//                            ->whereBetween('payments.sst_paid_date',  [$date_from, $date_to])
//                            ->groupBy('outstanding_reports.case_disburse_detail_id')
//                        ;

                        $query->whereBetween('sst_paid_date', [$date_from, $date_to]);
                        break;
                }
            })
            ->orderBy('inv_date')
            ->orderBy('or_date')
        ;

        $outstandingReport      = $main_query->get();
        $total_fees             = $main_query->sum('fee');
        $total_ssts             = $main_query->sum('sst');
        $total_disbs            = $main_query->sum('disb');
        $total_totals           = $main_query->sum('total');

        return view('admin.report.outstandingReport', compact('outstandingReport', 'total_fees', 'total_ssts', 'total_disbs', 'total_totals', 'month', 'ym_setting', 'date_type', 'date_from', 'date_to'));
    }

    public function commission_index(Request $request)
    {
        abort_if(Gate::denies('commission_list_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ym_setting = year_month_setting();
        $month      = month_collection();

        $this_year          = $request->search_year ?? $ym_setting->this_year;
        $this_start_month   = $request->search_start_month ?? $ym_setting->this_month;
        $this_end_month     = $request->search_end_month ?? $ym_setting->this_month;
        $input              = $request->search_input;

        $url_hash   = $request->url_hash ?? '';

        $this_year          = $this_year  == 'all' ? null   : $this_year;
        $this_start_month   = $this_start_month == 'all' ? null   : $this_start_month;
        $this_end_month     = $this_end_month == 'all' ? null   : $this_end_month;

        $main_query = DB::table('commission_reports')
            ->when($this_year, function ($query) use ($this_year){
                $query->where('or_year', $this_year);
            })
            ->when($this_start_month && $this_end_month, function ($query) use ($this_start_month, $this_end_month) {
                $query->whereBetween('or_month', [$this_start_month, $this_end_month]);
            })
            ->groupBy('case_disburse_detail_id')
            ->orderBy('or_date')
        ;

        $commission_report      = $main_query->get();
        $total_service_amount   = $main_query->sum('service_amount');
        $total_bfe_cms          = $main_query->sum('bfe_cms');
        $total_banker_cms       = $main_query->sum('banker_cms');

        $main_query_2 = DB::table('commission_person_reports')
            ->when($this_year, function ($query) use ($this_year){
                $query->where('or_year', $this_year);
            })
            ->when($this_start_month && $this_end_month, function ($query) use ($this_start_month, $this_end_month) {
                $query->whereBetween('or_month', [$this_start_month, $this_end_month]);
            })
            ->groupBy('user_id')
        ;

        $commission_person_report   = $main_query_2->get();

        $commission_person_sum      = $commission_person_report->sum('total_cms');

        return view('admin.report.commissionList', compact('commission_report', 'total_banker_cms', 'total_bfe_cms', 'total_service_amount', 'month', 'ym_setting', 'this_year', 'this_end_month', 'this_start_month', 'commission_person_report', 'commission_person_sum', 'url_hash'));
    }

    public function sales_modal(Request $request){
        $case_disburse_details_id   = $request->sales_id;

        $overriding_query           = CaseOverridings::where('case_disburse_detail_id', $case_disburse_details_id)->get();

        $html = '';

        foreach ($overriding_query as $overriding_key => $overriding_item){
            $content = '
            <div class="row">
                <div class="form-group col-12 col-md-3">
                    <label class="required" for="name">Overriding</label>
                    <input class="form-control" type="text" name="name[]" value="'.$overriding_item->name.'" readonly>
                    <span class="help-block"></span>
                </div>
                <div class="form-group col-12 col-md-3">
                    <label class="required" for="percent">Percent (%)</label>
                    <input class="form-control" type="text" name="percent[]" value="'.$overriding_item->commission_rate.'" readonly>
                    <span class="help-block"></span>
                </div>
                <div class="form-group col-12 col-md-3">
                    <label class="required" for="commission">Commission (RM)</label>
                    <input class="form-control" type="text" name="commission[]" value="'.money_num_format($overriding_item->commission).'" readonly>
                    <span class="help-block"></span>
                </div>
                <div class="form-group col-12 col-md-3">
                    <label class="required" for="paydate2">Pay Out Date</label>
                    <input class="form-control datepicker-new" type="text" name="overriding_pay_day[]" value="'.$overriding_item->commission_pay_day.'" data-language="en" placeholder="YYYY-MM-DD">
                    <span class="help-block"></span>
                </div>
            </div>
            ';

            $html .= $content;
        }

        $sales_report = DB::table('sales_reports')->where('case_disburse_detail_id', $case_disburse_details_id)->first();

        return json_encode([
            'html'                  => $html,
            'disburse_detail_id'    => $case_disburse_details_id,
            'bfe_pay_out'           => $sales_report->bfe_pay_out,
            'banker_pay_out'        => $sales_report->banker_pay_out,
        ]);

    }

    public function sales_modal_update(Request $request){
        $disburse_detail_id = $request->disburse_detail_id;
        $bfe_pay_out        = $request->bfe_pay_out;
        $banker_pay_out     = $request->banker_pay_out;
        $overriding_pay_day = $request->overriding_pay_day;

        CaseDisburseDetails::where('id', $disburse_detail_id)->update([
            'bfe_commission_pay_day'    => $bfe_pay_out,
            'banker_commission_pay_day' => $banker_pay_out,
        ]);

        foreach ($overriding_pay_day as $overriding_pay_day_key => $overriding_pay_day_item){
            CaseOverridings::where('case_disburse_detail_id', $disburse_detail_id)->update([
                'commission_pay_day'    => $overriding_pay_day_item,
            ]);
        }

        return redirect()->route('admin.report.sales_index');
    }

    public function outstanding_modal(Request $request){
        $case_disburse_details_id   = $request->detail_id;

        $outstanding_report = DB::table('outstanding_reports')->where('case_disburse_detail_id', $case_disburse_details_id)->first();

        return json_encode([
            'disburse_detail_id'    => $case_disburse_details_id,
            'sst_paid_date'         => $outstanding_report->sst_paid_date,
            'particular'            => $outstanding_report->particular,
            'inv_no'                => $outstanding_report->inv_no,
        ]);

    }

    public function outstanding_modal_update(Request $request){
        $disburse_detail_id = $request->disburse_detail_id;
        $sst_paid_date      = $request->sst_paid_date;

        CaseDisburseDetails::where('id', $disburse_detail_id)->update([
            'sst_paid_date'    => $sst_paid_date,
        ]);

        return redirect()->route('admin.report.outstanding_index');
    }

    public function generate_report_pdf(Request $request){
        $html = $request->pdf_report_html;
        $type = $request->pdf_type;
        $this_year  = $request->pdf_this_year ?? 'All Year';

        if ($request->pdf_this_start_month && $request->pdf_this_end_month){
            $start_month    = $request->pdf_this_start_month ?? 0;
            $end_month      = $request->pdf_this_end_month ?? 0;

            $start_month_name   = month_collection()[$start_month - 1]->full_name;
            $end_month_name     = month_collection()[$end_month - 1]->full_name;

            if (!$request->pdf_this_year){
                $start_year = year_month_setting()->start_year;
                $end_year = year_month_setting()->this_year+1;
            }
            else{
                $start_year = $request->pdf_this_year;
                $end_year = $request->pdf_this_year;
            }

//            dd($start_year, $end_year);

            if ($start_month_name == $end_month_name){
                $content_title         = $start_month_name.' '.$start_year;
            }
            else{
                $content_title         = 'From '.$start_month_name.' '.$start_year.' until '.$end_month_name.' '.$end_year;
            }
        }
        elseif ($request->pdf_date_type){
            $date_from    = $request->pdf_date_from ?? 0;
            $date_to      = $request->pdf_date_to ?? 0;
            $this_year    = '';

            if ($date_from == $date_to){
                $month_name         = $date_from;
            }
            else{
                $month_name         = 'From '.$date_from.' until '.$date_to;
            }

            switch ($request->pdf_date_type){
                case 1:
                    $content_title = $month_name .' (Invoice Date)';
                    break;

                case 2:
                    $content_title = $month_name .' (Payment Date)';
                    break;

                case 3:
                    $content_title = $month_name .' (SST Paid Date)';
                    break;
            }
        }
        else{
            $this_month = $request->pdf_this_month ?? 0;
            $month_name = month_collection()[$this_month - 1]->full_name ?? 'Whole Month';

            if (!$request->pdf_this_year && $this_month == 0){
                $content_title = 'Whole Month in All Year';
            }
            elseif ($this_month == 0 || !$request->pdf_this_year){
                $content_title = $month_name.' in '.$this_year;
            }
            else{
                $content_title = $month_name.' '.$this_year;
            }
        }

        /*
         * Type Num
         * 1: sales
         * 2. collection
         * 3. outstanding
         * 4. commission - main
         * 5. commission - person
         * */

        switch ($type){
            case 1:
                $orientation = 'landscape';
                $file_name   = 'sales_report';
                $title       = 'Sales Report';
                $td_width    = '34px';
                break;

            case 2:
                $orientation = 'landscape';
                $file_name   = 'collection_report';
                $title       = 'Collection Report';
                $td_width    = '65px';
                break;

            case 3:
                $orientation = 'landscape';
                $file_name   = 'outstanding_report';
                $title       = 'Outstanding Report';
                $td_width    = '75px';
                break;

            case 4:
                $orientation = 'landscape';
                $file_name   = 'commission_list';
                $title       = 'Commission List';
                $td_width    = '65px';
                break;

            case 5:
                $orientation = 'portrait';
                $file_name   = 'commission_details';
                $title       = 'Commission Details';
                $td_width    = '170px';
                break;
        }

        ini_set('memory_limit', '512M');
        $preview = 0;
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        $html = str_replace('min-width: 100px;', 'min-width: 30px;', $html);

        $pdf->loadView('admin.report.pdf.reportPdf', compact(
            'preview','html', 'td_width', 'title', 'content_title'
        ),[],'UTF-8');

        $pdf_name = $file_name.date("Ymdhis");

        $pdf->setPaper('A4', $orientation);
        return $pdf->download($pdf_name.'.pdf');
    }

    public function generate_report_excel(Request $request){
        $html = $request->excel_report_html;
        $table_row = $request->table_row;

        str_replace('vertical-align-center', '', $html);
        str_replace('hori-align-center', '', $html);

        $type = $request->excel_type;
        $this_year  = $request->excel_this_year ?? 'All Year';


        if ($request->excel_this_start_month && $request->excel_this_end_month){
            $start_month    = $request->excel_this_start_month ?? 0;
            $end_month      = $request->excel_this_end_month ?? 0;

            $start_month_name   = month_collection()[$start_month - 1]->full_name;
            $end_month_name     = month_collection()[$end_month - 1]->full_name;

            if (!$request->excel_this_year){
                $start_year = year_month_setting()->start_year;
                $end_year = year_month_setting()->this_year+1;
            }
            else{
                $start_year = $request->excel_this_year;
                $end_year = $request->excel_this_year;
            }

//            dd($start_year, $end_year);

            if ($start_month_name == $end_month_name){
                $content_title         = $start_month_name.' '.$start_year;
            }
            else{
                $content_title         = 'From '.$start_month_name.' '.$start_year.' until '.$end_month_name.' '.$end_year;
            }
        }
        elseif ($request->excel_date_type){
            $date_from    = $request->excel_date_from ?? 0;
            $date_to      = $request->excel_date_to ?? 0;
            $this_year    = '';

            if ($date_from == $date_to){
                $month_name         = $date_from;
            }
            else{
                $month_name         = 'From '.$date_from.' until '.$date_to;
            }

            switch ($request->excel_date_type){
                case 1:
                    $content_title = $month_name .' (Invoice Date)';
                    break;

                case 2:
                    $content_title = $month_name .' (Payment Date)';
                    break;

                case 3:
                    $content_title = $month_name .' (SST Paid Date)';
                    break;
            }
        }
        else{
            $this_month = $request->excel_this_month ?? 0;
            $month_name = month_collection()[$this_month - 1]->full_name ?? 'Whole Month';

            if (!$request->excel_this_year && $this_month == 0){
                $content_title = 'Whole Month in All Year';
            }
            elseif ($this_month == 0 || !$request->excel_this_year){
                $content_title = $month_name.' in '.$this_year;
            }
            else{
                $content_title = $month_name.' '.$this_year;
            }
        }

        /*
         * Type Num
         * 1: sales
         * 2. collection
         * 3. outstanding
         * 4. commission - main
         * 5. commission - person
         * */

        switch ($type){
            case 1:
                $orientation = 'landscape';
                $file_name   = 'sales_report';
                $title       = 'Sales Report';
                $td_width    = '100px';
                break;

            case 2:
                $orientation = 'landscape';
                $file_name   = 'collection_report';
                $title       = 'Collection Report';
                $td_width    = '100px';
                break;

            case 3:
                $orientation = 'landscape';
                $file_name   = 'outstanding_report';
                $title       = 'Outstanding Report';
                $td_width    = '100px';
                break;

            case 4:
                $orientation = 'landscape';
                $file_name   = 'commission_list';
                $title       = 'Commission List';
                $td_width    = '100px';
                break;

            case 5:
                $orientation = 'portrait';
                $file_name   = 'commission_details';
                $title       = 'Commission Details';
                $td_width    = '170px';
                break;
        }

        $view_html  = view('admin.report.excel.reportExcel', compact(
            'html', 'td_width', 'content_title', 'title'
        ),[],'UTF-8');

        $temporary_html_file = 'storage/excel_html/' . time() . '.html';

        file_put_contents($temporary_html_file, $view_html);

        $reader = IOFactory::createReader('Html');
        $spreadsheet = $reader->load($temporary_html_file);

        // global css
        $havenStyle = new Style(false, true);
        $havenStyle->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB('E1EFDA');
        $havenStyle->getFont()->setBold(true)->setColor(new Color('FE1E16'));

        $p_havenStyle = new Style(false, true);
        $p_havenStyle->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB('E6EDEF');
        $p_havenStyle->getFont()->setBold(true)->setColor(new Color('717171'));

        $p_fullyPaidStyle = new Style(false, true);
        $p_fullyPaidStyle->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB('E6EDEF');
        $p_fullyPaidStyle->getFont()->setBold(true)->setColor(new Color('198754'));

        $p_partPaidStyle = new Style(false, true);
        $p_partPaidStyle->getFill()->setFillType(Fill::FILL_SOLID)->getEndColor()->setARGB('E6EDEF');
        $p_partPaidStyle->getFont()->setBold(true)->setColor(new Color('11CAF0'));

        //total border line css
        $totalBorderLine = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                    'color' => array('argb' => 'FFFF0000'),
                ),
            ),
        );

        // switch for type
        switch ($type){
            case 1: //sales report
                $spreadsheet->getActiveSheet()->getStyle('A4:J4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('FFF2C2');
                $spreadsheet->getActiveSheet()->getStyle('K4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('S4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('L4:O4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('FFE699');
                $spreadsheet->getActiveSheet()->getStyle('P4:R4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('C9DFF1');
                $spreadsheet->getActiveSheet()->getStyle('T4:W4')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()
                    ->setARGB('fce4d6');

                $spreadsheet->getActiveSheet()->getStyle('A4:W4')
                    ->getFont()->setBold(true);

                // number format
                //$spreadsheet->getActiveSheet()->getStyle('F4:F'.($table_row+3))->getNumberFormat()->getFormatCode('0.00');
                $spreadsheet->getActiveSheet()->getStyle('F5:F'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('J5:J'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('N5:N'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('R5:R'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('V5:V'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');

                //set condition
                $allCellRange1 = 'A5:I'.($table_row+3);
                $allCellRange2 = 'L5:W'.($table_row+3);
                $allCellRange3 = 'A5:W'.($table_row+3);
                $paymentStatusCellRange = 'K5:K'.($table_row+3);
                $conditionalStyles = [];


//                $wizardFactory = new Wizard($allCellRange3);
//                /** @var Wizard\CellValue $cellWizard */
//                $cellWizard = $wizardFactory->newRule(Wizard::CELL_VALUE);
//                $cellWizard->equals(0)->getStyle()->getNumberFormat()->getFormatCode('#,##0.00');
//                $conditionalStyles[] = $cellWizard->getConditional();
//
//                $spreadsheet->getActiveSheet()
//                    ->getStyle($cellWizard->getCellRange())
//                    ->setConditionalStyles($conditionalStyles);

//                $WizardFactory = new Wizard($allCellRange3);
//                /** @var Wizard\TextValue $textWizard */
//                $textWizard = $WizardFactory->newRule(Wizard::TEXT_VALUE);
//                $textWizard->contains("0")->setStyle($havenStyle);
//                $conditionalStyles[] = $textWizard->getConditional();
//
//                $spreadsheet->getActiveSheet()
//                    ->getStyle($textWizard->getCellRange())
//                    ->setConditionalStyles($conditionalStyles);
//                $conditionalStyles = [];

                //when this range have 'Haven't'
                $WizardFactory = new Wizard($allCellRange1);
                /** @var Wizard\TextValue $textWizard */
                $textWizard = $WizardFactory->newRule(Wizard::TEXT_VALUE);
                $textWizard->contains("Haven't")->setStyle($havenStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $spreadsheet->getActiveSheet()->getStyle($textWizard->getCellRange())->setConditionalStyles($conditionalStyles);
                $conditionalStyles = [];
                //When this range have 'Haven't'
                $WizardFactory = new Wizard($allCellRange2);
                /** @var Wizard\TextValue $textWizard */
                $textWizard = $WizardFactory->newRule(Wizard::TEXT_VALUE);
                $textWizard->contains("Haven't")->setStyle($havenStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $spreadsheet->getActiveSheet()->getStyle($textWizard->getCellRange())->setConditionalStyles($conditionalStyles);
                $conditionalStyles = [];
                //When this range have 'Haven't'
                $ps_WizardFactory = new Wizard($paymentStatusCellRange);
                /** @var Wizard\TextValue $textWizard */
                $textWizard = $ps_WizardFactory->newRule(Wizard::TEXT_VALUE);
                $textWizard->contains("Haven't")->setStyle($p_havenStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                //When this range have 'Fully Paid'
                $textWizard->contains("Fully Paid")->setStyle($p_fullyPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                //When this range have 'Part Paid'
                $textWizard->contains("Part Paid")->setStyle($p_partPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $spreadsheet->getActiveSheet()->getStyle($textWizard->getCellRange())->setConditionalStyles($conditionalStyles);

                // Auto width
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');
                foreach (range('A', 'W') as $col){
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                break;
            case 2: //collection report
                // colors
                $spreadsheet->getActiveSheet()->getStyle('H5:H'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('I5:I'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('J5:J'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e2efda');
                $spreadsheet->getActiveSheet()->getStyle('K5:K'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e2efda');
                $spreadsheet->getActiveSheet()->getStyle('L5:L'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fce4d6');
                $spreadsheet->getActiveSheet()->getStyle('M5:M'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fce4d6');
                $spreadsheet->getActiveSheet()->getStyle('O4:O5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('N6:N'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e6edef');
                $spreadsheet->getActiveSheet()->getStyle('O6:O'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e6edef');
                // bold
                $spreadsheet->getActiveSheet()->getStyle('A4:O4')->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A5:O5')->getFont()->setBold(true);
                // decimal
                $spreadsheet->getActiveSheet()->getStyle('C6:C'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('D6:D'.($table_row+3))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('N6:N'.($table_row))->getNumberFormat()->setFormatCode('#,##0.00');
                // status
                $paymentStatusCellRange = 'O6:O'.$table_row;
                $conditionalStyles = [];
                $ps_WizardFactory = new Wizard($paymentStatusCellRange);
                $textWizard = $ps_WizardFactory->newRule(Wizard::TEXT_VALUE);
                $textWizard->contains("Haven't")->setStyle($p_havenStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $textWizard->contains("Fully Paid")->setStyle($p_fullyPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $textWizard->contains("Part Paid")->setStyle($p_partPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $spreadsheet->getActiveSheet()->getStyle($textWizard->getCellRange())->setConditionalStyles($conditionalStyles);
                // Auto width
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');

                //add equal line
                $this->totalBorderLine($spreadsheet, 'C'.($table_row+2));
                $this->totalBorderLine($spreadsheet, 'D'.($table_row+2));

                foreach (range('A', 'O') as $col){
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                break;
            case 3: // outstanding report
                // colors
                $spreadsheet->getActiveSheet()->getStyle('A5:M5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDEBF7');
                $spreadsheet->getActiveSheet()->getStyle('H6:H'.($table_row))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e6edef');
                $spreadsheet->getActiveSheet()->getStyle('I6:I'.($table_row))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('e6edef');
                // bold
                $spreadsheet->getActiveSheet()->getStyle('J4:K4')->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A5:M5')->getFont()->setBold(true);
                // decimal
                $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('H6:H'.($table_row))->getNumberFormat()->setFormatCode('#,##0.00');
                // status
                $paymentStatusCellRange = 'I6:I'.$table_row;
                $conditionalStyles = [];
                $ps_WizardFactory = new Wizard($paymentStatusCellRange);
                $textWizard = $ps_WizardFactory->newRule(Wizard::TEXT_VALUE);
                $textWizard->contains("Haven't")->setStyle($p_havenStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $textWizard->contains("Fully Paid")->setStyle($p_fullyPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $textWizard->contains("Part Paid")->setStyle($p_partPaidStyle);
                $conditionalStyles[] = $textWizard->getConditional();
                $spreadsheet->getActiveSheet()->getStyle($textWizard->getCellRange())->setConditionalStyles($conditionalStyles);
                // Auto width
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');

                //add equal line
                $this->totalBorderLine($spreadsheet, 'D'.($table_row+2));
                $this->totalBorderLine($spreadsheet, 'E'.($table_row+2));
                $this->totalBorderLine($spreadsheet, 'F'.($table_row+2));
                $this->totalBorderLine($spreadsheet, 'G'.($table_row+2));

                foreach (range('A', 'M') as $col){
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                break;
            case 4: // commission list
                // color
                $spreadsheet->getActiveSheet()->getStyle('H4:H'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('I4:I'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('J4:J'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('K4:K'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('L4:L'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('M4:M'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('N4:N'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                $spreadsheet->getActiveSheet()->getStyle('O4:O'.$table_row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ebf1de');
                // bold
                $spreadsheet->getActiveSheet()->getStyle('A4:O4')->getFont()->setBold(true);
                $spreadsheet->getActiveSheet()->getStyle('A5:O5')->getFont()->setBold(true);
                // decimal
                $spreadsheet->getActiveSheet()->getStyle('D6:D'.($table_row))->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#,##0.00');
                $spreadsheet->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#,##0.00');
                // Auto width
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');

                //add equal line
                $this->totalBorderLine($spreadsheet, 'F'.($table_row+3));
                $this->totalBorderLine($spreadsheet, 'G'.($table_row+3));

                $this->totalBorderLine($spreadsheet, 'I'.($table_row+3));
                $this->totalBorderLine($spreadsheet, 'K'.($table_row+3));
                $this->totalBorderLine($spreadsheet, 'M'.($table_row+3));
                $this->totalBorderLine($spreadsheet, 'O'.($table_row+3));

                foreach (range('A', 'O') as $col){
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                break;
            case 5: // commission details
                // bold
                $spreadsheet->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);
                // decimal
                $spreadsheet->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
                // Auto width
                $spreadsheet->getActiveSheet()->mergeCells('A1:H1');
                $spreadsheet->getActiveSheet()->mergeCells('A2:H2');

                //add equal line
                $this->totalBorderLine($spreadsheet, 'D'.($table_row+3));

                foreach (range('D', 'O') as $col){
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
                }
                break;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-disposition: attachment; filename='.$file_name.date("Ymdhis").'.xls');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    private function totalBorderLine($spreadsheet, $style_code){
        $spreadsheet->getActiveSheet()->getStyle($style_code)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE)->setColor(new Color('050505'));
        $spreadsheet->getActiveSheet()->getStyle($style_code)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('050505'));
    }
}
