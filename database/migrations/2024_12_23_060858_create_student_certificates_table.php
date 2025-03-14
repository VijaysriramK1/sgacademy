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
        Schema::create('student_certificates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('header_left_text')->nullable();
            $table->string('header_bottom_text')->nullable();
            $table->string('header_right_text')->nullable();
            $table->string('header_top_text')->nullable();
            $table->string('header_font_size')->nullable();
            $table->string('header_text_color')->nullable();
            
            $table->string('title')->nullable();
            $table->string('title_left_text')->nullable();
            $table->string('title_bottom_text')->nullable();
            $table->string('title_right_text')->nullable();
            $table->string('title_top_text')->nullable();
            $table->string('title_font_size')->nullable();
            $table->string('title_text_color')->nullable();
        
            $table->date('date')->nullable();
            $table->string('date_left_text')->nullable();
            $table->string('date_bottom_text')->nullable();
            $table->string('date_right_text')->nullable();
            $table->string('date_top_text')->nullable();
            $table->string('date_font_size')->nullable();
            $table->string('date_text_color')->nullable();
            
            $table->text('body')->nullable();
            
            $table->string('footer_left_text')->nullable();
            $table->string('footer_center_text')->nullable();
            $table->string('footer_right_text')->nullable();
            $table->string('footer_top_text')->nullable();
            $table->string('footer_font_size')->nullable();
            $table->string('footer_text_color')->nullable();
            
            $table->string('file')->nullable();
            
            $table->tinyInteger('student_photo')->default(1)->comment('1 = yes, 0 = no');
            $table->integer('layout')->nullable()->comment('1 = Portrait, 2 = Landscape');
            $table->string('body_font_family')->nullable()->default('Arial');
            $table->string('body_font_size')->nullable()->default('2em');
            $table->string('height', 50)->nullable()->comment('Height in mm');
            $table->string('width', 50)->nullable()->comment('Width in mm');
            
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();
        
            $table->json('student_id')->nullable();
           
        });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_certificates');
    }
};
