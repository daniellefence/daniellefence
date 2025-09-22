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
        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diy_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('available_color_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('available_spacing_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('available_height_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('price_modification_type', ['percentage', 'fixed'])->default('fixed');
            $table->decimal('price_modification_value', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['diy_product_id', 'is_active']);
            $table->unique(['diy_product_id', 'available_color_id', 'available_spacing_id', 'available_height_id'], 'unique_modifier_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifiers');
    }
};
