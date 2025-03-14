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
        Schema::create('assigning_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->default(null)->constrained('courses');
            $table->foreignId('staff_id')->nullable()->default(null)->constrained('staffs');
            $table->foreignId('assign_staff_batch_program_id')->nullable()->default(null)->constrained('assign_staff_batch_programs');
            $table->string('status')->nullable()->default(null);
            $table->string('notes')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigning_courses');
    }
};
