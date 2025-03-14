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


        Schema::create('source_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->string('assigned')->nullable();
            $table->integer('reference')->nullable();
            $table->integer('no_of_child')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('student_status')->nullable();
            $table->foreignId('source_type_id')->nullable()->constrained('source_types');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('created_by')->nullable()->constrained('staffs');
            $table->foreignId('updated_by')->nullable()->constrained('staffs');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('admission_reminders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('reminder_at');
            $table->text('reminder_notes')->nullable();
            $table->boolean('is_notify')->default(false);
            $table->unsignedTinyInteger('status')->default(2);
            $table->foreignId('admission_id')->nullable()->constrained('admissions');
            $table->timestamps();
        });

        Schema::create('admission_followups', function (Blueprint $table) {
            $table->id();
            $table->text('response')->nullable();
            $table->text('note')->nullable();
            $table->date('date')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('admission_id')->nullable()->constrained('admissions');
            $table->foreignId('created_by')->nullable()->constrained('staffs');
            $table->foreignId('updated_by')->nullable()->constrained('staffs');
            $table->timestamps();
        });

        Schema::create('admission_attachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedTinyInteger('status')->default(2);
            $table->foreignId('admission_id')->nullable()->constrained('admissions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_queries');
        Schema::dropIfExists('admission_queries_reminders');
        Schema::dropIfExists('admission_followups');
        Schema::dropIfExists('admission_attachments');
    }
};
