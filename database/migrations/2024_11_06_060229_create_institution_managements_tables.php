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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('currency_code', 5)->nullable();
            $table->string('locale')->nullable()->default('en');
            $table->text('address')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('student_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('student_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('staff_no')->nullable();
            $table->boolean('is_teaching')->default(false);
            $table->date('dob')->nullable();
            $table->enum('gender', ['gender', 'female', 'transgender', 'non-binary', 'other'])->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'other'])->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->date('join_date')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_name', 20)->nullable();
            $table->string('bank_brach')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('emergency_mobile')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed', 'separated'])->nullable();
            $table->string('staff_photo')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('qualification')->nullable();
            $table->string('experience')->nullable();
            $table->string('epf_no', 20)->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('location')->nullable();
            $table->string('casual_leave', 15)->nullable();
            $table->string('medical_leave', 15)->nullable();
            $table->string('metarnity_leave', 15)->nullable();
            $table->string('facebook_url', 100)->nullable();
            $table->string('twiteer_url', 100)->nullable();
            $table->string('linkedin_url', 100)->nullable();
            $table->string('instragram_url', 100)->nullable();
            $table->string('joining_letter')->nullable();
            $table->string('resume')->nullable();
            $table->string('other_document')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(1);
            $table->string('driving_license')->nullable();
            $table->date('dl_expiry_date')->nullable();
            $table->text('custom_field')->nullable();
            $table->string('custom_field_form_name')->nullable();
            $table->foreignId('user_id')->nullable()->default(null)->constrained('users');
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', ['gender', 'female', 'transgender', 'non-binary', 'other'])->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'other'])->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->integer('admission_no')->nullable();
            $table->integer('roll_no')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['gender', 'female', 'transgender', 'non-binary', 'other'])->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'other'])->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('student_photo')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('national_id_no')->nullable();
            $table->string('local_id_no')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('aditional_notes')->nullable();
            $table->string('document_title_1')->nullable();
            $table->string('document_file_1')->nullable();
            $table->string('document_title_2')->nullable();
            $table->string('document_file_2')->nullable();
            $table->string('document_title_3')->nullable();
            $table->string('document_file_3')->nullable();
            $table->string('document_title_4')->nullable();
            $table->string('document_file_4')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(1);
            $table->text('custom_field')->nullable();
            $table->string('custom_field_form_name')->nullable();
            $table->string('religion')->nullable();
            $table->foreignId('student_category_id')->nullable()->constrained('student_categories');
            $table->foreignId('student_group_id')->nullable()->constrained('student_groups');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('student_parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents');
            $table->foreignId('student_id')->constrained('students');
            $table->enum('relation', ['parent', 'guardian', 'grandparent', 'sibling', 'spouse', 'other'])->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('notice_boards', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->date('date')->nullable();
            $table->date('publish_on')->nullable();
            $table->string('inform_to')->nullable()->comment('Notice message sent to these roles');
            $table->integer('is_published')->nullable()->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('staffs');
            $table->foreignId('updated_by')->nullable()->constrained('staffs');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('staffs');
        Schema::dropIfExists('student_categories');
        Schema::dropIfExists('student_groups');
        Schema::dropIfExists('students');
        Schema::dropIfExists('student_parents');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('notice_boards');
    }
};
