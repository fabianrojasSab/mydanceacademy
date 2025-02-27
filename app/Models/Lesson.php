<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Inscripciones;
use App\Models\Academy;
use App\Models\TeacherLesson;
use Illuminate\Support\Facades\DB;  // Asegúrate de importar DB
use App\Models\Service;

class Lesson extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo

    protected $table = 'lessons';

    protected $fillable = [
        'name',
        'description',
        'duration',
        'start_date',
        'end_date',
        'state',
        'academy_id',
        'service_id'
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
    
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'lesson_id');
    }

    public static function inscriptionsByStudent($studentId)
    {
        return self::whereHas('inscriptions', function($query) use ($studentId) {
            $query->where('user_id', $studentId);
        })->get();
    }

    public function services()
    {
        return self::belongsTo(Service::class, 'service_id');
    }
}
