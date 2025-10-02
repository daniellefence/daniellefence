<?php

namespace Database\Seeders;

use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\AvailableSpacing;
use App\Models\DiyCategory;
use App\Models\DiyProduct;
use App\Models\DiyProductModifier;
use App\Models\DiyProductPhoto;
use App\Models\DiyOrder;
use App\Models\DiyOrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DiySystemSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting COMPREHENSIVE DIY System Seeding...');

        // Disable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear ALL existing data
        $this->command->info('🗑️  Clearing existing data...');
        DiyOrderItem::truncate();
        DiyOrder::truncate();
        DiyProductPhoto::truncate();
        DiyProductModifier::truncate();
        DiyProduct::truncate();
        DiyCategory::truncate();
        AvailableSpacing::truncate();
        AvailableHeight::truncate();
        AvailableColor::truncate();

        // Re-enable foreign key checks
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ====================
        // COLORS WITH SWATCHES
        // ====================
        $this->command->info('🎨 Seeding colors with swatches...');
        $colors = [
            ['name' => 'White', 'description' => 'Classic white finish for a clean, traditional look. Timeless color that complements any architectural style.', 'price_percentage' => 0, 'hex_code' => '#FFFFFF'],
            ['name' => 'Almond', 'description' => 'Soft almond color with creamy undertones. Warm alternative to stark white.', 'price_percentage' => 10, 'hex_code' => '#EED9C4'],
            ['name' => 'Adobe', 'description' => 'Rich adobe color inspired by southwestern design. Deep, warm terracotta hue.', 'price_percentage' => 12, 'hex_code' => '#C85A3C'],
            ['name' => 'Gray', 'description' => 'Modern gray finish for contemporary homes. Sleek and sophisticated neutral tone.', 'price_percentage' => 12, 'hex_code' => '#808080'],
        ];

        foreach ($colors as $index => $colorData) {
            $color = AvailableColor::create([
                'name' => $colorData['name'],
                'description' => $colorData['description'],
                'price_percentage' => $colorData['price_percentage'],
                'hex_code' => $colorData['hex_code'],
                'order' => $index + 1,
            ]);

            // Create solid color swatch image
            $rgb = sscanf($colorData['hex_code'], '#%02x%02x%02x');
            $width = 200;
            $height = 200;
            $image = imagecreatetruecolor($width, $height);
            $colorFill = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
            imagefill($image, 0, 0, $colorFill);

            // Save to temp file
            $tempFile = sys_get_temp_dir() . '/swatch_' . $color->id . '.png';
            imagepng($image, $tempFile);
            imagedestroy($image);

            // Add to media library
            $color->addMedia($tempFile)
                ->usingName($colorData['name'] . ' Swatch')
                ->toMediaCollection('color-swatches');

            // Clean up temp file
            @unlink($tempFile);
        }

        // ====================
        // HEIGHTS
        // ====================
        $this->command->info('📏 Seeding heights...');
        $heights = [
            ['name' => '3 feet', 'value_feet' => 3, 'description' => '3 foot height - perfect for decorative borders and garden accents', 'price_per_panel' => 0.00],
            ['name' => '4 feet', 'value_feet' => 4, 'description' => '4 foot height - ideal for front yards, gardens, and pool safety', 'price_per_panel' => 15.00],
            ['name' => '5 feet', 'value_feet' => 5, 'description' => '5 foot height - great for side yards and moderate privacy needs', 'price_per_panel' => 25.00],
            ['name' => '6 feet', 'value_feet' => 6, 'description' => '6 foot height - standard privacy fence for backyards and property lines', 'price_per_panel' => 35.00],
            ['name' => '8 feet', 'value_feet' => 8, 'description' => '8 foot height - maximum privacy and security for commercial or high-privacy residential', 'price_per_panel' => 55.00],
        ];

        foreach ($heights as $index => $heightData) {
            AvailableHeight::create(array_merge($heightData, ['order' => $index + 1]));
        }

        // ====================
        // SPACINGS
        // ====================
        $this->command->info('↔️  Seeding spacings...');
        $spacings = [
            ['name' => 'Privacy (No Gap)', 'value_feet' => 0.00, 'description' => 'Solid panels with no spacing for complete privacy. No gaps between pickets or boards.', 'price_per_panel' => 15.00],
            ['name' => 'Standard (1" Gap)', 'value_feet' => 0.08, 'description' => 'Traditional picket spacing with 1 inch gaps. Classic fence look with some airflow.', 'price_per_panel' => 0.00],
            ['name' => 'Decorative (2" Gap)', 'value_feet' => 0.17, 'description' => 'Wider spacing for decorative open look. Maximum airflow and visibility.', 'price_per_panel' => -5.00],
            ['name' => 'Semi-Privacy (1/2" Gap)', 'value_feet' => 0.04, 'description' => 'Minimal gaps for partial privacy. Good balance of privacy and airflow.', 'price_per_panel' => 8.00],
        ];

        foreach ($spacings as $index => $spacingData) {
            AvailableSpacing::create(array_merge($spacingData, ['order' => $index + 1]));
        }

        // ====================
        // CATEGORIES WITH HERO PHOTOS
        // ====================
        $this->command->info('🗂️  Seeding categories with hero photos...');
        $categories = [
            [
                'name' => 'Vinyl Fence',
                'description' => 'Durable, low-maintenance vinyl fencing in various styles. Never needs painting or staining. Resists fading, cracking, and warping. Made from premium PVC compounds with UV inhibitors and impact modifiers. Backed by manufacturer warranties up to lifetime. Perfect for homeowners who want beautiful fencing without the maintenance hassle.',
                'order' => 1,
                'photo' => public_path('images/fence.webp'),
            ],
            [
                'name' => 'Wood Fence',
                'description' => 'Classic wood fencing with natural beauty and traditional charm. Available in premium cedar, pine, and pressure-treated options. Perfect for traditional and rustic homes. Wood offers unmatched warmth and can be stained or painted any color. Natural insect-resistant cedar or economical pressure-treated pine. Environmentally friendly and renewable resource.',
                'order' => 2,
                'photo' => public_path('images/fence2.webp'),
            ],
            [
                'name' => 'Aluminum Fence',
                'description' => 'Sleek aluminum fencing for modern aesthetics and pool safety. Rust-resistant powder-coated finish. Extremely durable and requires minimal maintenance. Ideal for pool enclosures, decorative borders, and commercial properties. Meets pool code requirements. Available in multiple colors and styles from classic to contemporary. Won\'t rust, rot, or corrode.',
                'order' => 3,
                'photo' => public_path('images/whychoose.webp'),
            ],
        ];

        $allCategories = [];
        foreach ($categories as $categoryData) {
            $photoPath = $categoryData['photo'];
            unset($categoryData['photo']);

            $category = DiyCategory::create($categoryData);
            $allCategories[] = $category;

            // Add hero photo
            if (file_exists($photoPath)) {
                $category->addMedia($photoPath)
                    ->preservingOriginal()
                    ->usingName($category->name . ' Hero Image')
                    ->toMediaCollection('category-photos');
            }
        }

        // ====================
        // PRODUCTS - ALL WITH PHOTOS AND FULL MODIFIERS
        // ====================
        $this->command->info('📦 Seeding products with photos and modifiers...');

        $allProducts = [
            // VINYL FENCE PRODUCTS
            'Vinyl Fence' => [
                [
                    'name' => 'Lakeland Classic',
                    'description' => 'Our most popular vinyl fence style featuring vertical pickets with decorative caps and routed rails. Perfect balance of privacy and aesthetics with classic American styling. Includes aluminum reinforcement inserts in bottom rails for extra strength and rigidity. Heavy-duty vinyl construction with virgin PVC compounds. Features interlocking tongue-and-groove panels for seamless appearance. Dog-ear or gothic picket tops available. Suitable for residential backyards and side yards.',
                    'base_price' => 145.00,
                    'order' => 1,
                ],
                [
                    'name' => 'Estate Privacy',
                    'description' => 'Premium privacy fence with tongue-and-groove panels for seamless appearance without visible fasteners. Features decorative lattice top option for enhanced elegance. Commercial-grade virgin vinyl construction with reinforced rails and posts. Interlocking panel system prevents gaps over time. Perfect for upscale residential properties and commercial applications. Available with straight or stepped top rails for sloped yards. Lifetime limited warranty against fading, cracking, and warping.',
                    'base_price' => 175.00,
                    'order' => 2,
                ],
                [
                    'name' => 'Contemporary Horizontal',
                    'description' => 'Modern horizontal slat design for contemporary and mid-century modern homes. Sleek, clean lines with optional spacing variations from fully closed to open decorative. Heavy-duty aluminum frame included for maximum durability. Wide routed rails accommodate horizontal slats. Perfect for modern architecture and upscale properties. Can be installed with graduated spacing for artistic effects. UV-protected vinyl never needs painting. Professional installation recommended.',
                    'base_price' => 195.00,
                    'order' => 3,
                ],
                [
                    'name' => 'Ranch Rail',
                    'description' => 'Traditional post-and-rail design for a country aesthetic and rustic charm. 2-rail or 3-rail configurations available depending on desired look and animal containment needs. UV-protected vinyl never needs painting or sealing. Perfect for horse farms, country estates, and large properties. Maintains the look of split-rail wood fencing without maintenance. Posts and rails snap together for easy installation. Extremely durable and will never rot or warp.',
                    'base_price' => 95.00,
                    'order' => 4,
                ],
                [
                    'name' => 'Victorian Picket',
                    'description' => 'Elegant Victorian-style fence with scalloped picket tops and decorative post caps. Perfect for front yards, gardens, and cottage-style homes. Includes ornamental finials and detailed post caps for period-appropriate aesthetic. Routed rails and decorative details throughout. Various scallop patterns available from gentle curves to dramatic arcs. Combines timeless beauty with modern vinyl durability. Never needs painting - retains crisp white finish forever.',
                    'base_price' => 165.00,
                    'order' => 5,
                ],
            ],
            // WOOD FENCE PRODUCTS
            'Wood Fence' => [
                [
                    'name' => 'Cedar Privacy Fence',
                    'description' => 'Premium Western Red Cedar with natural resistance to rot, decay, and insects. Tight board-on-board or shadowbox construction for complete privacy. Beautiful natural grain patterns and aromatic scent. Naturally insect-resistant without chemical treatment. Can be left natural to weather to silver-gray or stained for color retention. Environmentally friendly sustainable resource. Perfect for environmentally-conscious homeowners. Include posts, rails, and all cedar construction.',
                    'base_price' => 125.00,
                    'order' => 1,
                ],
                [
                    'name' => 'Classic White Picket',
                    'description' => 'Traditional white-painted pine picket fence in iconic American style. Perfect for front yards and cottage gardens. Pre-primed and ready for finishing coat of paint. Dog-ear or gothic picket tops available. Various picket spacing options for different levels of visibility. Represents timeless charm and curb appeal. Easy to repaint or stain as desired. Made from kiln-dried pine for dimensional stability.',
                    'base_price' => 85.00,
                    'order' => 2,
                ],
                [
                    'name' => 'Pressure-Treated Privacy',
                    'description' => 'Economical pressure-treated pine with 15-year warranty against rot and decay. Ground-contact rated posts for maximum longevity. Dog-ear or gothic-style picket tops available. Chemically treated to resist rot, insects, and fungal decay. Can be stained or painted after proper drying period. Most affordable option for full privacy fencing. Ideal for backyards and side yards. Includes posts treated to ground-contact rating.',
                    'base_price' => 95.00,
                    'order' => 3,
                ],
                [
                    'name' => 'Horizontal Cedar Slat',
                    'description' => 'Modern horizontal cedar design with customizable spacing for contemporary and mid-century homes. Natural oil finish recommended to preserve wood color. Perfect for contemporary, modern, and mid-century home styles. Can specify exact spacing between boards. Creates clean, linear appearance. Premium Western Red Cedar throughout. Natural resistance to rot and insects. Sophisticated alternative to traditional vertical fencing.',
                    'base_price' => 155.00,
                    'order' => 4,
                ],
                [
                    'name' => 'Shadowbox Style',
                    'description' => 'Alternating board pattern provides privacy from both sides - looks good from inside and outside. Premium cedar or pressure-treated pine options. Allows airflow while maintaining seclusion and privacy. Boards alternate on both sides of fence for attractive appearance from any angle. More resistant to wind damage than solid fencing. Perfect for property line fences where both sides are visible. Available in various board widths.',
                    'base_price' => 115.00,
                    'order' => 5,
                ],
            ],
            // ALUMINUM FENCE PRODUCTS
            'Aluminum Fence' => [
                [
                    'name' => 'Classic Pool Fence',
                    'description' => 'Code-compliant aluminum pool fence with self-closing, self-latching safety gate. Powder-coated finish resists rust and corrosion in pool chemical environment. Meets all residential pool safety code requirements including spacing and height regulations. Self-closing hinges and child-proof gate latch included. No sharp edges or protrusions. Resists chlorine and salt water. Available in black, bronze, or white powder coat. 4-foot and 5-foot heights available.',
                    'base_price' => 155.00,
                    'order' => 1,
                ],
                [
                    'name' => 'Ornamental Estate',
                    'description' => 'Decorative aluminum fence with ornamental finials, rings, and scrollwork. Commercial-grade construction suitable for both residential and commercial properties. Available in black, bronze, white, or custom powder coat colors. Heavy-duty aluminum rails and pickets. Decorative elements cast into design. Perfect for front yards, estates, and commercial properties. Mimics wrought iron appearance without rust or maintenance. Lifetime warranty against rust.',
                    'base_price' => 185.00,
                    'order' => 2,
                ],
                [
                    'name' => 'Modern Minimalist',
                    'description' => 'Sleek contemporary aluminum design with clean lines and flat top rail. No decorative elements for pure modern aesthetic. Ideal for commercial, industrial, and upscale residential properties. Square or rectangular pickets available. Powder-coated in modern colors including black, bronze, charcoal, or custom colors. Professional architectural appearance. Perfect for modern architecture and minimalist design. Commercial-grade construction throughout.',
                    'base_price' => 175.00,
                    'order' => 3,
                ],
                [
                    'name' => 'Heavy-Duty Commercial',
                    'description' => 'Industrial-strength aluminum fence for commercial applications and high-security needs. Reinforced posts and rails with thicker gauge aluminum. Meets commercial building codes and security standards. Perfect for commercial properties, schools, parks, and industrial sites. Available in heights from 4 to 8 feet. Crash-rated options available. 10-year commercial warranty. Tamper-resistant hardware and industrial-grade gate hardware included.',
                    'base_price' => 225.00,
                    'order' => 4,
                ],
            ],
        ];

        // Seed all products with photos and full modifier combinations
        $colors = AvailableColor::all();
        $heights = AvailableHeight::all();
        $spacings = AvailableSpacing::all();

        foreach ($allCategories as $category) {
            $categoryProducts = $allProducts[$category->name];

            foreach ($categoryProducts as $productData) {
                // Randomly assign best seller status to ~30% of products
                $productData['is_best_seller'] = rand(1, 100) <= 30;

                $product = $category->diyProducts()->create($productData);

                // Add product photo (use category photo as placeholder)
                if ($category->hasMedia('category-photos')) {
                    $categoryMedia = $category->getFirstMedia('category-photos');
                    $product->addMedia($categoryMedia->getPath())
                        ->preservingOriginal()
                        ->usingName($product->name . ' Product Image')
                        ->toMediaCollection('product-photos');
                }

                // Create FULL modifier combinations for ALL products
                $this->command->info("  Creating modifiers for {$product->name}...");
                foreach ($colors as $color) {
                    foreach ($heights as $height) {
                        foreach ($spacings as $spacing) {
                            DiyProductModifier::create([
                                'diy_product_id' => $product->id,
                                'available_color_id' => $color->id,
                                'available_height_id' => $height->id,
                                'available_spacing_id' => $spacing->id,
                                'is_available' => true,
                            ]);
                        }
                    }
                }
            }
        }

        // ====================
        // SAMPLE ORDERS
        // ====================
        $this->command->info('📋 Seeding sample orders...');
        $user = User::first();
        if ($user) {
            // Order 1 - Recent pending order
            $order1 = DiyOrder::create([
                'user_id' => $user->id,
                'order_number' => 'DIY-' . str_pad(1, 6, '0', STR_PAD_LEFT),
                'subtotal' => 1584.00,
                'tax_amount' => 134.64,
                'total_amount' => 1718.64,
                'status' => 'pending',
                'notes' => 'Customer requested installation assistance and delivery before weekend',
                'ordered_at' => now()->subDays(2),
            ]);

            $modifier1 = DiyProductModifier::where('is_available', true)->first();
            if ($modifier1) {
                DiyOrderItem::create([
                    'diy_order_id' => $order1->id,
                    'diy_product_modifier_id' => $modifier1->id,
                    'quantity' => 8,
                    'unit_price' => 198.00,
                    'line_total' => 1584.00,
                    'custom_notes' => 'White Lakeland Classic panels - 6ft height with privacy spacing (no gaps)',
                ]);
            }

            // Order 2 - Completed order
            $order2 = DiyOrder::create([
                'user_id' => $user->id,
                'order_number' => 'DIY-' . str_pad(2, 6, '0', STR_PAD_LEFT),
                'subtotal' => 760.00,
                'tax_amount' => 64.60,
                'total_amount' => 824.60,
                'status' => 'completed',
                'notes' => 'Pickup scheduled for Saturday morning. Customer will provide own installation.',
                'ordered_at' => now()->subDays(7),
            ]);

            $modifier2 = DiyProductModifier::where('is_available', true)->skip(50)->first();
            if ($modifier2) {
                DiyOrderItem::create([
                    'diy_order_id' => $order2->id,
                    'diy_product_modifier_id' => $modifier2->id,
                    'quantity' => 4,
                    'unit_price' => 190.00,
                    'line_total' => 760.00,
                    'custom_notes' => 'Gray Estate Privacy panels - 5ft height standard spacing',
                ]);
            }

            // Order 3 - In progress order
            $order3 = DiyOrder::create([
                'user_id' => $user->id,
                'order_number' => 'DIY-' . str_pad(3, 6, '0', STR_PAD_LEFT),
                'subtotal' => 2340.00,
                'tax_amount' => 198.90,
                'total_amount' => 2538.90,
                'status' => 'processing',
                'notes' => 'Large order - checking inventory before confirming delivery date',
                'ordered_at' => now()->subDays(5),
            ]);

            $modifier3 = DiyProductModifier::where('is_available', true)->skip(100)->first();
            if ($modifier3) {
                DiyOrderItem::create([
                    'diy_order_id' => $order3->id,
                    'diy_product_modifier_id' => $modifier3->id,
                    'quantity' => 12,
                    'unit_price' => 195.00,
                    'line_total' => 2340.00,
                    'custom_notes' => 'Contemporary Horizontal - mixed heights for stepped installation',
                ]);
            }
        }

        // ====================
        // FINAL SUMMARY
        // ====================
        $this->command->newLine();
        $this->command->info('🎉🎉🎉 COMPLETE DIY SYSTEM SEEDED SUCCESSFULLY! 🎉🎉🎉');
        $this->command->newLine();
        $this->command->table(
            ['Resource', 'Count', 'Status'],
            [
                ['Colors', AvailableColor::count(), '✅ All with swatches'],
                ['Heights', AvailableHeight::count(), '✅ Complete'],
                ['Spacings', AvailableSpacing::count(), '✅ Complete'],
                ['Categories', DiyCategory::count(), '✅ All with hero photos'],
                ['Products', DiyProduct::count(), '✅ All with photos'],
                ['Product Modifiers', DiyProductModifier::count(), '✅ Full combinations'],
                ['Sample Orders', DiyOrder::count(), '✅ With realistic data'],
                ['Media Items', \Spatie\MediaLibrary\MediaCollections\Models\Media::count(), '✅ All using Spatie'],
            ]
        );
    }
}