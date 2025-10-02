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
        Schema::table('diy_products', function (Blueprint $table) {
            $table->boolean('is_best_seller')->default(false)->after('base_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diy_products', function (Blueprint $table) {
            $table->dropColumn('is_best_seller');
        });
    }
};
