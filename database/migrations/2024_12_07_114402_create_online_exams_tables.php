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
        Schema::create('online_exams', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191)->nullable();
            $table->date('date')->nullable();
            $table->string('start_time', 200)->nullable();
            $table->string('end_time', 200)->nullable();
            $table->string('end_date_time', 191)->nullable();
            $table->integer('percentage')->nullable();
            $table->text('instruction')->nullable();
            $table->tinyInteger('is_published')->nullable()->default(0);
            $table->tinyInteger('is_taken')->nullable()->default(0);
            $table->tinyInteger('is_closed')->nullable()->default(0);
            $table->tinyInteger('is_waiting')->nullable()->default(0);
            $table->tinyInteger('is_running')->nullable()->default(0);
            $table->tinyInteger('auto_mark')->nullable()->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('online_exam_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('type', 1)->nullable();
            $table->double('mark')->nullable();
            $table->double('error_mark')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('online_exam_id')->constrained('online_exams');
            $table->boolean('is_true')->nullable();
            $table->text('suitable_words')->nullable();
            $table->timestamps();
        });

        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('is_answer')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('question_id')->constrained('questions');
            $table->timestamps();
        });

        Schema::create('exam_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('online_exam_id')->constrained('online_exams');
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('enrollment_id')->constrained('enrollments');
            $table->unsignedInteger('mark')->nullable();
            $table->unsignedInteger('error_mark')->nullable();
            $table->integer('abs')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('participant_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_participant_id')->constrained('exam_participants');
            $table->foreignId('question_id')->constrained('questions');
            $table->string('answer')->nullable();
            $table->unsignedInteger('mark')->nullable();
            $table->unsignedInteger('error_mark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_exams');
        Schema::dropIfExists('online_exam_programs');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('exam_participants');
        Schema::dropIfExists('participant_answers');
    }
};
