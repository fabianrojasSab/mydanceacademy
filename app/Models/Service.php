<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //sin timestamps
    public $timestamps = false;

    protected $table = 'services';
    protected $fillable = ['academy_id', 'name', 'description', 'price'];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_services', 'service_id', 'lesson_id');
    }
}
