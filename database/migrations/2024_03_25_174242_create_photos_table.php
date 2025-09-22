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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('blog_id')->nullable();
            $table->bigInteger('review_id')->nullable();
            $table->bigInteger('carousel_id')->nullable();
            $table->bigInteger('special_id')->nullable();
            $table->string('path');
            $table->longText('title')->nullable();
            $table->bigInteger('order')->default(0);
            $table->boolean('show_title')->default(0);
            $table->longText('keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
