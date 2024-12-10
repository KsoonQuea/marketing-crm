<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Permission extends \Spatie\Permission\Models\Permission
{
    use SoftDeletes;
    use HasFactory;
    use Auditable;

    public function permission_group(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class);
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
