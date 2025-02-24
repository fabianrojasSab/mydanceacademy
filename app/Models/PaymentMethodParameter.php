<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodParameter extends Model
{
    public $timestamps = false;
    
    protected $table = 'payment_method_parameters';

    protected $fillable =  [
        'payment_method_id',
        'param_name',
        'param_type'
    ];
}
