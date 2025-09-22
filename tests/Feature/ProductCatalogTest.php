<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_page_displays_products()
    {
        $category = Category::factory()->create([
            'title' => 'Test Category',
            'hidden' => false
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'title' => 'Test Product',
            'hidden' => false
        ]);

        $response = $this->get("/products/category/{$category->id}/test-category");

        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertSee('Test Category');
    }

    public function test_hidden_products_not_displayed()
    {
        $category = Category::factory()->create([
            'title' => 'Test Category',
            'hidden' => false
        ]);

        $visibleProduct = Product::factory()->create([
            'category_id' => $category->id,
            'title' => 'Visible Product',
            'hidden' => false
        ]);

        $hiddenProduct = Product::factory()->create([
            'category_id' => $category->id,
            'title' => 'Hidden Product',
            'hidden' => true
        ]);

        $response = $this->get("/products/category/{$category->id}/test-category");

        $response->assertStatus(200);
        $response->assertSee('Visible Product');
        $response->assertDontSee('Hidden Product');
    }

    public function test_subcategory_organization()
    {
        $category = Category::factory()->create([
            'title' => 'Parent Category',
            'hidden' => false
        ]);

        $subcategory = Subcategory::factory()->create([
            'parent_id' => $category->id,
            'title' => 'Test Subcategory',
            'hidden' => false
        ]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'subcategory_id' => $subcategory->id,
            'title' => 'Subcategory Product',
            'hidden' => false
        ]);

        $response = $this->get("/products/subcategory/{$subcategory->id}/test-subcategory");

        $response->assertStatus(200);
        $response->assertSee('Subcategory Product');
        $response->assertSee('Test Subcategory');
    }

    public function test_product_detail_page()
    {
        $category = Category::factory()->create(['hidden' => false]);

        $product = Product::factory()->create([
            'category_id' => $category->id,
            'title' => 'Detailed Product',
            'content' => 'This is a detailed product description',
            'hidden' => false
        ]);

        $response = $this->get("/product/{$product->id}/detailed-product");

        $response->assertStatus(200);
        $response->assertSee('Detailed Product');
        $response->assertSee('This is a detailed product description');
    }
}