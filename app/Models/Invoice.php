<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    public const GENERATE_TYPE = [
        '0' => 'none',
        '1' => 'auto-generate',
        '2' => 'reuse',
    ];

    public const DISBURSEMENT_TYPE = [
        '0' => 'invoice',
        '1' => 'reimbursement invoice',
        '2' => 'burned invoice',
    ];

    public const SST_STATUS = [
        '0' => 'none',
        '1' => 'have SST',
    ];

    public $table = 'invoices';

    protected $fillable = ['date', 'file_num', 'company_name', 'description', 'generate_type', 'disbursement_type', 'case_id', 'case_disburse_detail_id', 'running_number', 'year', 'month', 'company_address', 'contact_person', 'contact_phone', 'service_fee', 'sst_status', 'company_address_1', 'company_address_2', 'company_address_3'];

    public function case()
    {
        return $this->belongsTo(CaseList::class,'case_id');
    }

    public function case_disburse_detail()
    {
        return $this->belongsTo(CaseDisburseDetails::class,'case_disburse_detail_id');
    }
}
