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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('visitor_id')->nullable();
            $table->integer('no_of_person')->nullable();
            $table->string('purpose')->nullable();
            $table->date('date')->nullable();
            $table->string('in_time')->nullable();
            $table->string('out_time')->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->unsignedInteger('created_by')->nullable()->default(1);
            $table->unsignedInteger('updated_by')->nullable()->default(1);
            $table->unsignedInteger('batch_id')->nullable()->default(1)->index('sm_visitors_academic_id_foreign');
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
