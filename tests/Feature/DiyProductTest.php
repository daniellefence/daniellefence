<?php

namespace Tests\Feature;

use App\Models\DiyProduct;
use App\Models\DiyProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiyProductTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private DiyProductCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->admin->createPermission('DiyRead');

        $this->category = DiyProductCategory::factory()->create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => true
        ]);
    }

    public function test_diy_page_displays_active_products()
    {
        // Create active and inactive products
        $activeProduct = DiyProduct::factory()->create([
            'diy_product_category_id' => $this->category->id,
            'name' => 'Active Product',
            'is_active' => true,
            'base_price' => 99.99
        ]);

        $inactiveProduct = DiyProduct::factory()->create([
            'diy_product_category_id' => $this->category->id,
            'name' => 'Inactive Product',
            'is_active' => false,
            'base_price' => 199.99
        ]);

        $response = $this->get('/diy');

        $response->assertStatus(200);
        $response->assertSee('Active Product');
        $response->assertDontSee('Inactive Product');
        $response->assertSee('$99.99');
    }

    public function test_diy_page_shows_products_by_category()
    {
        $category2 = DiyProductCategory::factory()->create([
            'name' => 'Category 2',
            'slug' => 'category-2',
            'is_active' => true
        ]);

        $product1 = DiyProduct::factory()->create([
            'diy_product_category_id' => $this->category->id,
            'name' => 'Product in Category 1',
            'is_active' => true
        ]);

        $product2 = DiyProduct::factory()->create([
            'diy_product_category_id' => $category2->id,
            'name' => 'Product in Category 2',
            'is_active' => true
        ]);

        $response = $this->get('/diy');

        $response->assertStatus(200);
        $response->assertSee('Test Category');
        $response->assertSee('Category 2');
        $response->assertSee('Product in Category 1');
        $response->assertSee('Product in Category 2');
    }

    public function test_diy_products_display_proper_formatting()
    {
        $product = DiyProduct::factory()->create([
            'diy_product_category_id' => $this->category->id,
            'name' => 'Test Product',
            'description' => 'This is a test product description that should be truncated if too long',
            'base_price' => 123.45,
            'is_active' => true
        ]);

        $response = $this->get('/diy');

        $response->assertStatus(200);
        $response->assertSee('Test Product');
        $response->assertSee('$123.45');
        $response->assertSee('Add to Cart');
    }

    public function test_empty_category_shows_appropriate_message()
    {
        // Create category with no products
        $emptyCategory = DiyProductCategory::factory()->create([
            'name' => 'Empty Category',
            'slug' => 'empty-category',
            'is_active' => true
        ]);

        $response = $this->get('/diy');

        $response->assertStatus(200);
        $response->assertSee('Empty Category');
    }
}