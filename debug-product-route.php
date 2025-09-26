<?php

/**
 * Debug the product route issue
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

$category_slug = 'privacy-fence';
$product_slug = 'lakeland-vinyl-fence';

echo "Debugging product route for: /fencing/{$category_slug}/{$product_slug}\n\n";

// Test the exact same logic as in the controller
echo "Step 1: Getting all categories...\n";
$categories = Category::all();
echo "Found {$categories->count()} categories\n\n";

echo "Step 2: Looking for category with slug '{$category_slug}'...\n";
$category = $categories->first(function ($cat) use ($category_slug) {
    $catSlug = Str::slug($cat->title);
    echo "  - Category '{$cat->title}' -> slug '{$catSlug}'\n";
    return $catSlug === $category_slug;
});

if (!$category) {
    echo "❌ Category not found!\n";
    exit(1);
}

echo "✅ Found category: {$category->title} (ID: {$category->id})\n\n";

echo "Step 3: Getting products in category {$category->id}...\n";
$products = Product::where('category_id', $category->id)->get();
echo "Found {$products->count()} products in category\n\n";

echo "Step 4: Looking for product with slug '{$product_slug}'...\n";
$product = $products->first(function ($prod) use ($product_slug) {
    $prodSlug = Str::slug($prod->title);
    echo "  - Product '{$prod->title}' -> slug '{$prodSlug}'\n";
    return $prodSlug === $product_slug;
});

if (!$product) {
    echo "❌ Product not found!\n";
    echo "\nAvailable products in this category:\n";
    $products->each(function($p) {
        echo "  - {$p->title} -> " . Str::slug($p->title) . "\n";
    });
    exit(1);
}

echo "✅ Found product: {$product->title} (ID: {$product->id})\n\n";

echo "Step 5: Checking if view exists...\n";
$viewPath = resource_path('views/pages/product/read.blade.php');
if (file_exists($viewPath)) {
    echo "✅ View file exists: {$viewPath}\n";
} else {
    echo "❌ View file missing: {$viewPath}\n";
    exit(1);
}

echo "\n🎉 All checks passed! The route should work.\n";
echo "This suggests the issue might be:\n";
echo "1. Middleware blocking the request\n";
echo "2. Route order/priority issue\n";
echo "3. Server configuration\n";
echo "4. Caching issue\n";