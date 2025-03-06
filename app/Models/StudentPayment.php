<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    public $timestamps = false; // Desactiva las columnas de marca de tiempo
    protected $table = 'student_payments';
    protected $fillable = [
        'student_id',
        'payment_method_id',
        'service_id',
        'amount',
        'payment_date',
        'description',
        'is_pending'
    ];

    //La relacion BelongsTo indica que un pago pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class , 'student_id');
    }

    //relacion con los servicios
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    //La relacion BelongsTo indica que un pago pertenece a un metodo de pago
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
