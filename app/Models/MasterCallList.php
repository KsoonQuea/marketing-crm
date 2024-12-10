<?php

namespace App\Models;
use App\Traits\Auditable;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCallList extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public const STATUS_SELECT = [
        '0' => 'Pending',
        '1' => 'Assigned',
        '2' => 'Called',
        '3' => 'Added To Case',
    ];

    public const STATUS_CLASSES = [
        '0' => 'muted',
        '1' => 'primary',
        '2' => 'info',
        '3' => 'green',
    ];

    public $table = 'master_call_lists';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'ic',
        'phone',
        'company_name',
        'company_description',
        'company_address',
        'revenue',
        'status',
        'master_call_batch_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function batch()
    {
        return $this->belongsTo(MasterCallBatch::class, 'master_call_batch_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
