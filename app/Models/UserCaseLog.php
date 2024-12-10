<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCaseLog extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    protected $guarded = [];

    public const STATUS_SELECT = [
        '1' => 'Checked',
        '2' => 'Rework',
        '3' => 'Resubmit',
        '4' => 'Reject',
        '5' => 'Drop',
    ];

    protected $fillable = [
        'user_role',
        'action',
        'remark',
        'user_id',
        'case_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function case()
    {
        return $this->belongsTo(CaseList::class, 'case_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function roles()
    {
        return $this->hasOne(Role::class, 'id', 'user_role');
    }
}
