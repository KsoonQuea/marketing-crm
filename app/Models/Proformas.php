<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proformas extends Model
{
    use SoftDeletes;

    public $table = 'proformas';

    protected $fillable = [
        'date',
        'file_num',
        'case_disburse_detail_id',
        'description',
        'case_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class,'case_id');
    }

    public function case_disburse_detail()
    {
        return $this->belongsTo(CaseDisburseDetails::class,'case_disburse_detail_id');
    }
}
