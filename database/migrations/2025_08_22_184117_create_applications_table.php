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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewing', 'interviewed', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
            $table->index('career_id');
            $table->index('status');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
