<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroupTitle extends Model
{
    public $table = 'permission_group_titles';

    protected $guarded = ['id'];

    protected $fillable = [
        'name',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function permission_groups()
    {
//        return $this->hasMany(PermissionGroup::class);
        return $this->hasMany(PermissionGroup::class, 'title_id');
    }

//    public function permissionGroupTitle()
//    {
//        return $this->hasMany(PermissionGroupTitle::class, 'title_id')->orderBy('created_at', 'desc');
//    }
}
