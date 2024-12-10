<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $table = 'audit_logs';

    protected $guarded = [];

    protected $casts = [
        'properties' => 'collection',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search['subject_type'])) {
            $query->where('subject_type', 'like',  '%'.$search['subject_type'] . '%');
        }
        if (isset($search['description'])) {
            $query->where('description', $search['description']);
        }
        if (isset($search['user_id'])) {
            $query->where('user_id', $search['user_id']);
        }
        return $query;
    }

}
