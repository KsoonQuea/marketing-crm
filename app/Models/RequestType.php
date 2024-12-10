<?php

namespace App\Models;

use App\Enum\Status;
use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestType extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => Status::class,
    ];

    public $table = 'request_types';

    protected $attributes = [
        'status' => Status::Active,
    ];

    public function scopeActive($query): Builder
    {
        return $query->whereStatus(Status::Active);
    }

    public function scopeInactive($query): Builder
    {
        return $query->whereStatus(Status::Inactive);
    }

    public function scopeSearch($query, $search): Builder
    {
        if (isset($search['name'])) {
            $query->where('name', 'like', $search['name'] . '%');
        }
        if (isset($search['status'])) {
            $query->where('status', $search['status']);
        }

        return $query;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
