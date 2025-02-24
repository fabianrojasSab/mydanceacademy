<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthGroup extends Model
{
    protected $table = 'auth_group';
    protected $fillable = [
        'name',
        // 'description',
    ];
}
