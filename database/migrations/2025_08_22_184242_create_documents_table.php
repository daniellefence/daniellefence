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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->unsignedBigInteger('document_category_id')->nullable();
            $table->boolean('published')->default(true);
            $table->timestamps();

            $table->foreign('document_category_id')->references('id')->on('document_categories')->onDelete('set null');
            $table->index('published');
            $table->index('document_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
