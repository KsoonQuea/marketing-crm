<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class commissionSettingDetails extends Model
{
    use SoftDeletes;

    public $table = 'commission_setting_details';

    protected $fillable = [
        'rate',
        'range',
        'range_fee',
        'commission_settings_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function commission_settings()
    {
        return $this->belongsTo(commissionSettings::class, 'commission_settings_id');
    }
}
