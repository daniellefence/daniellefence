<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static $blogs = 20;

    public static $careers = 10;

    public static $reviews = 10;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $files = glob('storage/app/*/*.*');
        foreach ($files as $file) {
            unlink($file);
        }
        $this->call(GeneralSettingSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ProductSeeder::class);
        // $this->call(DocumentationcategorySeeder::class);
        $this->call(BlogcategorySeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(CareerSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(VideoSeeder::class);
        $this->call(AreasWeServeSeeder::class);
        $this->call(SeoSeeder::class);
        $this->call(SpecialsSeeder::class);
    }
}
