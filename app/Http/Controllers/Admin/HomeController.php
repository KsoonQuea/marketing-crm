<?php

namespace App\Http\Controllers\Admin;

use App\Models\CaseBank;
use App\Models\CaseDisburse;
use App\Models\CaseList;
use App\Models\MasterCallList;
use App\Models\MasterCallUserTask;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class HomeController
{
    // preset
    private $annual_kpi_total           = 100000000;
    private $monthly_kpi_total          = 60000;
    private $credit_monthly_kpi_total   = 15000000;

    public function index()
    {
        $this_user                  = auth()->user();
        $my_id                      = $this_user->id;
        $this_year                  = date("Y");
        $this_month                 = date('m');
        $date                       = new \Carbon\Carbon(date("Y-m-d"));
        $firstOfQuarter             = $date->firstOfQuarter();
        $start_quarter              = date("Y-m-d",strtotime($firstOfQuarter));
        $lastOfQuarter              = $date->lastOfQuarter();
        $end_quarter                = date("Y-m-d",strtotime($lastOfQuarter));
        $annual_kpi_total           = $this->annual_kpi_total;
        $monthly_kpi_total          = $this->monthly_kpi_total;
        $quarter_kpi_total          = $this->monthly_kpi_total * 3;
        $credit_monthly_kpi_total   = $this->credit_monthly_kpi_total;
        $data                       = [];

        $salesman_leader            = 0;

        // dd("BBB");

        // team
        if (!Gate::denies('dashboard_team_index_2') == true){
            $teams      = Team::all();
            $this_team  = Team::all()->first();
            if($this_team !== NULL){
                $salesman_leader            = 1;
                $team_member_count  = $this_team->users()->count();
                $team_ids           = $this_team->users()->pluck('id')->toArray();
                array_push($team_ids,$my_id);
                $team_member_count += 1;
            }
        }
        else{
            $teams      = Team::where('team_lead_id',$my_id)->get();
            $this_team  = Team::where('team_lead_id',$my_id)->first();


            $checkteam = $this_team;
            if($checkteam) {

                $salesman_leader    = 1;

                $team_member_count  = $checkteam->users()->count();
                $team_ids           = $checkteam->users()->pluck('id')->toArray();

                array_push($team_ids,$my_id);
                $team_member_count += 1;
            }
        }

        // to do list
        if (!Gate::denies('dashboard_all_mtd_case_index_2') == true){
            $data['data_cards']['mtd_case_submission'] = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at', $this_month)->where('case_status',0)->where('draft_status',1)->count();
        }
        elseif (!Gate::denies('dashboard_personal_mtd_case_index_2') == true){
            $data['data_cards']['mtd_case_submission'] = CaseList::where('salesman_id',$my_id)
                ->whereYear('created_at', $this_year)
                ->whereMonth('created_at', $this_month)
                ->where('case_status',0)
                ->where('draft_status',1)
                ->count();
        }
        else{
            $data['data_cards']['mtd_case_submission'] = 0;
        }

        if (!Gate::denies('dashboard_all_pending_assessment_index_2') == true){
            $data['data_cards']['pending_assessment'] = CaseList::where('case_status',0)->where('draft_status',1)->count();
        }
        elseif (!Gate::denies('dashboard_personal_pending_assessment_index_2') == true){
            $data['data_cards']['pending_assessment'] = CaseList::where('salesman_id',$my_id)->where('case_status',0)->where('draft_status',1)->count();
        }
        else{
            $data['data_cards']['pending_assessment'] = 0;
        }

        if (!Gate::denies('dashboard_all_pending_offer_index_2') == true){
            $data['data_cards']['pending_offer'] = CaseBank::where('current_status','=', 0)->count();
        }
        elseif (!Gate::denies('dashboard_personal_pending_offer_index_2') == true){
            $data['data_cards']['pending_offer'] = $data['data_cards']['pending_approval'] = CaseBank::with('case')->whereHas('case', function ($query) use ($my_id){
                $query->where('salesman_id', $my_id);
            })->where('current_status','=', 0)->count();
        }
        else{
            $data['data_cards']['pending_offer'] = 0;
        }

        if (!Gate::denies('dashboard_all_rework_case_index_2') == true){
            $data['data_cards']['rework_cases'] = CaseList::where('case_status',3)->count();
        }
        elseif (!Gate::denies('dashboard_personal_rework_case_index_2') == true){
            $data['data_cards']['rework_cases'] = CaseList::where('salesman_id',$my_id)->where('case_status',3)->count();
        }
        else{
            $data['data_cards']['rework_cases'] = 0;
        }

        if (!Gate::denies('dashboard_all_pending_approval_index_2') == true){
            $data['data_cards']['pending_approval'] = CaseBank::where('current_status', '<', 5)->where('current_status','>', 0)->count();
        }
        elseif (!Gate::denies('dashboard_personal_pending_approval_index_2') == true){
            $data['data_cards']['pending_approval'] = CaseBank::with('case')->whereHas('case', function ($query) use ($my_id){
                $query->where('salesman_id', $my_id);
            })->where('current_status', '<', 5)->where('current_status','>', 0)->count();
        }
        else{
            $data['data_cards']['pending_approval'] = 0;
        }

        if (!Gate::denies('dashboard_all_pending_disbursement_index_2') == true){
            $data['data_cards']['pending_disbursement'] = CaseBank::where('current_status', '<', 7)->where('current_status', '>=', 5)->count();
        }
        elseif (!Gate::denies('dashboard_personal_pending_disbursement_index_2') == true){
            $data['data_cards']['pending_disbursement'] = CaseBank::with('case')->whereHas('case', function ($query) use ($my_id){
                $query->where('salesman_id', $my_id);
            })->where('current_status', '<', 7)->where('current_status', '>=', 5)->count();
        }
        else{
            $data['data_cards']['pending_disbursement'] = 0;
        }

        // achievements
        if (!Gate::denies('dashboard_all_year_kpi_index_2') == true){
            $approved           = CaseList::whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['year_kpi'] = [
                'total'     => $annual_kpi_total,
                'type'      => 0,
                'approved'  => $approved,
                'balance'   => $annual_kpi_total-$approved,
                'percent'   => $annual_kpi_total != 0 ? ($approved/$annual_kpi_total) * 100 : 0,
            ];
        }
        elseif (!Gate::denies('dashboard_personal_year_kpi_index_2') == true){
            $approved           = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['year_kpi'] = [
                'total'     => $annual_kpi_total,
                'type'      => 1,
                'approved'  => $approved,
                'balance'   => $annual_kpi_total-$approved,
                'percent'   => $annual_kpi_total != 0 ? ($approved/$annual_kpi_total) * 100 : 0,
            ];
        }
        else{
            $approved = CaseList::whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['year_kpi'] = [
                'total'     => $annual_kpi_total,
                'type'      => 0,
                'approved'  => $approved,
                'balance'   => $annual_kpi_total-$approved,
                'percent'   => $annual_kpi_total != 0 ? ($approved/$annual_kpi_total) * 100 : 0,
            ];
        }

        if (!Gate::denies('dashboard_all_monthly_kpi_index_2') == true){
            $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['monthly_kpi'] = [
                'total'     => $monthly_kpi_total,
                'type'      => 0,
                'approved'  => $monthly_kpi_approved,
                'balance'   => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                'percent'   => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
            ];
        }
        elseif (!Gate::denies('dashboard_personal_monthly_kpi_index_2') == true){
            $monthly_kpi_approved = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['monthly_kpi'] = [
                'total' => $monthly_kpi_total,
                'type'      => 1,
                'approved' => $monthly_kpi_approved,
                'balance' => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                'percent' => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
            ];
        }
        else{
            $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['monthly_kpi'] = [
                'total' => $monthly_kpi_total,
                'type'      => 0,
                'approved' => $monthly_kpi_approved,
                'balance' => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                'percent' => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
            ];

            $salesman_leader = 0;
        }

        if (!Gate::denies('dashboard_all_quarterly_kpi_index_2') == true){
//            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['quarterly_kpi']= [
                'total' => $quarter_kpi_total,
                'type'      => 0,
                'approved' => $quarter_kpi_approved,
                'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                'percent' => $quarter_kpi_approved > $quarter_kpi_total ? 100 : ( $quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0),
            ];
        }
        elseif (!Gate::denies('dashboard_personal_quarterly_kpi_index_2') == true){
//            $quarter_kpi_approved   = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
            $quarter_kpi_approved   = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('case_status', '!=', '5')->where('draft_status',1)->sum('approved_amount');

            $data['achievement']['quarterly_kpi'] = [
                'total'     => $quarter_kpi_total,
                'type'      => 1,
                'approved'  => $quarter_kpi_approved,
                'balance'   => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                'percent'   => (($quarter_kpi_approved > $quarter_kpi_total) ? 100 : ($quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0)),
            ];
        }
        else{
//            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

            $data['achievement']['quarterly_kpi']= [
                'total' => $quarter_kpi_total,
                'type'      => 0,
                'approved' => $quarter_kpi_approved,
                'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                'percent' => $quarter_kpi_approved > $quarter_kpi_total ? 100 : ( $quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0),
            ];

            $salesman_leader = 0;

        }

        if (!Gate::denies('dashboard_all_ytd_chart_one_index_2') == true){
            $ytd_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs1'] = [
                'first' => $ytd_service_fee,  // YTD KPI
                'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                'type'      => 0,
            ];

        }
        elseif (!Gate::denies('dashboard_personal_ytd_chart_two_index_2') == true){
            $ytd_service_fee = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs1'] = [
                'first' => $ytd_service_fee,  // YTD KPI
                'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                'type'      => 1,
            ];

        }
        else{
            $ytd_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs1'] = [
                'first' => $ytd_service_fee,  // YTD KPI
                'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                'type'      => 0,
            ];

            $salesman_leader = 0;
        }

        if (!Gate::denies('dashboard_all_ytd_chart_two_index_2') == true){
            $ytd_collected_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs2'] = [
                'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                'type'      => 0,
            ];
        }
        elseif (!Gate::denies('dashboard_personal_ytd_chart_two_index_2') == true){
            $ytd_collected_service_fee = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs2'] = [
                'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                'type'      => 1,
            ];
        }
        else{
            $ytd_collected_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

            $data['achievement']['vs2'] = [
                'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                'type'      => 0,
            ];

            $salesman_leader = 0;
        }

        if (!Gate::denies('dashboard_all_ytd_total_customer_index_2') == true){
            $customer_onboard = CaseList::whereYear('created_at',$this_year)->where('case_status', '!=', '5')->count();

            $data['achievement']['customer_onboard'] = $customer_onboard;
            $data['achievement']['customer_onboard_type'] = 0;
        }
        elseif (!Gate::denies('dashboard_personal_ytd_total_customer_index_2') == true){
            $customer_onboard = CaseList::where('salesman_id',$my_id)->where('case_status', '!=', '5')->whereYear('created_at',$this_year)->count();

            $data['achievement']['customer_onboard'] = $customer_onboard;
            $data['achievement']['customer_onboard_type'] = 1;
        }
        else{
            $customer_onboard = CaseList::whereYear('created_at',$this_year)->where('case_status', '!=', '5')->count();

            $data['achievement']['customer_onboard'] = $customer_onboard;
            $data['achievement']['customer_onboard_type'] = 1;

            $salesman_leader = 0;
        }

        // latest cases
        if (!Gate::denies('dashboard_all_latest_case_index_2') == true){
            $CaseList = CaseList::where('draft_status', '1')->whereNotNull('created_at')->take(4)->orderBy('created_at', 'desc')->get();
        }
        elseif (!Gate::denies('dashboard_personal_latest_case_index_2') == true){
            $CaseList = CaseList::where('draft_status', '1')->where('salesman_id',$my_id)->whereNotNull('created_at')->take(4)->orderBy('created_at', 'desc')->get();
        }
        else{
            $CaseList = CaseList::where('draft_status', '1')->whereNotNull('created_at')->take(4)->orderBy('created_at', 'desc')->get();
        }


        // call logs
        if (!Gate::denies('dashboard_all_call_log_index_2') == true){
            $MasterCaseLists    = MasterCallList::select()->orderBy('created_at','ASC')->get()->take(6);
            $achievement_size   = 'col-9';
        }
        elseif (!Gate::denies('dashboard_personal_call_log_index_2') == true){
            $list_ids = MasterCallUserTask::where('user_id',$my_id)->where('response_status',1)->get()->pluck('master_call_list_id')->toArray();
            $MasterCaseLists = MasterCallList::whereIn('id',$list_ids)->orderBy('created_at','ASC')->get()->take(6);
            $achievement_size   = 'col-9';
        }
        else{
            $MasterCaseLists = MasterCallList::select()->orderBy('created_at','ASC')->get()->take(6);
            $achievement_size   = 'col-12';
        }

//        dd($data);

        // return view
        return view('admin.home',compact(
            'data',
            'salesman_leader',
            'achievement_size',
            'MasterCaseLists',
            'CaseList',
            'teams',
            'this_team',
        ));
    }

    public function ajax_dashboard_kpi(Request $request)
    {
        // preset
        $my_id = auth()->user()->id;
        $this_year = date("Y");
        $this_month = date('m');
        $date = new \Carbon\Carbon(date("Y-m-d"));
        $firstOfQuarter = $date->firstOfQuarter();
        $start_quarter = date("Y-m-d",strtotime($firstOfQuarter));
        $lastOfQuarter = $date->lastOfQuarter();
        $end_quarter = date("Y-m-d",strtotime($lastOfQuarter));
        $monthly_kpi_total = $this->monthly_kpi_total;

        // start find KPI
        $team_id = $request->id;
        $team = Team::find($team_id);

        if($team){
            $team_member_count = $team->users()->count();
            $team_ids = $team->users()->pluck('id')->toArray();
            array_push($team_ids,$my_id);
            $team_member_count += 1;

            $monthly_kpi_total_team     = $monthly_kpi_total*$team_member_count;// redeclare

            $monthly_kpi_approved       = 0;
            $quarter_kpi_approved       = 0;
            $quarter_kpi_total          = $monthly_kpi_total*3*$team_member_count;
            $ytd_service_fee            = 0;
            $ytd_collected_service_fee  = 0;
            $customer_onboard           = 0;

            foreach ($team_ids as $member_id){
                $monthly_kpi_approved       += CaseList::where('salesman_id',$member_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');
                $quarter_kpi_approved       += CaseList::where('salesman_id',$member_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('case_status', '!=', '5')->where('draft_status',1)->sum('approved_amount');
                $ytd_service_fee            += CaseList::where('salesman_id',$member_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');
                $ytd_collected_service_fee  += CaseList::where('salesman_id',$member_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');
                $customer_onboard           += CaseList::where('salesman_id',$member_id)->where('case_status', '!=', '5')->whereYear('created_at',$this_year)->whereNotNull('agreement_sign_date')->count();
            }

            $team_display['achievement'] = [
                'monthly_kpi' => [
                    'total' => $monthly_kpi_total_team,
                    'approved' => $monthly_kpi_approved,
                    'balance' => (($monthly_kpi_approved > $monthly_kpi_total_team) ? 0 : ($monthly_kpi_total_team-$monthly_kpi_approved)),
                    'percent' => (($monthly_kpi_approved > $monthly_kpi_total_team) ? 100 : ($monthly_kpi_approved/$monthly_kpi_total_team*100)),
                ],
                'quarterly_kpi' => [
                    'total' => $quarter_kpi_total,
                    'approved' => $quarter_kpi_approved,
                    'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                    'percent' => (($quarter_kpi_approved > $quarter_kpi_total) ? 100 : ($quarter_kpi_approved/$quarter_kpi_total*100)),
                ],
                'vs1' => [
                    'first' => $ytd_service_fee,  // YTD KPI
                    'second' => ($monthly_kpi_total_team*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                ],
                'vs2' => [
                    'first' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                    'second' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                ],
                'customer_onboard' => $customer_onboard,
            ];
        }
        else
        {
            // elements (personal)
//            $monthly_kpi_approved       = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
//            $quarter_kpi_total          = $monthly_kpi_total*3;
//            $quarter_kpi_approved       = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
//            $ytd_service_fee            = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->sum('service_fee_amount');
//            $ytd_collected_service_fee  = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->sum('service_fee_amount');
//            $team_display = [
//                'monthly_kpi' => [
//                    'total' => $monthly_kpi_total,
//                    'approved' => $monthly_kpi_approved,
//                    'balance' => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
//                    'percent' => (($monthly_kpi_approved > $monthly_kpi_total) ? 100 : ($monthly_kpi_approved/$monthly_kpi_total*100)),
//                ],
//                'quarterly_kpi' => [
//                    'total' => $quarter_kpi_total,
//                    'approved' => $quarter_kpi_approved,
//                    'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
//                    'percent' => (($quarter_kpi_approved > $quarter_kpi_total) ? 100 : ($quarter_kpi_approved/$quarter_kpi_total*100)),
//                ],
//                'vs1' => [
//                    'first' => $ytd_service_fee,  // YTD KPI
//                    'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
//                ],
//                'vs2' => [
//                    'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
//                    'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
//                ],
//                'customer_onboard' => CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->count(),
//            ];

            if (!Gate::denies('dashboard_all_monthly_kpi_index_2') == true){
//            $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

                $team_display['achievement']['monthly_kpi'] = [
                    'total'     => $monthly_kpi_total,
                    'type'      => 0,
                    'approved'  => $monthly_kpi_approved,
                    'balance'   => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                    'percent'   => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
                ];
            }
            elseif (!Gate::denies('dashboard_personal_monthly_kpi_index_2') == true){
//            $monthly_kpi_approved = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $monthly_kpi_approved = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

                $team_display['achievement']['monthly_kpi'] = [
                    'total' => $monthly_kpi_total,
                    'type'      => 1,
                    'approved' => $monthly_kpi_approved,
                    'balance' => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                    'percent' => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
                ];
            }
            else{
//            $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $monthly_kpi_approved = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');

                $team_display['achievement']['monthly_kpi'] = [
                    'total' => $monthly_kpi_total,
                    'type'      => 0,
                    'approved' => $monthly_kpi_approved,
                    'balance' => (($monthly_kpi_approved > $monthly_kpi_total) ? 0 : ($monthly_kpi_total-$monthly_kpi_approved)),
                    'percent' => $monthly_kpi_approved > $monthly_kpi_total ? 100 :  ($monthly_kpi_total != 0 ? ($monthly_kpi_approved/$monthly_kpi_total*100) : 0),
                ];

                $salesman_leader = 0;
            }

            if (!Gate::denies('dashboard_all_quarterly_kpi_index_2') == true){
//            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');
                $quarter_kpi_total          = $monthly_kpi_total*3;


                $team_display['achievement']['quarterly_kpi']= [
                    'total' => $quarter_kpi_total,
                    'type'      => 0,
                    'approved' => $quarter_kpi_approved,
                    'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                    'percent' => $quarter_kpi_approved > $quarter_kpi_total ? 100 : ( $quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0),
                ];
            }
            elseif (!Gate::denies('dashboard_personal_quarterly_kpi_index_2') == true){
//            $quarter_kpi_approved   = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $quarter_kpi_approved   = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('case_status', '!=', '5')->where('draft_status',1)->sum('approved_amount');
                $quarter_kpi_total          = $monthly_kpi_total*3;

                $team_display['achievement']['quarterly_kpi'] = [
                    'total'     => $quarter_kpi_total,
                    'type'      => 1,
                    'approved'  => $quarter_kpi_approved,
                    'balance'   => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                    'percent'   => (($quarter_kpi_approved > $quarter_kpi_total) ? 100 : ($quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0)),
                ];
            }
            else{
//            $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->sum('service_fee_amount');
                $quarter_kpi_approved   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->where('case_status', '!=', '5')->sum('approved_amount');
                $quarter_kpi_total          = $monthly_kpi_total*3;

                $team_display['achievement']['quarterly_kpi']= [
                    'total' => $quarter_kpi_total,
                    'type'      => 0,
                    'approved' => $quarter_kpi_approved,
                    'balance' => (($quarter_kpi_approved > $quarter_kpi_total) ? 0 : ($quarter_kpi_total-$quarter_kpi_approved)),
                    'percent' => $quarter_kpi_approved > $quarter_kpi_total ? 100 : ( $quarter_kpi_total != 0 ? ($quarter_kpi_approved/$quarter_kpi_total*100) : 0),
                ];

                $salesman_leader = 0;

            }

            if (!Gate::denies('dashboard_all_ytd_chart_one_index_2') == true){
                $ytd_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs1'] = [
                    'first' => $ytd_service_fee,  // YTD KPI
                    'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                    'type'      => 0,
                ];

            }
            elseif (!Gate::denies('dashboard_personal_ytd_chart_two_index_2') == true){
                $ytd_service_fee = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs1'] = [
                    'first' => $ytd_service_fee,  // YTD KPI
                    'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                    'type'      => 1,
                ];

            }
            else{
                $ytd_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs1'] = [
                    'first' => $ytd_service_fee,  // YTD KPI
                    'second' => ($monthly_kpi_total*$this_month)-$ytd_service_fee, // YTD Service Fee Charged (left)
                    'type'      => 0,
                ];

                $salesman_leader = 0;
            }

            if (!Gate::denies('dashboard_all_ytd_chart_two_index_2') == true){
                $ytd_collected_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs2'] = [
                    'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                    'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                    'type'      => 0,
                ];
            }
            elseif (!Gate::denies('dashboard_personal_ytd_chart_two_index_2') == true){
                $ytd_collected_service_fee = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs2'] = [
                    'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                    'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                    'type'      => 1,
                ];
            }
            else{
                $ytd_collected_service_fee = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->where('case_status', '!=', '5')->sum('service_fee_amount');

                $team_display['achievement']['vs2'] = [
                    'first' => $ytd_service_fee-$ytd_collected_service_fee, // YTD Service Fee Charged (left)
                    'second' => $ytd_collected_service_fee, // YTD Collected Service Fee Charged
                    'type'      => 0,
                ];

                $salesman_leader = 0;
            }

            if (!Gate::denies('dashboard_all_ytd_total_customer_index_2') == true){
                $customer_onboard = CaseList::whereYear('created_at',$this_year)->where('case_status', '!=', '5')->where('draft_status', '1')
                    ->whereNotNull('agreement_sign_date')->count();

                $team_display['achievement']['customer_onboard'] = $customer_onboard;
                $team_display['achievement']['customer_onboard_type'] = 0;
            }
            elseif (!Gate::denies('dashboard_personal_ytd_total_customer_index_2') == true){
                $customer_onboard = CaseList::where('salesman_id',$my_id)->where('case_status', '!=', '5')->whereYear('created_at',$this_year)->where('draft_status', '1')
                    ->whereNotNull('agreement_sign_date')->count();

                $team_display['achievement']['customer_onboard'] = $customer_onboard;
                $team_display['achievement']['customer_onboard_type'] = 1;
            }
            else{
                $customer_onboard = CaseList::whereYear('created_at',$this_year)->where('case_status', '!=', '5')->where('draft_status', '1')
                    ->whereNotNull('agreement_sign_date')->count();

                $team_display['achievement']['customer_onboard'] = $customer_onboard;
                $team_display['achievement']['customer_onboard_type'] = 1;

                $salesman_leader = 0;
            }

//            dd($team_display);
        }

        return $team_display;
    }

    //View More Part
    public function view_more_details(Request $request){
        $type   = $request->type;
        $category    = $request->category;

        /* type
         * 0, all
         * 1, personal
         * 2, team
         * */

        /* category
         * 0, yearly - all
         * 1, monthly - all
         * 2, quarterly - all
         * 3, ytd chart 1 - all
         * 4, ytd chart 2 - all
         * 5, total customer onboard - all
         * */

        $this_user                  = auth()->user();
        $my_id                      = $this_user->id;
        $this_year                  = date("Y");
        $this_month                 = date('m');
        $date                       = new \Carbon\Carbon(date("Y-m-d"));
        $firstOfQuarter             = $date->firstOfQuarter();
        $start_quarter              = date("Y-m-d",strtotime($firstOfQuarter));
        $lastOfQuarter              = $date->lastOfQuarter();
        $end_quarter                = date("Y-m-d",strtotime($lastOfQuarter));

        // team part
        if ($type == 2){
            $this_team  = Team::all()->first();
            $team_ids   = $this_team->users()->pluck('id')->toArray();
            array_push($team_ids,$my_id);
        }

        $title = '';

        switch ($category){
            case 0:
                $title = 'Yearly KPI';

                if ($type == 0){
                    $query           = CaseList::whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                elseif ($type == 1){
                    $query           = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                else{
                    $query           = CaseList::whereYear('created_at',$this_year)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
            break;

            case 1:
                $title = 'Monthly KPI';

                if ($type == 0){
                    $query       = CaseList::whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                elseif ($type == 1){
                    $query       = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                else{
                    $query       = CaseList::whereIn('salesman_id',$team_ids)->whereYear('created_at',$this_year)->whereMonth('created_at',$this_month)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
            break;

            case 2:
                $title = 'Quarterly KPI';

                if ($type == 0){
                    $query   = CaseList::whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                elseif ($type == 1){
                    $query   = CaseList::where('salesman_id',$my_id)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
                else{
                    $query   = CaseList::whereIn('salesman_id',$team_ids)->whereDate('created_at','>=',$start_quarter)->whereDate('created_at','<=',$end_quarter)->where('platform_status','>',4)->where('draft_status',1)->get();
                }
            break;

            case 3:
                $title = 'YTD Service Fee Charged vs. YTD KPI';

                if ($type == 0){
                    $query = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->get();
                }
                elseif ($type == 1){
                    $query = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->get();
                }
                else{
                    $query = CaseList::whereIn('salesman_id',$team_ids)->whereYear('created_at',$this_year)->where('draft_status',1)->get();
                }
            break;

            case 4:
                $title = 'YTD Service Fee Charged vs. YTD Collected Service Fee';

                if ($type == 0){
                    $query = CaseList::whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->get();
                }
                elseif ($type == 1){
                    $query = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->get();
                }
                else{
                    $query = CaseList::whereIn('salesman_id',$team_ids)->whereYear('created_at',$this_year)->where('draft_status',1)->where('platform_status',7)->get();
                }
            break;

            case 5:
                $title = 'YTD Total Customer Onboarded';

                if ($type == 0){
                    $query = CaseList::whereYear('created_at',$this_year)->get();
                }
                elseif ($type == 1){
                    $query = CaseList::where('salesman_id',$my_id)->whereYear('created_at',$this_year)->get();
                }
                else{
                    $query = CaseList::whereIn('salesman_id',$team_ids)->whereYear('created_at',$this_year)->get();
                }
            break;
        }

        if ($request->ajax()) {
            $table = Datatables::of($query);

            $table->editColumn('case_code', function ($row) {
                $url = route('admin.case-lists.show',$row->id);
                $link = '<a href="'.$url.'">'.($row->case_code ?? '-').'</a>';
                return $link;
            });
            $table->editColumn('company_name', function ($row) {
                return $row->company_name;
            });
            $table->editColumn('approved_amount', function ($row) {
                return '<b>RM </b>'.$row->approved_amount;
            });
            $table->editColumn('service_fee_amount', function ($row) {
                return '<b>RM </b>'.$row->service_fee_amount;
            });
            $table->editColumn('created_at', function ($row){
                return $row->created_at;
            });
            $table->rawColumns(['case_code','approved_amount', 'service_fee_amount', 'created_at']);
            return $table->make(true);
        }

        return view('admin.homeDetails.index', compact('type', 'category', 'title'));


    }

}
