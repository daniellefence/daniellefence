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
        Schema::table('areas_we_serves', function (Blueprint $table) {
            $table->longText('services_content')->nullable()->after('page_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas_we_serves', function (Blueprint $table) {
            $table->dropColumn('services_content');
        });
    }
};
