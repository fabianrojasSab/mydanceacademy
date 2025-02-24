<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    public $timestamps = false;

    protected $table = 'states';
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function academies()
    // {
    //     return $this->hasMany(Academy::class);
    // }
}
