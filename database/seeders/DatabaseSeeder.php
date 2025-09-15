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
            TagSeeder::class,            // Tags for categories/products
            SiteSettingSeeder::class,
            CategorySeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            AttachmentSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            ApplicationSeeder::class,
            CareerSeeder::class,
            ContactSeeder::class,
            QuoteRequestSeeder::class,
            ServiceAreaSeeder::class,
            AreaSeeder::class,
            FaqSeeder::class,
            ReviewSeeder::class,
            SpecialSeeder::class,
            YouTubeVideoSeeder::class,
            DiyAttributeSeeder::class,
            DiyOptionSeeder::class,
            DiyCombinationSeeder::class,
            ModifierSeeder::class,
            VisitorSeeder::class,
            DemoDataSeeder::class,      // Demo data should run last
        ]);
    }
}
