<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AccountController extends Controller
{
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

    public function __invoke()
    {

    }

    public function generatePDF($data)
    {
        ini_set('memory_limit', '512M');
        $preview_type = 1;
        $data['service_fee'] = reformatToNumeric($data['service_fee']);
        $service_fee = $data['service_fee'];
        $sst_status = $data['sst_status'];
        if($sst_status == 1){
            $sst_amount = $service_fee*0.06;
        } else{
            $sst_amount = 0;
        }
        $file_num = '';
        switch($data['selection']){
            case '1':$file_num = $data['auto_generate_inv_no']; break;
            case '2':$file_num = $data['re_use_inv_no']; break;
            case '3':$file_num = $data['file_num']; break;
        }
        $total_amount = $service_fee+$sst_amount;
        $other_data = [
            'service_fee' => $service_fee,
            'number_word' => strtoupper(convertNumberToWord($total_amount)),
            'sst_amount' => $sst_amount,
            'total_amount' => $total_amount,
            'file_num' => $file_num,
        ];
        $pdf = PDF::setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        $pdf->loadView('admin.accounts.components.invoice-pdf', compact(
            'preview_type','data','other_data'
        ),[],'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('disbursement-invoice.pdf');
    }
}
