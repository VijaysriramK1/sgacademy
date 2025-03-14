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
        Schema::create('fee_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('fee_group_id')->nullable()->default(1);
            $table->string('type')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('assign_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_type_id')->nullable()->constrained('fee_types');
            $table->foreignId('batch_id')->constrained('batches');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('semester_id')->nullable()->constrained('semesters');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->date('create_date')->nullable();
            $table->date('due_date')->nullable();
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('fine')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('scholarship_amount')->nullable();
            $table->double('service_charge')->nullable();
            $table->double('total')->nullable();
            $table->double('installment')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('fee_fines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('form')->nullable();
            $table->string('to')->nullable();
            $table->enum('fine_type', ['percentage', 'fixed'])->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->json('fee_type_ids')->nullable();
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('fee_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->double('discount')->nullable();
            $table->string('note', 191)->nullable();
            $table->json('fee_type_ids')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('admission_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_type_id')->nullable()->constrained('fee_types');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->double('amount')->nullable();
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('fee_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->foreignId('fee_type_id')->nullable()->constrained('fee_types');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->foreignId('student_id')->nullable()->constrained('students');
            $table->foreignId('enrollment_id')->nullable()->constrained('enrollments');
            $table->date('create_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('type')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(1);
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('fee_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_invoice_id')->nullable()->constrained('fee_invoices');
            $table->double('amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('fine')->nullable();
            $table->double('sub_total')->nullable();
            $table->double('paid_amount')->nullable();
            $table->double('scholarship_amount')->nullable();
            $table->double('service_charge')->nullable();
            $table->double('due_amount')->nullable();
            $table->double('total')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });

        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_invoice_id')->nullable()->constrained('fee_invoices');
            $table->foreignId('fee_invoice_item_id')->nullable()->constrained('fee_invoice_items');
            $table->double('amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_mode', 100)->nullable();
            $table->text('note')->nullable();
            $table->string('slip')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_types');
        Schema::dropIfExists('fee_groups');
        Schema::dropIfExists('fee_fines');
        Schema::dropIfExists('fee_discounts');
        Schema::dropIfExists('admission_fees');
        Schema::dropIfExists('fee_invoices');
        Schema::dropIfExists('fee_invoice_items');
        Schema::dropIfExists('fee_transactions');
        Schema::dropIfExists('fee_payments');
    }
};
