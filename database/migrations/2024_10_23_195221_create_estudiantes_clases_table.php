<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Schema::create('pagos', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('concepto');
        //     $table->date('fecha_pago');
        //     $table->decimal('monto', 8, 2);
        //     $table->foreignId('user_id')->references('id')->on('users');
        // });

        // Schema::create('clases', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('capacidad');
        //     $table->integer('duracion');
        //     $table->string('horario');
        //     $table->string('nombre');
        //     $table->foreignId('user_id')->references('id')->on('users');
        // });

        // Schema::create('inscripciones', function (Blueprint $table) {
        //     $table->id();
        //     $table->date('fecha_inscripcion');
        //     $table->foreignId('clase_id')->references('id')->on('clases');
        //     $table->foreignId('user_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
        Schema::dropIfExists('pagos');
        Schema::dropIfExists('inscripciones');
    }
};
