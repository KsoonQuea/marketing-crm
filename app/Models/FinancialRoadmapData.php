<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;

class FinancialRoadmapData extends Model
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

    public $table = 'financial_roadmap_data';

    protected $fillable = [
        'financial_year',
        'turnover',
        'cogs',
        'gross_profit',
        'depreciation_expenses',
        'finance_cost',
        'profit_bfr_tax',
        'tax',
        'profit_aft_tax',
        'inventories',
        'trade_receivables',
        'trade_payables',
        'share_capital',
        'retained_earnings',
        'net_worth',
        'annual_debts',
        'net_cash',
        'group_id',
        'financial_roadmap_id',
        'general_expenses',
        'working_capital_eligibility',
        'existing_loan',
        'financing_term_loan',
        'financing_overdraft',
        'financing_trade_line',
        'financing_property_loan',
        'total_loan_amount',
        'repayment_term_property_loan',
        'repayment_od_trade',
        'repayment_term_loan',
        'repayment_overdraft',
        'repayment_trade_line',
        'repayment_property_loan',
        'annual_repayment',
        'ebitda',
        'total_outstanding_loan_amount',
        'dscr',
        'gearing_ratio',
        'facilities_required',
        'edit_status',

        'turnover_percent',
        'cogs_percent',
        'gross_profit_percent',
        'general_expenses_percent',
        'profit_bfr_tax_percent',
        'tax_percent',
        'profit_aft_tax_percent',
        'inventories_percent',
        'trade_receivables_percent',
        'trade_payables_percent',
    ];

    public function financial_roadmap()
    {
        return $this->belongsTo(FinancialRoadmap::class, 'financial_roadmap_id');
    }
}
