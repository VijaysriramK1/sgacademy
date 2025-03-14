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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('eligibility_criteria')->nullable();
            $table->string('coverage_amount')->nullable();
            $table->enum('coverage_type', ['full', 'percentage', 'fixed'])->nullable();
            $table->json('applicable_fee_ids')->nullable();
            $table->foreignId('batch_id')->nullable()->default(null)->constrained('batches');
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('student_scholarships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id')->nullable()->default(null);
            $table->unsignedBigInteger('section_id')->nullable()->default(null);
            $table->unsignedBigInteger('group_id')->nullable()->default(null);
            $table->json('student_id')->nullable()->default(null)->constrained('students');
            $table->unsignedBigInteger('scholarship_id')->nullable()->default(null);
            $table->decimal('scholarship_fees_amount', 9)->nullable()->default(null);
            $table->decimal('amount', 9)->nullable()->default(null);
            $table->decimal('stipend_amount', 9)->nullable()->default(null);
            $table->dateTime('awarded_date')->nullable()->default(null);
            $table->foreignId('batch_id')->nullable()->default(null)->constrained('batches');
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->timestamps();
        });

        Schema::create('stipends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable()->default(null);
            $table->unsignedBigInteger('scholarship_id')->nullable()->default(null);
            $table->enum('interval_type', ['monthly', 'yearly'])->nullable()->default(null);
            $table->decimal('amount', 5, 2)->nullable()->default(null);
            $table->dateTime('start_date')->nullable()->default(null);
            $table->dateTime('end_date')->nullable()->default(null);
            $table->unsignedInteger('cycle_count')->nullable()->default(null);
            $table->foreignId('student_scholarship_id')->nullable()->default(null)->constrained('student_scholarships');
            $table->foreignId('batch_program_id')->nullable()->default(null)->constrained('batch_programs');
            $table->timestamps();
        });

        Schema::create('stipend_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('stipend_id');
            $table->enum('payment_method', ['Cash', 'Card', 'Bank Transfer', 'Online'])->nullable();
            $table->decimal('amount', 5);
            $table->dateTime('payment_date');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('stipends_amount');
            $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
        Schema::dropIfExists('student_scholarships');
        Schema::dropIfExists('stipends');
        Schema::dropIfExists('stipend_payments');
    }
};
