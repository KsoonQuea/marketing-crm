<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Views\CaseController;
use App\Models\ApplicationType;
use App\Models\Bank;
use App\Models\BankOfficer;
use App\Models\BankStatement;
use App\Models\BankStatus;
use App\Models\CaseBank;
use App\Models\CaseBankStatus;
use App\Models\CaseCommitment;
use App\Models\CaseCreditCheck;
use App\Models\CaseCreditCheckType;
use App\Models\CaseCriterion;
use App\Models\CaseDirectorCommitment;
use App\Models\CaseDisburse;
use App\Models\CaseDisburseDetails;
use App\Models\CaseFinancial;
use App\Models\CaseFinancingInstrument;
use App\Models\CaseGearingView;
use App\Models\CaseList;
use App\Models\CaseManagementTeam;
use App\Models\CaseOverridings;
use App\Models\CaseReportRecommendation;
use App\Models\CaseRequest;
use App\Models\CashFlowView;
use App\Models\commissionSettings;
use App\Models\creditReport;
use App\Models\Director;
use App\Models\dsrView;
use App\Models\EditedApprovedAmountLogs;
use App\Models\FinancingInstrument;
use App\Models\IndustryType;
use App\Models\Invoice;
use App\Models\Managements;
use App\Models\Memo;
use App\Models\Proformas;
use App\Models\RequestType;
use App\Models\Team;
use App\Models\User;
use App\Models\UserCaseLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use function Pest\Laravel\get;

class CaseViewController extends Controller
{
    protected $base_path;

    use CsvImportTrait;
    use MediaUploadingTrait;

    // Global
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

    private function reformatToNumericThree($input)
    {
        $nagtive = 0;
        if (strpos($input, '(') !== false) {
            $nagtive = 1;
        }
        $new_input = floatval(preg_replace('/[^\d.]/', '', $input));
        $new_value = number_format($new_input, 3, '.', '');
        if($nagtive == 1){ $return = -$new_value; } else { $return = $new_value; }
        return $return;
    }

    private function updateCaseStatus($case_list_id){
        $CaseBankCount = CaseBank::where('case_id',$case_list_id)->count();
        $CaseBanks     = CaseBank::where('case_id',$case_list_id)->get();

        $platform_status_array  = [];
        $disburse_count =  $approved_count = $rejected_count = 0;
        $this_case              = CaseList::find($case_list_id);

        foreach ($CaseBanks as $CaseBank){
            // check if rejected
            if($CaseBank->current_status >= 5){
                $CaseBankStatus = CaseBankStatus::with('case_bank')
                    ->where('case_id',$case_list_id)
                    ->where('case_bank_id', $CaseBank->id)
                    ->where('bank_status_id',5)
                    ->whereNotNull('date')
                    ->get();

                if($CaseBankStatus){

                    foreach ($CaseBankStatus as $CaseBankStatus_key => $CaseBankStatus_item){
                        if($CaseBankStatus_item->amount > 0){
                            array_push($platform_status_array,$CaseBank->current_status);
                            $approved_count += 1;
                        } else if($CaseBankStatus_item->amount <= 0){
                            $rejected_count += 1;
                        }
                        if($CaseBankStatus_item->case_bank->current_status == 7 && $CaseBankStatus_item->date !== NULL){
                            $disburse_count += 1;
                        }
                    }
                }

            }
            else {
                array_push($platform_status_array,$CaseBank->current_status);
            }
        }

        // update case
        if(count($platform_status_array) > 0){
            $platform_status = min($platform_status_array);
            if($platform_status < 0){ $platform_status = 0; }
        } else {
            $platform_status = 0;
        }

//        dd($CaseBankCount, $rejected_count, $approved_count, $disburse_count);

        if($CaseBankCount == $rejected_count){
            // all rejected
            $this_case->update([
                'case_status' => 2, // rejected
                'platform_status' => 5, // in Pending Acceptance
            ]);
        }
        else if($approved_count > 0 && $CaseBankCount == ($rejected_count+$approved_count)) {
            if($disburse_count > 0 && $CaseBankCount == ($rejected_count+$disburse_count)){
                // all disburse already
                $this_case->update([
                    'case_status' => 4, // Completed
                    'platform_status' => 7, // Completed
                ]);
            }
        }
        else if ($approved_count > 0){
            // got approved, and all already rejected/approved
            $this_case->update([
                'case_status' => 6, // Approved
                'platform_status' => $platform_status, // in Pending Acceptance
            ]);
        }
        else {
            // not complete to approval step
            $this_case->update([
                'platform_status' => $platform_status, // in Pending Acceptance
            ]);
        }
    }

    private function updateCaseInfo($case_list_id, $bank_id, $unique_num, $bank_officer_id)
    {

        // update case list amounts, platform status
//        $CaseBankCount = CaseBank::where('case_id',$case_list_id)->count();
        $CaseBankQuery          = CaseBank::where('case_id',$case_list_id)->where('current_bank_id', $bank_id)->where('current_stage', $unique_num);
        $CaseBank               = $CaseBankQuery->first();

        $platform_status_array  = [];
        $approved_amount        = $disburse_count =  $approved_count = $rejected_count = 0;

        //loan approved
        if ($CaseBank->current_status == 5){
            // check if rejected
            if($CaseBank->current_status >= 5){
                $CaseBankStatus = CaseBankStatus::with('case_bank')
                    ->where('case_id',$case_list_id)
                    ->where('bank_status_id',5)
                    ->whereNotNull('date')
                    ->get();

                if($CaseBankStatus){

                    foreach ($CaseBankStatus as $CaseBankStatus_key => $CaseBankStatus_item){
                        if($CaseBankStatus_item->amount > 0){
                            array_push($platform_status_array,$CaseBank->current_status);
                            $approved_count += 1;
                        } else if($CaseBankStatus_item->amount <= 0){
                            $rejected_count += 1;
                        }
                        if($CaseBankStatus_item->case_bank->current_status == 7 && $CaseBankStatus_item->date !== NULL){
                            $disburse_count += 1;
                        }
                    }
                }

            }
            else {
                array_push($platform_status_array,$CaseBank->current_status);
            }

            // update case
            if(count($platform_status_array) > 0){
                $platform_status = min($platform_status_array);
                if($platform_status < 0){ $platform_status = 0; }
            } else {
                $platform_status = 0;
            }

            //check and run disburse details
            $caseDisburseDetails = CaseDisburseDetails::with(['case_disburses'])
                ->whereHas('case_disburses', function ($query) use ($case_list_id, $unique_num) {
                    $query->where('case_list_id', $case_list_id)
                        ->where('unique_num', $unique_num);
                })
                ->first();

            //check and run bs details (approved version)
            $bankStatusDetail = CaseBankStatus::select(['amount', 'date'])->where('case_bank_id', $CaseBank->id)
                ->where('bank_status_id', 5)
                ->where('stage', $unique_num)
                ->whereNotNull('date')
                ->first();

            $approved_amount = $bankStatusDetail->amount;

            //declare function
            $this_case          = CaseList::find($case_list_id);
            $this_case_disburse = CaseDisburse::where('case_list_id', $case_list_id)->where('bank_id', $bank_id)->where('unique_num', $unique_num);

            $this_case_disburse->update([
                'approved_amount' => $approved_amount,
                'current_stage' => $platform_status, // Completed
            ]);

            $current_stage      = $CaseBank->current_status;

            if ($bankStatusDetail->amount > 0 && $bankStatusDetail->date != null){
                if($caseDisburseDetails){

                    $caseDisburseDetails->update([
                        'bank_id'                   => $CaseBank->current_bank_id,
                        'approved_amount'           => $approved_amount,
                        'account_stage'             => 1,
                        'approval_date'             => $bankStatusDetail->date,
                    ]);

                }
                else {

                    $caseDisburseQuery = CaseDisburse::create([
                        'case_list_id'              => $case_list_id,
                        'current_stage'             => $current_stage,
                        'bank_id'                   => $CaseBank->current_bank_id,
                        'user_id'                   => auth()->user()->id,
                        'approved_amount'           => $approved_amount,
                        'unique_num'                => $unique_num,
                        'bank_officer_id'           => $bank_officer_id,
                        'approval_date'             => $bankStatusDetail->date,
                    ]);

                    $caseDisburseDetails_2 = CaseDisburseDetails::create([
                        'case_disburse_id'          => $caseDisburseQuery->id,
                        'account_stage'             => 1,
                    ]);

                    $current_year       = substr(date('Y'), 2);
                    $proforma_num       = sprintf("%05d",(Proformas::count() + 1));
                    $full_proforma_num  = $current_year.$proforma_num;

                    //Generate Proforma
                    Proformas::insert([
                        'date'                      => $bankStatusDetail->date,
                        'description'               => 'Being service fee as strategic advisor providing business and consultation advice services',
                        'case_id'                   => $case_list_id,
                        'case_disburse_detail_id'   => $caseDisburseDetails_2->id,
                        'file_num'                  => 'P.Invoice '.$full_proforma_num,
                    ]);
                }
            }
            elseif($bankStatusDetail->amount == 0 && $bankStatusDetail->date != null){
                CaseDisburse::where('case_list_id', $case_list_id)
                    ->where('unique_num', $unique_num)->delete();
            }
        }

        //loan released
        if ($CaseBank->current_status == 7){
            // check if rejected
            if($CaseBank->current_status >= 5){
                $CaseBankStatus = CaseBankStatus::with('case_bank')
                    ->where('case_id',$case_list_id)
                    ->where('bank_status_id',5)
                    ->whereNotNull('date')
                    ->get();

                if($CaseBankStatus){

                    foreach ($CaseBankStatus as $CaseBankStatus_key => $CaseBankStatus_item){
                        if($CaseBankStatus_item->amount > 0){
                            array_push($platform_status_array,$CaseBank->current_status);
                            $approved_count += 1;
                        } else if($CaseBankStatus_item->amount <= 0){
                            $rejected_count += 1;
                        }
                        if($CaseBankStatus_item->case_bank->current_status == 7 && $CaseBankStatus_item->date !== NULL){
                            $disburse_count += 1;
                        }
                    }
                }

            }
            else {
                array_push($platform_status_array,$CaseBank->current_status);
            }

            // update case
            if(count($platform_status_array) > 0){
                $platform_status = min($platform_status_array);
                if($platform_status < 0){ $platform_status = 0; }
            } else {
                $platform_status = 0;
            }

            $this_case          = CaseList::find($case_list_id);
            $this_case_disburse = CaseDisburse::where('case_list_id', $case_list_id)->where('bank_id', $bank_id)->where('unique_num', $unique_num);

            $service_fee_percentage = $this_case->service_fee_percentage;
            $service_fee_amount     = $approved_amount*($service_fee_percentage/100);

            $this_case_disburse->update([
                'current_stage'     => $platform_status,
            ]);

            //check and run disburse details
            $caseDisburseDetails = CaseDisburseDetails::with(['case_disburses'])
                ->whereHas('case_disburses', function ($query) use ($case_list_id, $unique_num) {
                    $query->where('case_list_id', $case_list_id)
                        ->where('unique_num', $unique_num);
                })
                ->first();

            //check and run bs details (disbursement version)
            $bankStatusDetail = CaseBankStatus::select(['amount', 'date'])->where('case_bank_id', $CaseBank->id)
                ->where('bank_status_id', 7)
                ->where('stage', $unique_num)
                ->whereNotNull('date')
                ->first();

            $loan_disbursement_date = $bankStatusDetail->date;

             $caseDisburseDetails->update([
                'bank_id'                   => $CaseBank->current_bank_id,
                'account_stage'             => 2,
            ]);

            //insert the disbursement date
            $caseDisburseDetails->case_disburses->update([
                'loan_disbursement_date'    => $loan_disbursement_date,
            ]);

            $case_list  = CaseList::find($case_list_id);

            $invoice = Invoice::where('case_disburse_detail_id', $caseDisburseDetails->id);

            if ($invoice->first()){
                $invoice->update([
                    'date'                          => $loan_disbursement_date,
                    'description'                   => 'Being service fee as strategic advisor providing business and consultation advice services',
                    'case_id'                       => $case_list_id,
                    'case_disburse_detail_id'       => $caseDisburseDetails->id,
                    'disbursement_type'             => 0,
                    'generate_type'                 => 0,
                    'company_name'                  => $case_list->company_name,
                    'company_address'               => $case_list->address,
                    'contact_person'                => $case_list->director_commitment?->first()->director_name ?? null,
                    'contact_phone'                 => $case_list->director_commitment?->first()->phone ?? null,
                    'service_fee'                   => $caseDisburseDetails->case_disburses->service_fee_amount,
                ]);
            }
            else{
                //Generate Invoices
                Invoice::insert([
                    'date'                          => $loan_disbursement_date,
                    'description'                   => 'Being service fee as strategic advisor providing business and consultation advice services',
                    'case_id'                       => $case_list_id,
                    'case_disburse_detail_id'       => $caseDisburseDetails->id,
                    'disbursement_type'             => 0,
                    'generate_type'                 => 0,
                    'company_name'                  => $case_list->company_name,
                    'company_address'               => $case_list->address,
                    'contact_person'                => $case_list->director_commitment?->first()->director_name ?? null,
                    'contact_phone'                 => $case_list->director_commitment?->first()->phone ?? null,
                    'service_fee'                   => $caseDisburseDetails->case_disburses->service_fee_amount,
                ]);
            }
        }
    }


    // Case View - Credit
    public function showCredit(Request $request, CaseList $caseList)
    {
        abort_if(Gate::denies('case_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // If has notification, mark as read
        if ($request->has('notification')) {
            auth('admin')->user()->notifications()->where('id', $request->notification)->update(['read_at' => now()]);
        }

        // action permissions
        $isSalesMan = (Auth::user()->roles()->first()->id == 3);

        if ($isSalesMan) {
            $isSeen = true;
            if (isset($caseList->salesman->teams)) {
                foreach ($caseList->salesman->teams as $teams) {
                    $isTeamLeader = $teams->team_lead_id == Auth::user()->id;
                    if ($isTeamLeader) {
                        $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
                        break;
                    }
                }
            }
        } else {
            $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
        }

        if (count($caseList->user_case_logs) > 0){
            if($caseList?->user_case_logs[count($caseList->user_case_logs)-1]?->action == 2 && $caseList->case_status == 3){
                $custom_errors = $caseList->user_case_logs[count($caseList->user_case_logs)-1]->remark;
            }else{
                $custom_errors = '';
            }
        }
        else{
            $custom_errors = '';
        }
        // permissions
        $permissions = checkCasePermissions($caseList);

//        dd($caseList);

        // case bank status
        $case_bank_status       = [];
        $caseBankStatusBankId   = CaseBankStatus::where('case_id', $caseList->id)->pluck('bank_id')->toArray();
        $bankList               = Bank::whereIn('id', $caseBankStatusBankId)->orderBy('id', 'ASC')->get();
        $caseBankList           = CaseBank::with('bank','bank_officer')->where('case_id',$caseList->id)->orderBy('current_stage','ASC')->get();
        $agreement_date         = CaseList::where('id', $caseList->id)->first()->agreement_sign_date;

        $bankStatus             = BankStatus::all();
        if ($bankList && count($bankList) > 0) {
            foreach($caseBankList as $rowCBL_key => $rowCBL){
                // 7 bank status
                $dates  = [];
                $d      = [];
                foreach ($bankStatus as $rowBankStatus_key => $rowBankStatus) {
                    $thisStatus = CaseBankStatus::where('case_id', $caseList->id)
                        ->where('bank_id', $rowCBL->current_bank_id)
                        ->where('stage', $rowCBL_key + 1)
                        ->where('bank_status_id', $rowBankStatus->id)->first();
                    $d['date'] = $thisStatus->date ?? '';
                    $d['amount'] = $thisStatus->amount ?? '0';
                    array_push($dates, $d);
                }
                if($rowCBL->bank_officer !== NULL){
                    $this_bank_id = $rowCBL->current_bank_id;
                } else {
                    $this_bank_id = 1;
                }
                $d['bank_officers'] = BankOfficer::where('bank_id',$this_bank_id)->get();
                $d['bank_officer_id'] = $rowCBL->bank_officer_id;
                $d['current_stage'] = $rowCBL->current_stage;
                $d['bank_id'] = $rowCBL->bank->id;
                $d['bank_name'] = $rowCBL->bank->name;
                $d['dates'] = $dates;
                array_push($case_bank_status, $d);
            }
        }

        // Bank
        $Bank = Bank::all();
        // credit_report_application_type
        $credit_report_application_type = [];
        $credit_report_application_type = creditReport::where('case_id', '=', $caseList->id)->pluck('application_type')->toArray();

        $credit_report = creditReport::where('case_id', '=', $caseList->id)->first();

        $case_report_recommendation = CaseReportRecommendation::where('case_id', '=', $caseList->id)->first();

        // case_criterion
        $case_criterion = [];
        for($i=1;$i<=10;$i++){
            $this_criterion = CaseCriterion::where('case_id',$caseList->id)->where('arrange',$i)->first();
            $answer = $this_criterion ? $this_criterion->answer : '';
            array_push($case_criterion, $answer);
        }
        // pcr
        $caseControllerView = new CaseController($caseList->id);
        $pcr_display = $caseControllerView->pcr();
        $dsr_display = $caseControllerView->dsr();
        // director
        $directors = Director::get(['id', 'name', 'ic']);
        $directors_array = array();
        foreach ($directors as $director_key => $director_item) {
            array_push($directors_array, $director_item->name . ' (' . $director_item->ic . ')');
        }

        switch ($caseList->case_status){
            case 0 : case 1 : case 2 :case 6:
                $caseType_class = 'management_class';
                $caseType_num   = 0;
                break;

            case 3 :
                $caseType_class = 'bfe_class';
                $caseType_num   = 1;
                break;

            case 4 : case 5 :
                $caseType_class = 'drop_class';
                $caseType_num   = 2;
                break;

            default:
                $caseType_class = '';
                $caseType_num   = 3;
                break;
        }

        return view('admin.caseLists.show-credit', compact(
            'isSeen','custom_errors','caseList','permissions',
            'case_bank_status','bankStatus','Bank', 'caseBankList',
            'credit_report_application_type','case_criterion',
            'pcr_display','directors_array', 'credit_report', 'case_report_recommendation',
            'caseType_class', 'caseType_num', 'agreement_date'
        ));
    }

    public function caseStatusUpdate(Request $request)
    {
        $case_list_id       = $request->case_list_id;

        try {
            //declare variable
            $user_id            = auth()->user()->id;
            $case_list_id       = $request->case_list_id;
            $agreement_date     = CaseList::where('id', $case_list_id)->first()->agreement_sign_date;

            // update old inputs
            $old_banks          = array_merge(($request->input('old_bank') ?? []), ($request->input('new_bank') ?? []) );
            $old_bank_dates     = array_merge(($request->input('old_bank_date') ?? []), ($request->input('new_bank_date') ?? []));
            $old_amount         = array_merge(($request->input('old_amount') ?? []), ($request->input('new_amount') ?? []));
            $old_officer        = array_merge(($request->input('old_officer') ?? []), ($request->input('new_officer') ?? []));

             //remove all old data
            CaseBank::where('case_id',$case_list_id)->delete();
            CaseBankStatus::where('case_id',$case_list_id)->delete();

            if (isset($old_banks) && count($old_banks) > 0) {
                foreach ($old_banks as $bank_key => $bank_id) {
                    $stage              = $bank_key + 1;
                    $unique_num         = $stage;
                    $bank_officer_id    = $old_officer[$bank_key] ?? NULL;

                    $CaseBank = CaseBank::Create([
                        'case_id'           => $case_list_id,
                        'current_bank_id'   => $bank_id,
                        'current_stage'     => $stage,
                        'bank_officer_id'   => $bank_officer_id,
                    ]);

                    foreach ($old_bank_dates[$bank_key] as $key => $date) {
                        if($date!=''){
                            $this_old_date = date("Y-m-d",strtotime($date));
                        } else {
                            $this_old_date = NULL;
                        }

                        $bank_status_id = $key + 1;
                        $reformat_amount = $this->reformatToNumeric($old_amount[$bank_key][$key] ?? 0);
                        $caseBankStatus = CaseBankStatus::Create([
                            'stage'             => $stage,
                            'case_id'           => $case_list_id,
                            'bank_status_id'    => $bank_status_id,
                            'bank_id'           => $bank_id,
                            'date'              => $this_old_date,
                            'user_id'           => $user_id,
                            'amount'            => $reformat_amount,
                            'case_bank_id'      => $CaseBank->id,
                        ]);

                        if ($bank_status_id == 2){
                            if ($agreement_date != null) {
                                $caseBankStatus->update(['date' => $agreement_date]);
                            }
                            else{
                                CaseList::where('id', $case_list_id)->update([
                                    'agreement_sign_date' => $this_old_date,
                                ]);

                                // update all summary agreement date
                                CaseBankStatus::where('case_id', $case_list_id)->where('bank_status_id', 2)->update([
                                    'date' => $this_old_date,
                                ]);

                                $agreement_date = $this_old_date;
                            }

                            $date = $agreement_date;
                        }
                        if ((!($date == NULL) || $date != '') && $bank_status_id != 2) {
                            $CaseBank->update(['current_status' => $bank_status_id]);
                        }elseif((!($date == NULL) || $date != '') && $bank_status_id = 1) {
                            CaseBank::where('case_id', $case_list_id)->where('current_status', 1)->update([
                                'current_status' => 2,
                            ]);
                        }
                    }

                    if ($CaseBank->current_status == 5 || $CaseBank->current_status == 7){
                        // update case's related amount, service fee charged
                        $this->updateCaseInfo($case_list_id, $bank_id, $unique_num, $bank_officer_id);
                    }
                }
            }

            // create new inputs
//            $new_bank       = $request->input('new_bank');
//            $new_bank_date  = $request->input('new_bank_date');
//            $new_amount     = $request->input('new_amount');
//
//            if (isset($new_bank) && count($new_bank) > 0) {
//                foreach ($new_bank as $new_stage => $new_bank_id) {
////                    dd($new_stage);
//                    $unique_num = $new_stage;
//
//                    $bank_officer_id = $request->input('new_officer')[$new_stage] ?? NULL;
//                    $CaseBank = CaseBank::Create([
//                        'case_id'           => $case_list_id,
//                        'current_bank_id'   => $new_bank_id,
//                        'current_stage'     => $new_stage,
//                        'bank_officer_id'   => $bank_officer_id,
//                    ]);
//                    foreach ($new_bank_date[$new_stage] as $new_key => $new_date) {
//                        if($new_date!=''){
//                            $this_new_date = date("Y-m-d",strtotime($new_date));
//                        } else {
//                            $this_new_date = NULL;
//                        }
//                        $reformat_amount = $this->reformatToNumeric($new_amount[$new_stage][$new_key] ?? 0);
//                        $bank_status_id = $new_key + 1;
//                        CaseBankStatus::Create([
//                            'stage'             => $new_stage,
//                            'case_id'           => $case_list_id,
//                            'bank_status_id'    => $bank_status_id,
//                            'bank_id'           => $new_bank_id,
//                            'date'              => $this_new_date,
//                            'user_id'           => $user_id,
//                            'case_bank_id'      => $CaseBank->id,
//                            'amount'            => $reformat_amount,
//                        ]);
//                        if (!($new_date == NULL) || $new_date != '') {
//                            $CaseBank->update(['current_status' => $bank_status_id]);
//                        }
//                    }
//
//                    if ($CaseBank->current_status == 5 || $CaseBank->current_status == 7){
//                        // update case's related amount, service fee charged
//                        $this->updateCaseInfo($case_list_id, $new_bank_id, $unique_num, $bank_officer_id);
//                    }
//                }
//            }

            $this->updateCaseStatus($case_list_id);

            $message = 'Update Case Status Summary Successfully.';
            return redirect()->route('admin.case-lists.show-credit',[$case_list_id,'#summary-memo'])->with('message', $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-credit',[$request->case_list_id,'#summary-memo'])->withErrors([$message]);
        }
    }

    public function storeMemo(Request $request)
    {
        try {
            $user_name = Auth::user()?->name;
            $position = Auth::user()?->roles?->first()?->name;
            Memo::create([
                'user_name' => $user_name,
                'position' => $position,
                'remark' => $request->remark,
                'case_id' => $request->case_id,
            ]);
            $message = 'Create Memo Successfully.';
            return redirect()->route('admin.case-lists.show-credit',[$request->case_id,'#summary-memo'])->with('message', $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-credit',[$request->case_id,'#summary-memo'])->withErrors([$message]);
        }
    }

    public function findBankOfficers(Request $request)
    {
        $bank_id = $request->id;
        return response()->json([
            'bank_officers' => BankOfficer::where('bank_id',$bank_id)->get() ?? NULL,
        ]);
    }

    public function pcrUpdate(Request $request)
    {
//        dd($request->all());

        try {
            foreach($request->input('assessment_answer') as $key => $answer){
                $arrange = $key+1;
                CaseCriterion::updateOrCreate([
                    'case_id' => $request->case_list_id,
                    'arrange' => $arrange,
                ],[
                    'answer' => $answer,
                ]);
            }
//            CaseReportRecommendation::updateOrCreate([
//                'case_id' => $request->case_list_id,
//            ],[
//                'recommendation' => $request->recommendation,
////                'date' => $request->date,
//            ]);

            CaseReportRecommendation::updateOrCreate([
                'case_id' => $request->case_list_id,
            ],[
                'recommendation' => $request->recommendation,
                'date' => $request->date,
            ]);
            $message = 'Update Successfully.';
            return redirect()->route('admin.case-lists.show-credit',[$request->case_list_id,'#pcr'])->with('message', $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-credit',[$request->case_list_id,'#pcr'])->withErrors([$message]);
        }
    }

    // Case View - Case Information
    public function showCaseInfo(Request $request, CaseList $caseList)
    {
        abort_if(Gate::denies('case_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        switch ($caseList->case_status){
            case 0 : case 1 : case 2 :case 6:
            $caseType_class = 'management_class';
            $caseType_num   = 0;
            break;

            case 3 :
                $caseType_class = 'bfe_class';
                $caseType_num   = 1;
                break;

            case 4 : case 5 :
            $caseType_class = 'drop_class';
            $caseType_num   = 2;
            break;

            default:
                $caseType_class = '';
                $caseType_num   = 3;
                break;
        }

        // action permissions
        $isSalesMan = (Auth::user()->roles()->first()->id == 3);

        if ($isSalesMan) {
            $isSeen = true;
            if (isset($caseList->salesman->teams)) {
                foreach ($caseList->salesman->teams as $teams) {
                    $isTeamLeader = $teams->team_lead_id == Auth::user()->id;
                    if ($isTeamLeader) {
                        $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
                        break;
                    }
                }
            }
        } else {
            $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
        }

        if (count($caseList->user_case_logs) > 0){
            if($caseList?->user_case_logs[count($caseList->user_case_logs)-1]?->action == 2 && $caseList->case_status == 3){
                $custom_errors = $caseList->user_case_logs[count($caseList->user_case_logs)-1]->remark;
            }else{
                $custom_errors = '';
            }
        }
        else{
            $custom_errors = '';
        }
        // permissions
        $permissions = checkCasePermissions($caseList);
        // IndustryType
        $industry_types = IndustryType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // ApplicationType
        $application_types = ApplicationType::pluck('name', 'id');
        // catch salesman id,name
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_id')
            ->where('role_id', '=', '2')
            ->where('model_type', '=', 'App\Models\User')
            ->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // get case request
        $caseRequest = CaseRequest::all()->where('case_id', '=', $caseList->id);
        // RequestType
        $request_types = RequestType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');
        // CaseManagementTeam
        $caseMgmtTeam = CaseManagementTeam::all()->where('case_id', '=', $caseList->id);
        // CaseCreditCheck
        $caseCreditCheck = CaseCreditCheck::all()->where('case_id', '=', $caseList->id);
        // CaseCreditCheckType
        $case_credit_check_types = CaseCreditCheckType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // CaseCommitment
        $caseCommitment = CaseCommitment::all()->where('case_id', '=', $caseList->id);
        // CaseFinancingInstrument
        $case_financingInstruments_loan      = CaseFinancingInstrument::with('financing_instrument')->where('financing_instrument_id', '!=', '7')->where('case_id', '=', $caseList->id)->get();
        // CaseFinancingInstrument (capboost)
        $case_financingInstruments_capboost  = CaseFinancingInstrument::with('financing_instrument')->where('financing_instrument_id', '=', '7')->where('case_id', '=', $caseList->id)->get();

//        dd($case_financingInstruments_capboost);

        // BankStatement (new)
        $bank_statements_date_array     = array();
        $bank_statements_credit_array   = array();
        $bank_statements_debit_array    = array();
        $bank_statements_month_array    = array();
        $bank_statements = BankStatement::where('case_id',$caseList->id)->groupBy('group_id')->orderBy('group_id','asc')->get();
        foreach($bank_statements as $rowBS){
            $bank_id = $rowBS->bank_id;
            $group_id = $rowBS->group_id;
            $bank_statements_details_date_array     = array();
            $bank_statements_details_credit_array   = array();
            $bank_statements_details_debit_array    = array();
            $bank_statements_details_month_array    = array();
            $bank_statements_details  = BankStatement::select(['credit', 'debit', 'month_end_balance', 'month'])
                ->where('case_id', '=', $caseList->id)
                ->where('bank_id', '=', $bank_id)
                ->where('group_id','=',$group_id)
                ->get();

            foreach ($bank_statements_details as $bank_statements_detail_key => $bank_statements_detail_item){
                array_push($bank_statements_details_date_array, $bank_statements_detail_item->month);
                array_push($bank_statements_details_credit_array, $bank_statements_detail_item->credit);
                array_push($bank_statements_details_debit_array, $bank_statements_detail_item->debit);
                array_push($bank_statements_details_month_array, $bank_statements_detail_item->month_end_balance);
            }

            array_push($bank_statements_date_array,     $bank_statements_details_date_array);
            array_push($bank_statements_credit_array,   $bank_statements_details_credit_array);
            array_push($bank_statements_debit_array,    $bank_statements_details_debit_array);
            array_push($bank_statements_month_array,    $bank_statements_details_month_array);
        }

//        // bank_statements_credit_array (old)
//        $bank_statements = BankStatement::with('bank')->where('case_id', '=', $caseList->id)->groupBy('group_id')->orderBy('bank_id')->get();
//        $bank_statements_date_array     = array();
//        $bank_statements_credit_array   = array();
//        $bank_statements_debit_array    = array();
//        $bank_statements_month_array    = array();
//        foreach ($bank_statements as $bank_statements_credit_key => $bank_statement_item){
//            $bank_statements_details_date_array     = array();
//            $bank_statements_details_credit_array   = array();
//            $bank_statements_details_debit_array    = array();
//            $bank_statements_details_month_array    = array();
//
//            $bank_statements_details  = BankStatement::select(['credit', 'debit', 'month_end_balance', 'month'])->where('case_id', '=', $caseList->id)->where('bank_id', '=', $bank_statement_item->bank_id)->get();
//
//            foreach ($bank_statements_details as $bank_statements_detail_key => $bank_statements_detail_item){
//                array_push($bank_statements_details_date_array, $bank_statements_detail_item->month);
//                array_push($bank_statements_details_credit_array, $bank_statements_detail_item->credit);
//                array_push($bank_statements_details_debit_array, $bank_statements_detail_item->debit);
//                array_push($bank_statements_details_month_array, $bank_statements_detail_item->month_end_balance);
//            }
//
//            array_push($bank_statements_date_array,     $bank_statements_details_date_array);
//            array_push($bank_statements_credit_array,   $bank_statements_details_credit_array);
//            array_push($bank_statements_debit_array,    $bank_statements_details_debit_array);
//            array_push($bank_statements_month_array,    $bank_statements_details_month_array);
//        }

        //get the case commitments
        $case_commitment_loop   = CaseCommitment::select(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->get();
        $case_commitment_count  = CaseCommitment::all()->count();
        $case_commitment        = CaseCommitment::all()->except(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->first();

        // banks
        $banks = Bank::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '0');
        // director commitment default
        $director_commitment_array      = array();
        $final_director_commitment_array      = array();
        $director_commitment = CaseDirectorCommitment::with('director')->where('case_id', '=', $caseList->id)->groupBy('director_id')->orderBy('director_id')->get();
        foreach ($director_commitment as $director_commitment_key => $director_commitment_item){
            $director_commitment_hl_array       = array();
            $director_commitment_pl_array       = array();
            $director_commitment_hp_array       = array();
            $director_commitment_cc_array       = array();
            $director_commitment_details  = CaseDirectorCommitment::select(['house_loan', 'personal_loan', 'hire_purchase', 'credit_card_limit'])->where('case_id', '=', $caseList->id)->where('director_id', '=', $director_commitment_item->director_id)->get();

            foreach ($director_commitment_details as $director_commitment_details_key => $director_commitment_details_item){
                array_push($director_commitment_hl_array,    $director_commitment_details[$director_commitment_details_key]->house_loan);
                array_push($director_commitment_pl_array,    $director_commitment_details[$director_commitment_details_key]->personal_loan);
                array_push($director_commitment_hp_array,    $director_commitment_details[$director_commitment_details_key]->hire_purchase);
                array_push($director_commitment_cc_array,    $director_commitment_details[$director_commitment_details_key]->credit_card_limit);
            }

            $director_commitment_array['id']    = $director_commitment_item->director->id;
            $director_commitment_array['name']  = $director_commitment_item->director->name;
            $director_commitment_array['ic']    = $director_commitment_item->director->ic;

            $director_commitment_array['hl']    = $director_commitment_hl_array;
            $director_commitment_array['pl']    = $director_commitment_pl_array;
            $director_commitment_array['hp']    = $director_commitment_hp_array;
            $director_commitment_array['cc']    = $director_commitment_cc_array;

            $director_commitment_array['total_hl']    = $director_commitment_item->total_hl;
            $director_commitment_array['total_pl']    = $director_commitment_item->total_pl;
            $director_commitment_array['total_hp']    = $director_commitment_item->total_hp;
            $director_commitment_array['total_cc']    = $director_commitment_item->total_cc;

            $director_commitment_array['total_cc_charge']       = $director_commitment_item->total_cc_charge;
            $director_commitment_array['sub_total']             = $director_commitment_item->sub_total;
            $director_commitment_array['total']                 = $director_commitment_item->final_total;

            array_push($final_director_commitment_array, $director_commitment_array);
        }
        $directors_array = array();

//        dd($final_director_commitment_array);

        $directors = Director::get(['id', 'name', 'ic']);
        foreach ($directors as $director_key => $director_item) {
            array_push($directors_array, $director_item->name . ' (' . $director_item->ic . ')');
        }

        $financingInstruments_loan = FinancingInstrument::where('type', '=', '0')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month', 'able_edit_type']);
        $financingInstruments_capboost  = FinancingInstrument::where('type', '=', '1')->get(['loan_product', 'id', 'interest_rate', 'tenor', 'tenor_number', 'tenor_month', 'able_edit_type']);

        // get case financial
        $fye_1 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '1')->first();
        $fye_2 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '2')->first();
        $fye_3 = CaseFinancial::all()->where('case_id', '=', $caseList->id)->where('group_id', '=', '3')->first();
        $case_commitment_loop = CaseCommitment::select(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->get();
        $case_commitment = CaseCommitment::all()->except(['house_loan', 'term_loan', 'hire_purchase', 'credit_card_limit', 'trade_line_limit'])->where('case_id', '=', $caseList->id)->first();

        $dsr            = dsrView::all()->where('case_id', '=', $caseList->id)->first();
        $cash_flow      = CashFlowView::all()->where('case_id', '=', $caseList->id)->first();
        $case_gearing   = CaseGearingView::all()->where('case_id', '=', $caseList->id)->first();

        $caseControllerView = new CaseController($caseList->id);
        $pcr_display        = $caseControllerView->pcr();

//        dd($pcr_display);

        return view('admin.caseLists.show-caseInfo', compact(
            'isSeen','custom_errors','caseList','permissions',
            'industry_types','application_types','users',
            'caseRequest','request_types','caseMgmtTeam','caseCreditCheck','case_credit_check_types','caseCommitment',
            'case_financingInstruments_loan','case_financingInstruments_capboost','bank_statements',
            'bank_statements_date_array','bank_statements_credit_array','bank_statements_debit_array','bank_statements_month_array',
            'banks','final_director_commitment_array','directors_array',
            'financingInstruments_loan','financingInstruments_capboost',
            'fye_1','fye_2','fye_3',
            'case_commitment_loop','case_commitment',
            'dsr', 'cash_flow', 'case_gearing', 'pcr_display',
            'caseType_class', 'caseType_num'
        ));
    }

    public function kycEdit(Request $request, CaseList $caseList)
    {
        //KYC PArt
        // -- 1. Normal
        $incorporation_date = $request->get('incorporation_date');

        $kyc_details = $request->only(
            'company_name',
            'business_activity',
            'address',
            'industry_type_id',
            'business_bg',
            'remark',
        );

        $kyc_details['incorporation_date']  = $incorporation_date;

        $caseList->update($kyc_details);
        $caseList->application_types()->attach($request->input('application_type', []));

        $case_id = $caseList->id;

        // --2. Request
        CaseRequest::where('case_id', $caseList->id)->delete();

        if ($request->get('request') != null){
            foreach ($request->get('request') as $key => $request_id) {
                $facility_type      = $request->get('facility_type')[$key];
                $amount             = $request->get('amount')[$key];
                $specific_concern   = $request->get('specific_concern')[$key];

                if ($facility_type == null && $amount == null && $specific_concern == null){

                }
                else{
                    CaseRequest::create([
                        'request'           => $request_id,
                        'facility_type'     => $facility_type,
                        'amount'            => $amount,
                        'specific_concern'  => $specific_concern,
                        'case_id'           => $case_id
                    ]);
                }
            }
        }

        // --3. mgmt team
        CaseManagementTeam::where('case_id', $caseList->id)->delete();
        if ($request->get('mgmt_team_name') != null){
            foreach ($request->get('mgmt_team_name') as $key => $mgmt_team_name) {
//                $mgmt_team_age                  = $request->get('mgmt_team_age')[$key];
                $mgmt_team_ic                   = $request->get('mgmt_team_ic')[$key];
                $mgmt_team_phone                = $request->get('mgmt_team_phone')[$key];
                $mgmt_team_email                = $request->get('mgmt_team_email')[$key];
                $mgmt_team_designation          = $request->get('mgmt_team_designation')[$key];
                $mgmt_team_shareholding         = $request->get('mgmt_team_shareholding')[$key];
                $mgmt_team_responsibilityArea   = $request->get('mgmt_team_responsibilityArea')[$key];
                $mgmt_team_expeienceYear        = $request->get('mgmt_team_expeienceYear')[$key];
                $mgmt_team_companyYear          = $request->get('mgmt_team_companyYear')[$key];
                $mgmt_team_relationship         = $request->get('mgmt_team_relationship')[$key];


                    CaseManagementTeam::create([
                        'name'                  => $mgmt_team_name,
                        'ic'                   => $mgmt_team_ic,
                        'phone'                 => $mgmt_team_phone,
                        'email'                 => $mgmt_team_email,
                        'designation'           => $mgmt_team_designation,
                        'shareholding'          => $mgmt_team_shareholding,
                        'responsible_area'      => $mgmt_team_responsibilityArea,
                        'experience_year'       => $mgmt_team_expeienceYear,
                        'case_year'             => $mgmt_team_companyYear,
                        'director_relationship' => $mgmt_team_relationship,
                        'case_id'               => $case_id,
                    ]);
            }
        }

        // --4. credit check
        CaseCreditCheck::where('case_id', $caseList->id)->delete();

        if ($request->get('credit_check_type') != null){
            foreach ($request->get('credit_check_type') as $key => $credit_check_type) {
                $director_n_company                  = $request->get('director_n_company')[$key];
                $credit_check_finding                = $request->get('credit_check_finding')[$key];
                $credit_check_mitigation             = $request->get('credit_check_mitigation')[$key];

                if ($director_n_company == null && $credit_check_finding == null && $credit_check_mitigation == null){

                }
                else{
                    CaseCreditCheck::create([
                        'director_n_company'        => $director_n_company,
                        'finding'                   => $credit_check_finding,
                        'migration'                 => $credit_check_mitigation,
                        'credit_check_id'           => $credit_check_type,
                        'case_id'                   => $case_id,
                    ]);
                }
            }
        }

        return redirect()->route('admin.case-lists.show-caseInfo',[$case_id,'#kyc'])->with('success', 'KYC Edit Successfully');
    }

    public function finEdit1(Request $request, CaseList $caseList){
        $case_id = $caseList->id;

        // Financial Part
        // --1. FYP
        CaseFinancial::where('case_id', $caseList->id)->delete();

//        dd( ($request->get('fye_cost2')?? 0) ,$this->reformatToNumeric($request->get('fye_cost2')?? 0));

        for ($i = 1; $i <= 3; $i++) {
            $fye_date                   = (string)$request->get('fye_date' . $i);
            $fye_auditor                = $request->get('fye_auditor' . $i);
            $fye_non_current_asset      = $this->reformatToNumeric($request->get('fye_non_current_asset'.$i)?? 0);
            $fye_current_asset          = $this->reformatToNumeric($request->get('fye_current_asset'.$i)?? 0);
            $fye_other_asset            = $this->reformatToNumeric($request->get('fye_other_asset'.$i)?? 0);
            $fye_non_current_liability  = $this->reformatToNumeric($request->get('fye_non_current_liability'.$i)?? 0);
            $fye_current_liability      = $this->reformatToNumeric($request->get('fye_current_liability'.$i)?? 0);
            $fye_other_liability        = $this->reformatToNumeric($request->get('fye_other_liability'.$i)?? 0);
            $fye_current_maturity       = $this->reformatToNumeric($request->get('fye_current_maturity'.$i)?? 0);
            $fye_equity                 = $this->reformatToNumeric($request->get('fye_equity'.$i)?? 0);
            $share_capital              = $this->reformatToNumeric($request->get('share_capital'.$i)?? 0);
            $fye_retained_earning       = $this->reformatToNumeric($request->get('fye_retained_earning'.$i)?? 0);
            $fye_tnw                    = $this->reformatToNumeric($request->get('fye_tnw'.$i)?? 0);
            $fye_revenue                = $this->reformatToNumeric($request->get('fye_revenue'.$i)?? 0);
            $fye_cost                   = $this->reformatToNumeric($request->get('fye_cost'.$i)?? 0);
            $fye_gross_profit           = $this->reformatToNumeric($request->get('fye_gross_profit'.$i)?? 0);
            $fye_finance_cost           = $this->reformatToNumeric($request->get('fye_finance_cost'.$i)?? 0);
            $fye_depreciation           = $this->reformatToNumeric($request->get('fye_depreciation'.$i)?? 0);
            $fye_profit_bfr_tax         = $this->reformatToNumeric($request->get('fye_profit_bfr_tax'.$i)?? 0);
            $fye_profit_aft_tax         = $this->reformatToNumeric($request->get('fye_profit_aft_tax'.$i)?? 0);
            $fye_ebitda                 = $this->reformatToNumeric($request->get('fye_ebitda'.$i)?? 0);

            CaseFinancial::create([
                'group_id'                  => $i,
                'financial_date'            => $fye_date,
                'current_asset'             => $fye_current_asset,
                'non_current_asset'         => $fye_non_current_asset,
                'other_asset'               => $fye_other_asset,
                'current_liabilities'       => $fye_current_liability,
                'non_current_liabilities'   => $fye_non_current_liability,
                'other_liabilities'         => $fye_other_liability,
                'current_maturity'          => $fye_current_maturity,
                'share_capital'             => $share_capital,
                'retained_earnings'         => $fye_retained_earning,
                'tnw'                       => $fye_tnw,
                'revenue'                   => $fye_revenue,
                'sales_cost'                => $fye_cost,
                'gross_profit'              => $fye_gross_profit,
                'finance_cost'              => $fye_finance_cost,
                'depreciation'              => $fye_depreciation,
                'profit_bfr_tax'            => $fye_profit_bfr_tax,
                'profit_aft_tax'            => $fye_profit_aft_tax,
                'ebitda'                    => $fye_ebitda,
                'equity'                    => $fye_equity,
                'auditor'                   => $fye_auditor,
                'case_id'                   => $case_id,
            ]);
        }

        // --2. Commitment from CCRIS
        CaseCommitment::where('case_id', $caseList->id)->delete();

        if ($request->get('case_commitment_houseLoan') != null){
//            dd($request->get('case_commitment_houseLoan'));
            foreach ($request->get('case_commitment_houseLoan') as $key => $case_commitment_houseLoan) {
                $case_commitment_houseLoan              = $this->reformatToNumeric($case_commitment_houseLoan?? 0);
                $case_commitment_termLoan               = $this->reformatToNumeric($request->get('case_commitment_termLoan')[$key]?? 0);
                $case_commitment_hirePurchase           = $this->reformatToNumeric($request->get('case_commitment_hirePurchase')[$key]?? 0);
                $case_commitment_cc                     = $this->reformatToNumeric($request->get('case_commitment_cc')[$key]?? 0);
                $case_commitment_trade_line             = $this->reformatToNumeric($request->get('case_commitment_trade_line')[$key]?? 0);
                $total_caseCommitment_hl                = $this->reformatToNumeric($request->get('total_caseCommitment_hl')?? 0);
                $total_caseCommitment_tl                = $this->reformatToNumeric($request->get('total_caseCommitment_tl')?? 0);
                $total_caseCommitment_hp                = $this->reformatToNumeric($request->get('total_caseCommitment_hp')?? 0);
                $total_caseCommitment_cc                = $this->reformatToNumeric($request->get('total_caseCommitment_cc')?? 0);
                $total_caseCommitment_trade_line        = $this->reformatToNumeric($request->get('total_caseCommitment_trade_line')?? 0);
                $total_caseCommitment_cc_charge         = $this->reformatToNumeric($request->get('total_caseCommitment_cc_charge')?? 0);
                $total_caseCommitment_trade_line_charge = $this->reformatToNumeric($request->get('total_caseCommitment_trade_line_charge')?? 0);
                $final_total_caseCommitment             = $this->reformatToNumeric($request->get('final_total_caseCommitment')?? 0);

                CaseCommitment::create([
                    'house_loan'        => $case_commitment_houseLoan,
                    'term_loan'         => $case_commitment_termLoan,
                    'hire_purchase'     => $case_commitment_hirePurchase,
                    'credit_card_limit' => $case_commitment_cc,
                    'trade_line_limit'  => $case_commitment_trade_line,
                    'total_hl'          => $total_caseCommitment_hl,
                    'total_tl'          => $total_caseCommitment_tl,
                    'total_hp'          => $total_caseCommitment_hp,
                    'total_cc'          => $total_caseCommitment_cc,
                    'total_trade_line'  => $total_caseCommitment_trade_line,
                    'cc_charge'         => $total_caseCommitment_cc_charge,
                    'tl_charge'         => $total_caseCommitment_trade_line_charge,
                    'final_total'       => $final_total_caseCommitment,
                    'case_id'           => $case_id
                ]);
            }
        }

        return redirect()->route('admin.case-lists.show-caseInfo',[$case_id,'#financial'])->with('success', 'Financial Edit Successfully');
    }

    public function finEdit2(Request $request, CaseList $caseList){

        $case_id = $caseList->id;

        //update normal
        $fin_part2 = $request->only(
            'dsr_bankStt_commitment',
            'cash_flow_factor',
            'gearing_date',
            'gearing_borrow',
            'gearing_redemtion',
        );

        $caseList->update([
            'dsr_bankStt_commitment'    => str_replace(',', '', $request->get('dsr_bankStt_commitment') ?? 0),
            'cash_flow_factor'          => str_replace(',', '', $request->get('cash_flow_factor') ?? 0),
            'gearing_date'              => $request->get('gearing_date'),
            'gearing_borrow'            => str_replace(',', '', $request->get('gearing_borrow') ?? 0),
            'gearing_redemtion'         => str_replace(',', '', $request->get('gearing_redemtion') ?? 0),
        ]);

        // update financing instrument
        CaseFinancingInstrument::where('case_id', $case_id)->delete();
        if($request->get('financingInstrument_id') !== NULL){
            foreach ($request->get('financingInstrument_id') as $key => $FI_id){
                $tenor = str_replace(',', '', $request->get('financingInstrument_tenor_input')[$key]);
                if($tenor == NULL){ $tenor = 0; } else if($tenor == 'On demand' ){ $tenor = 0.8; }
                CaseFinancingInstrument::create([
                    'proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_propose_limit')[$key]) ?? 0,
                    'interest_rate' => $this->reformatToNumericThree($request->get('financingInstrument_interest_rate')[$key]) ?? 0,
                    'tenor' => $tenor,
                    'commitments'  => $this->reformatToNumeric($request->get('financingInstrument_commitment')[$key]) ?? 0,
                    'financing_instrument_id' => $FI_id ?? 0,
                    'case_id' => $case_id,
                    'total_proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_total_propose_loan')) ?? 0,
                    'total_commitments' => $this->reformatToNumeric($request->get('financingInstrument_total_commitment_loan')) ?? 0,
                ]);
            }
        }
        // update financing instrument (cap-boost)
        if($request->get('financingInstrument_id_capboost') !== NULL){
            foreach ($request->get('financingInstrument_id_capboost') as $key => $FI_id_cb){
                CaseFinancingInstrument::create([
                    'proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_propose_limit_capboost')[$key]) ?? 0,
                    'interest_rate' => $this->reformatToNumericThree($request->get('financingInstrument_interest_rate_capboost')[$key]) ?? 0,
                    'tenor' => NULL,
                    'commitments'  => $this->reformatToNumeric($request->get('financingInstrument_commitment_capboost')[$key]) ?? 0,
                    'financing_instrument_id' => $FI_id_cb ?? 0,
                    'case_id' => $case_id,
                    'total_proposed_limit' => $this->reformatToNumeric($request->get('financingInstrument_total_propose_capboost')) ?? 0,
                    'total_commitments' => $this->reformatToNumeric($request->get('financingInstrument_total_commitment_capboost')) ?? 0,
                ]);
            }
        }

        return redirect()->route('admin.case-lists.show-caseInfo',[$case_id,'#financial'])->with('success', 'Financial Edit Successfully');
    }

    public function bankSttEdit(Request $request, CaseList $caseList){
        $case_id = $caseList->id;

        //Bank Statement Part
        BankStatement::where('case_id', $caseList->id)->delete();

//        dd($request->all());
        if ($request->get('bankStt_bank_id') != null) {
            foreach ($request->get('bankStt_bank_id') as $key => $bankStt_bank_id) {

                if ($request->get('bank_statement_date') != null ){
                    foreach ($request->get('bank_statement_date')[$key] as $new_key => $bankSttDate) {

                        BankStatement::create([
                            //one array
                            'case_id'                       => $case_id,
                            'bank_id'                       => $bankStt_bank_id,
                            'currency'                      => $request->get('bankStt_currency')[$key],
                            'month'                         => $bankSttDate,
                            'avg_credit'                    => $this->reformatToNumeric($request->get('avg_credit_transaction')[$key] ?? 0),
                            'avg_debit'                     => $this->reformatToNumeric($request->get('avg_debit_transaction')[$key] ?? 0),
                            'avg_month_end_balance'         => $this->reformatToNumeric($request->get('avg_month_balance')[$key] ?? 0),

                            //two array
                            'credit'                        => $this->reformatToNumeric($request->get('bank_statement_credit_transaction')[$key][$new_key] ?? 0),
                            'debit'                         => $this->reformatToNumeric($request->get('bank_statement_debit_transaction')[$key][$new_key] ?? 0),
                            'month_end_balance'             => $this->reformatToNumeric($request->get('bank_statement_month_end_balance')[$key][$new_key] ?? 0),

                            //none array
                            'total_avg_credit'              => $this->reformatToNumeric($request->get('final_total_credit_transaction') ?? 0),
                            'total_avg_debit'               => $this->reformatToNumeric($request->get('final_total_debit_transaction') ?? 0),
                            'total_avg_month_end_balance'   => $this->reformatToNumeric($request->get('final_total_month_end_balance_transaction') ?? 0),
                            'group_id'                      => $key,

                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.case-lists.show-caseInfo',[$case_id,'#bankstt'])->with('success', 'Bank Statement Edit Successfully');
    }

    public function directorCommitmentEdit(Request $request, CaseList $caseList){
        $case_id = $caseList->id;

        //Director Commitment Part
        CaseDirectorCommitment::where('case_id', $caseList->id)->delete();

        if ($request->get('total_director_commitment_hl') != null) {
            foreach ($request->get('total_director_commitment_hl') as $key => $total_director_commitment_hl) {

                $find_director = Director::where('name', $request->get('hidden_director_name')[$key])->where('ic', $request->get('hidden_director_ic')[$key])->first();

                if (!$find_director) {
                    $new_director = Director::create([
                        'name'             => $request->get('hidden_director_name')[$key],
                        'ic'               => $request->get('hidden_director_ic')[$key],
                        'phone'            => $request->get('hidden_director_phone')[$key] ?? null,
                    ]);
                }

                foreach ($request->get('director_commitment_hl')[$key] as $new_key => $director_commitment_hl) {

                    CaseDirectorCommitment::create([
                        //one array
                        'case_id'                   => $case_id,
                        //                    'director_id'               => $request->get('hidden_director_id')[$key],
                        'director_id'               => $find_director->id ?? $new_director->id,
                        'director_name'             => $request->get('hidden_director_name')[$key],
                        'director_ic'               => $request->get('hidden_director_ic')[$key],
                        'phone'                     => $request->get('hidden_director_phone')[$key] ?? null,
                        'total_hl'                  => str_replace(',', '', $request->get('total_director_commitment_hl')[$key] ?? 0),
                        'total_pl'                  => str_replace(',', '', $request->get('total_director_commitment_pl')[$key] ?? 0),
                        'total_hp'                  => str_replace(',', '', $request->get('total_director_commitment_hp')[$key] ?? 0),
                        'total_cc'                  => str_replace(',', '', $request->get('total_director_commitment_cc')[$key] ?? 0),
                        'total_cc_charge'           => str_replace(',', '', $request->get('director_commitment_cc_charge')[$key] ?? 0),
                        'sub_total'                 => str_replace(',', '', $request->get('final_total_director_commitment')[$key] ?? 0),

                        //two array
                        'house_loan'                => str_replace(',', '', $request->get('director_commitment_hl')[$key][$new_key] ?? 0),
                        'personal_loan'             => str_replace(',', '', $request->get('director_commitment_pl')[$key][$new_key] ?? 0),
                        'hire_purchase'             => str_replace(',', '', $request->get('director_commitment_hp')[$key][$new_key] ?? 0),
                        'credit_card_limit'         => str_replace(',', '', $request->get('director_commitment_cc')[$key][$new_key] ?? 0),

                        //none array
                        'final_total'               => str_replace(',', '', $request->get('all_final_total_director_commitment') ?? 0),
                        'group_id'                  => $key,

                    ]);
                }
            }
        }

        return redirect()->route('admin.case-lists.show-caseInfo',[$case_id,'#directorCommitment'])->with('message', 'Director Commitment Edit Successfully');
    }
    // unuse
    public function updateDirectorCommitment(Request $request)
    {
        $case_list_id = $request->case_list_id;
        $caseList = CaseList::find($case_list_id);
        try {
            //Director Commitment Part
            CaseDirectorCommitment::where('case_id', $caseList->id)->delete();
            if ($request->get('total_director_commitment_hl') != null) {
                foreach ($request->get('total_director_commitment_hl') as $key => $total_director_commitment_hl) {

                    $find_director = Director::where('name', $request->get('hidden_director_name')[$key])->where('ic', $request->get('hidden_director_ic')[$key])->first();

                    if (!$find_director) {
                        $new_director = Director::create([
                            'name'             => $request->get('hidden_director_name')[$key],
                            'ic'               => $request->get('hidden_director_ic')[$key],
                            'phone'            => $request->get('hidden_director_phone')[$key] ?? null,
                        ]);
                    }

                    foreach ($request->get('director_commitment_hl')[$key] as $new_key => $director_commitment_hl) {
                        CaseDirectorCommitment::create([
                            //one array
                            'case_id'                   => $case_list_id,
                            'director_id'               => $request->get('hidden_director_id')[$key] ?? $new_director->id,
                            'director_name'             => $request->get('hidden_director_name')[$key],
                            'director_ic'               => $request->get('hidden_director_ic')[$key],
                            'phone'                     => $request->get('hidden_director_phone')[$key] ?? null,
                            'total_hl'                  => $request->get('total_director_commitment_hl')[$key],
                            'total_pl'                  => $request->get('total_director_commitment_pl')[$key],
                            'total_hp'                  => $request->get('total_director_commitment_hp')[$key],
                            'total_cc'                  => $request->get('total_director_commitment_cc')[$key],
                            'total_cc_charge'           => $request->get('director_commitment_cc_charge')[$key],
                            'sub_total'                 => $request->get('final_total_director_commitment')[$key],
                            //two array
                            'house_loan'                => $request->get('director_commitment_hl')[$key][$new_key],
                            'personal_loan'             => $request->get('director_commitment_pl')[$key][$new_key],
                            'hire_purchase'             => $request->get('director_commitment_hp')[$key][$new_key],
                            'credit_card_limit'         => $request->get('director_commitment_cc')[$key][$new_key],
                            //none array
                            'final_total'               => $request->get('all_final_total_director_commitment'),
                            'group_id'                  => $key,

                        ]);
                    }
                }
            }
            $message = 'Update Director Commitment Successfully.';
            return redirect()->route('admin.case-lists.show',[$case_list_id,'#directorCommitment'])->with('message', $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show',[$case_list_id,'#directorCommitment'])->withErrors([$message]);
        }
    }

    // Case View - Attachment
    public function showAttachment(Request $request, CaseList $caseList)
    {
        abort_if(Gate::denies('case_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        switch ($caseList->case_status){
            case 0 : case 1 : case 2 :case 6:
            $caseType_class = 'management_class';
            $caseType_num   = 0;
            break;

            case 3 :
                $caseType_class = 'bfe_class';
                $caseType_num   = 1;
                break;

            case 4 : case 5 :
            $caseType_class = 'drop_class';
            $caseType_num   = 2;
            break;

            default:
                $caseType_class = '';
                $caseType_num   = 3;
                break;
        }

        // action permissions
        $isSalesMan = (Auth::user()->roles()->first()->id == 3);;
        if ($isSalesMan) {
            $isSeen = true;
            if (isset($caseList->salesman->teams)) {
                foreach ($caseList->salesman->teams as $teams) {
                    $isTeamLeader = $teams->team_lead_id == Auth::user()->id;
                    if ($isTeamLeader) {
                        $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
                        break;
                    }
                }
            }
        } else {
            $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
        }
        if (count($caseList->user_case_logs) > 0){
            if($caseList?->user_case_logs[count($caseList->user_case_logs)-1]?->action == 2 && $caseList->case_status == 3){
                $custom_errors = $caseList->user_case_logs[count($caseList->user_case_logs)-1]->remark;
            }else{
                $custom_errors = '';
            }
        }
        else{
            $custom_errors = '';
        }
        // permissions
        $permissions = checkCasePermissions($caseList);

        // documents
        $docController = new DocumentController();
        $documentsView = $docController->getDocumentsDirectory($caseList);

        // director
        $directors = Director::get(['id', 'name', 'ic']);
        $directors_array = array();
        foreach ($directors as $director_key => $director_item) {
            array_push($directors_array, $director_item->name . ' (' . $director_item->ic . ')');
        }

        return view('admin.caseLists.show-attachment', compact(
            'isSeen','custom_errors','caseList','permissions',
            'directors_array','documentsView',
            'caseType_num', 'caseType_class'
        ));
    }

    // Case View - Agreement & Billing
    public function showAgreement(Request $request, CaseList $caseList)
    {
        $case_disburse_ids = CaseDisburse::where('case_list_id',$caseList->id)->pluck('id');

        if($case_disburse_ids){
            $approved_amount_logs = EditedApprovedAmountLogs::whereIn('case_disburse_id',$case_disburse_ids)->orderBy('created_at','desc')->get();
        }else{
            $approved_amount_logs = "";
        }

        abort_if(Gate::denies('case_view_2'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        switch ($caseList->case_status){
            case 0 : case 1 : case 2 :case 6:
            $caseType_class = 'management_class';
            $caseType_num   = 0;
            break;

            case 3 :
                $caseType_class = 'bfe_class';
                $caseType_num   = 1;
                break;

            case 4 : case 5 :
            $caseType_class = 'drop_class';
            $caseType_num   = 2;
            break;

            default:
                $caseType_class = '';
                $caseType_num   = 3;
                break;
        }

        // action permissions
        $isSalesMan = (Auth::user()->roles()->first()->id == 3);;
        if ($isSalesMan) {
            $isSeen = true;
            if (isset($caseList->salesman->teams)) {
                foreach ($caseList->salesman->teams as $teams) {
                    $isTeamLeader = $teams->team_lead_id == Auth::user()->id;
                    if ($isTeamLeader) {
                        $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
                        break;
                    }
                }
            }
        } else {
            $isSeen = UserCaseLog::where('case_id', $caseList->id)->where('user_id', Auth::user()->id)->where('action', 1)->first() ? true : false;
        }
        if (count($caseList->user_case_logs) > 0){
            if($caseList?->user_case_logs[count($caseList->user_case_logs)-1]?->action == 2 && $caseList->case_status == 3){
                $custom_errors = $caseList->user_case_logs[count($caseList->user_case_logs)-1]->remark;
            }else{
                $custom_errors = '';
            }
        }
        else{
            $custom_errors = '';
        }
        // permissions
        $permissions = checkCasePermissions($caseList);

        // director
        $directors = Director::get(['id', 'name', 'ic']);
        $directors_array = array();
        foreach ($directors as $director_key => $director_item) {
            array_push($directors_array, $director_item->name . ' (' . $director_item->ic . ')');
        }

        // case disbursement (signing section)
        $CaseDisburse       = CaseDisburse::with('details')->where('case_list_id',$caseList->id)->OrderBy('current_stage','ASC')->get();
        $CaseDisburse_num   = CaseDisburse::where('case_list_id',$caseList->id)->OrderBy('current_stage','ASC')->count();
        $agreement_document = $caseList->getMedia('agreement_document');
        $check_caseDisburse_num = $CaseDisburse_num > 0;

        return view('admin.caseLists.show-agreement', compact(
            'isSeen','custom_errors','caseList','permissions',
            'directors_array','CaseDisburse','agreement_document',
            'caseType_num', 'caseType_class', 'check_caseDisburse_num', 'approved_amount_logs'
        ));
    }

    public function signAction(Request $request)
    {
        if($request->update_btn == '1'){
            try {
                $caseList = CaseList::find($request->case_list_id);

                // update agreement_document
                if (count($caseList->getMedia('agreement_document')) > 0) {
                    foreach ($caseList->getMedia('agreement_document') as $media) {
                        if (!in_array($media->file_name, $request->input('agreement', []))) {
                            $media->delete();
                        }
                    }
                }

                $media = $caseList->getMedia('agreement_document')->pluck('file_name')->toArray();

                if (count($request->input('agreement', [])) == 0){
                    return redirect()->route('admin.case-lists.show-agreement',[$request->case_list_id,'#agmt'])->withErrors(['Please insert the documentation']);
                }

                foreach ($request->input('agreement', []) as $file) {
                    if (count($media) === 0 || !in_array($file, $media)) {
                        $caseList->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('agreement_document');
                    }
                }

                // update case list
                $caseList->update(['agreement_sign_date' => $request->agreement_sign_date]);

                // update summary agreement date
                CaseBankStatus::where('case_id', $request->case_list_id)->where('bank_status_id', 2)->update([
                    'date' => $request->agreement_sign_date,
                ]);

                //change status of 1 to 2
                CaseBank::where('case_id', $request->case_list_id)->where('current_status', 1)->update([
                    'current_status' => 2,
                ]);

                // update case disburse
                $CaseDisburse = CaseDisburse::where('case_list_id',$request->case_list_id)->orderBy('current_stage','ASC')->get();

                foreach($CaseDisburse as $key => $rowCaseDisburse){
//                    $approved_amount = $rowCaseDisburse->approved_amount;
                    $approved_amount    = str_replace(',', '', $request->input('approved_amount')[$key]);
                    $percent            = $request->input('service_fee_percent')[$key];
                    $service_fee_amount = $approved_amount*($percent/100);
                    $remark             = $request->input('remark')[$key];

                    CaseDisburse::find($rowCaseDisburse->id)->update([
                        'approved_amount'       => $approved_amount,
                        'service_fee_percent'   => $percent,
                        'service_fee_amount'    => $service_fee_amount,
                        'remark'                => $remark,
                    ]);

                    // update summary approved amount
                    CaseBankStatus::where('case_id', $request->case_list_id)->where('bank_status_id', 5)->where('stage', $request->unique_num[$key])->update([
                        'amount' => $approved_amount,
                    ]);

                    if(!($rowCaseDisburse->approved_amount == $approved_amount)){
                        EditedApprovedAmountLogs::create([
                           'user_id' => auth()->user()->id,
                           'case_disburse_id' =>  $rowCaseDisburse->id,
                           'previous_amount' => $rowCaseDisburse->approved_amount,
                           'current_amount' => $approved_amount
                        ]);
                    }

                    //declare BFE's commission query
                    $user = User::with('class')->where('id', $caseList->salesman_id)
                            ->whereHas('class', function ($query){
                                $query?->with('commission_setting_details');
                            })
                            ->first() ?? User::where('id', $caseList->salesman_id)->first();

                    $bfe_commission_details = $user?->class()?->first()?->commission_setting_details ?? array();

                    //declare Banker's commission query
                    $banker = BankOfficer::with('bank')?->where('id', $rowCaseDisburse->bank_officer_id)
                        ->whereHas('bank', function ($query) use ($rowCaseDisburse){
                            $query->where('id', $rowCaseDisburse->bank_id);
                        })
                        ->first();

                    //declare Management's commission query
                    $management = Managements::with('user')->get();

                    //declare team's commission query
                    $team = Team::with(['team_lead','users'])
                        ->whereHas('team_lead', function ($query) use ($caseList){
                            $query->where('id', $caseList->salesman_id);
                        })
                        ->orWhereHas('users', function ($query) use ($caseList){
                            $query->where('id', $caseList->salesman_id);
                        })->get();

                    //get BFE's data
                    $bfe_commission_percent     = 0;

                    foreach ($bfe_commission_details as $bfe_commission_detail_key => $bfe_commission_detail_item){

                        if ($service_fee_amount >= $bfe_commission_detail_item->range_fee){
                            $bfe_commission_percent     = $bfe_commission_detail_item->rate;
                            break;
                        }
                        else{
                            $bfe_commission_percent = 0;
                        }

                    }

                    $bfe_name                   = $user->name ?? '';
                    $bfe_commission             = $bfe_commission_percent == 0 ? 0 : ($service_fee_amount * $bfe_commission_percent / 100);

                    //get Banker's data
                    $banker_name                = $banker->name ?? '';
                    $banker_commission_percent  = $banker->commission ?? 0;
                    $banker_commission          = $banker_commission_percent == 0 ? 0 : ($service_fee_amount * $banker_commission_percent / 100);

                    $overriding_array           = array();

                    //get Management's Commission
                    foreach ($management as $management_key => $management_item){
                        array_push($overriding_array, [
                            'name'                      => $management_item->user->name,
                            'commission_rate'           => (double)$management_item->commission_rate,
                            'commission'                => $management_item->commission_rate == 0 ? 0 : ($service_fee_amount * $management_item->commission_rate / 100),
                            'type'                      => 0,
                            'case_id'                   => $caseList->id,
                            'case_disburse_detail_id'   => $rowCaseDisburse->case_disburse_detail->id,
                            'user_id'                   => $management_item->user->id,
                        ]);
                    }

                    //get team's Commission
                    foreach ($team as $team_key => $team_item){
                        array_push($overriding_array, [
                            'name'                      => $team_item->team_lead->name,
                            'commission_rate'           => (double)$team_item->commission_percent,
                            'commission'                => $team_item->commission_percent == 0 ? 0 : ($service_fee_amount * $team_item->commission_percent / 100),
                            'type'                      => 1,
                            'case_id'                   => $caseList->id,
                            'case_disburse_detail_id'   => $rowCaseDisburse->case_disburse_detail->id,
                            'user_id'                   => $team_item->team_lead->id,
                        ]);
                    }

                    //update the case disburse details
                    CaseDisburseDetails::where('case_disburse_id', $rowCaseDisburse->id)->update([
                        'bfe_name'                  => $bfe_name,
                        'bfe_commission_rate'       => $bfe_commission_percent,
                        'bfe_commission'            => $bfe_commission,
                        'banker_name'               => $banker_name,
                        'banker_commission_rate'    => $banker_commission_percent,
                        'banker_commission'         => $banker_commission,
                    ]);

                    //create the case overriding
                    foreach ($overriding_array as $overriding_key => $overriding_item){
                        $check_case_overriding = CaseOverridings::where('case_id', $caseList->id)
                            ->where('case_disburse_detail_id', $rowCaseDisburse->case_disburse_detail->id)
                            ->where('user_id', $overriding_item['user_id']);

                        if ($check_case_overriding->first()){
                            $check_case_overriding->where('user_id', $overriding_item['user_id'])
                                ->update($overriding_item);
                        }
                        else{
                            CaseOverridings::create($overriding_item);
                        }
                    }
                }
                // message
                $message = 'Submit Successfully.';
                return redirect()->route('admin.case-lists.show-agreement',[$request->case_list_id,'#agmt'])->with('message', $message);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return redirect()->route('admin.case-lists.show-agreement',[$request->case_list_id,'#agmt'])->withErrors([$message]);
            }
        } else {
            try{
                $caseList = CaseList::find($request->case_list_id);
                // update case disburse
                $CaseDisburse = CaseDisburse::where('case_list_id',$request->case_list_id)->orderBy('current_stage','ASC')->get();
                foreach($CaseDisburse as $key => $rowCaseDisburse){
                    $approved_amount = $rowCaseDisburse->approved_amount;
                    $percent = $request->input('service_fee_percent')[$key];
                    $service_fee_amount = $approved_amount*($percent/100);

                    CaseDisburse::find($rowCaseDisburse->id)->update([
                        'service_fee_percent'   => $percent,
                        'service_fee_amount'    => $service_fee_amount,
                    ]);

                    //declare BFE's commission query
                    $user = User::with('class')->where('id', $caseList->salesman_id)
                            ->whereHas('class', function ($query){
                                $query?->with('commission_setting_details');
                            })
                            ->first() ?? User::where('id', $caseList->salesman_id)->first();

                    $bfe_commission_details = $user?->class()?->first()?->commission_setting_details ?? array();

                    //declare Banker's commission query
                    $banker = BankOfficer::with('bank')?->where('id', $rowCaseDisburse->bank_officer_id)
                        ->whereHas('bank', function ($query) use ($rowCaseDisburse){
                            $query->where('id', $rowCaseDisburse->bank_id);
                        })
                        ->first();

                    //declare Management's commission query
                    $management = Managements::with('user')->get();

                    //declare team's commission query
                    $team = Team::with(['team_lead','users'])
                        ->whereHas('team_lead', function ($query) use ($caseList){
                            $query->where('id', $caseList->salesman_id);
                        })
                        ->orWhereHas('users', function ($query) use ($caseList){
                            $query->where('id', $caseList->salesman_id);
                        })->get();

                    //get BFE's data
                    $bfe_commission_percent     = 0;

                    foreach ($bfe_commission_details as $bfe_commission_detail_key => $bfe_commission_detail_item){

                        if ($service_fee_amount >= $bfe_commission_detail_item->range_fee){
                            $bfe_commission_percent     = $bfe_commission_detail_item->rate;
                            break;
                        }
                        else{
                            $bfe_commission_percent = 0;
                        }

                    }

                    $bfe_name                   = $user->name ?? '';
                    $bfe_commission             = $bfe_commission_percent == 0 ? 0 : ($service_fee_amount * $bfe_commission_percent / 100);

                    //get Banker's data
                    $banker_name                = $banker->name ?? '';
                    $banker_commission_percent  = $banker->commission ?? 0;
                    $banker_commission          = $banker_commission_percent == 0 ? 0 : ($service_fee_amount * $banker_commission_percent / 100);

                    $overriding_array           = array();

                    //get Management's Commission
                    foreach ($management as $management_key => $management_item){
                        array_push($overriding_array, [
                            'name'                      => $management_item->user->name,
                            'commission_rate'           => (double)$management_item->commission_rate,
                            'commission'                => $management_item->commission_rate == 0 ? 0 : ($service_fee_amount * $management_item->commission_rate / 100),
                            'type'                      => 0,
                            'case_id'                   => $caseList->id,
                            'case_disburse_detail_id'   => $rowCaseDisburse->case_disburse_detail->id,
                            'user_id'                   => $management_item->user->id,
                        ]);
                    }

                    //get team's Commission
                    foreach ($team as $team_key => $team_item){
                        array_push($overriding_array, [
                            'name'                      => $team_item->team_lead->name,
                            'commission_rate'           => (double)$team_item->commission_percent,
                            'commission'                => $team_item->commission_percent == 0 ? 0 : ($service_fee_amount * $team_item->commission_percent / 100),
                            'type'                      => 1,
                            'case_id'                   => $caseList->id,
                            'case_disburse_detail_id'   => $rowCaseDisburse->case_disburse_detail->id,
                            'user_id'                   => $team_item->team_lead->id,
                        ]);
                    }

                    //update the case disburse details
                    CaseDisburseDetails::where('case_disburse_id', $rowCaseDisburse->id)->update([
                        'bfe_name'                  => $bfe_name,
                        'bfe_commission_rate'       => $bfe_commission_percent,
                        'bfe_commission'            => $bfe_commission,
                        'banker_name'               => $banker_name,
                        'banker_commission_rate'    => $banker_commission_percent,
                        'banker_commission'         => $banker_commission,
                    ]);

                    //create the case overriding
                    foreach ($overriding_array as $overriding_key => $overriding_item){
                        $check_case_overriding = CaseOverridings::where('case_id', $caseList->id)
                            ->where('case_disburse_detail_id', $rowCaseDisburse->case_disburse_detail->id)
                            ->where('user_id', $overriding_item['user_id']);

                        if ($check_case_overriding->first()){
                            $check_case_overriding->where('user_id', $overriding_item['user_id'])
                                ->update($overriding_item);
                        }
                        else{
                            CaseOverridings::create($overriding_item);
                        }
                    }
                }
                // message
                $message = 'Submit Successfully.';
                return redirect()->route('admin.case-lists.show-agreement',[$request->case_list_id,'#agmt'])->with('message', $message);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                return redirect()->route('admin.case-lists.show-agreement',[$request->case_list_id,'#agmt'])->withErrors([$message]);
            }
        }
    }

    public function showAgreementBillingAjax(Request $request){

        $case_id        = $request->case_id;
        $platform       = $request->platform; // case disburse details id
        $invoice_type   = $request->invoiceType;
        $preview        = 1;
        $printable      = 1;
        if($request->invoiceType == NULL){
            $returnHTML = view('admin.caseLists.print.empty')->render();
        } else {
            if ($invoice_type == 0) {
                // Proforma Invoice
                $caseList = CaseList::find($case_id);
                $caseDirectorCommitment = CaseDirectorCommitment::where('case_id',$case_id)
                    //->where('primary_type',1)
                    ->groupBy('director_id')->first();
                $proforma = Proformas::where('case_id',$case_id)->where('case_disburse_detail_id', $platform)->first();
                $proforma_content = [
                    'invoice_no' => $proforma->file_num ?? '',
                    'date' => date("d/m/Y"),
                    'term' => '-',
                ];

                $caseDisbursement = CaseDisburse::with('details')->whereHas('case_disburse_detail', function ($query) use ($platform){
                    $query->where('id', $platform);
                })->first();

                $returnHTML = view('admin.caseLists.print.components.proforma',compact('preview','caseList','proforma_content','caseDirectorCommitment','caseDisbursement','proforma'))->render();
            } else if($invoice_type == 1){
                // Invoice
                $caseList = CaseList::find($case_id);
                $caseDisbursement = CaseDisburse::with('details')->whereHas('case_disburse_detail', function ($query) use ($platform){
                    $query->where('id', $platform);
                })->first();
                $case_disburse_detail_id = $caseDisbursement->case_disburse_detail->id;
                $invoice = Invoice::where('case_disburse_detail_id',$case_disburse_detail_id)->first();
                $caseDirectorCommitment = CaseDirectorCommitment::where('case_id',$case_id)->groupBy('director_id')->first();
                $returnHTML = view('admin.caseLists.print.components.invoice',compact('preview','caseList','invoice','caseDirectorCommitment','caseDisbursement'))->render();
                if($invoice->file_num == '' || $invoice->file_num == NULL){ $printable = 0; }
            }
        }

        return response()->json([
            'type' => $request->invoiceType,
            'printable' => $printable,
            'content' => $returnHTML,
        ]);
    }

    public function proformaUpdate(Request $request)
    {
        try{
            Proformas::where('case_id',$request->case_id)->update(['description' => $request->description]);
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->with('message','Update Successfully.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->withErrors([$message]);
        }
    }

    public function invoiceUpdate(Request $request)
    {
        try{
            Invoice::where('case_id',$request->case_id)->update(['description' => $request->description]);
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->with('message','Update Successfully.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->withErrors([$message]);
        }
    }

    public function invoiceGenerateNo(Request $request)
    {
        try{
            $year = date("Y");$month = date('n');
            $invoice_front = 'IV-'.substr($year, -2);
            if($request->input('auto_generate') !== NULL){
                $last_invoice = Invoice::where('year',$year)->orderBy('running_number','desc')->first();
                $running_number = ($last_invoice->running_number ?? 0)+1;
                $invoice_middle = sprintf('%04d', $running_number);
                $invoice_no = $invoice_front.$invoice_middle;
            } elseif($request->input('reuse') !== NULL){
                $running_number = NULL;
                $invoice_no = $request->reuse_no;
            }
            $invoice = Invoice::find($request->invoice_id);
            $invoice->update([
                'file_num' => $invoice_no,
                'running_number' => $running_number,
                'year' => $year,
                'month' => $month,
            ]);
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->with('message','Action Successfully.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#billing'])->withErrors([$message]);
        }
    }
}
