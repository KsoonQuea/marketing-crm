<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class commissionSettings extends Model
{
    use SoftDeletes;

    public $table = 'commission_settings';

    protected $fillable = [
        'class',
        'monthly_target',
        'quarterly_target',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function commission_setting_details()
    {
        return $this->hasMany(commissionSettingDetails::class);
    }
}
