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
        Schema::create('assign_staff_batch_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->default(null)->constrained('staffs');
            $table->json('course_id')->nullable()->default(null)->constrained('courses');
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->foreignId('semester_id')->nullable()->default(null)->constrained('semesters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_staff_batch_programs');
    }
};
