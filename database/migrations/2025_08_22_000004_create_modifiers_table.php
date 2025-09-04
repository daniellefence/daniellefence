<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['add','subtract'])->default('add');
            $table->enum('operation', ['percent','fixed'])->default('percent');
            $table->enum('attribute', ['color','height','picket_width'])->index();
            $table->string('value'); // e.g., 'white', '6ft', '3in'
            $table->decimal('amount', 10, 2)->default(0); // amount to add/subtract
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('modifiers');
    }
};
