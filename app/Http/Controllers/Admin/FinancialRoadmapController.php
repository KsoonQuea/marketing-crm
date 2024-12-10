<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseCriterion;
use App\Models\CaseFinancingInstrument;
use App\Models\CaseList;
use App\Models\creditReport;
use App\Models\FinancialRoadmap;
use App\Models\FinancialRoadmapData;
use App\Models\FinancialRoadmapInstruments;
use App\Models\FinancingInstrument;
use App\Models\IndustryType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\Snappy\Facades\SnappyPdf;

class FinancialRoadmapController extends Controller
{
    private function reformatToNumeric($input)
    {
        $nagtive = 0;

        if ($input == '-'){
            $input = 0;
        }

        if ($input == 'On Demand'){
            $input = 0.8;
        }

        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 2, '.', '');

        if($nagtive == 1){ $return = -$new_value; } else { $return = $new_value; }

        return $return;
    }

    public function index( Request $request)
    {
        abort_if(Gate::denies('finRoadmap_all_index_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //set the normal value
        $financialRoadmap_status    =  FinancialRoadmap::STATUS_SELECT;
        $financialRoadmap_page      =  0;

        //set the datatable value
        if ($request->ajax()) {
            $query = FinancialRoadmap::all();
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name               = 'financial roadmap';
                $permission_name    = 'finRoadmap';
                $except             = ['edit','destroy'];
                $finRoadmap = 1;
                $blank              = 1;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'finRoadmap',
                    'blank'
                ));
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ?? '-';
            });
            $table->editColumn('contact_person', function ($row) {
                return $row->contact_person ?? '-';
            });
            $table->editColumn('contact_number', function ($row) {
                return $row->contact_number ?? '-';
            });
            $table->editColumn('user_id', function ($row) {

                $user = User::where('id', $row->user_id)->select('name')->first();

                return $user->name ?? '-';
            });
            $table->editColumn('financial_roadmap_status', function ($row) {
                $status_name    =  FinancialRoadmap::STATUS_SELECT[$row->status ?? 0];
                $status_class   =  FinancialRoadmap::STATUS_CLASSES[$row->status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });

            $table->rawColumns(['actions', 'placeholder', 'financial_roadmap_status', 'company_name', 'contact_person', 'contact_number', 'user_id']);
            return $table->make(true);
        }

        return view('admin.financialRoadmap.index', compact('financialRoadmap_status', 'financialRoadmap_page'));
    }

    public function pending_index( Request $request)
    {
        //set the normal value
        $financialRoadmap_status    =  FinancialRoadmap::STATUS_SELECT;
        $financialRoadmap_page      =  1;

        //set the datatable value
        if ($request->ajax()) {
            $query = FinancialRoadmap::all()->where('status', 0);
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name               = 'financial roadmap';
                $permission_name    = 'finRoadmap';
                $except             = ['edit','destroy'];
                $finRoadmap = 1;
                $blank              = 1;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'finRoadmap',
                    'blank'
                ));
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ?? '-';
            });
            $table->editColumn('contact_person', function ($row) {
                return $row->contact_person ?? '-';
            });
            $table->editColumn('contact_number', function ($row) {
                return $row->contact_number ?? '-';
            });
            $table->editColumn('user_id', function ($row) {

                $user = User::where('id', $row->user_id)->select('name')->first();

                return $user->name ?? '-';
            });
            $table->editColumn('financial_roadmap_status', function ($row) {
                $status_name    =  FinancialRoadmap::STATUS_SELECT[$row->status ?? 0];
                $status_class   =  FinancialRoadmap::STATUS_CLASSES[$row->status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });

            $table->rawColumns(['actions', 'placeholder', 'financial_roadmap_status', 'company_name', 'contact_person', 'contact_number', 'user_id']);
            return $table->make(true);
        }

        return view('admin.financialRoadmap.index', compact('financialRoadmap_status', 'financialRoadmap_page'));
    }

    public function confirm_index( Request $request)
    {
        //set the normal value
        $financialRoadmap_status    =  FinancialRoadmap::STATUS_SELECT;
        $financialRoadmap_page      =  2;

        if ($request->ajax()) {
            $query = FinancialRoadmap::all()->where('status', 1);
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $name               = 'financial roadmap';
                $permission_name    = 'finRoadmap';
                $except             = ['edit','destroy'];
                $finRoadmap         = 2;
                $blank              = 1;
                return view('partials.datatablesActions', compact(
                    'name',
                    'permission_name',
                    'except',
                    'row',
                    'finRoadmap',
                    'blank'
                ));
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name ?? '-';
            });
            $table->editColumn('contact_person', function ($row) {
                return $row->contact_person ?? '-';
            });
            $table->editColumn('contact_number', function ($row) {
                return $row->contact_number ?? '-';
            });
            $table->editColumn('user_id', function ($row) {

                $user = User::where('id', $row->user_id)->select('name')->first();

                return $user->name ?? '-';
            });
            $table->editColumn('financial_roadmap_status', function ($row) {
                $status_name    =  FinancialRoadmap::STATUS_SELECT[$row->status ?? 0];
                $status_class   =  FinancialRoadmap::STATUS_CLASSES[$row->status ?? 0];
                return '<b class="text-' . $status_class . '">' . $status_name . '</b>';
            });

            $table->rawColumns(['actions', 'placeholder', 'financial_roadmap_status', 'company_name', 'contact_person', 'contact_number', 'user_id']);
            return $table->make(true);
        }

        return view('admin.financialRoadmap.index', compact('financialRoadmap_status', 'financialRoadmap_page'));
    }

    public function show(FinancialRoadmap $FinancialRoadmap){
        $financialRoadmap = $FinancialRoadmap;

        $basic_info                     = FinancialRoadmap::where('id', $financialRoadmap->id)->first();
        $financialRoadmap_data          = FinancialRoadmapData::where('financial_roadmap_id', $financialRoadmap->id)->get();
        $industry_types                 = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $roadmap_financingInstruments   = FinancialRoadmapInstruments::where('financial_roadmap_id', $financialRoadmap->id)->get();
        $has_been_edit_status           = $financialRoadmap->edit_status;

        foreach ($roadmap_financingInstruments as $roadmap_financingInstruments_key => $roadmap_financingInstruments_item){
            switch ($roadmap_financingInstruments_item->group_id){
                case 0:
                    $loan_product   = 'Term Loan';
                    break;

                case 1:
                    $loan_product   = 'Overdraft';
                    break;

                case 2:
                    $loan_product   = 'Trade Line';
                    break;

                case 3:
                    $loan_product   = 'Property Loan';
                    break;

                default:
                    $loan_product   = '';
                    break;
            }

            if ($roadmap_financingInstruments_item->tenor == 0.8){
                $roadmap_financingInstruments_item->tenor_name = 'On Demand';
                $roadmap_financingInstruments_item->tenor_type = 0; // 0 : text
            }
            else{
                $roadmap_financingInstruments_item->tenor_type = 1; // 1 : number
            }

            $roadmap_financingInstruments_item->loan_product = $loan_product;
        }

        //declare array
        $financial_year_arr             = array();

        $empty_arr                      = array();
        $turnover_arr                   = array();
        $cogs_arr                       = array();
        $general_expenses_arr           = array();
        $depreciation_expenses_arr      = array();
        $finance_cost_arr               = array();
        $gross_profit_arr               = array();
        $profit_bfr_tax_arr             = array();
        $tax_arr                        = array();
        $profit_aft_tax_arr             = array();

        $inventories_arr                = array();
        $trade_receivables_arr          = array();
        $trade_payables_arr             = array();
        $facilities_required_arr        = array();
        $share_capital_arr              = array();
        $retained_earnings_arr          = array();
        $net_worth_arr                  = array();
        $annual_debts_arr               = array();

        $net_cash_arr                   = array();

        $working_capital_eligibility_arr     = array(0, 0, 0, 0, 0, 0);
        $existing_loan_arr                   = array(0, 0, 0, 0, 0, 0);
        $financing_term_loan_arr             = array(0, 0, 0, 0, 0, 0);
        $financing_overdraft_arr             = array(0, 0, 0, 0, 0, 0);
        $financing_trade_line_arr            = array(0, 0, 0, 0, 0, 0);
        $financing_property_loan_arr         = array(0, 0, 0, 0, 0, 0);
        $total_loan_amount_arr               = array(0, 0, 0, 0, 0, 0);
        $repayment_term_property_loan_arr    = array(0, 0, 0, 0, 0, 0);
        $repayment_od_trade_arr              = array(0, 0, 0, 0, 0, 0);
        $repayment_term_loan_arr             = array(0, 0, 0, 0, 0, 0);
        $repayment_overdraft_arr             = array(0, 0, 0, 0, 0, 0);
        $repayment_trade_line_arr            = array(0, 0, 0, 0, 0, 0);
        $repayment_property_loan_arr         = array(0, 0, 0, 0, 0, 0);
        $annual_repayment_arr                = array(0, 0, 0, 0, 0, 0);
        $ebitda_arr                          = array(0, 0, 0, 0, 0, 0);
        $total_outstanding_loan_amount_arr   = array(0, 0, 0, 0, 0, 0);
        $dscr_arr                            = array(0, 0, 0, 0, 0, 0);
        $gearing_ratio_arr                   = array(0, 0, 0, 0, 0, 0);

        $latest_turnover        = 0;
        $latest_profit_bfr_tax  = 0;
        $latest_profit_aft_tax  = 0;
        $latest_financial_year  = 0;

        //report part
        foreach ($financialRoadmap_data as $financialRoadmap_data_key => $financialRoadmap_data_item){
            if ($financialRoadmap_data_key < 3){
                array_push($financial_year_arr,         $financialRoadmap_data_item->financial_year);
                array_push($empty_arr,                  0);

                //area 1
                array_push($turnover_arr,               $financialRoadmap_data_item->turnover);
                array_push($cogs_arr,                   $financialRoadmap_data_item->cogs);
                array_push($gross_profit_arr,           $financialRoadmap_data_item->gross_profit);
                array_push($depreciation_expenses_arr,  $financialRoadmap_data_item->depreciation_expenses);
                array_push($finance_cost_arr,           $financialRoadmap_data_item->finance_cost);
                array_push($profit_bfr_tax_arr,         $financialRoadmap_data_item->profit_bfr_tax);
                array_push($tax_arr,                    $financialRoadmap_data_item->tax);
                array_push($profit_aft_tax_arr,         $financialRoadmap_data_item->profit_aft_tax);

                //area2
                array_push($inventories_arr,            $financialRoadmap_data_item->inventories);
                array_push($trade_receivables_arr,      $financialRoadmap_data_item->trade_receivables);
                array_push($trade_payables_arr,         $financialRoadmap_data_item->trade_payables);
                array_push($share_capital_arr,          $financialRoadmap_data_item->share_capital);
                array_push($retained_earnings_arr,      $financialRoadmap_data_item->retained_earnings);
                array_push($net_worth_arr,              $financialRoadmap_data_item->net_worth);
                array_push($annual_debts_arr,           $financialRoadmap_data_item->annual_debts);

                //area3
                array_push($net_cash_arr,               $financialRoadmap_data_item->net_cash);

                //get latest
                $latest_turnover        = $financialRoadmap_data_item->turnover;
                $latest_profit_bfr_tax  = $financialRoadmap_data_item->profit_bfr_tax;
                $latest_profit_aft_tax  = $financialRoadmap_data_item->profit_aft_tax;
                $latest_financial_year  = $financialRoadmap_data_item->financial_year;
            }
        }

        $comprehensive_arr      = array(
            'name'                  => ['Turnover', 'COGS / COS', 'Gross Profit', 'Depreciation Expenses', 'Finance Cost', 'Profit Before Tax', 'Tax', 'Profit After Tax'],
            'id'                    => ['turnover', 'cogs', 'gross_profit', 'depreciation_expenses', 'finance_cost', 'profit_bfr_tax', 'tax', 'profit_aft_tax'],
            'data'                  => [$turnover_arr, $cogs_arr, $gross_profit_arr, $depreciation_expenses_arr, $finance_cost_arr, $profit_bfr_tax_arr, $tax_arr, $profit_aft_tax_arr],
            'percent_status'        => [0, 1, 1, 0, 0, 1, 1, 1],
            'percent_status_id'     => ['', 'cogs_percent', 'gross_profit_percent', '', '', 'profit_bfr_tax_percent', 'tax_percent', 'profit_aft_tax_percent'],
        );

        $financial_position_arr = array(
            'name'                  => ['Inventories', 'Trade Receivables', 'Trade Payables', 'Share Capital', 'Retained Earnings', 'Total Tangible Net Worth', 'Annual Debts'],
            'id'                    => ['inventories', 'trade_receivables', 'trade_payables', 'share_capital', 'retained_earnings', 'net_worth', 'annual_debts'],
            'data'                  => [$inventories_arr, $trade_receivables_arr, $trade_payables_arr, $share_capital_arr, $retained_earnings_arr, $net_worth_arr, $annual_debts_arr],
            'percent_status'        => [1, 1, 1, 0, 0, 0, 0],
            'percent_status_id'     => ['inventories_percent', 'trade_receivables_percent', 'trade_payables_percent', '', '', '', ''],
        );

        $cash_flow_arr          = array(
            'name'      =>  ['Net Cash Generated From / (Used In) From Operating Activities'],
            'id'        =>  ['net_cash'],
            'data'      =>  [$net_cash_arr],
        );

        //create the report's fake data
        for ($i = 0; $i < 3; $i++ ){
            $latest_turnover        +=  $latest_turnover        * 20 / 100;
            $latest_profit_bfr_tax  +=  $latest_profit_bfr_tax  * 20 / 100;
            $latest_profit_aft_tax  +=  $latest_profit_aft_tax  * 20 / 100;
            $latest_financial_year  =   $latest_financial_year  + 1;

            array_push($turnover_arr,               $latest_turnover);
            array_push($profit_bfr_tax_arr,         $latest_profit_bfr_tax);
            array_push($profit_aft_tax_arr,         $latest_profit_aft_tax);
            array_push($financial_year_arr,         $latest_financial_year);
        }

        // Chart Text Array
        $turnover_arr_text          = implode(",", $turnover_arr);
        $profit_aft_tax_arr_text    = implode(",", $profit_aft_tax_arr);
        $profit_bfr_tax_arr_text    = implode(",", $profit_bfr_tax_arr);
        $financial_year_arr_text    = implode(",", $financial_year_arr);

        /**           Financial Roadmap Part          **/

        //add on the array to roadmap
        // 0 = add on
        // 1 = clear array, and add new array
        if ($financialRoadmap->edit_status == 1){
            //clear array
            array_splice($empty_arr                 , 0, 3);
            array_splice($financial_year_arr        , 0, 6); //clear with fake data

            array_splice($turnover_arr              , 0, 6); //clear with fake data
            array_splice($cogs_arr                  , 0, 3);
            array_splice($depreciation_expenses_arr , 0, 3);
            array_splice($finance_cost_arr          , 0, 3);
            array_splice($gross_profit_arr          , 0, 3);
            array_splice($profit_bfr_tax_arr        , 0, 6); //clear with fake data
            array_splice($tax_arr                   , 0, 3);
            array_splice($profit_aft_tax_arr        , 0, 6); //clear with fake data

            array_splice($inventories_arr           , 0, 3);
            array_splice($trade_receivables_arr     , 0, 3);
            array_splice($trade_payables_arr        , 0, 3);
            array_splice($share_capital_arr         , 0, 3);
            array_splice($retained_earnings_arr     , 0, 3);
            array_splice($net_worth_arr             , 0, 3);

            array_splice($net_cash_arr              , 0, 3);

            array_splice($working_capital_eligibility_arr  , 0, 6 );
            array_splice($existing_loan_arr                , 0, 6 );
            array_splice($financing_term_loan_arr          , 0, 6 );
            array_splice($financing_overdraft_arr          , 0, 6 );
            array_splice($financing_trade_line_arr         , 0, 6 );
            array_splice($financing_property_loan_arr      , 0, 6 );
            array_splice($total_loan_amount_arr            , 0, 6 );
            array_splice($repayment_term_property_loan_arr , 0, 6 );
            array_splice($repayment_od_trade_arr           , 0, 6 );
            array_splice($repayment_term_loan_arr          , 0, 6 );
            array_splice($repayment_overdraft_arr          , 0, 6 );
            array_splice($repayment_trade_line_arr         , 0, 6 );
            array_splice($repayment_property_loan_arr      , 0, 6 );
            array_splice($annual_repayment_arr             , 0, 6 );
            array_splice($ebitda_arr                       , 0, 6 );
            array_splice($total_outstanding_loan_amount_arr, 0, 6 );
            array_splice($dscr_arr                         , 0, 6 );
            array_splice($gearing_ratio_arr                , 0, 6 );

            foreach ($financialRoadmap_data as $financialRoadmap_data_key => $financialRoadmap_data_item) {
                array_push($empty_arr,                  0);
                array_push($financial_year_arr,         $financialRoadmap_data_item->financial_year);

                array_push($turnover_arr,               $financialRoadmap_data_item->turnover);
                array_push($cogs_arr,                   $financialRoadmap_data_item->cogs);
                array_push($gross_profit_arr,           $financialRoadmap_data_item->gross_profit);
                array_push($general_expenses_arr,       $financialRoadmap_data_item->general_expenses);
                array_push($depreciation_expenses_arr,  $financialRoadmap_data_item->depreciation_expenses);
                array_push($finance_cost_arr,           $financialRoadmap_data_item->finance_cost);
                array_push($profit_bfr_tax_arr,         $financialRoadmap_data_item->profit_bfr_tax);
                array_push($tax_arr,                    $financialRoadmap_data_item->tax);
                array_push($profit_aft_tax_arr,         $financialRoadmap_data_item->profit_aft_tax);

                array_push($inventories_arr,            $financialRoadmap_data_item->inventories);
                array_push($trade_receivables_arr,      $financialRoadmap_data_item->trade_receivables);
                array_push($trade_payables_arr,         $financialRoadmap_data_item->trade_payables);
                array_push($facilities_required_arr,    $financialRoadmap_data_item->facilities_required);
                array_push($share_capital_arr,          $financialRoadmap_data_item->share_capital);
                array_push($retained_earnings_arr,      $financialRoadmap_data_item->retained_earnings);
                array_push($net_worth_arr,              $financialRoadmap_data_item->net_worth);

                array_push($net_cash_arr,               $financialRoadmap_data_item->net_cash);

                array_push($working_capital_eligibility_arr  , $financialRoadmap_data_item->working_capital_eligibility );
                array_push($existing_loan_arr                , $financialRoadmap_data_item->existing_loan );
                array_push($financing_term_loan_arr          , $financialRoadmap_data_item->financing_term_loan );
                array_push($financing_overdraft_arr          , $financialRoadmap_data_item->financing_overdraft );
                array_push($financing_trade_line_arr         , $financialRoadmap_data_item->financing_trade_line );
                array_push($financing_property_loan_arr      , $financialRoadmap_data_item->financing_property_loan );
                array_push($total_loan_amount_arr            , $financialRoadmap_data_item->total_loan_amount );
                array_push($repayment_term_property_loan_arr , $financialRoadmap_data_item->repayment_term_property_loan );
                array_push($repayment_od_trade_arr           , $financialRoadmap_data_item->repayment_od_trade );
                array_push($repayment_term_loan_arr          , $financialRoadmap_data_item->repayment_term_loan );
                array_push($repayment_overdraft_arr          , $financialRoadmap_data_item->repayment_overdraft );
                array_push($repayment_trade_line_arr         , $financialRoadmap_data_item->repayment_trade_line );
                array_push($repayment_property_loan_arr      , $financialRoadmap_data_item->repayment_property_loan );
                array_push($annual_repayment_arr             , $financialRoadmap_data_item->annual_repayment );
                array_push($ebitda_arr                       , $financialRoadmap_data_item->ebitda );
                array_push($total_outstanding_loan_amount_arr, $financialRoadmap_data_item->total_outstanding_loan_amount );
                array_push($dscr_arr                         , $financialRoadmap_data_item->dscr );
                array_push($gearing_ratio_arr                , $financialRoadmap_data_item->gearing_ratio );
            }
        }
        else{
            //clear report's fake data
            array_splice($turnover_arr, 3,3);
            array_splice($profit_bfr_tax_arr, 3,3);
            array_splice($profit_aft_tax_arr, 3,3);

            for ($i = 0; $i < 3; $i++ ){
                array_push($empty_arr,                  0);
                array_push($turnover_arr,               0);
                array_push($cogs_arr,                   0);
                array_push($depreciation_expenses_arr,  0);
                array_push($finance_cost_arr,           0);
                array_push($gross_profit_arr,           0);
                array_push($profit_bfr_tax_arr,         0);
                array_push($tax_arr,                    0);
                array_push($profit_aft_tax_arr,         0);

                array_push($inventories_arr,            0);
                array_push($trade_receivables_arr,      0);
                array_push($trade_payables_arr,         0);
                array_push($share_capital_arr,          0);
                array_push($retained_earnings_arr,      0);
                array_push($net_worth_arr,              0);

                array_push($net_cash_arr,               0);
            }
        }

        $roadmap_comprehensive_stt_arr      = array(
            'name'                  => ['Sales', 'Turnover', 'COGS / COS', 'Gross Profit', 'Expenses', 'General / Administration Expenses', 'Depreciation Expenses', 'Finance Cost', 'Profit', 'Profit Before Tax', 'Tax', 'Profit After Tax'],
            'percent_status'        => [0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 1, 1],
            'label'                 => [1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0],

            'id'                    => ['', 'rm_turnover', 'rm_cogs', 'rm_gross_profit', '', 'rm_general_expenses', 'rm_depreciation_expenses', 'rm_finance_cost', '', 'rm_profit_bfr_tax', 'rm_tax', 'rm_profit_aft_tax'],
            'data'                  => [$empty_arr, $turnover_arr, $cogs_arr, $gross_profit_arr, $empty_arr, $empty_arr,$depreciation_expenses_arr, $finance_cost_arr, $empty_arr, $profit_bfr_tax_arr, $tax_arr, $profit_aft_tax_arr],
            'percent_status_id'     => ['', 'rm_turnover_percent', 'rm_cogs_percent', 'rm_gross_profit_percent', '', 'rm_general_expenses_percent', '', '', '', 'rm_profit_bfr_tax_percent', 'rm_tax_percent', 'rm_profit_aft_tax_percent'],

            'trigger_hide_status'   => [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0],
            'hide_status'           => [0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1],
        );

        $roadmap_financial_position_stt_arr = array(
            'name'                  => ['Inventories', 'Trade Receivables', 'Trade Payables', 'Facilities Required', 'Share Capital', 'Retained Earnings', 'Total Tangible Net Worth'],
            'percent_status'        => [1, 1, 1, 0, 0, 0, 0],

            'id'                    => ['rm_inventories', 'rm_trade_receivables', 'rm_trade_payables', 'rm_facilities_required', 'rm_share_capital', 'rm_retained_earnings', 'rm_net_worth'],
            'data'                  => [$inventories_arr, $trade_receivables_arr, $trade_payables_arr, $empty_arr, $share_capital_arr, $retained_earnings_arr, $net_worth_arr],
            'percent_status_id'     => ['rm_inventories_percent', 'rm_trade_receivables_percent', 'rm_trade_payables_percent', '', '', '', ''],

            'highlightable'         => [0, 0, 0, 1, 0, 0, 0],
            'border_top'            => [0, 0, 0, 0, 0, 0, 1],
        );

        $roadmap_cash_flow_arr              = array(
            'name'      =>  ['Net Cash Generated From / (Used In) From Operating Activities'],
            'id'        =>  ['rm_net_cash'],
            'data'      =>  [$net_cash_arr],
        );

        $roadmap_financial_position_arr     = array(
            'name'     => ['Working Capital Eligibility', 'Existing Loan', 'Projection On Additional Financing (Term Loan)', 'Projection On Additional Financing (Overdraft)',
                'Projection On Additional Financing (Trade Line)', 'Projection On Additional Financing (Property Loan)', 'Total Loan Amount (a)', 'Current Annual Repayment (Term Loan & Property Loan)',
                'Current Annual Repayment (OD & Trade)', 'New Annual Repayment (Term Loan)', 'New Annual Repayment (Overdraft)', 'New Annual Repayment (Trade Line)',
                'New Annual Repayment (Property Loan)', 'Total Annual Repayment (b)', 'EBITDA', 'Total Outstanding Loan Amount (a) - (b)',
                'Debt-Service Coverage Ratio (DSCR)', 'Gearing Ratio'
            ],

            'id'       => ['working_capital_eligibility', 'existing_loan', 'financing_term_loan', 'financing_overdraft',
                'financing_trade_line', 'financing_property_loan', 'total_loan_amount', 'repayment_term_property_loan',
                'repayment_od_trade', 'repayment_term_loan', 'repayment_overdraft', 'repayment_trade_line',
                'repayment_property_loan', 'annual_repayment', 'ebitda', 'total_outstanding_loan_amount',
                'dscr', 'gearing_ratio'],

            'data'              => [
                $working_capital_eligibility_arr  ,
                $existing_loan_arr                ,
                $financing_term_loan_arr          ,
                $financing_overdraft_arr          ,
                $financing_trade_line_arr         ,
                $financing_property_loan_arr      ,
                $total_loan_amount_arr            ,
                $repayment_term_property_loan_arr ,
                $repayment_od_trade_arr           ,
                $repayment_term_loan_arr          ,
                $repayment_overdraft_arr          ,
                $repayment_trade_line_arr         ,
                $repayment_property_loan_arr      ,
                $annual_repayment_arr             ,
                $ebitda_arr                       ,
                $total_outstanding_loan_amount_arr,
                $dscr_arr                         ,
                $gearing_ratio_arr                ,
            ],

            'highlightable'     => [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0],
            'col_block'         => [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1],
            'summary'           => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1],
            'top_line'          => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0],
        );

//        $financial_year_arr_text = financial_year_arrimplode(",", $financial_year_arr);

        return view('admin.financialRoadmap.show',
            compact('roadmap_comprehensive_stt_arr', 'roadmap_financial_position_stt_arr', 'roadmap_cash_flow_arr', 'roadmap_financial_position_arr', 'roadmap_financingInstruments',
            'comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data', 'industry_types', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text',
            'financial_year_arr', 'financialRoadmap', 'has_been_edit_status')
        );
    }

    public function update(Request $request, FinancialRoadmap $FinancialRoadmap){

        $financialRoadmap = $FinancialRoadmap;

        $basic_data = $request->only(
            'company_name',
            'business_industry',
            'contact_person',
            'contact_number',
            'email',
            'default_turnover_percent',
            'default_cogs_percent',
            "default_gross_profit_percent",
            "default_finance_cost_percent",
            "default_inventories_percent",
            "default_trade_receivables_percent",
            "default_trade_payables_percent",
            "default_eligibility_percent"
        );

        $data_details = collect($request->all())->mapWithKeys(function ($item, $key) {
            if(str_contains($key, 'rm_') && str_starts_with($key, 'rm_')) {
//                $key = substr($key, 3);
                $key = str_replace('rm_', '', $key);
                return [$key => $item];
            }
            return [$key => $item];
        })->except(
            'company_name',
            'business_industry',
            'contact_person',
            'contact_number',
            'email',
            'default_turnover_percent',
            'default_cogs_percent',
            "default_gross_profit_percent",
            "default_finance_cost_percent",
            "default_inventories_percent",
            "default_trade_receivables_percent",
            "default_trade_payables_percent",
            "default_eligibility_percent"
        );

        $financialRoadmap_data = collect($request->only(
            'financingInstrument_proposed_limit',
            'financingInstrument_interest_rate',
            'financingInstrument_tenor_input',
            'financingInstrument_commitments',
            'new_financingInstrument_commitments',
        ))->mapWithKeys(function ($item, $key) {
            if(str_contains($key, 'financingInstrument_')) {
//                $key = substr($key, 3);
                $key = str_replace('financingInstrument_', '', $key);
                return [$key => $item];
            }
            return [$key => $item];
        });


        $basic_data["edit_status"] = 1;

        $financialRoadmap->update(
            $basic_data
        );

        for ($i = 0; $i < 6; $i++ ){
            FinancialRoadmapData::where('financial_roadmap_id', $financialRoadmap->id)->where('group_id', $i)->update([
                "turnover"                      => $this->reformatToNumeric($data_details->get('turnover')[$i]                      ?? 0),
                "cogs"                          => $this->reformatToNumeric($data_details->get('cogs')[$i]                          ?? 0),
                "gross_profit"                  => $this->reformatToNumeric($data_details->get('gross_profit')[$i]                  ?? 0),
                "general_expenses"              => $this->reformatToNumeric($data_details->get('general_expenses')[$i]              ?? 0),
                "depreciation_expenses"         => $this->reformatToNumeric($data_details->get('depreciation_expenses')[$i]         ?? 0),
                "finance_cost"                  => $this->reformatToNumeric($data_details->get('finance_cost')[$i]                  ?? 0),
                "profit_bfr_tax"                => $this->reformatToNumeric($data_details->get('profit_bfr_tax')[$i]                ?? 0),
                "tax"                           => $this->reformatToNumeric($data_details->get('tax')[$i]                           ?? 0),
                "profit_aft_tax"                => $this->reformatToNumeric($data_details->get('profit_aft_tax')[$i]                ?? 0),

                "inventories"                   => $this->reformatToNumeric($data_details->get('inventories')[$i]                   ?? 0),
                "trade_receivables"             => $this->reformatToNumeric($data_details->get('trade_receivables')[$i]             ?? 0),
                "trade_payables"                => $this->reformatToNumeric($data_details->get('trade_payables')[$i]                ?? 0),
                "facilities_required"           => $this->reformatToNumeric($data_details->get('facilities_required')[$i]           ?? 0),
                "share_capital"                 => $this->reformatToNumeric($data_details->get('share_capital')[$i]                 ?? 0),
                "retained_earnings"             => $this->reformatToNumeric($data_details->get('retained_earnings')[$i]             ?? 0),
                "net_worth"                     => $this->reformatToNumeric($data_details->get('net_worth')[$i]                     ?? 0),

                "net_cash"                      => $this->reformatToNumeric($data_details->get('net_cash')[$i]                      ?? 0),

                "working_capital_eligibility"   => $this->reformatToNumeric($data_details->get('working_capital_eligibility')[$i]   ?? 0),
                "existing_loan"                 => $this->reformatToNumeric($data_details->get('existing_loan')[$i]                 ?? 0),
                "financing_term_loan"           => $this->reformatToNumeric($data_details->get('financing_term_loan')[$i]           ?? 0),
                "financing_overdraft"           => $this->reformatToNumeric($data_details->get('financing_overdraft')[$i]           ?? 0),
                "financing_trade_line"          => $this->reformatToNumeric($data_details->get('financing_trade_line')[$i]          ?? 0),
                "financing_property_loan"       => $this->reformatToNumeric($data_details->get('financing_property_loan')[$i]       ?? 0),
                "total_loan_amount"             => $this->reformatToNumeric($data_details->get('total_loan_amount')[$i]             ?? 0),
                "repayment_term_property_loan"  => $this->reformatToNumeric($data_details->get('repayment_term_property_loan')[$i]  ?? 0),
                "repayment_od_trade"            => $this->reformatToNumeric($data_details->get('repayment_od_trade')[$i]            ?? 0),
                "repayment_term_loan"           => $this->reformatToNumeric($data_details->get('repayment_term_loan')[$i]           ?? 0),
                "repayment_overdraft"           => $this->reformatToNumeric($data_details->get('repayment_overdraft')[$i]           ?? 0),
                "repayment_trade_line"          => $this->reformatToNumeric($data_details->get('repayment_trade_line')[$i]          ?? 0),
                "repayment_property_loan"       => $this->reformatToNumeric($data_details->get('repayment_property_loan')[$i]       ?? 0),
                "annual_repayment"              => $this->reformatToNumeric($data_details->get('annual_repayment')[$i]              ?? 0),
                "ebitda"                        => $this->reformatToNumeric($data_details->get('ebitda')[$i]                        ?? 0),
                "total_outstanding_loan_amount" => $this->reformatToNumeric($data_details->get('total_outstanding_loan_amount')[$i] ?? 0),
                "dscr"                          => $this->reformatToNumeric($data_details->get('dscr')[$i]                          ?? 0),
                "gearing_ratio"                 => $this->reformatToNumeric($data_details->get('gearing_ratio')[$i]                 ?? 0),

                "edit_status"                   => 1,

                "turnover_percent"                      => $this->reformatToNumeric($data_details->get('turnover_percent')[$i]                      ?? 0),
                "cogs_percent"                          => $this->reformatToNumeric($data_details->get('cogs_percent')[$i]                          ?? 0),
                "gross_profit_percent"                  => $this->reformatToNumeric($data_details->get('gross_profit_percent')[$i]                  ?? 0),
                "general_expenses_percent"              => $this->reformatToNumeric($data_details->get('general_expenses_percent')[$i]              ?? 0),
                "profit_bfr_tax_percent"                => $this->reformatToNumeric($data_details->get('profit_bfr_tax_percent')[$i]                ?? 0),
                "tax_percent"                           => $this->reformatToNumeric($data_details->get('tax_percent')[$i]                           ?? 0),
                "profit_aft_tax_percent"                => $this->reformatToNumeric($data_details->get('profit_aft_tax_percent')[$i]                ?? 0),
                "inventories_percent"                   => $this->reformatToNumeric($data_details->get('inventories_percent')[$i]                   ?? 0),
                "trade_receivables_percent"             => $this->reformatToNumeric($data_details->get('trade_receivables_percent')[$i]             ?? 0),
                "trade_payables_percent"                => $this->reformatToNumeric($data_details->get('trade_payables_percent')[$i]                ?? 0),
            ]);
        }

        for ($i = 0; $i < 4; $i++ ){
            FinancialRoadmapInstruments::where('financial_roadmap_id', $financialRoadmap->id)->where('group_id', $i)->update([
                'proposed_limit'            => $this->reformatToNumeric($financialRoadmap_data->get('proposed_limit')[$i]),
                'interest_rate'             => $this->reformatToNumeric($financialRoadmap_data->get('interest_rate')[$i]),
                'tenor'                     => $this->reformatToNumeric($financialRoadmap_data->get('tenor_input')[$i]),
                'commitments'               => $this->reformatToNumeric($financialRoadmap_data->get('commitments')[$i]),
                'new_commitments'           => $this->reformatToNumeric($financialRoadmap_data->get('new_commitments')[$i]),
            ]);
        }

        $chart_name = str_replace('/', '_', $request->chartImg);
        $chart_name = str_replace('.png', '', $chart_name);

        if ($request->chartImg_status == 1){
//            $this->generatePdf($request->chartImg, $financialRoadmap);
            return redirect()->route('admin.financial-roadmaps.print.generate-roadmaps-pdf', ['financialRoadmap' => $FinancialRoadmap, 'chartImg' => $chart_name]);
        }
        else{
            return redirect()->route('admin.financial-roadmaps.show', ['FinancialRoadmap' => $financialRoadmap, '#finRoadmap']);
        }
    }

    public function updateStatus(Request $request){

        FinancialRoadmap::where('id', $request->finRm_id)
            ->update([
                'status' => $request->finRm_status,
            ]);

        return redirect()->route('admin.financial_roadmap.pending_index');
    }

    public function generateChartImg(Request $request ,FinancialRoadmap $financialRoadmap){
        $base64_string  = $request->image;

        $imageName = 'financialRoadmap/'.$financialRoadmap->id.'/'.rand(0, 10000000).'.'.'png';

        Storage::disk('public')->put($imageName, $base64_string);

        return $imageName;
    }

    public function generatePdf(FinancialRoadmap $financialRoadmap, $chartImg){
        ini_set('memory_limit', '512M');

        $chartImg = str_replace('_', '/', $chartImg);
        $chartImg = $chartImg.'.png';

//        dd('yesy');

//        return $request->chart_img;

        $basic_info                     = FinancialRoadmap::where('id', $financialRoadmap->id)->first();
        $financialRoadmap_data          = FinancialRoadmapData::where('financial_roadmap_id', $financialRoadmap->id)->get();
        $industry_types                 = IndustryType::where('id', $basic_info->business_industry)->first();
        $roadmap_financingInstruments   = FinancialRoadmapInstruments::where('financial_roadmap_id', $financialRoadmap->id)->get();
        $has_been_edit_status           = $financialRoadmap->edit_status;

        foreach ($roadmap_financingInstruments as $roadmap_financingInstruments_key => $roadmap_financingInstruments_item){
            switch ($roadmap_financingInstruments_item->group_id){
                case 0:
                    $loan_product   = 'Term Loan';
                    break;

                case 1:
                    $loan_product   = 'Overdraft';
                    break;

                case 2:
                    $loan_product   = 'Trade Line';
                    break;

                case 3:
                    $loan_product   = 'Property Loan';
                    break;

                default:
                    $loan_product   = '';
                    break;
            }

            if ($roadmap_financingInstruments_item->tenor == 0.8){
                $roadmap_financingInstruments_item->tenor_name = 'On Demand';
                $roadmap_financingInstruments_item->tenor_type = 0; // 0 : text
            }
            else{
                $roadmap_financingInstruments_item->tenor_type = 1; // 1 : number
            }

            $roadmap_financingInstruments_item->loan_product = $loan_product;
        }

        //declare array
        $financial_year_arr             = array();

        $empty_arr                      = array();
        $turnover_arr                   = array();
        $cogs_arr                       = array();
        $general_expenses_arr           = array();
        $depreciation_expenses_arr      = array();
        $finance_cost_arr               = array();
        $gross_profit_arr               = array();
        $profit_bfr_tax_arr             = array();
        $tax_arr                        = array();
        $profit_aft_tax_arr             = array();

        $inventories_arr                = array();
        $trade_receivables_arr          = array();
        $trade_payables_arr             = array();
        $facilities_required_arr        = array();
        $share_capital_arr              = array();
        $retained_earnings_arr          = array();
        $net_worth_arr                  = array();
        $annual_debts_arr               = array();

        $net_cash_arr                   = array();

        $working_capital_eligibility_arr     = array(0, 0, 0, 0, 0, 0);
        $existing_loan_arr                   = array(0, 0, 0, 0, 0, 0);
        $financing_term_loan_arr             = array(0, 0, 0, 0, 0, 0);
        $financing_overdraft_arr             = array(0, 0, 0, 0, 0, 0);
        $financing_trade_line_arr            = array(0, 0, 0, 0, 0, 0);
        $financing_property_loan_arr         = array(0, 0, 0, 0, 0, 0);
        $total_loan_amount_arr               = array(0, 0, 0, 0, 0, 0);
        $repayment_term_property_loan_arr    = array(0, 0, 0, 0, 0, 0);
        $repayment_od_trade_arr              = array(0, 0, 0, 0, 0, 0);
        $repayment_term_loan_arr             = array(0, 0, 0, 0, 0, 0);
        $repayment_overdraft_arr             = array(0, 0, 0, 0, 0, 0);
        $repayment_trade_line_arr            = array(0, 0, 0, 0, 0, 0);
        $repayment_property_loan_arr         = array(0, 0, 0, 0, 0, 0);
        $annual_repayment_arr                = array(0, 0, 0, 0, 0, 0);
        $ebitda_arr                          = array(0, 0, 0, 0, 0, 0);
        $total_outstanding_loan_amount_arr   = array(0, 0, 0, 0, 0, 0);
        $dscr_arr                            = array(0, 0, 0, 0, 0, 0);
        $gearing_ratio_arr                   = array(0, 0, 0, 0, 0, 0);

        $latest_turnover        = 0;
        $latest_profit_bfr_tax  = 0;
        $latest_profit_aft_tax  = 0;
        $latest_financial_year  = 0;

        //report part
        foreach ($financialRoadmap_data as $financialRoadmap_data_key => $financialRoadmap_data_item){
            if ($financialRoadmap_data_key < 3){
                array_push($financial_year_arr,         $financialRoadmap_data_item->financial_year);
                array_push($empty_arr,                  0);

                //area 1
                array_push($turnover_arr,               $financialRoadmap_data_item->turnover);
                array_push($cogs_arr,                   $financialRoadmap_data_item->cogs);
                array_push($gross_profit_arr,           $financialRoadmap_data_item->gross_profit);
                array_push($depreciation_expenses_arr,  $financialRoadmap_data_item->depreciation_expenses);
                array_push($finance_cost_arr,           $financialRoadmap_data_item->finance_cost);
                array_push($profit_bfr_tax_arr,         $financialRoadmap_data_item->profit_bfr_tax);
                array_push($tax_arr,                    $financialRoadmap_data_item->tax);
                array_push($profit_aft_tax_arr,         $financialRoadmap_data_item->profit_aft_tax);

                //area2
                array_push($inventories_arr,            $financialRoadmap_data_item->inventories);
                array_push($trade_receivables_arr,      $financialRoadmap_data_item->trade_receivables);
                array_push($trade_payables_arr,         $financialRoadmap_data_item->trade_payables);
                array_push($share_capital_arr,          $financialRoadmap_data_item->share_capital);
                array_push($retained_earnings_arr,      $financialRoadmap_data_item->retained_earnings);
                array_push($net_worth_arr,              $financialRoadmap_data_item->net_worth);
                array_push($annual_debts_arr,           $financialRoadmap_data_item->annual_debts);

                //area3
                array_push($net_cash_arr,               $financialRoadmap_data_item->net_cash);

                //get latest
                $latest_turnover        = $financialRoadmap_data_item->turnover;
                $latest_profit_bfr_tax  = $financialRoadmap_data_item->profit_bfr_tax;
                $latest_profit_aft_tax  = $financialRoadmap_data_item->profit_aft_tax;
                $latest_financial_year  = $financialRoadmap_data_item->financial_year;
            }
        }

        $comprehensive_arr      = array(
            'name'                  => ['Turnover', 'COGS / COS', 'Gross Profit', 'Depreciation Expenses', 'Finance Cost', 'Profit Before Tax', 'Tax', 'Profit After Tax'],
            'id'                    => ['turnover', 'cogs', 'gross_profit', 'depreciation_expenses', 'finance_cost', 'profit_bfr_tax', 'tax', 'profit_aft_tax'],
            'data'                  => [$turnover_arr, $cogs_arr, $gross_profit_arr, $depreciation_expenses_arr, $finance_cost_arr, $profit_bfr_tax_arr, $tax_arr, $profit_aft_tax_arr],
            'percent_status'        => [0, 1, 1, 0, 0, 1, 1, 1],
            'percent_status_id'     => ['', 'cogs_percent', 'gross_profit_percent', '', '', 'profit_bfr_tax_percent', 'tax_percent', 'profit_aft_tax_percent'],
        );

        $financial_position_arr = array(
            'name'                  => ['Inventories', 'Trade Receivables', 'Trade Payables', 'Share Capital', 'Retained Earnings', 'Total Tangible Net Worth', 'Annual Debts'],
            'id'                    => ['inventories', 'trade_receivables', 'trade_payables', 'share_capital', 'retained_earnings', 'net_worth', 'annual_debts'],
            'data'                  => [$inventories_arr, $trade_receivables_arr, $trade_payables_arr, $share_capital_arr, $retained_earnings_arr, $net_worth_arr, $annual_debts_arr],
            'percent_status'        => [1, 1, 1, 0, 0, 0, 0],
            'percent_status_id'     => ['inventories_percent', 'trade_receivables_percent', 'trade_payables_percent', '', '', '', ''],
        );

        $cash_flow_arr          = array(
            'name'      =>  ['Net Cash Generated From / (Used In) From Operating Activities'],
            'id'        =>  ['net_cash'],
            'data'      =>  [$net_cash_arr],
        );

        //create the report's fake data
        for ($i = 0; $i < 3; $i++ ){
            $latest_turnover        +=  $latest_turnover        * 20 / 100;
            $latest_profit_bfr_tax  +=  $latest_profit_bfr_tax  * 20 / 100;
            $latest_profit_aft_tax  +=  $latest_profit_aft_tax  * 20 / 100;
            $latest_financial_year  =   $latest_financial_year  + 1;

            array_push($turnover_arr,               $latest_turnover);
            array_push($profit_bfr_tax_arr,         $latest_profit_bfr_tax);
            array_push($profit_aft_tax_arr,         $latest_profit_aft_tax);
            array_push($financial_year_arr,         $latest_financial_year);
        }

        // Chart Text Array
        $turnover_arr_text          = implode(",", $turnover_arr);
        $profit_aft_tax_arr_text    = implode(",", $profit_aft_tax_arr);
        $profit_bfr_tax_arr_text    = implode(",", $profit_bfr_tax_arr);
        $financial_year_arr_text    = implode(",", $financial_year_arr);

        /**           Financial Roadmap Part          **/

        //add on the array to roadmap
        // 0 = add on
        // 1 = clear array, and add new array
        if ($financialRoadmap->edit_status == 1){
            //clear array
            array_splice($empty_arr                 , 0, 3);
            array_splice($financial_year_arr        , 0, 6); //clear with fake data

            array_splice($turnover_arr              , 0, 6); //clear with fake data
            array_splice($cogs_arr                  , 0, 3);
            array_splice($depreciation_expenses_arr , 0, 3);
            array_splice($finance_cost_arr          , 0, 3);
            array_splice($gross_profit_arr          , 0, 3);
            array_splice($profit_bfr_tax_arr        , 0, 6); //clear with fake data
            array_splice($tax_arr                   , 0, 3);
            array_splice($profit_aft_tax_arr        , 0, 6); //clear with fake data

            array_splice($inventories_arr           , 0, 3);
            array_splice($trade_receivables_arr     , 0, 3);
            array_splice($trade_payables_arr        , 0, 3);
            array_splice($share_capital_arr         , 0, 3);
            array_splice($retained_earnings_arr     , 0, 3);
            array_splice($net_worth_arr             , 0, 3);

            array_splice($net_cash_arr              , 0, 3);

            array_splice($working_capital_eligibility_arr  , 0, 6 );
            array_splice($existing_loan_arr                , 0, 6 );
            array_splice($financing_term_loan_arr          , 0, 6 );
            array_splice($financing_overdraft_arr          , 0, 6 );
            array_splice($financing_trade_line_arr         , 0, 6 );
            array_splice($financing_property_loan_arr      , 0, 6 );
            array_splice($total_loan_amount_arr            , 0, 6 );
            array_splice($repayment_term_property_loan_arr , 0, 6 );
            array_splice($repayment_od_trade_arr           , 0, 6 );
            array_splice($repayment_term_loan_arr          , 0, 6 );
            array_splice($repayment_overdraft_arr          , 0, 6 );
            array_splice($repayment_trade_line_arr         , 0, 6 );
            array_splice($repayment_property_loan_arr      , 0, 6 );
            array_splice($annual_repayment_arr             , 0, 6 );
            array_splice($ebitda_arr                       , 0, 6 );
            array_splice($total_outstanding_loan_amount_arr, 0, 6 );
            array_splice($dscr_arr                         , 0, 6 );
            array_splice($gearing_ratio_arr                , 0, 6 );

            //percent array
            $turnover_arr_percent               = array();
            $cogs_arr_percent                   = array();
            $gross_profit_arr_percent           = array();
            $general_expenses_arr_percent       = array();
            $profit_bfr_tax_arr_percent         = array();
            $tax_arr_percent                    = array();
            $profit_aft_tax_arr_percent         = array();
            $inventories_arr_percent            = array();
            $trade_receivables_arr_percent      = array();
            $trade_payables_arr_percent         = array();

            foreach ($financialRoadmap_data as $financialRoadmap_data_key => $financialRoadmap_data_item) {
                array_push($empty_arr,                  0);
                array_push($financial_year_arr,         $financialRoadmap_data_item->financial_year);

                array_push($turnover_arr,               $financialRoadmap_data_item->turnover);
                array_push($cogs_arr,                   $financialRoadmap_data_item->cogs);
                array_push($gross_profit_arr,           $financialRoadmap_data_item->gross_profit);
                array_push($general_expenses_arr,       $financialRoadmap_data_item->general_expenses);
                array_push($depreciation_expenses_arr,  $financialRoadmap_data_item->depreciation_expenses);
                array_push($finance_cost_arr,           $financialRoadmap_data_item->finance_cost);
                array_push($profit_bfr_tax_arr,         $financialRoadmap_data_item->profit_bfr_tax);
                array_push($tax_arr,                    $financialRoadmap_data_item->tax);
                array_push($profit_aft_tax_arr,         $financialRoadmap_data_item->profit_aft_tax);

                array_push($inventories_arr,            $financialRoadmap_data_item->inventories);
                array_push($trade_receivables_arr,      $financialRoadmap_data_item->trade_receivables);
                array_push($trade_payables_arr,         $financialRoadmap_data_item->trade_payables);
                array_push($facilities_required_arr,    $financialRoadmap_data_item->facilities_required);
                array_push($share_capital_arr,          $financialRoadmap_data_item->share_capital);
                array_push($retained_earnings_arr,      $financialRoadmap_data_item->retained_earnings);
                array_push($net_worth_arr,              $financialRoadmap_data_item->net_worth);

                array_push($net_cash_arr,               $financialRoadmap_data_item->net_cash);

                array_push($working_capital_eligibility_arr  , $financialRoadmap_data_item->working_capital_eligibility );
                array_push($existing_loan_arr                , $financialRoadmap_data_item->existing_loan );
                array_push($financing_term_loan_arr          , $financialRoadmap_data_item->financing_term_loan );
                array_push($financing_overdraft_arr          , $financialRoadmap_data_item->financing_overdraft );
                array_push($financing_trade_line_arr         , $financialRoadmap_data_item->financing_trade_line );
                array_push($financing_property_loan_arr      , $financialRoadmap_data_item->financing_property_loan );
                array_push($total_loan_amount_arr            , $financialRoadmap_data_item->total_loan_amount );
                array_push($repayment_term_property_loan_arr , $financialRoadmap_data_item->repayment_term_property_loan );
                array_push($repayment_od_trade_arr           , $financialRoadmap_data_item->repayment_od_trade );
                array_push($repayment_term_loan_arr          , $financialRoadmap_data_item->repayment_term_loan );
                array_push($repayment_overdraft_arr          , $financialRoadmap_data_item->repayment_overdraft );
                array_push($repayment_trade_line_arr         , $financialRoadmap_data_item->repayment_trade_line );
                array_push($repayment_property_loan_arr      , $financialRoadmap_data_item->repayment_property_loan );
                array_push($annual_repayment_arr             , $financialRoadmap_data_item->annual_repayment );
                array_push($ebitda_arr                       , $financialRoadmap_data_item->ebitda );
                array_push($total_outstanding_loan_amount_arr, $financialRoadmap_data_item->total_outstanding_loan_amount );
                array_push($dscr_arr                         , $financialRoadmap_data_item->dscr );
                array_push($gearing_ratio_arr                , $financialRoadmap_data_item->gearing_ratio );

                array_push($turnover_arr_percent,               $financialRoadmap_data_item->turnover_percent);
                array_push($cogs_arr_percent,                   $financialRoadmap_data_item->cogs_percent);
                array_push($gross_profit_arr_percent,           $financialRoadmap_data_item->gross_profit_percent);
                array_push($general_expenses_arr_percent,       $financialRoadmap_data_item->general_expenses_percent);
                array_push($profit_bfr_tax_arr_percent,         $financialRoadmap_data_item->profit_bfr_tax_percent);
                array_push($tax_arr_percent,                    $financialRoadmap_data_item->tax_percent);
                array_push($profit_aft_tax_arr_percent,         $financialRoadmap_data_item->profit_aft_tax_percent);
                array_push($inventories_arr_percent,            $financialRoadmap_data_item->inventories_percent);
                array_push($trade_receivables_arr_percent,      $financialRoadmap_data_item->trade_receivables_percent);
                array_push($trade_payables_arr_percent,         $financialRoadmap_data_item->trade_payables_percent);
            }
        }
        else{
            //clear report's fake data
            array_splice($turnover_arr, 3,3);
            array_splice($profit_bfr_tax_arr, 3,3);
            array_splice($profit_aft_tax_arr, 3,3);

            //percent array
            $turnover_arr_percent               = array(0, 0, 0);
            $cogs_arr_percent                   = array(0, 0, 0);
            $gross_profit_arr_percent           = array(0, 0, 0);
            $general_expenses_arr_percent       = array(0, 0, 0);
            $profit_bfr_tax_arr_percent         = array(0, 0, 0);
            $tax_arr_percent                    = array(0, 0, 0);
            $profit_aft_tax_arr_percent         = array(0, 0, 0);
            $inventories_arr_percent            = array(0, 0, 0);
            $trade_receivables_arr_percent      = array(0, 0, 0);
            $trade_payables_arr_percent         = array(0, 0, 0);

            for ($i = 0; $i < 3; $i++ ){
                array_push($empty_arr,                  0);
                array_push($turnover_arr,               0);
                array_push($cogs_arr,                   0);
                array_push($depreciation_expenses_arr,  0);
                array_push($finance_cost_arr,           0);
                array_push($gross_profit_arr,           0);
                array_push($profit_bfr_tax_arr,         0);
                array_push($tax_arr,                    0);
                array_push($profit_aft_tax_arr,         0);

                array_push($inventories_arr,            0);
                array_push($trade_receivables_arr,      0);
                array_push($trade_payables_arr,         0);
                array_push($share_capital_arr,          0);
                array_push($retained_earnings_arr,      0);
                array_push($net_worth_arr,              0);

                array_push($net_cash_arr,               0);
            }
        }

        $roadmap_comprehensive_stt_arr      = array(
            'name'                  => ['Sales', 'Turnover', 'COGS / COS', 'Gross Profit', 'Expenses', 'General / Administration Expenses', 'Depreciation Expenses', 'Finance Cost', 'Profit', 'Profit Before Tax', 'Tax', 'Profit After Tax'],
            'percent_status'        => [0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 1, 1],
            'label'                 => [1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0],

            'id'                    => ['', 'rm_turnover', 'rm_cogs', 'rm_gross_profit', '', 'rm_general_expenses', 'rm_depreciation_expenses', 'rm_finance_cost', '', 'rm_profit_bfr_tax', 'rm_tax', 'rm_profit_aft_tax'],
            'data'                  => [$empty_arr, $turnover_arr, $cogs_arr, $gross_profit_arr, $empty_arr, $empty_arr,$depreciation_expenses_arr, $finance_cost_arr, $empty_arr, $profit_bfr_tax_arr, $tax_arr, $profit_aft_tax_arr],
            'percent_status_id'     => ['', 'rm_turnover_percent', 'rm_cogs_percent', 'rm_gross_profit_percent', '', 'rm_general_expenses_percent', '', '', '', 'rm_profit_bfr_tax_percent', 'rm_tax_percent', 'rm_profit_aft_tax_percent'],

            'trigger_hide_status'   => [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0],
            'hide_status'           => [0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1],

            'percent_data'          => [$empty_arr, $turnover_arr_percent, $cogs_arr_percent, $gross_profit_arr_percent, $empty_arr, $general_expenses_arr_percent, $empty_arr, $empty_arr, $empty_arr, $profit_bfr_tax_arr_percent, $tax_arr_percent, $profit_aft_tax_arr_percent],
        );

        $roadmap_financial_position_stt_arr = array(
            'name'                  => ['Inventories', 'Trade Receivables', 'Trade Payables', 'Facilities Required', 'Share Capital', 'Retained Earnings', 'Total Tangible Net Worth'],
            'percent_status'        => [1, 1, 1, 0, 0, 0, 0],

            'id'                    => ['rm_inventories', 'rm_trade_receivables', 'rm_trade_payables', 'rm_facilities_required', 'rm_share_capital', 'rm_retained_earnings', 'rm_net_worth'],
            'data'                  => [$inventories_arr, $trade_receivables_arr, $trade_payables_arr, $empty_arr, $share_capital_arr, $retained_earnings_arr, $net_worth_arr],
            'percent_status_id'     => ['rm_inventories_percent', 'rm_trade_receivables_percent', 'rm_trade_payables_percent', '', '', '', ''],

            'percent_data'          => [$inventories_arr_percent, $trade_receivables_arr_percent, $trade_payables_arr_percent, $empty_arr, $empty_arr, $empty_arr, $empty_arr],

            'highlightable'         => [0, 0, 0, 1, 0, 0, 0],
            'border_top'            => [0, 0, 0, 0, 0, 0, 1],
        );

        $roadmap_cash_flow_arr          = array(
            'name'      =>  ['Net Cash Generated From / (Used In) From Operating Activities'],
            'id'        =>  ['rm_net_cash'],
            'data'      =>  [$net_cash_arr],
        );

        $roadmap_financial_position_arr = array(
            'name'     => ['Working Capital Eligibility', 'Existing Loan', 'Projection On Additional Financing (Term Loan)', 'Projection On Additional Financing (Overdraft)',
                'Projection On Additional Financing (Trade Line)', 'Projection On Additional Financing (Property Loan)', 'Total Loan Amount (a)', 'Current Annual Repayment (Term Loan & Property Loan)',
                'Current Annual Repayment (OD & Trade)', 'New Annual Repayment (Term Loan)', 'New Annual Repayment (Overdraft)', 'New Annual Repayment (Trade Line)',
                'New Annual Repayment (Property Loan)', 'Total Annual Repayment (b)', 'EBITDA', 'Total Outstanding Loan Amount (a) - (b)',
                'Debt-Service Coverage Ratio (DSCR)', 'Gearing Ratio'
            ],

            'id'       => ['working_capital_eligibility', 'existing_loan', 'financing_term_loan', 'financing_overdraft',
                'financing_trade_line', 'financing_property_loan', 'total_loan_amount', 'repayment_term_property_loan',
                'repayment_od_trade', 'repayment_term_loan', 'repayment_overdraft', 'repayment_trade_line',
                'repayment_property_loan', 'annual_repayment', 'ebitda', 'total_outstanding_loan_amount',
                'dscr', 'gearing_ratio'],

            'data'              => [
                $working_capital_eligibility_arr  ,
                $existing_loan_arr                ,
                $financing_term_loan_arr          ,
                $financing_overdraft_arr          ,
                $financing_trade_line_arr         ,
                $financing_property_loan_arr      ,
                $total_loan_amount_arr            ,
                $repayment_term_property_loan_arr ,
                $repayment_od_trade_arr           ,
                $repayment_term_loan_arr          ,
                $repayment_overdraft_arr          ,
                $repayment_trade_line_arr         ,
                $repayment_property_loan_arr      ,
                $annual_repayment_arr             ,
                $ebitda_arr                       ,
                $total_outstanding_loan_amount_arr,
                $dscr_arr                         ,
                $gearing_ratio_arr                ,
            ],

            'highlightable'     => [1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0],
            'col_block'         => [0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1],
            'summary'           => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1],
            'top_line'          => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0],
        );

        $chart = Storage::disk('public')->get($chartImg);

        $type = 'landscape';

//        return view('admin.financialRoadmap.print.pdf',
//            compact('roadmap_comprehensive_stt_arr', 'roadmap_financial_position_stt_arr', 'roadmap_cash_flow_arr', 'roadmap_financial_position_arr',
//                'roadmap_financingInstruments', 'comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data',
//                'industry_types', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text',
//                'financial_year_arr', 'financialRoadmap', 'has_been_edit_status', 'type', 'chart')
//        );

        $pdf = SnappyPdf::loadView('admin.financialRoadmap.print.pdf',
            compact('roadmap_comprehensive_stt_arr', 'roadmap_financial_position_stt_arr', 'roadmap_cash_flow_arr', 'roadmap_financial_position_arr',
                'roadmap_financingInstruments', 'comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data',
                'industry_types', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text',
                'financial_year_arr', 'financialRoadmap', 'has_been_edit_status', 'type', 'chart')
        );

        $pdf->setPaper('a4')->setOrientation('landscape');

        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('images', true);
        $pdf->setOption('javascript-delay', 1000);
        $pdf->setOption('no-stop-slow-scripts', true);
        $pdf->setOption('enable-smart-shrinking', true);

        $fileName = $financialRoadmap->company_name.'.pdf';

//        dd($fileName);

        return $pdf->download($fileName);

//        return 'succ';

    }
}
