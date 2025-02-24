<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthPermission extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content_type_id',
        'name',
        'codename',
    ];

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }
}
