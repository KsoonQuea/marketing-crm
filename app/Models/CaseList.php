<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CaseList extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    // const
    public const STATUS_SELECT = [
        '0' => 'Pending',       // case created/resubmitted
        '1' => 'Checked',      // case checked
        '2' => 'Rejected',      // Bank Rejected
        '3' => 'Rework',        // case reworked
        '4' => 'Completed',     // Bank Disburse
        '5' => 'Drop',          // case cancelled
        '6' => 'Approved',          // case Approved
    ];
    public const STATUS_CLASSES = [
        '0' => 'muted',
        '1' => 'green',
        '2' => 'danger',
        '3' => 'warning',
        '4' => 'primary',
        '5' => 'danger',
        '6' => 'success',
    ];
    public const DRAFT_SELECT = [
        '0' => 'Draft',
        '1' => 'Active',
    ];
    public const BRANCH_LIST = [
        '0' => 'HQ',
    ];
    public const PLATFORM_STATUS_SELECT = [
        '0' => 'Pending Offer',
        '1' => 'Pending Agreement',
        '2' => 'Pending Site Visit',
        '3' => 'Pending Case Submission',
        '4' => 'Pending Approval',
        '5' => 'Pending Acceptance',
        '6' => 'Pending Disbursement',
        '7' => 'Completed',
    ];

    // table name
    public $table = 'case_lists';

    // protected
    protected $casts = ['applicaion_date' => 'datetime'];
    protected $fillable = ['case_code', 'company_name', 'incorporation_date', 'bfe', 'business_activity', 'applicaion_date', 'business_bg', 'remark', 'address_1', 'address_2', 'postcode', 'salesmen_status', 'case_status', 'salesman_id', 'industry_type_id', 'city_id', 'state_id', 'country_id', 'address', 'draft_status', 'gearing_date', 'dsr_bankStt_commitment', 'cash_flow_factor', 'gearing_borrow', 'gearing_redemtion', 'approved_amount', 'service_fee_percentage', 'service_fee_amount', 'platform_status', 'case_branch', 'agreement_sign_date', 'created_by', 'bfe_commission_rate', 'team_commission_rate', 'agreement_signed_date'];
    protected $guarded = [];
    protected function applicaionDate(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? Carbon::parse($value)->format(config('panel.date_format')) : null,
            set: fn ($value) => $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null,
        );
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    // relationships
    public function salesman()
    {
        return $this->belongsTo(User::class, 'salesman_id');
    }
    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }
    public function industry_type()
    {
        return $this->belongsTo(IndustryType::class, 'industry_type_id');
    }
    public function application_types()
    {
        return $this->belongsToMany(ApplicationType::class)->orderBy('created_at', 'desc');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function case_logs()
    {
        return $this->hasMany(CaseCallLog::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function user_case_logs()
    {
        return $this->hasMany(UserCaseLog::class,'case_id')->orderBy('created_at', 'asc');
    }
    public function memos()
    {
        return $this->hasMany(Memo::class, 'case_id')->orderBy('created_at', 'desc');
    }
    public function case_bank_status()
    {
        return $this->hasMany(CaseBankStatus::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function director_commitment()
    {
        return $this->hasMany(CaseDirectorCommitment::class, 'case_id')->orderBy('created_at', 'desc');
    }
    public function request()
    {
        return $this->hasMany(CaseRequest::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function management_team()
    {
        return $this->hasMany(CaseManagementTeam::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function credit_check()
    {
        return $this->hasMany(CaseCreditCheck::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function bank_statement()
    {
        return $this->hasMany(BankStatement::class,'case_id')->orderBy('created_at', 'desc');
    }
    public function case_disburse()
    {
        return $this->hasMany(CaseDisburse::class,'case_list_id')->orderBy('created_at', 'desc');
//        return $this->hasOne(CaseDisburse::class,'case_list_id')->orderBy('created_at', 'desc');
    }
    public function case_criterion()
    {
        return $this->hasMany(CaseCriterion::class,'case_id')->orderBy('arrange', 'asc');
    }
    public function case_financial()
    {
        return $this->hasMany(CaseFinancial::class,'case_id');
    }
    public function case_commitment()
    {
        return $this->hasMany(CaseCommitment::class,'case_id');
    }
    public function case_financing_instruments()
    {
        return $this->hasMany(CaseFinancingInstrument::class,'case_id');
    }

    // scope
    public function scopeSearch($query, $search): Builder
    {
        if (isset($search['case_code'])) {
            $query->where('case_code', 'like', $search['case_code'] . '%');
        }

        return $query;
    }
}
