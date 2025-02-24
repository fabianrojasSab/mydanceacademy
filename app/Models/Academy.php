<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    //Desactivar el timestamp
    public $timestamps = false;

    protected $table = 'academies';
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'state_id',
        'rating',
    ];


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }


    //La relacion hasMany indica que una academia puede tener muchos usuarios-academia
    public function academyUser()
    {
        return $this->hasMany(AcademyUser::class);
    }
}
