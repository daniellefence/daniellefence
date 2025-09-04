<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diy_combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            // Each product may choose which attributes correspond to color/height/picket_width via its attributes
            $table->foreignId('color_option_id')->nullable()->constrained('diy_options')->nullOnDelete();
            $table->foreignId('height_option_id')->nullable()->constrained('diy_options')->nullOnDelete();
            $table->foreignId('picket_width_option_id')->nullable()->constrained('diy_options')->nullOnDelete();
            $table->decimal('price_modifier_percent', 6, 2)->default(0); // e.g., +10.00 = +10%
            $table->timestamps();

            $table->unique(
                ['product_id', 'color_option_id', 'height_option_id', 'picket_width_option_id'],
                'diy_combo_unique_triplet'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diy_combinations');
    }
};
