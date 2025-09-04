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
        Schema::create('you_tube_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('youtube_id')->unique();
            $table->string('youtube_url');
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->timestamp('published_at')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('show_on_videos_page')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->string('category')->nullable();
            $table->json('youtube_data')->nullable(); // Store full YouTube API response
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('you_tube_videos');
    }
};
