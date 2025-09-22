<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add parent_id to categories table for self-referential relationship (if not exists)
        if (! Schema::hasColumn('categories', 'parent_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('id');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }

        // Migrate subcategory data to categories as children
        DB::statement('
            INSERT INTO categories (title, description, `order`, parent_id, created_at, updated_at)
            SELECT title, description, `order`, category_id, created_at, updated_at
            FROM subcategories
        ');

        // Update products to point to the migrated categories (former subcategories)
        DB::statement('
            UPDATE products p
            INNER JOIN subcategories s ON p.subcategory_id = s.id
            INNER JOIN categories c ON c.title = s.title AND c.parent_id = s.category_id
            SET p.category_id = c.id
            WHERE p.subcategory_id IS NOT NULL
        ');

        // Remove subcategory_id column from products table
        if (Schema::hasColumn('products', 'subcategory_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('subcategory_id');
            });
        }

        // Drop subcategories table
        Schema::dropIfExists('subcategories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Create subcategories table
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->bigInteger('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add subcategory_id back to products table
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('set null');
        });

        // Remove parent_id from categories table
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
