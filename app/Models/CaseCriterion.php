<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseCriterion extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const ANSWER_SELECT = [
        '0' => 'Please Select',
        '1' => 'YES',
        '2' => 'NO',
        '3' => 'NA',
    ];

    protected $guarded = [];

    public $table = 'case_criteria';

    protected $fillable = [
        'answer',
        'arrange',
        'case_id',
        'criteria_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
