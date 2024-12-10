<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseRequest extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function request_type()
    {
        return $this->belongsTo(RequestType::class, 'request_type_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
