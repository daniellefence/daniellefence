<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diy_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diy_attribute_id')->constrained()->cascadeOnDelete();
            $table->string('value');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->unique(['diy_attribute_id', 'value']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diy_options');
    }
};
