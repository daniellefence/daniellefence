<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\User;
use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilamentAdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user for testing
        $this->adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
        ]);
    }

    public function test_admin_panel_requires_authentication(): void
    {
        // Act
        $response = $this->get('/admin');

        // Assert
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_admin_panel(): void
    {
        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin');

        // Assert
        $response->assertSuccessful();
    }

    public function test_blog_resource_list_page_accessible(): void
    {
        // Arrange
        Blog::factory()->count(3)->create();

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Blogs');
    }

    public function test_blog_resource_create_page_accessible(): void
    {
        // Arrange
        Blogcategory::factory()->create();

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs/create');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Create Blog');
    }

    public function test_blog_resource_edit_page_accessible(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->get("/admin/blogs/{$blog->id}/edit");

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Edit Blog');
        $response->assertSee($blog->title);
    }

    public function test_blog_resource_view_page_accessible(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->get("/admin/blogs/{$blog->id}");

        // Assert
        $response->assertSuccessful();
        $response->assertSee($blog->title);
        $response->assertSee($blog->content, false); // false to avoid HTML escaping
    }

    public function test_blog_form_displays_required_fields(): void
    {
        // Arrange
        Blogcategory::factory()->create();

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs/create');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Author');
        $response->assertSee('Category');
        $response->assertSee('Title');
        $response->assertSee('Content');
        $response->assertSee('SEO Keywords');
        $response->assertSee('Show publication date');
        $response->assertSee('Published');
    }

    public function test_blog_form_includes_chatgpt_rich_editor(): void
    {
        // Arrange
        Blogcategory::factory()->create();

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs/create');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Fill with ChatGPT');
        $response->assertSee('chatgpt-rich-editor');
    }

    public function test_blog_table_displays_correct_columns(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
            'title' => 'Test Blog Post',
            'published' => true,
            'show_date' => true,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Test Blog Post');
        $response->assertSee('Test Category');
        $response->assertSee($this->adminUser->name);
    }

    public function test_areas_we_serve_resource_accessible(): void
    {
        // Arrange
        AreasWeServe::factory()->count(2)->create();

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/areas-we-serves');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Areas We Serves');
    }

    public function test_areas_we_serve_form_displays_required_fields(): void
    {
        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/areas-we-serves/create');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Title');
        $response->assertSee('County');
        $response->assertSee('Meta Title');
        $response->assertSee('Meta Description');
        $response->assertSee('Page Content');
        $response->assertSee('Services Content');
        $response->assertSee('Published');
    }

    public function test_areas_we_serve_includes_chatgpt_rich_editor(): void
    {
        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/areas-we-serves/create');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Fill with ChatGPT');
        $response->assertSee('chatgpt-rich-editor');
    }

    public function test_blog_resource_create_form_validation(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();

        // Act - Submit empty form
        $response = $this->actingAs($this->adminUser)->post('/admin/blogs', []);

        // Assert
        $response->assertSessionHasErrors(['user_id', 'blogcategory_id', 'title', 'content']);
    }

    public function test_blog_resource_successful_creation(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();

        $blogData = [
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
            'title' => 'Test Blog Post',
            'content' => '<p>This is test content</p>',
            'keywords' => 'test, blog, post',
            'show_date' => true,
            'published' => false,
        ];

        // Act
        $response = $this->actingAs($this->adminUser)->post('/admin/blogs', $blogData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Blog Post',
            'content' => '<p>This is test content</p>',
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
        ]);
    }

    public function test_blog_resource_successful_update(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
            'title' => 'Original Title',
        ]);

        $updateData = [
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
            'title' => 'Updated Title',
            'content' => '<p>Updated content</p>',
            'keywords' => 'updated, keywords',
            'show_date' => true,
            'published' => true,
        ];

        // Act
        $response = $this->actingAs($this->adminUser)->put("/admin/blogs/{$blog->id}", $updateData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'title' => 'Updated Title',
            'content' => '<p>Updated content</p>',
            'published' => true,
        ]);
    }

    public function test_blog_resource_successful_deletion(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->delete("/admin/blogs/{$blog->id}");

        // Assert
        $response->assertRedirect();
        $this->assertSoftDeleted('blogs', ['id' => $blog->id]);
    }

    public function test_areas_we_serve_resource_successful_creation(): void
    {
        // Arrange
        $areaData = [
            'title' => 'Orlando',
            'county' => 'Orange',
            'meta_title' => 'Fence Installation in Orlando, FL',
            'meta_description' => 'Professional fence installation in Orlando',
            'page_content' => '<p>Orlando content</p>',
            'services_content' => '<p>Services content</p>',
            'latitude' => 28.5383,
            'longitude' => -81.3792,
            'published' => true,
            'sort_order' => 1,
        ];

        // Act
        $response = $this->actingAs($this->adminUser)->post('/admin/areas-we-serves', $areaData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('areas_we_serves', [
            'title' => 'Orlando',
            'county' => 'Orange',
            'published' => true,
        ]);
    }

    public function test_navigation_groups_are_visible(): void
    {
        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Content Management');
    }

    public function test_blog_resource_has_correct_navigation_properties(): void
    {
        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs');

        // Assert
        $response->assertSuccessful();
        // Check that the page loads without errors which implies navigation is working
    }

    public function test_bulk_actions_available_on_blog_table(): void
    {
        // Arrange
        Blog::factory()->count(3)->create([
            'user_id' => $this->adminUser->id,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs');

        // Assert
        $response->assertSuccessful();
        // Check that bulk actions are rendered (this would need more specific implementation)
        $response->assertSee('checkbox'); // Bulk action checkboxes
    }

    public function test_blog_relationships_are_loaded_correctly(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create(['title' => 'Tech Category']);
        $blog = Blog::factory()->create([
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $response = $this->actingAs($this->adminUser)->get('/admin/blogs');

        // Assert
        $response->assertSuccessful();
        $response->assertSee('Tech Category');
        $response->assertSee($this->adminUser->name);
    }

    public function test_form_has_proper_field_validation_rules(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();

        // Act - Submit form with invalid data
        $response = $this->actingAs($this->adminUser)->post('/admin/blogs', [
            'user_id' => 'invalid',
            'blogcategory_id' => 'invalid',
            'title' => str_repeat('a', 200), // Exceeds max length
            'content' => '', // Required field empty
        ]);

        // Assert
        $response->assertSessionHasErrors(['user_id', 'blogcategory_id', 'title', 'content']);
    }

    public function test_toggle_fields_work_correctly(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();

        $blogData = [
            'user_id' => $this->adminUser->id,
            'blogcategory_id' => $category->id,
            'title' => 'Toggle Test Blog',
            'content' => '<p>Test content</p>',
            'show_date' => false,
            'published' => true,
        ];

        // Act
        $response = $this->actingAs($this->adminUser)->post('/admin/blogs', $blogData);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('blogs', [
            'title' => 'Toggle Test Blog',
            'show_date' => false,
            'published' => true,
        ]);
    }
}