<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lesson;


class StudentLesson extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'student_lessons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lesson_id',
        'student_id',
        'inscription_date'
    ];

    //relacion con los estudiantes
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    //relacion con las clases
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
