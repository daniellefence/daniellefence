<?php

namespace Tests\Feature\Livewire;

use App\Livewire\AdminBlogs;
use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminBlogsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Blogcategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->admin->createPermission('BlogRead');

        $this->category = Blogcategory::factory()->create([
            'title' => 'Test Category'
        ]);
    }

    public function test_admin_blogs_component_renders()
    {
        Blog::factory()->create([
            'title' => 'Test Blog Post',
            'blogcategory_id' => $this->category->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->assertSee('Test Blog Post')
            ->assertStatus(200);
    }

    public function test_admin_can_search_blogs()
    {
        Blog::factory()->create([
            'title' => 'Fence Installation Guide',
            'blogcategory_id' => $this->category->id
        ]);

        Blog::factory()->create([
            'title' => 'Outdoor Kitchen Tips',
            'blogcategory_id' => $this->category->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->set('search', 'fence')
            ->assertSee('Fence Installation Guide')
            ->assertDontSee('Outdoor Kitchen Tips');
    }

    public function test_admin_can_toggle_blog_publish_status()
    {
        $blog = Blog::factory()->create([
            'title' => 'Draft Blog Post',
            'published' => false,
            'blogcategory_id' => $this->category->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->call('togglePublish', $blog->id);

        $blog->refresh();
        $this->assertTrue($blog->published);
    }

    public function test_admin_blogs_pagination()
    {
        // Create more than 15 blogs (default pagination)
        Blog::factory()->count(20)->create([
            'blogcategory_id' => $this->category->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->assertSee('Next')
            ->call('nextPage')
            ->assertSet('page', 2);
    }

    public function test_admin_can_filter_by_category()
    {
        $category2 = Blogcategory::factory()->create([
            'title' => 'Category 2'
        ]);

        $blog1 = Blog::factory()->create([
            'title' => 'Blog in Category 1',
            'blogcategory_id' => $this->category->id
        ]);

        $blog2 = Blog::factory()->create([
            'title' => 'Blog in Category 2',
            'blogcategory_id' => $category2->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->set('selectedCategory', $this->category->id)
            ->assertSee('Blog in Category 1')
            ->assertDontSee('Blog in Category 2');
    }

    public function test_admin_can_filter_by_published_status()
    {
        Blog::factory()->create([
            'title' => 'Published Blog',
            'published' => true,
            'blogcategory_id' => $this->category->id
        ]);

        Blog::factory()->create([
            'title' => 'Draft Blog',
            'published' => false,
            'blogcategory_id' => $this->category->id
        ]);

        Livewire::actingAs($this->admin)
            ->test(AdminBlogs::class)
            ->set('publishedFilter', 'published')
            ->assertSee('Published Blog')
            ->assertDontSee('Draft Blog');
    }

    public function test_unauthorized_user_cannot_access()
    {
        $unauthorizedUser = User::factory()->create();

        Livewire::actingAs($unauthorizedUser)
            ->test(AdminBlogs::class)
            ->assertForbidden();
    }
}