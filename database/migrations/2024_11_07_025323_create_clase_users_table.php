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
        // Schema::create('teacher_lessons', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
        //     $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        // });

        Schema::create('student_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->date('inscription_date');
        });

        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->tinyInteger('status');             //status: 0 = absent, 1 = present, 2 = late
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_lessons');
        Schema::dropIfExists('student_lessons');
        Schema::dropIfExists('presences');
    }
};
