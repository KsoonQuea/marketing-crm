<?php

namespace App\Models;
use \DateTimeInterface;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCallBatch extends Model
{
    use SoftDeletes;
    use Auditable;
    use HasFactory;

    public $table = 'master_call_batches';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function lists()
    {
        return $this->hasMany(MasterCallList::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
