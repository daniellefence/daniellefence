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
        Schema::create('diy_product_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diy_product_id')->constrained('diy_products')->cascadeOnDelete();
            $table->unsignedBigInteger('diy_product_modifier_id')->nullable();
            $table->string('name');
            $table->string('file_path');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diy_product_photos');
    }
};
