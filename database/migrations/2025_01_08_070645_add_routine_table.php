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
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->default(null)->constrained('staffs');
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->foreignId('course_id')->nullable()->default(null)->constrained('courses');
            $table->foreignId('lesson_id')->nullable()->default(null)->constrained('lessons');
            $table->json('topic_id')->nullable()->default(null)->constrained('topics');
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->date('completed_date')->nullable()->default(null);
            $table->string('day')->nullable()->default(null);
            $table->string('start_time')->nullable()->default(null);
            $table->string('end_time')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->foreignId('semester_id')->nullable()->default(null)->constrained('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routines');
    }
};
