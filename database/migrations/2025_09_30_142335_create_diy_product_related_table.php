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
        Schema::create('diy_product_related', function (Blueprint $table) {
            $table->foreignId('diy_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('related_product_id')->constrained('diy_products')->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->primary(['diy_product_id', 'related_product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diy_product_related');
    }
};
