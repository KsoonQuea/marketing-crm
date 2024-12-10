<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankStatement extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public $table = 'bank_statements';

    protected $fillable = [
        'bank_owner',
        'bank_account',
        'credit',
        'debit',
        'month_end_balance',
        'currency',
        'month',
        'avg_credit',
        'avg_debit',
        'avg_month_end_balance',
        'total_avg_credit',
        'total_avg_debit',
        'total_avg_month_end_balance',
        'bank_id',
        'case_id',
        'group_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
