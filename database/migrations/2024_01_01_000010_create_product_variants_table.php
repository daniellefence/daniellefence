<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->unique()->nullable();
            $table->string('color')->nullable();
            $table->string('height')->nullable();
            $table->string('picket_width')->nullable();
            $table->string('material')->nullable();
            $table->string('finish')->nullable();
            $table->decimal('price_modifier', 10, 2)->default(0);
            $table->enum('price_modifier_type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->decimal('weight', 8, 2)->nullable();
            $table->json('dimensions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('meta_data')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'is_active']);
            $table->index(['color', 'height', 'picket_width']);
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};