<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyUser extends Model
{

    //Nombre de la tabla
    protected $table = 'academy_users';

    //Desactivamos timestamps
    public $timestamps = false;

    protected $fillable = [
        'academy_id',
        'user_id',
    ];

    //La relacion belongsTo indica que academyUser pertenece a un Academy
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    //La relacion belongsTo indica que academyUser pertenece a un User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
