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
        Schema::table('available_colors', function (Blueprint $table) {
            $table->dropColumn('hex_code');
            $table->string('image_url')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_colors', function (Blueprint $table) {
            $table->string('hex_code', 7)->after('name');
            $table->dropColumn('image_url');
        });
    }
};