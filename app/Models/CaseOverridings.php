<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaseOverridings extends Model
{
    use SoftDeletes;

    public const TYPE = [
        '0' => 'management',
        '1' => 'team leader',
    ] ;

    public $table = 'case_overridings';

    protected $fillable = ['name', 'commission_rate', 'commission', 'commission_pay_day', 'type', 'case_id', 'case_disburse_detail_id', 'user_id'];
}
