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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->integer('rating')->unsigned()->default(5); // 1-5 stars
            $table->text('content');
            $table->enum('source', ['google', 'facebook', 'website', 'yelp', 'other'])->default('website');
            $table->boolean('published')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->string('google_review_id')->nullable()->unique();
            $table->timestamps();

            $table->index('rating');
            $table->index('published');
            $table->index('source');
            $table->index('reviewed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
