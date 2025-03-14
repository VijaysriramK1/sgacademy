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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->text('purpose');
            $table->text('subject');
            $table->longText('body');
            $table->text('variable');
            $table->integer('status')->default(1);
            $table->foreignId('institution_id')->constrained('institutions');
            $table->timestamps();
        });

        Schema::create('template_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('templates');
            $table->string('event')->nullable();
            $table->string('destination')->nullable();
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->longText('template')->nullable();
            $table->string('shortcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
