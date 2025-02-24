<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherPaymentSetting extends Model
{
    public $timestamps = false;

    protected $table = 'teacher_payment_settings';

    protected $fillable = [
        'teacher_id',
        'payment_method_id',
        'param_name',
        'param_value'
    ];
}
