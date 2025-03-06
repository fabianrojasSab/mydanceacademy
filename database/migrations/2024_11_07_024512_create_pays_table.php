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
        //=============================> Tabla metodos de pagos <=============================
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
        });

        //=============================> Tabla de parametros para los metodos de pagos <=============================
        Schema::create('payment_method_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->references('id')->on('payment_methods');
            $table->string('param_name');
            $table->text('param_type');
        });

         //=============================> Tabla de configuracion de pagos a profesores <=============================
        Schema::create('teacher_payment_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->references('id')->on('users');
            $table->foreignId('payment_method_id')->references('id')->on('payment_methods');
            $table->string('param_name');
            $table->text('param_value');
        });

        //=============================> Tabla de pagos de estudiantes <=============================
        Schema::create('student_payments', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->foreignId('student_id')->references('id')->on('users');
            $table->foreignId('service_id')->references('id')->on('services');
            $table->integer('amount');
            $table->date('payment_date');
            $table->boolean('is_pending')->default(false);
        });

        //=============================> Tabla de pagos de profesores <=============================
        Schema::create('teacher_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->references('id')->on('users');
            $table->foreignId('payment_method_id')->references('id')->on('payment_methods');
            $table->integer('amount');
            $table->date('payment_date');
            $table->bigInteger('lesson_id')->unsigned();
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_payments');
        Schema::dropIfExists('student_payments');
        Schema::dropIfExists('teacher_payment_settings');
        Schema::dropIfExists('payment_method_parameters');
        Schema::dropIfExists('payment_methods');
    }
};
