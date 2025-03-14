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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->float('daily_rate')->nullable()->default(null);
            $table->tinyText('details')->nullable();
            $table->foreignId('department_id')->nullable()->default(null)->constrained('departments');
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->nullable()->default(null)->constrained('staffs');
            $table->smallInteger('type_id')->comment('1-full_day, 2-half_day, 3-above_day')->default(1);
            $table->unsignedSmallInteger('leave_type_id')->comment('leave_types');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('hours_duration')->nullable()->default(null);
            $table->longText('reason')->nullable()->default(null);
            $table->unsignedTinyInteger('status')->default(1)->comment('1-pending,2-approved,3-disapproved');
            $table->boolean('is_paid')->default(false);
            $table->foreignId('institution_id')->nullable()->default(null)->constrained('institutions');
            $table->foreignId('user_id')->nullable()->default(null)->constrained('users');
            $table->foreignId('role_id')->nullable()->default(null)->constrained('roles');
            $table->timestamps();
        });

        Schema::create('hr_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->time('lunch_time')->nullable();
            $table->tinyInteger('department_id')->nullable();
            $table->json('working_days');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs');
            $table->date('date');
            $table->time('time_in')->nullable()->default(null);
            $table->time('time_out')->nullable();
            $table->integer('regular')->nullable();
            $table->integer('late')->nullable();
            $table->integer('undertime')->nullable();
            $table->integer('overtime')->nullable();
            $table->integer('night_differential')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default('5')->comment('1-Present, 2-Absent, 3-Late, 4-Halfday, 5-Pending');
            $table->time('scheduled_time_in')->nullable();
            $table->time('scheduled_time_out')->nullable();
            $table->bigInteger('hr_schedule_id')->nullable();
            $table->string('task')->nullable();
            $table->unsignedInteger('category')->nullable();
            $table->unsignedInteger('sub_category')->nullable();
            $table->unsignedInteger('created_by')->nullable()->comment('NULL = generated');
            $table->dateTime('date_approved')->nullable();
            $table->timestamps();
        });

        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs');
            $table->unsignedInteger('payroll_period_id');
            $table->unsignedInteger('cutoff_order');
            $table->boolean('is_paid')->default(0);

            $table->decimal('basic_pay', $precision = 20, $scale = 3);
            $table->decimal('gross_pay', $precision = 20, $scale = 3);
            $table->decimal('net_pay', $precision = 20, $scale = 3);

            $table->decimal('tardiness', $precision = 20, $scale = 3);
            $table->decimal('deductions', $precision = 20, $scale = 3);

            $table->decimal('taxable', $precision = 20, $scale = 3)->nullable();
            $table->decimal('non_taxable', $precision = 20, $scale = 3)->nullable();

            $table->json('labels')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('designations');
        Schema::dropIfExists('leave_types');
        Schema::dropIfExists('leaves');
        Schema::dropIfExists('staff_attendances');
        Schema::dropIfExists('payslips');
    }
};
