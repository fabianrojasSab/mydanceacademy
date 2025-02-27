<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Schedule;

class Presence extends Model
{
    protected $table = 'presences';

    protected $fillable = [
        'schedule_id',
        'teacher_id',
        'created_at',
        'updated_at',
        'status'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
