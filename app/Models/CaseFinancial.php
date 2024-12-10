<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class CaseFinancial extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $casts = [
//        'financial_date' => 'datetime',
    ];

    protected $guarded = [];

    public $table = 'case_financials';

    protected $fillable = [
        'current_asset',
        'non_current_asset',
        'director_asset',
        'related_customer_asset',
        'customer_asset',
        'current_liabilities',
        'non_current_liabilities',
        'director_liabilities',
        'related_customer_liabilities',
        'customer_liabilities',
        'loan_n_hp',
        'share_capital',
        'revenue',
        'sales_cost',
        'finance_cost',
        'depreciation',
        'profit',
        'tax',
        'financial_date',
        'other_asset',
        'other_liabilities',
        'current_maturity',
        'retained_earnings',
        'tnw',
        'gross_profit',
        'profit_bfr_tax',
        'profit_aft_tax',
        'ebitda',
        'equity',
        'auditor',
        'created_at',
        'updated_at',
        'deleted_at',
        'group_id',
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
