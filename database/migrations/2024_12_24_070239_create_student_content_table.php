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
        Schema::create('content_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->onDelete('set null');

        });

        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer('content_type_id');
            $table->string('youtube_link')->nullable();
            $table->string('upload_file')->length(200)->nullable();
            $table->timestamps();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->onDelete('set null');

        });

        Schema::create('video_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('youtube_link');
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->integer('created_by')->nullable();
            $table->timestamps();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->onDelete('set null');

        });

        Schema::create('content_share_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->date('share_date')->nullable();
            $table->date('valid_upto')->nullable();
            $table->text('description')->nullable();
            $table->string('send_type')->nullable()->comment('G, C, I, P');
            $table->json('content_ids')->nullable();
            $table->json('gr_role_ids')->nullable();
            $table->json('ind_user_ids')->nullable();
            $table->foreignId('program_id')->nullable()->constrained('programs');
            $table->json('section_ids')->nullable();
            $table->text('url')->nullable();
            $table->integer('shared_by')->nullable();
            $table->timestamps();
            $table->foreignId('institution_id')->nullable()->constrained('institutions')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_types');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('video_uploads');
        Schema::dropIfExists('content_share_lists');
    }
};
