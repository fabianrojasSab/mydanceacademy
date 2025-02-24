<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;

class Schedule extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'schedules';

    protected $fillable = [
        'lesson_id',
        'teacher_id',
        'day',
        'start_time',
        'end_time',
        'capacity',
        'date'
    ];

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    public function teachers()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    //funcion para que me traiga el nombre de los profesores sin repetir
    public function getTeachersAttribute()
    {
        return $this->teachers()->get()->unique('id');
    }

    //funcion para la relacion con la tabla presences
    public function presences()
    {
        return $this->belongsToMany(User::class, 'presences', 'schedule_id', 'teacher_id');
    }
}
