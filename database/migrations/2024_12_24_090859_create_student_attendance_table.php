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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->date('date')->nullable()->default(null);
            $table->unsignedTinyInteger('status')->nullable()->default('5')->comment('1-Present, 2-Absent, 3-Late, 4-Halfday, 5-Pending');
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->foreignId('course_id')->nullable()->default(null)->constrained('courses');
            $table->foreignId('semester_id')->nullable()->default(null)->constrained('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
