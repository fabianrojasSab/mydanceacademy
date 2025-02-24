<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiantes extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo
    
    protected $fillable = [
        'id',
        'email',
        'fecha_nacimiento',
        'fecha_registro',
        'nombre',
        'telefono'
    ];
}
