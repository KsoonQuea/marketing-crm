<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class PermissionGroup extends Model
{
    use HasFactory;
    use Auditable;

    public $timestamps = false;

    protected $guarded = ['id'];

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Permission::class);
    }

    public function permissionGroupTitle()
    {
        return $this->hasMany(PermissionGroupTitle::class, 'title_id')->orderBy('created_at', 'desc');
    }
}
