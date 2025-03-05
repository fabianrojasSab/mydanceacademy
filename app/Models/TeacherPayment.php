<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPayment extends Model
{
    public $timestamps = false;

    protected $table = 'teacher_payments';

    protected $fillable = [
        'teacher_id',
        'payment_method_id',
        'amount',
        'payment_date',
        'lesson_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
