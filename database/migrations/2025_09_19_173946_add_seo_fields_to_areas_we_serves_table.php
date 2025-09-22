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
            $table->string('slug')->nullable()->after('title');
            $table->string('county')->nullable()->after('slug');
            $table->string('meta_title')->nullable()->after('county');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('page_content')->nullable()->after('meta_description');

            $table->unique('slug');
            $table->index('county');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas_we_serves', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropIndex(['county']);
            $table->dropColumn(['slug', 'county', 'meta_title', 'meta_description', 'page_content']);
        });
    }
};
