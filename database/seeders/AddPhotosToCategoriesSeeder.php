<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Photo;
use Illuminate\Database\Seeder;

class AddPhotosToCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📸 Adding photos to categories...');

        // Get all categories that are used by products linked to DIY products
        $categoriesUsed = \App\Models\DiyProduct::with('product')
            ->get()
            ->pluck('product.category_id')
            ->unique()
            ->filter();

        $this->command->info('Found ' . $categoriesUsed->count() . ' categories used by DIY products');

        foreach ($categoriesUsed as $categoryId) {
            $category = Category::find($categoryId);
            if (!$category) continue;

            // Check how many photos this category already has
            $currentPhotoCount = Photo::where('category_id', $categoryId)->count();

            if ($currentPhotoCount >= 5) {
                $this->command->info("  ✓ Category '{$category->title}' already has {$currentPhotoCount} photos");
                continue;
            }

            // Get all available distinct photo paths from other categories
            $availablePhotoPaths = Photo::select('path')
                ->distinct()
                ->pluck('path')
                ->toArray();

            if (empty($availablePhotoPaths)) {
                $availablePhotoPaths = ['placeholder.jpg'];
            }

            // Add photos until we have at least 5, using different photos
            $photosToAdd = 5 - $currentPhotoCount;
            for ($i = 0; $i < $photosToAdd; $i++) {
                // Get a random photo path from available ones
                $photoPath = $availablePhotoPaths[array_rand($availablePhotoPaths)];

                Photo::create([
                    'category_id' => $categoryId,
                    'path' => $photoPath,
                    'title' => $category->title . ' - Image ' . ($currentPhotoCount + $i + 1),
                    'order' => $currentPhotoCount + $i + 1,
                    'show_title' => false,
                ]);
            }

            $newCount = Photo::where('category_id', $categoryId)->count();
            $this->command->info("  ✓ Category '{$category->title}' now has {$newCount} photos (added {$photosToAdd})");
        }

        $this->command->info('✅ Photos added successfully');
    }
}
