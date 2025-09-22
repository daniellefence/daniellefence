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
        // First, rename the existing permissions table to preserve legacy data
        Schema::rename('permissions', 'legacy_permissions');

        // Now create the proper Spatie permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // We need to recreate the foreign keys for the tables that reference permissions
        // Drop the existing foreign key constraints from our recent migration
        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->dropForeign(['permission_id']);
            });
        }

        if (Schema::hasTable('role_has_permissions')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->dropForeign(['permission_id']);
            });
        }

        // Recreate the foreign key constraints
        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');
            });
        }

        if (Schema::hasTable('role_has_permissions')) {
            Schema::table('role_has_permissions', function (Blueprint $table) {
                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the Spatie permissions table
        Schema::dropIfExists('permissions');

        // Restore the original permissions table
        Schema::rename('legacy_permissions', 'permissions');
    }
};
