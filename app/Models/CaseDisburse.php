<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseDisburse extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'case_disburses';

    protected $fillable = [
        'current_stage',
        'agreement_sign_date',
        'approved_amount',
        'service_fee_percent',
        'service_fee_amount',
        'loan_disbursement_date',
        'remark',
        'user_id',
        'case_list_id',
        'bank_id',
        'created_at',
        'updated_at',
        'deleted_at', 'unique_num', 'bank_officer_id', 'approval_date'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function case_list()
    {
        return $this->belongsTo(CaseList::class, 'case_list_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function case_disburse_detail(){
        return $this->hasOne(CaseDisburseDetails::class, 'case_disburse_id');
    }

    public function details()
    {
        return $this->hasMany(CaseDisburseDetails::class);
    }

}
