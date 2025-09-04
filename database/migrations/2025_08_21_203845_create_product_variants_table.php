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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('color')->nullable();
            $table->string('height')->nullable();
            $table->string('picket_width')->nullable();
            $table->string('material')->nullable();
            $table->string('finish')->nullable();
            $table->decimal('price_modifier', 10, 2)->default(0);
            $table->enum('price_modifier_type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};