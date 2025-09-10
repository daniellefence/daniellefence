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
        Schema::table('reviews', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('reviews', 'review_date')) {
                $table->timestamp('review_date')->nullable()->after('google_review_id');
            }
            if (!Schema::hasColumn('reviews', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('published');
            }
            if (!Schema::hasColumn('reviews', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['review_date', 'is_published', 'is_featured']);
        });
    }
};
