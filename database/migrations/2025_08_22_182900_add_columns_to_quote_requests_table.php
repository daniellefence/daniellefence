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
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained();
            $table->string('color')->nullable();
            $table->string('height')->nullable();
            $table->string('picket_width')->nullable();
            $table->decimal('base_price', 10, 2)->nullable();
            $table->decimal('calculated_price', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'color', 'height', 'picket_width', 'base_price', 'calculated_price']);
        });
    }
};
