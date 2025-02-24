<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthPermissionGroup extends Model
{
    protected $table = 'auth_group_permission';
    protected $fillable = [
        'group_id',
        'permission_id',
    ];


    public function permissions()
    {
        return $this->hasMany(AuthPermission::class, 'group_id');
    }

    public function groups()
    {
        return $this->hasMany(AuthGroup::class, 'permission_id');
    }
}
