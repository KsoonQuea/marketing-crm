<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Models\CaseDisburse;
use App\Models\CaseDisburseDetails;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    use MediaUploadingTrait;

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

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Payments $payments)
    {
        //
    }

    public function edit(Payments $payments)
    {
        //
    }

    public function update(Request $request, Payments $payments)
    {
        //
    }

    public function destroy(Payments $payments)
    {
        //
    }

    public function uploadPayslip(Request $request)
    {
        try{
            $paid_amount = $request->get('paid_amount');
            $paid_amount = $this->reformatToNumeric($paid_amount);

            $request->merge(['paid_amount' => $paid_amount]);

            $payment = Payments::create($request->all());

            foreach ($request->input('document', []) as $file) {
                $payment->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
            }

            $all_payment_amount = Payments::where('case_disburse_detail_id', $request->case_disburse_detail_id)->sum('paid_amount');
            $service_amount     = CaseDisburseDetails::with('case_disburses')->where('id', $request->case_disburse_detail_id)->first()->case_disburses->service_fee_amount * 1.06;

            if ($all_payment_amount >= (double)$service_amount){
                CaseDisburseDetails::where('id', $request->case_disburse_detail_id)->update([
                    'account_stage' => 4
                ]);
            }
            else{
                CaseDisburseDetails::where('id', $request->case_disburse_detail_id)->update([
                    'account_stage' => 3
                ]);
            }

            DB::commit();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->with('message','Upload successfully.');
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = 'Upload failed.'.$e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->withErrors($error_msg);
        }
    }

    public function createPayslip(Request $request)
    {
        try{
            $case_disburse_ids = CaseDisburse::where('case_list_id',$request->case_id)->pluck('id')->toArray();

            $paid_amount = $request->get('paid_amount');
            $paid_amount = $this->reformatToNumeric($paid_amount);
            $request->merge(['paid_amount' => $paid_amount]);

            foreach($request->bank_paid_amount as $bank_id => $bank_paid_amount){

                $bank_paid_amount = $this->reformatToNumeric($bank_paid_amount);

                $case_disburse_id = CaseDisburse::where('case_list_id',$request->case_id)->where('bank_id',$bank_id)->first();
                $case_disburse_detail_id = CaseDisburseDetails::where('case_disburse_id',$case_disburse_id->id)->first();
                $payment = Payments::create([
                    'date' => $request->date,
                    'cheque_no' => $request->cheque_no,
                    'case_id' => $request->case_id,
                    'case_disburse_detail_id' => $case_disburse_detail_id->id,
                    'paid_amount' => $bank_paid_amount,
                ]);

                foreach ($request->input('document', []) as $file) {
                    $payment->addMedia(storage_path('tmp/uploads/' . basename($file)))->preservingOriginal()->toMediaCollection('document');
                }

                $all_payment_amount = Payments::where('case_disburse_detail_id', $case_disburse_detail_id->id)->sum('paid_amount');
                $service_amount     = CaseDisburseDetails::with('case_disburses')->where('id', $case_disburse_detail_id->id)->first()->case_disburses->service_fee_amount * 1.06;

                if ($all_payment_amount >= (double)$service_amount){
                    CaseDisburseDetails::where('id', $case_disburse_detail_id->id)->update([
                        'account_stage' => 4
                    ]);
                }
                else{
                    CaseDisburseDetails::where('id', $case_disburse_detail_id->id)->update([
                        'account_stage' => 3
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->with('message','Upload successfully.');
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = 'Upload failed.'.$e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->withErrors($error_msg);
        }
    }

    public function updatePayslip(Request $request)
    {
        try{
            $paid_amount = $request->get('paid_amount');
            $paid_amount = $this->reformatToNumeric($paid_amount);
            $request->merge(['paid_amount' => $paid_amount]);
            $payment = Payments::find($request->payment_id);
            if($payment){ $payment->update($request->all()); }
            if($request->done_btn == '1'){
                $payment->update(['status' => 1]);
            }
            DB::commit();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->with('message','Update successfully.');
        } catch (\Exception $e){
            DB::rollback();
            $error_msg = 'Update failed.'.$e->getMessage();
            return redirect()->route('admin.case-lists.show-agreement',[$request->case_id,'#payslip'])->withErrors($error_msg);
        }
    }

    public function fetchData(Request $request)
    {
        $payment = Payments::find($request->id) ?? NULL;
        $doc = [];
        foreach($payment->document as $document){
            $d['url'] = $document->url;
            $d['file_name'] = $document->file_name;
            array_push($doc,$d);
        }
        return response()->json([
            'documents' => $doc,
            'payment' => $payment,
        ]);
    }

    public function removePayment(Request $request)
    {
        $payment = Payments::find($request->id);
        if($payment){ $payment->delete(); }
        return redirect()->back();
    }

    public function updateStatus(Request $request)
    {
        $payment = Payments::find($request->id);
        if($payment && $request->status == '0'){
            $payment->update(['status' => 1]);
        }
        return redirect()->back();
    }
}
