<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diy_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g., color, height, picket_width
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diy_attributes');
    }
};
