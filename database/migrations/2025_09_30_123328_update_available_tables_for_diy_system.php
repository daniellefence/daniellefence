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
        // Update available_colors table
        Schema::table('available_colors', function (Blueprint $table) {
            if (!Schema::hasColumn('available_colors', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('available_colors', 'photo_path')) {
                $table->string('photo_path')->nullable()->after('description');
            }
            if (!Schema::hasColumn('available_colors', 'price_percentage')) {
                $table->decimal('price_percentage', 8, 2)->default(0)->after('photo_path');
            }
            if (!Schema::hasColumn('available_colors', 'order')) {
                $table->integer('order')->default(0)->after('price_percentage');
            }
            if (!Schema::hasColumn('available_colors', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Update available_heights table
        Schema::table('available_heights', function (Blueprint $table) {
            if (!Schema::hasColumn('available_heights', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('available_heights', 'price_per_panel')) {
                $table->decimal('price_per_panel', 8, 2)->default(0)->after('description');
            }
            if (!Schema::hasColumn('available_heights', 'order')) {
                $table->integer('order')->default(0)->after('price_per_panel');
            }
            if (!Schema::hasColumn('available_heights', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        // Update available_spacings table
        Schema::table('available_spacings', function (Blueprint $table) {
            if (!Schema::hasColumn('available_spacings', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('available_spacings', 'price_per_panel')) {
                $table->decimal('price_per_panel', 8, 2)->default(0)->after('description');
            }
            if (!Schema::hasColumn('available_spacings', 'order')) {
                $table->integer('order')->default(0)->after('price_per_panel');
            }
            if (!Schema::hasColumn('available_spacings', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_colors', function (Blueprint $table) {
            $table->dropColumn(['description', 'photo_path', 'price_percentage', 'order', 'deleted_at']);
        });

        Schema::table('available_heights', function (Blueprint $table) {
            $table->dropColumn(['description', 'price_per_panel', 'order', 'deleted_at']);
        });

        Schema::table('available_spacings', function (Blueprint $table) {
            $table->dropColumn(['description', 'price_per_panel', 'order', 'deleted_at']);
        });
    }
};