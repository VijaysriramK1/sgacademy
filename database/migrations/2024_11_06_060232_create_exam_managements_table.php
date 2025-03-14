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
        Schema::create('exam_signatures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('signature');
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('exam_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->tinyInteger('is_average')->default(0);
            $table->double('percentage')->nullable();
            $table->double('average_mark')->default(0);
            $table->double('percantage')->nullable()->default(100);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('grade_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained('grades');
            $table->string('name')->nullable();
            $table->double('gpa')->nullable();
            $table->double('min_mark')->nullable();
            $table->double('max_mark')->nullable();
            $table->double('min_percent')->nullable();
            $table->double('max_percent')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_type_id')->nullable()->constrained('exam_types');
            $table->double('total_mark');
            $table->double('pass_mark')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedInteger('staff_id')->nullable()->constrained('staffs');
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('semester_id')->nullable()->constrained('semesters');
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->timestamps();
        });

        Schema::create('exam_setups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams');
            $table->string('name');
            $table->double('min_mark')->nullable();
            $table->double('mark');
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams');
            $table->foreignId('student_id')->nullable()->index('students');
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments');
            $table->integer('roll_no')->default(1);
            $table->integer('addmission_no')->default(1);
            $table->unsignedTinyInteger('is_absent')->default(0)->comment('1=Absent, 0=Present');
            $table->string('obtained_mark')->nullable();
            $table->double('total_mark')->default(0);
            $table->double('gpa_point')->nullable();
            $table->string('gpa_grade')->nullable();
            $table->tinyText('teacher_remarks')->nullable();
            $table->boolean('is_edited')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(1);
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('semester_id')->nullable()->constrained('semesters');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('exam_setup_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('exam_setup_id')->nullable()->constrained('exam_setups');
            $table->foreignId('exam_result_id')->nullable()->constrained('exam_results');
            $table->string('mark')->nullable();
            $table->boolean('is_edited')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_signatures');
        Schema::dropIfExists('exam_types');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('grade_setups');
        Schema::dropIfExists('exam_setups');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('exam_results');
        Schema::dropIfExists('exam_setup_marks');
    }
};
