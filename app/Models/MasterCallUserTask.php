<?php

namespace App\Models;
use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCallUserTask extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Called',
    ];

    public const RESPONSE_STATUS_SELECT = [
        '0' => 'Before Call',
        '1' => 'Callback/Busy',
        '2' => 'Not Interested',
        '3' => 'Unqualified',
        '4' => 'Interested',
        '5' => 'Do not call list',
    ];

    public const RESPONSE_STATUS_CLASSES = [
        '0' => 'muted',
        '1' => 'warning',
        '2' => 'danger',
        '3' => 'muted',
        '4' => 'green',
        '5' => 'red-box',
    ];

    public $table = 'master_call_user_tasks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'status',
        'response_status',
        'master_call_batch_id',
        'master_call_list_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function batch()
    {
        return $this->belongsTo(MasterCallBatch::class, 'master_call_batch_id');
    }

    public function list()
    {
        return $this->belongsTo(MasterCallList::class, 'master_call_list_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
