<?php

use App\Models\CaseBank;
use App\Models\CaseList;
use App\Models\MasterCallUserTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

if (! function_exists('checkNULL')) {
    function checkNULL($item)
    {
        return $item == '' || $item == null ? '-' : $item ;
    }
}

if (! function_exists('checkNotInt')) {
    function checkNotInt($item)
    {
        return $item == '' || $item == null ? '0' : $item ;
    }
}

if (! function_exists('reformatToNumeric')) {
    function reformatToNumeric($input)
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
}

// call logs
if (! function_exists('pendingCallCount')) {
    function pendingCallCount(){
        $query = MasterCallUserTask::with(['batch','list'])->where('user_id',Auth::user()->id)->where('status',0);
        return $query->count() ?? 0;
    }
}
if (! function_exists('allCallCount')) {
    function allCallCount(){
        $query = MasterCallUserTask::with(['batch','list'])->where('user_id',Auth::user()->id);
        return $query->count() ?? 0;
    }
}

// cases
if (! function_exists('allCaseCount')) {
    function allCaseCount()
    {
        $isSalesMan = !Gate::denies('case_personal_index_2');

        $query = CaseList::when($isSalesMan, function ($query2) {
            return $query2->whereHas('salesman.teams', function ($query) {
                $query->where('team_lead_id', Auth::user()->id);
            })->orWhere('salesman_id', Auth::user()->id);
        });
        $query->where('draft_status','!=',0); // ignore draft
        return $query->count() ?? 0;
    }
}
if (! function_exists('draftCaseCount')) {
    function draftCaseCount()
    {
        $query = CaseList::where(function ($query1) {
            $query1->where('salesman_id', Auth::user()->id)->orWhere('created_by', Auth::user()->id);
        })
            ->where('draft_status', 0);

        return $query->count() ?? 0;
    }
}

if (! function_exists('submittedCaseCount')) {
    function submittedCaseCount()
    {
        $isSalesMan = !Gate::denies('case_personal_submitted_index_2');

//        $query = CaseList::where(function ($query2) {
//            $query2->whereDoesntHave('user_case_logs', function ($query) {
//                $query->where('user_id', Auth::user()->id);
//            })->orWhereHas('user_case_logs', function ($query) {
//                $query->where('user_id', Auth::user()->id)->where('action', '!=', 1);
//            });
//        })->when($isSalesMan, function ($query2) {
//            return $query2->whereHas('salesman.teams', function ($query) {
//                $query->where('team_lead_id', Auth::user()->id);
//            });
//        })->where('case_status', 0);

        $query = CaseList::when($isSalesMan, function ($query2) {
            return $query2->whereHas('salesman.teams', function ($query) {
                $query->where('team_lead_id', Auth::user()->id);
            })->orWhere('salesman_id', Auth::user()->id);
        });

        $query->where('draft_status','!=',0)->where('case_status', 0); // ignore draft

        return $query->count() ?? 0;
    }
}
if (! function_exists('reworkCaseCount')) {
    function reworkCaseCount()
    {
        $isSalesMan = !Gate::denies('case_personal_rework_index_2');

        $query = CaseList::when($isSalesMan, function ($query2) {
            return $query2->where('case_status', 3)->where('salesman_id', Auth::user()->id);
        })->where('case_status', 3);

        return $query->count() ?? 0;
    }
}
if (! function_exists('creditCaseCount')) {
    function creditCaseCount()
    {
        $query = CaseBank::select();
        return $query->count() ?? 0;
    }
}
if (! function_exists('pendingResultCaseCount')) {
    function pendingResultCaseCount()
    {
        $query = CaseBank::where('current_status', '<', 5)->where('current_status','>', 0);
        return $query->count() ?? 0;
    }
}
if (! function_exists('pendingDisbursementCaseCount')) {
    function pendingDisbursementCaseCount()
    {
        $query = CaseBank::where('current_status', '<', 7)->where('current_status', '>=', 5);
        return $query->count() ?? 0;
    }
}



// permissions
if (! function_exists('checkCasePermissions')) {
    function checkCasePermissions($caseList)
    {
        // preset
        $permissions    = NULL;
        $isAdmin        = \Auth::user()->hasRole('Master Account');
        $isBfe          = \Auth::user()->hasRole('BFE');
        $isManager      = \Auth::user()->hasRole('Manager');
        $isCredit       = \Auth::user()->hasRole('Credit');
        $isAccount      = \Auth::user()->hasRole('Account');

        // kyc
        $kp['update'] = 0;
        if(($isBfe == true && $caseList->case_status == '3') || $isAdmin == true || $isAccount == true || $isCredit == true){ $kp['update'] = 1; }
        $permissions['kyc'] = $kp;

        // financial
        $fp['update_part_one'] = $fp['update_part_two'] = 0;
        if($isAdmin == true || $isAccount == true || $isCredit == true){ $fp['update_part_one'] = $fp['update_part_two'] = 1; }
        if($isBfe == true && $caseList->case_status == '3'){ $fp['update_part_one'] = 1; }
        if($isCredit == true || $isManager == true){ $fp['update_part_two'] = 1; }
        $permissions['financial'] = $fp;

        // bank statement
        $bsp['update'] = 0;
        if(($isBfe == true && $caseList->case_status == '3') || $isAdmin == true || $isAccount == true || $isCredit == true){ $bsp['update'] = 1; }
        $permissions['bank_statement'] = $bsp;

        // director commitment
        $dcp['update'] = 0;
        if(($isBfe == true && $caseList->case_status == '3') || $isAdmin == true || $isAccount == true || $isCredit == true){ $dcp['update'] = 1; }
        $permissions['director_commitment'] = $dcp;

        // call log
        $clp['create'] = 1;
        $permissions['call_log'] = $clp;

        // documents
        $dp['close_button'] = $dp['new_folder'] = $dp['upload'] = $dp['select'] = $dp['select_all'] = $dp['unselect_all'] = $dp['delete'] = $dp['zip_download'] = 0;
        if($isAdmin == true || $isManager == true || $isCredit == true || $isAccount == true ){ $dp['close_button'] = $dp['new_folder'] = $dp['upload'] = $dp['select'] = $dp['select_all'] = $dp['unselect_all'] = $dp['delete'] = $dp['zip_download'] = 1; }
        if($isBfe == true && $caseList->case_status == '3'){ $dp['close_button'] = $dp['new_folder'] = $dp['upload'] = $dp['select'] = $dp['select_all'] = $dp['unselect_all'] = $dp['delete'] = $dp['zip_download'] = 1; }
        $permissions['document'] = $dp;

        // memo
        $mp['create'] = 0;
        if($isManager == true || $isCredit == true || $isAdmin == true || $isAccount == true){ $mp['create'] = 1; }
        $permissions['memo'] = $mp;

        // case status summary
        $cssp['update'] = $cssp['actions'] = 0;
        if($isAdmin == true || $isManager == true || $isCredit == true){ $cssp['update'] = $cssp['actions'] = 1; }
        $permissions['case_status_summary'] = $cssp;

        // Pulse Check Report
        $pcrp['update'] = 0;
        if($isBfe == true || $isAdmin == true || $isAccount == true || $isCredit == true){ $pcrp['update'] = 1; }
        $permissions['pulse_check_report'] = $pcrp;

        // return data of permissions
        return $permissions;
    }
}
if (! function_exists('checkCaseDocumentPermissions')) {
    function checkCaseDocumentPermissions($caseList)
    {
        $permissions_document = 0;
        $isAdmin = \Auth::user()->hasRole('Master Account');
        $isBfe = \Auth::user()->hasRole('BFE');
        $isManager = \Auth::user()->hasRole('Manager');
        $isCredit = \Auth::user()->hasRole('Credit');
        $isAccount = \Auth::user()->hasRole('Account');
        if($isAdmin == true || $isManager == true || $isCredit == true || $isAccount == true){
            $permissions_document = 1;
        } elseif($isCredit == true && $caseList->case_status == '3'){
            $permissions_document = 1;
        }
        return $permissions_document;
    }
}

if (! function_exists('oriNotiFunc')) {
    function oriNotiFunc()
    {
        $status = 'New Pending Case - ';

        if (isset($notification->data['case_type'])){
            switch ($notification->data['case_type']){
                case 0:
                    $status = 'New Pending Case - ';
                    break;
                case 1:
                    $status = 'New Approved Case - ';
                    break;
                case 2:
                    $status = 'New Rejected Case - ';
                    break;
                case 3:
                    $status = 'New Reworked Case - ';
                    break;
                case 4:
                    $status = 'New Closed Case - ';
                    break;
            };
        }

        return $status;
    }
}

// convertNumberToWord
if (! function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        if(! $num) {
            return false;
        }
//        $new_num1 = sprintf('%0.2f', $num);
        $new_num = reformatToNumeric($num);
        $new_num = (double)$new_num;
        $decones = array(
            '00' => "",
            '01' => "One",
            '02' => "Two",
            '03' => "Three",
            '04' => "Four",
            '05' => "Five",
            '06' => "Six",
            '07' => "Seven",
            '08' => "Eight",
            '09' => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $ones = array(
            0 => " ",
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Eleven",
            12 => "Twelve",
            13 => "Thirteen",
            14 => "Fourteen",
            15 => "Fifteen",
            16 => "Sixteen",
            17 => "Seventeen",
            18 => "Eighteen",
            19 => "Nineteen"
        );
        $tens = array(
            0 => "",
            1 => "",
            2 => "Twenty",
            3 => "Thirty",
            4 => "Forty",
            5 => "Fifty",
            6 => "Sixty",
            7 => "Seventy",
            8 => "Eighty",
            9 => "Ninety"
        );
        $hundreds = array(
            "Hundred",
            "Thousand",
            "Million",
            "Billion",
            "Trillion",
            "Quadrillion"
        ); //limit t quadrillion
        $new_num = number_format($new_num,2,".",",");
        $num_arr = explode(".",$new_num);
        $wholenum = $num_arr[0];
        $decnum = $num_arr[1];
        $whole_arr = array_reverse(explode(",",$wholenum));
        krsort($whole_arr);

        $rettxt = "";
        foreach($whole_arr as $key => $i){
            $int_i = (int)$i;
            $string_i = (string)$int_i;
            if($int_i < 20){
                $rettxt .= $ones[$string_i];
            }
            elseif($int_i < 100){
                $rettxt .= $tens[substr($string_i,0,1)];
                $rettxt .= " ".$ones[substr($string_i,1,1)];
            }
            else{
                $rettxt .= $ones[substr($string_i,0,1)]." ".$hundreds[0];

                if(substr($string_i,1,2) < 20){
                    $rettxt .= " ".$decones[substr($string_i,1,2)];
                }
                else{
                    $rettxt .= " ".$tens[substr($string_i,1,1)];
                    $rettxt .= " ".$ones[substr($string_i,2,1)];
                }
            }
            if($key > 0){
                $rettxt .= " ".$hundreds[$key]." ";
            }

        }
        $rettxt = $rettxt;

        if($decnum > 0){
            $rettxt .= " and ";
            if($decnum < 20){
                $rettxt .= $decones[$decnum];
            }
            elseif($decnum < 100){
                $rettxt .= $tens[substr($decnum,0,1)];
                $rettxt .= " ".$ones[substr($decnum,1,1)];
            }
            $rettxt = $rettxt." cents";
        }
        return $rettxt;
//        return implode('|', $whole_arr);
//        return sizeof($whole_arr);
    }
}

// money number format
if (! function_exists('money_num_format')) {
    function money_num_format($num = '', $type = 0)
    {
        /*
         * 0 : none,
         * 1 : RM
         * */

        switch ($type){
            case 1 :
                $new_num = 'RM '.number_format($num, 2, '.', ',');
                break;

            default:
                $new_num = number_format($num, 2, '.', ',');
                break;
        }

        return $new_num;
    }
}

if (! function_exists('year_month_setting')){
    function year_month_setting(){
        $object = (object)array(
            'this_year'  => date('Y'),
            'this_month' => date('m'),
            'start_year' => 2022,
        );

        return $object;
    }
}

//month on sorting
if (! function_exists('month_collection')) {
    function month_collection()
    {
        $month =[
            (object)[
                'month'         => 1,
                'full_name'     => 'January',
                'short_name'    => 'Jan',
            ], (object)[
                'month'         => 2,
                'full_name'     => 'February',
                'short_name'    => 'Feb',
            ],(object)[
                'month'         => 3,
                'full_name'     => 'March',
                'short_name'    => 'Mar',
            ],(object)[
                'month'         => 4,
                'full_name'     => 'April',
                'short_name'    => 'Apr',
            ],(object)[
                'month'         => 5,
                'full_name'     => 'May',
                'short_name'    => 'May',
            ],(object)[
                'month'         => 6,
                'full_name'     => 'June',
                'short_name'    => 'Jun',
            ],(object)[
                'month'         => 7,
                'full_name'     => 'July',
                'short_name'    => 'Jul',
            ],(object)[
                'month'         => 8,
                'full_name'     => 'August',
                'short_name'    => 'Aug',
            ],(object)[
                'month'         => 9,
                'full_name'     => 'September',
                'short_name'    => 'Sep',
            ],(object)[
                'month'         => 10,
                'full_name'     => 'October',
                'short_name'    => 'Oct',
            ],(object)[
                'month'         => 11,
                'full_name'     => 'November',
                'short_name'    => 'Nov',
            ],(object)[
                'month'         => 12,
                'full_name'     => 'December',
                'short_name'    => 'Dec',
            ],
        ];

        return $month;
    }
}

if (! function_exists('preset_num_decimal_format')) {
    function preset_num_decimal_format($value, $brackets = 0)
    {
        if ($value == 0 || $value == null){
            return 0;
        }
        else{
            if ($value < 0 && $brackets == 1){
                $content = '('.number_format(abs($value), 2, '.', ',').')';
            }
            else{
                $content = number_format($value, 2, '.', ',');
            }

            return $content;
        }
    }
}

if (! function_exists('db_date_format')) {
    function db_date_format($value)
    {
        $db_date = date('Y-m-d', strtotime($value));

        return $db_date;
    }
}

if (! function_exists('report_date_format')) {
    function report_date_format($value)
    {
        $date = date('d-m-y', strtotime($value));

        return $date;
    }
}
