<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseFinancingInstrument extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public $table = 'case_financing_instruments';

    protected $fillable = [
        'proposed_limit',
        'interest_rate',
        'tenor',
        'total_proposed_limit',
        'total_commitments',
        'commitments',
        'created_at',
        'updated_at',
        'deleted_at',
        'case_id',
        'financing_instrument_id',
    ];

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function financing_instrument()
    {
        return $this->belongsTo(FinancingInstrument::class, 'financing_instrument_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
