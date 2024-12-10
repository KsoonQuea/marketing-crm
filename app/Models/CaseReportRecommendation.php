<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class CaseReportRecommendation extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public $table = 'case_report_recommendations';

    protected $fillable = [
        'recommendation',
        'date',
        'case_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function date(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? Carbon::parse($value)->format(config('panel.date_format')) : null,
            set: fn ($value) => $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null,
        );
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
