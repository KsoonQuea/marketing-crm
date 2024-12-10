<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use App\Traits\Auditable;

class CaseCallLog extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

//    protected $casts = [
//        'datetime' => 'datetime',
//    ];

    public $table = 'case_call_logs';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'datetime',
    ];

    protected $fillable = [
        'details',
        'datetime',
        'phone',
        'response_status',
        'user_id',
        'case_id',
        'master_call_list_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    public function list()
    {
        return $this->belongsTo(MasterCallList::class, 'master_call_list_id');
    }

    protected function datetime(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format').' '.config('panel.time_format')) : null,
            set: fn ($value) => $value ? Carbon::createFromFormat(config('panel.date_format').' '.config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
