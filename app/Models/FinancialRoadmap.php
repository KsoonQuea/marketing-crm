<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class FinancialRoadmap extends Model
{
    use InteractsWithMedia;
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    // const
    public const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Confirm',
    ];

    public const STATUS_CLASSES = [
        '0' => 'muted',
        '1' => 'green',
    ];

    public $table = 'financial_roadmaps';

    protected $fillable = [
        'company_name',
        'business_industry',
        'contact_person',
        'contact_number',
        'email',

        'default_turnover_percent',
        'default_cogs_percent',
        "default_gross_profit_percent",
        "default_general_expenses_percent",
        "default_finance_cost_percent",
        "default_inventories_percent",
        "default_trade_receivables_percent",
        "default_trade_payables_percent",
        "default_eligibility_percent",
        "edit_status",

        "user_id",

        "status",

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function business_industry()
    {
        return $this->belongsTo(IndustryType::class, 'business_industry');
    }

    public function financial_roadmap()
    {
        return $this->belongsTo(FinancialRoadmapData::class, 'financial_roadmap_id');
    }
}
