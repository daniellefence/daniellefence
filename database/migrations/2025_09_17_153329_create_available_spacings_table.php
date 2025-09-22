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
        Schema::create('available_spacings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "6 feet on center"
            $table->decimal('value_feet', 5, 2); // Allow decimals like 6.5 feet
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique('value_feet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_spacings');
    }
};
