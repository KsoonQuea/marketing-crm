<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Director extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const GENDER_SELECT = [
        '0' => 'Male',
        '1' => 'Female',
    ];

    public const MARITAL_STATUS_SELECT = [
        '0' => 'Single',
        '1' => 'Married',
        '2' => 'Separated',
        '3' => 'Divorced',
        '4' => 'Widowed',
        '5' => 'Annulled',
    ];

    public $table = 'directors';

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'ic',
        'email',
        'phone',
        'gender',
        'marital_status',
        'address_1',
        'address_2',
        'postcode',
        'city_id',
        'state_id',
        'country_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

    public function case()
    {
        return $this->belongsToMany(CaseList::class, CaseDirectorCommitment::class, 'director_id', 'case_id');
    }

    public function scopeSearch($query, $search): Builder
    {
        if (isset($search['name'])) {
            $query->where('name', 'like', $search['name'] . '%');
        }

        if (isset($search['ic'])) {
            $query->where('ic', 'like', $search['ic'] . '%');
        }

        return $query;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
