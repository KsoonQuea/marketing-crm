<?php

namespace App\Http\Controllers;

use App\Models\MasterCallList;
use App\Models\MasterCallUserTask;

class AssignPhoneToUserController extends Controller
{
    protected $users_id,$amount;

    public function __construct()
    {

    }

    public function assignPhone($users_id,$amount)
    {
        $count = 0;
        foreach($users_id as $user_id){
            $MasterCallList = MasterCallList::select('id','master_call_batch_id')->where('status',0)->orderBy('id','ASC')->take($amount)->get();
            foreach($MasterCallList as $rowList){
                MasterCallUserTask::create([
                    'status' => 0,
                    'master_call_batch_id' => $rowList->master_call_batch_id,
                    'master_call_list_id' => $rowList->id,
                    'user_id' => $user_id,
                ]);
                $rowList->update(['status'=>1]);
                $count++;
            }
        }
        if($count > 0){
            $message = 'Success';
        } else {
            $message = 'No Result Found.';
        }
        return $message;
    }
}
