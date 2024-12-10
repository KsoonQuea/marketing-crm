<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseCommitment extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public $table = 'case_commitments';

    protected $fillable = [
        'house_loan',
        'term_loan',
        'hire_purchase',
        'credit_card_limit',
        'trade_line_limit',
        'total_hl',
        'total_tl',
        'total_hp',
        'total_cc',
        'total_trade_line',
        'cc_charge',
        'tl_charge',
        'final_total',
        'created_at',
        'updated_at',
        'deleted_at',
        'case_id',
    ];

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
