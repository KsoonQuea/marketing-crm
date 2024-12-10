<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class CaseGearing extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $guarded = [];

    protected function date(): Attribute
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
}
