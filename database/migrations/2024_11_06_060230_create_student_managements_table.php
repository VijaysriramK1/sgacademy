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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('batch_program_id');
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('roll_no', 191)->nullable();
            $table->boolean('is_promote')->nullable()->default(false);
            $table->boolean('is_graduate')->nullable()->default(false);
            $table->tinyInteger('is_default')->nullable()->default(0);
            $table->date('enrolled_at');
            $table->json('course_ids')->nullable();
            $table->unsignedBigInteger('badge_id')->nullable();
            $table->foreignId('student_category_id')->nullable()->constrained('student_categories');
            $table->foreignId('student_group_id')->nullable()->constrained('student_groups');
            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('batch_program_id')->references('id')->on('batch_programs')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
        });

        Schema::create('student_promotions', function (Blueprint $table) {
            $table->id();
            $table->string('result_status', 10)->nullable();
            $table->unsignedInteger('previous_class_id')->nullable()->index('student_promotions_previous_class_id_foreign');
            $table->unsignedInteger('current_class_id')->nullable()->index('student_promotions_current_class_id_foreign');
            $table->unsignedInteger('previous_section_id')->nullable()->index('student_promotions_previous_section_id_foreign');
            $table->unsignedInteger('current_section_id')->nullable()->index('student_promotions_current_section_id_foreign');
            $table->unsignedInteger('previous_session_id')->nullable()->index('student_promotions_previous_session_id_foreign');
            $table->unsignedInteger('current_session_id')->nullable()->index('student_promotions_current_session_id_foreign');
            $table->unsignedInteger('student_id')->nullable()->index('student_promotions_student_id_foreign');
            $table->integer('admission_number')->nullable();
            $table->longText('student_info')->nullable();
            $table->longText('merit_student_info')->nullable();
            $table->integer('previous_roll_number')->nullable();
            $table->integer('current_roll_number')->nullable();
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->timestamps();
        });

        Schema::create('student_id_cards', function (Blueprint $table) {
            $table->id();
            $table->text('role_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('staffs');
            $table->string('layout')->nullable();
            $table->string('profile_layout')->nullable();
            $table->string('logo')->nullable();
            $table->string('background_image')->nullable();
            $table->string('pageLayoutWidth')->nullable();
            $table->string('pageLayoutHeight')->nullable();
            $table->string('admission_no')->default(0)->comment('0 for no 1 for yes');
            $table->string('student_name')->default(0)->comment('0 for no 1 for yes');
            $table->string('program')->default(0)->comment('0 for no 1 for yes');
            $table->string('father_name')->default(0)->comment('0 for no 1 for yes');
            $table->string('mother_name')->default(0)->comment('0 for no 1 for yes');
            $table->string('student_address')->default(0)->comment('0 for no 1 for yes');
            $table->string('phone_number')->default(0)->comment('0 for no 1 for yes');
            $table->string('dob')->default(0)->comment('0 for no 1 for yes');
            $table->string('blood')->default(0)->comment('0 for no 1 for yes');
            $table->string('signature')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->date('homework_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('evaluation_date')->nullable();
            $table->string('file', 200)->nullable();
            $table->string('marks', 200)->nullable();
            $table->string('description', 500)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('evaluated_by')->nullable();
            $table->foreign('evaluated_by')->references('id')->on('enrollments')->onDelete('cascade');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->foreignId('course_id')->constrained('courses');
            $table->timestamps();
        });

        Schema::create('student_homeworks', function (Blueprint $table) {
            $table->id();
            $table->date('homework_date')->nullable();
            $table->date('submission_date')->nullable();
            $table->text('description')->nullable();
            $table->double('percentage')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('evaluated_by')->nullable()->constrained('staffs');
            $table->foreignId('student_id')->nullable()->constrained('students');
            $table->foreignId('course_id')->nullable()->constrained('courses');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->foreignId('institution_id')->nullable()->index('institutions');
            $table->timestamps();
        });

        Schema::create('study_materials', function (Blueprint $table) {
            $table->id();
            $table->string('content_title')->length(200)->nullable();
            $table->string('content_type')->nullable()->comment("as assignment, st study material, sy sullabus, ot others download");
            $table->integer('available_for_admin')->default(0)->nullable();
            $table->integer('available_for_all_programs')->default(0);
            $table->date('upload_date')->nullable();
            $table->string('description')->length(500)->nullable();
            $table->string('source_url')->nullable();
            $table->string('upload_file')->length(200)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('student_promotions');
        Schema::dropIfExists('student_id_cards');
        Schema::dropIfExists('homeworks');
        Schema::dropIfExists('student_homeworks');
        Schema::dropIfExists('study_materials');
    }
};
