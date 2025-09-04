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
        // Check if column exists before adding
        if (!Schema::hasColumn('products', 'deleted_at')) {
            Schema::table('products', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('blogs', 'deleted_at')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('pages', 'deleted_at')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('documents', 'deleted_at')) {
            Schema::table('documents', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('careers', 'deleted_at')) {
            Schema::table('careers', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('f_a_q_s', 'deleted_at')) {
            Schema::table('f_a_q_s', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('reviews', 'deleted_at')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('contacts', 'deleted_at')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (!Schema::hasColumn('quote_requests', 'deleted_at')) {
            Schema::table('quote_requests', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('careers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('f_a_q_s', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
