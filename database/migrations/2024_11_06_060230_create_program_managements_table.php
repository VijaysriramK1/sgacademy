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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('year')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->timestamps();
        });

        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('year')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('program_code')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('course_code')->nullable();
            $table->enum('course_type', ['theory', 'practical'])->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        // Schema::create('modules', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title');
        //     $table->string('content')->nullable();
        //     $table->unsignedTinyInteger('status')->default(0);
        //     $table->foreignId('course_id')->constrained('courses');
        //     $table->timestamps();
        // });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('module_id')->constrained('modules');
            $table->foreignId('course_id')->constrained('courses');
            $table->string('title');
            $table->string('content')->nullable();
            $table->string('date')->nullable();
            $table->timestamps();
        });

        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained('lessons');
            $table->string('title');
            $table->string('content')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });

        Schema::create('batch_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->unsignedTinyInteger('status')->default(0);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->string('batch_group')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->foreignId('batch_id')->nullable()->default(null)->constrained('batches');
            $table->unsignedTinyInteger('status')->default(0);
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->json('courses')->nullable()->default(null);
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->foreignId('semester_id')->nullable()->default(null)->constrained('semesters');
            $table->timestamps();
        });

        Schema::create('program_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_program_id')->constrained('batch_programs');
            $table->foreignId('course_id')->constrained('courses');
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('status')->default(0);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('course_routines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day');
            $table->foreignId('batch_program_id')->constrained('batch_programs');
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->foreignId('staff_id')->constrained('staffs');
            $table->foreignId('class_room_id')->constrained('class_rooms');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('courses');
        // Schema::dropIfExists('modules');
        Schema::dropIfExists('lessions');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('batch_programs');
        Schema::dropIfExists('course_sections');
        Schema::dropIfExists('program_courses');
        Schema::dropIfExists('class_rooms');
        Schema::dropIfExists('course_routines');
    }
};
