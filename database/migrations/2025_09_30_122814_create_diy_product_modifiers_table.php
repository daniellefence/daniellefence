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
        Schema::create('diy_product_modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diy_product_id')->constrained('diy_products')->cascadeOnDelete();
            $table->foreignId('available_color_id')->constrained('available_colors')->cascadeOnDelete();
            $table->foreignId('available_height_id')->constrained('available_heights')->cascadeOnDelete();
            $table->foreignId('available_spacing_id')->constrained('available_spacings')->cascadeOnDelete();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diy_product_modifiers');
    }
};
