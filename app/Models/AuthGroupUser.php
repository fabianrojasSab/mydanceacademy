<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthGroupUser extends Model
{
    protected $table = 'auth_group_user';
    protected $fillable = [
        'group_id',
        'user_id',
    ];

    public function groups()
    {
        return $this->hasMany(AuthGroup::class, 'group_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
