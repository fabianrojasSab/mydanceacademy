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
        //=============================> Tabla Estados <=============================
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
        });

        //=============================> Tabla Especialidades <=============================
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('description');
        });

        Schema::create('academies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->references('id')->on('states');
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->integer('rating');
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id')->references('id')->on('academies')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->integer('price');
        });

        //=============================> Tabla Usuarios <=============================
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('profile_photo_path', 2048)->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('hiring_date')->nullable();
            $table->string('specialty_id')->references('id')->on('specialties')->nullable();;
            $table->foreignId('state_id')->references('id')->on('states');
            $table->timestamps();
            $table->string('eps')->nullable();
        });

        //=============================> Tabla Clases <=============================
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academy_id')->references('id')->on('academies');
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->string('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('state');
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->references('id')->on('lessons');
            $table->foreignId('teacher_id')->references('id')->on('users');
            $table->integer('day');    //day: 1 = monday, 2 = tuesday, 3 = wednesday, 4 = thursday, 5 = friday, 6 = saturday, 7 = sunday
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('capacity');
            $table->date('date');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Schema::create('gastos_contables', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('concepto');
        //     $table->date('fecha_gasto');
        //     $table->decimal('monto', 8, 2);
        //     $table->foreignId('usuario_id')->references('id')->on('users');
        // });

        // Schema::create('ingresos_contables', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('concepto');
        //     $table->date('fecha_ingreso');
        //     $table->decimal('monto', 8, 2);
        //     $table->foreignId('usuario_id')->references('id')->on('users');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar restricciones de claves foráneas primero (esto depende del motor y la versión)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Eliminar las tablas en el orden correcto
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('specialties');
        Schema::dropIfExists('states');
        Schema::dropIfExists('users');
        Schema::dropIfExists('services');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('academies');
        
        // Restaurar las restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
    
    
};
