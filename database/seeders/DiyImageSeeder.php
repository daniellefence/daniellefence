<?php

namespace Database\Seeders;

use App\Models\AvailableColor;
use App\Models\DiyCategory;
use App\Models\DiyProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DiyImageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🖼️  Seeding products from DIY_IMAGES folder...');

        $imagesPath = resource_path('DIY_IMAGES');

        if (!File::exists($imagesPath)) {
            $this->command->error('DIY_IMAGES folder not found!');
            return;
        }

        // Get all image files
        $files = File::files($imagesPath);

        // Get existing categories and colors
        $vinylCategory = DiyCategory::where('name', 'LIKE', '%Vinyl%')->first();
        if (!$vinylCategory) {
            $this->command->error('Please run DiySystemSeeder first to create categories and colors!');
            return;
        }

        $colors = [
            'White' => AvailableColor::where('name', 'White')->first(),
            'Almond' => AvailableColor::where('name', 'Almond')->first(),
            'Adobe' => AvailableColor::where('name', 'Adobe')->first(),
            'Gray' => AvailableColor::where('name', 'Gray')->first(),
        ];

        // Product mapping from image filenames
        $productData = [];

        foreach ($files as $file) {
            $filename = $file->getFilename();

            // Skip non-DIY files
            if (!str_starts_with($filename, 'DIY_')) continue;

            // Parse filename: DIY_72in Lakeland_Adobe.png
            $cleanName = str_replace('DIY_', '', $filename);
            $cleanName = str_replace('.png', '', $cleanName);

            // Extract height (72in), product name, and color/variant
            if (preg_match('/^(\d+)in\s+(.+?)(_(.+))?$/', $cleanName, $matches)) {
                $height = $matches[1];
                $productName = $matches[2];
                $variant = $matches[4] ?? 'White'; // Default to White if no variant specified

                // Determine color from variant
                $colorName = 'White';
                if (str_contains($variant, 'Almond')) {
                    $colorName = 'Almond';
                } elseif (str_contains($variant, 'Adobe')) {
                    $colorName = 'Adobe';
                } elseif (str_contains($variant, 'Gray')) {
                    $colorName = 'Gray';
                }

                // Store product data
                if (!isset($productData[$productName])) {
                    $productData[$productName] = [];
                }

                $productData[$productName][] = [
                    'file' => $file->getPathname(),
                    'filename' => $filename,
                    'height' => $height,
                    'color' => $colorName,
                    'variant' => $variant,
                ];
            }
        }

        // Create products
        $productCount = 0;
        $photoCount = 0;

        foreach ($productData as $name => $images) {
            // Clean up product name (remove spacing numbers like "180", "250", etc.)
            $cleanProductName = preg_replace('/_(180|250|375|10|20)$/', '', $name);

            // Skip if product already exists
            $product = DiyProduct::where('name', $cleanProductName)->first();

            if (!$product) {
                $product = DiyProduct::create([
                    'diy_category_id' => $vinylCategory->id,
                    'name' => $cleanProductName,
                    'description' => 'Premium vinyl fencing product featuring durable construction and professional finish.',
                    'base_price' => 150.00,
                    'order' => $productCount + 1,
                ]);
                $productCount++;
            }

            // Add images to product with color metadata
            foreach ($images as $imageData) {
                $color = $colors[$imageData['color']] ?? null;

                if ($color && file_exists($imageData['file'])) {
                    $product->addMedia($imageData['file'])
                        ->preservingOriginal()
                        ->usingName($product->name . ' - ' . $imageData['color'] . ' - ' . $imageData['height'])
                        ->withCustomProperties([
                            'color_id' => $color->id,
                            'color_name' => $imageData['color'],
                            'height' => $imageData['height'],
                            'variant' => $imageData['variant'],
                        ])
                        ->toMediaCollection('product-photos');
                    $photoCount++;
                }
            }
        }

        $this->command->info("✅ Created $productCount products");
        $this->command->info("✅ Added $photoCount product photos with color/height metadata");
    }
}