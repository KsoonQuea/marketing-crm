<?php

namespace App\Http\Controllers;

use App\Models\FinancialRoadmap;
use App\Models\FinancialRoadmapData;
use App\Models\FinancialRoadmapInstruments;
use App\Models\IndustryType;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class FinancialRoadmapsController extends Controller
{
    private function reformatToNumeric($input)
    {
        $nagtive = 0;
        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 2, '.', '');
        if($nagtive == 1){ $return = -$new_value; } else { $return = $new_value; }
        return $return;
    }

    public function stage1($id, $encode_code)
    {
        $first_year = date('Y') - 3;

        $industry_types                 = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $comprehensive_arr      = array(
            'name'  =>  ['Turnover', 'COGS / COS', 'Gross Profit', 'Depreciation Expenses', 'Finance Cost', 'Profit Before Tax', 'Tax', 'Profit After Tax'],
            'id'    =>  ['turnover', 'cogs', 'gross_profit', 'depreciation_expenses', 'finance_cost', 'profit_bfr_tax', 'tax', 'profit_aft_tax'],
        );

        $financial_position_arr = array(
            'name'  =>  ['Inventories', 'Trade Receivables', 'Trade Payables', 'Share Capital', 'Retained Earnings', 'Total Tangible Net Worth', 'Annual Debts'],
            'id'    =>  ['inventories', 'trade_receivables', 'trade_payables', 'share_capital', 'retained_earnings', 'net_worth', 'annual_debts']
        );

        $cash_flow_arr          = array(
            'name'  =>  ['Net Cash Generated From / (Used In) From Operating Activities'],
            'id'    =>  ['net_cash'],
        );

        if (Hash::check($id, str_replace('_', '/', $encode_code)) || Hash::check($id, $encode_code) ){
            $user_id = $id;

            return view('user.financialRoadmap.index', compact('comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'first_year', 'industry_types', 'user_id'));
        }
        else{
            return redirect()->route('admin.financial_roadmap.pending_index')->withErrors(
                ['Fail to generate the Financial Roadmap']
            );
        }
    }

    public function stage2(FinancialRoadmap $financialRoadmap, $user_id, $encode_code)
    {
        $basic_info             = FinancialRoadmap::where('id', $financialRoadmap->id)->first();

        $financialRoadmap_data  = FinancialRoadmapData::where('financial_roadmap_id', $financialRoadmap->id)->get();

        $industry_types         = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $financial_year_arr         = array();

        $turnover_arr               = array();
        $cogs_arr                   = array();
        $gross_profit_arr           = array();
        $depreciation_expenses_arr  = array();
        $finance_cost_arr           = array();
        $profit_bfr_tax_arr         = array();
        $tax_arr                    = array();
        $profit_aft_tax_arr         = array();

        $inventories_arr            = array();
        $trade_receivables_arr      = array();
        $trade_payables_arr         = array();
        $share_capital_arr          = array();
        $retained_earnings_arr      = array();
        $net_worth_arr              = array();
        $annual_debts_arr           = array();

        $net_cash_arr               = array();

        foreach ($financialRoadmap_data as $financialRoadmap_data_key => $financialRoadmap_data_item){
            if ($financialRoadmap_data_key < 3){
                array_push($financial_year_arr,         $financialRoadmap_data_item->financial_year);

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

        //chart add on the array
        for ($i = 0; $i < 3; $i++ ){
            $latest_turnover        += $latest_turnover * 20 / 100;
            $latest_profit_bfr_tax  += $latest_profit_bfr_tax * 20 / 100;
            $latest_profit_aft_tax  += $latest_profit_aft_tax * 20 / 100;
            $latest_financial_year  = $latest_financial_year + 1;

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

        if (Hash::check($user_id, str_replace('_', '/', $encode_code)) || Hash::check($user_id, $encode_code) ){
            return view('user.financialRoadmap.stage2', compact('comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data', 'industry_types', 'financial_year_arr', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text'));
        }
        else{
            return redirect()->route('admin.financial_roadmap.pending_index')->withErrors(
                ['Fail to generate the Financial Roadmap']
            );
        }
    }

    public function stage3(FinancialRoadmap $financialRoadmap)
    {
        ini_set('memory_limit', '512M');

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

        $type = 'landscape';

        return view('admin.financialRoadmap.print.pdf',
            compact('roadmap_comprehensive_stt_arr', 'roadmap_financial_position_stt_arr', 'roadmap_cash_flow_arr', 'roadmap_financial_position_arr',
                'roadmap_financingInstruments', 'comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data',
                'industry_types', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text',
                'financial_year_arr', 'financialRoadmap', 'has_been_edit_status', 'type')
        );

        $pdf = SnappyPdf::loadView('admin.financialRoadmap.print.pdf',
            compact('roadmap_comprehensive_stt_arr', 'roadmap_financial_position_stt_arr', 'roadmap_cash_flow_arr', 'roadmap_financial_position_arr',
                'roadmap_financingInstruments', 'comprehensive_arr', 'financial_position_arr', 'cash_flow_arr', 'basic_info', 'financialRoadmap_data',
                'industry_types', 'turnover_arr_text', 'profit_aft_tax_arr_text', 'profit_bfr_tax_arr_text', 'financial_year_arr_text',
                'financial_year_arr', 'financialRoadmap', 'has_been_edit_status', 'type')
        );

        $pdf->setPaper('a4')->setOrientation('landscape');

        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('images', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('no-stop-slow-scripts', true);
        $pdf->setOption('enable-smart-shrinking', true);

        return $pdf->inline('invoice.pdf');
    }

    public function store(Request $request)
    {
        $basic_data = $request->only(
            'company_name',
            'business_industry',
            'contact_person',
            'contact_number',
            'email',
            'user_id'
        );

//        dd($basic_data);

        $financial_roadmap_data =
            FinancialRoadmap::create(
                $basic_data
            );

        $financial_roadmap_id = $financial_roadmap_data->id;

        $tmp_financial_year = 0;

        for ($i = 0; $i < 6; $i++ ){
            $turnover                   = $request->get('turnover')[$i] ?? 0;
            $cogs                       = $request->get('cogs')[$i] ?? 0;
            $gross_profit               = $request->get('gross_profit')[$i] ?? 0;
            $depreciation_expenses      = $request->get('depreciation_expenses')[$i] ?? 0;
            $finance_cost               = $request->get('finance_cost')[$i] ?? 0;
            $profit_bfr_tax             = $request->get('profit_bfr_tax')[$i] ?? 0;
            $tax                        = $request->get('tax')[$i] ?? 0;
            $profit_aft_tax             = $request->get('profit_aft_tax')[$i] ?? 0;

            $inventories                = $request->get('inventories')[$i] ?? 0;
            $trade_receivables          = $request->get('trade_receivables')[$i] ?? 0;
            $trade_payables             = $request->get('trade_payables')[$i] ?? 0;
            $share_capital              = $request->get('share_capital')[$i] ?? 0;
            $retained_earnings          = $request->get('retained_earnings')[$i] ?? 0;
            $net_worth                  = $request->get('net_worth')[$i] ?? 0;
            $annual_debts               = $request->get('annual_debts')[$i] ?? 0;

            $net_cash                   = $request->get('net_cash')[$i] ?? 0;

            $financial_year             = $request->get('financial_year')[$i] ?? 0;
            $group_id                   = $i;

            if ($i < 3){
                $financial_year             = $request->get('financial_year')[$i];
                $tmp_financial_year         = $request->get('financial_year')[$i];
            }
            else{
                $financial_year             = $tmp_financial_year + 1;
                $tmp_financial_year++;
            }

            FinancialRoadmapData::create([
                'turnover'                  => $this->reformatToNumeric($turnover),
                'cogs'                      => $this->reformatToNumeric($cogs),
                'gross_profit'              => $this->reformatToNumeric($gross_profit),
                'depreciation_expenses'     => $this->reformatToNumeric($depreciation_expenses),
                'finance_cost'              => $this->reformatToNumeric($finance_cost),
                'profit_bfr_tax'            => $this->reformatToNumeric($profit_bfr_tax),
                'tax'                       => $this->reformatToNumeric($tax),
                'profit_aft_tax'            => $this->reformatToNumeric($profit_aft_tax),

                'inventories'               => $this->reformatToNumeric($inventories),
                'trade_receivables'         => $this->reformatToNumeric($trade_receivables),
                'trade_payables'            => $this->reformatToNumeric($trade_payables),
                'share_capital'             => $this->reformatToNumeric($share_capital),
                'retained_earnings'         => $this->reformatToNumeric($retained_earnings),
                'net_worth'                 => $this->reformatToNumeric($net_worth),
                'annual_debts'              => $this->reformatToNumeric($annual_debts),

                'net_cash'                  => $this->reformatToNumeric($net_cash),

                'financial_year'            => $financial_year,
                'group_id'                  => $group_id,
                'financial_roadmap_id'      => $financial_roadmap_id,
            ]);
        }

        for ($i = 0; $i < 4; $i++){
            switch ($i){
                case 0:
                    $interest_rate  = 3.83;
                    $tenor          = 7;
                    break;

                case 2:
                case 1:
                    $interest_rate  = 7;
                    $tenor          = 0.8;
                    break;

                case 3:
                    $interest_rate  = 5;
                    $tenor          = 20;
                    break;
            }

            FinancialRoadmapInstruments::create([
                'proposed_limit'        =>  0,
                'interest_rate'         =>  $interest_rate??0,
                'tenor'                 =>  $tenor??0,
                'commitments'           =>  0,
                'new_commitments'       =>  0,
                'financial_roadmap_id'  => $financial_roadmap_id,
                'group_id'              => $i,
            ]);
        }

        $encode_code = Hash::make($request->get('user_id'));

//        dd('to stage 2');

        return redirect()->route('user.stage2', [
            'financialRoadmap'  => $financial_roadmap_data,
            'user_id'           => $request->user_id,
            'encode_code'       => str_replace('/', '_', $encode_code),
        ]);
    }

    public function show(FinancialRoadmap $financialRoadmap)
    {
        //
    }

    public function edit(FinancialRoadmap $financialRoadmap)
    {
        //
    }

    public function update(Request $request, FinancialRoadmap $financialRoadmap)
    {
        //
    }

    public function destroy(FinancialRoadmap $financialRoadmap)
    {
        //
    }
}
