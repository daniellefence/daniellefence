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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('blog_category_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();

            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('set null');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->index('published');
            $table->index('published_at');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
