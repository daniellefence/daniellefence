<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Blogcategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Blogcategory::factory()->create([
            'title' => 'Fencing Tips',
            'hidden' => false
        ]);
    }

    public function test_blog_index_displays_published_posts()
    {
        $publishedBlog = Blog::factory()->create([
            'title' => 'Published Blog Post',
            'content' => 'This is published content',
            'published' => true,
            'hidden' => false,
            'blogcategory_id' => $this->category->id
        ]);

        $unpublishedBlog = Blog::factory()->create([
            'title' => 'Unpublished Blog Post',
            'content' => 'This is unpublished content',
            'published' => false,
            'hidden' => false,
            'blogcategory_id' => $this->category->id
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Published Blog Post');
        $response->assertDontSee('Unpublished Blog Post');
    }

    public function test_blog_detail_page_shows_full_content()
    {
        $blog = Blog::factory()->create([
            'title' => 'Detailed Blog Post',
            'content' => 'This is the full blog content with detailed information',
            'published' => true,
            'hidden' => false,
            'blogcategory_id' => $this->category->id
        ]);

        $response = $this->get("/blog/{$blog->id}/detailed-blog-post");

        $response->assertStatus(200);
        $response->assertSee('Detailed Blog Post');
        $response->assertSee('This is the full blog content with detailed information');
        $response->assertSee($this->category->title);
    }

    public function test_hidden_blogs_not_accessible()
    {
        $hiddenBlog = Blog::factory()->create([
            'title' => 'Hidden Blog Post',
            'content' => 'This should not be accessible',
            'published' => true,
            'hidden' => true,
            'blogcategory_id' => $this->category->id
        ]);

        $response = $this->get("/blog/{$hiddenBlog->id}/hidden-blog-post");

        $response->assertStatus(404);
    }

    public function test_blog_category_filtering()
    {
        $category2 = Blogcategory::factory()->create([
            'title' => 'Outdoor Living',
            'hidden' => false
        ]);

        $fencingBlog = Blog::factory()->create([
            'title' => 'Fencing Guide',
            'blogcategory_id' => $this->category->id,
            'published' => true,
            'hidden' => false
        ]);

        $outdoorBlog = Blog::factory()->create([
            'title' => 'Outdoor Kitchen Tips',
            'blogcategory_id' => $category2->id,
            'published' => true,
            'hidden' => false
        ]);

        $response = $this->get("/blog/category/{$this->category->id}/fencing-tips");

        $response->assertStatus(200);
        $response->assertSee('Fencing Guide');
        $response->assertDontSee('Outdoor Kitchen Tips');
    }

    public function test_blog_seo_meta_tags()
    {
        $blog = Blog::factory()->create([
            'title' => 'SEO Test Blog',
            'content' => 'Content for SEO testing',
            'meta_description' => 'This is the meta description for SEO',
            'published' => true,
            'hidden' => false,
            'blogcategory_id' => $this->category->id
        ]);

        $response = $this->get("/blog/{$blog->id}/seo-test-blog");

        $response->assertStatus(200);
        $response->assertSee('This is the meta description for SEO', false);
    }
}