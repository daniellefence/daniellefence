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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('stock_code')->nullable()->unique();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->boolean('is_diy')->default(false);
            $table->text('description')->nullable();
            $table->json('available_colors')->nullable();
            $table->json('available_heights')->nullable();
            $table->json('available_picket_widths')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->decimal('rating', 2, 1)->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index('name');
            $table->index('published');
            $table->index(['published', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
