<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassUser extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'class_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
