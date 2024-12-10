<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseCreditCheck extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function credit_check()
    {
        return $this->belongsTo(CaseCreditCheckType::class, 'credit_check_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
