<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->admin->createPermission('AdminRead');
        $this->admin->createPermission('BlogRead');
        $this->admin->createPermission('ProductRead');
        $this->admin->createPermission('ContactRead');

        $this->regularUser = User::factory()->create();
    }

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_admin_dashboard_requires_permissions()
    {
        $response = $this->actingAs($this->regularUser)
            ->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_dashboard_accessible_with_permissions()
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    public function test_admin_can_view_blog_list()
    {
        Blog::factory()->create([
            'title' => 'Test Blog Post',
            'published' => true
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/blog/read');

        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
    }

    public function test_admin_can_view_contact_list()
    {
        Contact::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'message' => 'Test inquiry'
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/contact/read');

        $response->assertStatus(200);
        $response->assertSee('Test Customer');
        $response->assertSee('customer@test.com');
    }

    public function test_admin_can_view_product_list()
    {
        Product::factory()->create([
            'title' => 'Test Fence Product',
            'hidden' => false
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/product/read');

        $response->assertStatus(200);
        $response->assertSee('Test Fence Product');
    }

    public function test_admin_blog_preview_page()
    {
        $blog = Blog::factory()->create([
            'title' => 'Preview Test Blog',
            'content' => 'This is the blog content for preview',
            'published' => true
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/blog/preview/{$blog->id}");

        $response->assertStatus(200);
        $response->assertSee('Preview Test Blog');
        $response->assertSee('This is the blog content for preview');
    }

    public function test_admin_product_preview_page()
    {
        $product = Product::factory()->create([
            'title' => 'Preview Test Product',
            'content' => 'Product description for preview',
            'hidden' => false
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/product/preview/{$product->id}");

        $response->assertStatus(200);
        $response->assertSee('Preview Test Product');
        $response->assertSee('Product description for preview');
    }

    public function test_permission_system_granular_access()
    {
        $blogOnlyUser = User::factory()->create();
        $blogOnlyUser->createPermission('BlogRead');

        // Can access blog admin
        $response = $this->actingAs($blogOnlyUser)
            ->get('/admin/blog/read');
        $response->assertStatus(200);

        // Cannot access product admin
        $response = $this->actingAs($blogOnlyUser)
            ->get('/admin/product/read');
        $response->assertStatus(403);
    }
}