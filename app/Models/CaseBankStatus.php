<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseBankStatus extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [  //actually is stage
        '0' => 'pending',
        '1' => 'approve',
        '2' => 'reject',
    ];

    public const CURRENT_STATUS = [  //ACTUALLY IS STAGE
        '1' => 'Offer',
        '2' => 'Agreement',
        '3' => 'Site Visit',
        '4' => 'Case Submission',
        '5' => 'Approval',
        '6' => 'Acceptance',
        '7' => 'Disbursement',
    ];

    public $table = 'case_bank_status';

    protected $fillable = [
        'date',
        'stage',
        'amount',
        'case_id',
        'bank_id',
        'user_id',
        'bank_status_id',
        'memo_id',
        'case_bank_id',
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
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bank_status()
    {
        return $this->belongsTo(BankStatus::class, 'bank_status_id');
    }

    public function case_bank()
    {
        return $this->belongsTo(CaseBank::class, 'case_bank_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
