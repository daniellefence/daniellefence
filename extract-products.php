<?php

/**
 * Extract all products with their categories for URL testing
 */

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use Illuminate\Support\Str;

try {
    echo "Extracting products from database...\n";

    $products = Product::with('category')
        ->whereHas('category') // Only products with valid categories
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'category_id' => $product->category->id,
                'category_title' => $product->category->title,
                'category_slug' => Str::slug($product->category->title),
                'product_slug' => Str::slug($product->title),
                'url' => "/fencing/" . Str::slug($product->category->title) . "/" . Str::slug($product->title)
            ];
        })
        ->toArray();

    echo "Found " . count($products) . " products with valid categories\n";

    // Save to JSON file for the test script
    file_put_contents('products-data.json', json_encode($products, JSON_PRETTY_PRINT));

    echo "Products data saved to products-data.json\n";

    // Also output as JSON for direct consumption
    echo "\nJSON OUTPUT:\n";
    echo json_encode($products);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}