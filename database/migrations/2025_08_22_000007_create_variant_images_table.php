<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('variant_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('color')->nullable();
            $table->string('height')->nullable();
            $table->string('picket_width')->nullable();
            $table->string('image_path'); // storage path under disk
            $table->timestamps();
            $table->unique(['product_id','color','height','picket_width'], 'variant_images_unique_combo');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('variant_images');
    }
};
