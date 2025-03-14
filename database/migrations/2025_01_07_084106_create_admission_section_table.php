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
        Schema::create('admission_queries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->date('next_follow_up_date')->nullable();
            $table->string('assigned')->nullable();
            $table->integer('reference')->nullable();
            $table->integer('source')->nullable();
            $table->integer('no_of_child')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();

            $table->foreignId('program_id')->nullable()->constrained('programs');
          
        });


        Schema::create('setup_admins', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->nullable()->comment('1 purpose, 2 complaint type, 3 source, 4 Reference');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_queries');
        Schema::dropIfExists('setup_admins');
    }

};
