<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndAdminSeeder::class,  // Must run first to create roles
            UserSeeder::class,           // Then create user and assign role
            ProductCategorySeeder::class,
            ProductSeeder::class,
            ContactSeeder::class,
            QuoteRequestSeeder::class,
            AreaSeeder::class,
            FaqSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
