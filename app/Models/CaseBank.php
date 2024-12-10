<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseBank extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const CURRENT_STATUS = [  //ACTUALLY IS STAGE
        '1' => 'Offer',
        '2' => 'Agreement',
        '3' => 'Site Visit',
        '4' => 'Case Submission',
        '5' => 'Approval',
        '6' => 'Acceptance',
        '7' => 'Disbursement',
    ];

    public const CURRENT_STAGE = [  //ACTUALLY IS STATUS
        '0' => 'pending',
        '1' => 'approve',
        '2' => 'reject',
    ];

    public $table = 'case_banks';

    protected $fillable = [
        'current_stage',
        'current_status',
        'current_bank_id',
        'case_id',
        'bank_officer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'current_bank_id');
    }

    public function case_bank_status()
    {
        return $this->hasMany(CaseBankStatus::class);
    }

    public function bank_officer()
    {
        return $this->belongsTo(BankOfficer::class, 'bank_officer_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
