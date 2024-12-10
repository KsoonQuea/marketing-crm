<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseDisburseDetails extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const ACCOUNT_STAGE = [
        '0' => 'None',
        '1' => 'Sales, Collection',
        '2' => 'Sales, Collection, Outstanding',
        '3' => 'Sales, Collection, Outstanding (Part Payment)',
        '4' => 'Sales, Collection, Outstanding, Commission (Fully Payment)',
    ];

    public const PAYMENT_STATUS = [
        '0' => 'None',
        '1' => 'Part Of Payment',
        '2' => 'Completed Payment',
    ];

    public $table = 'case_disburse_details';

    protected $fillable = ['bfe_name', 'bfe_commission_rate', 'bfe_commission', 'bfe_commission_pay_day', 'banker_name', 'banker_commission_rate', 'banker_commission', 'banker_commission_pay_day', 'account_stage', 'payments_status', 'case_disburse_id', 'sst_paid_date'];

    public function case_disburses()
    {
        return $this->belongsTo(CaseDisburse::class,'case_disburse_id');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class,'case_disburse_detail_id','id');
    }
}
