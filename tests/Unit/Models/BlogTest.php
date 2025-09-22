<?php

namespace Tests\Unit\Models;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogTest extends TestCase
{
    use RefreshDatabase;

    private Blog $blog;

    protected function setUp(): void
    {
        parent::setUp();
        $this->blog = new Blog();
    }

    /** @test */
    public function it_uses_soft_deletes()
    {
        $this->assertContains(SoftDeletes::class, class_uses_recursive(Blog::class));
    }

    /** @test */
    public function it_has_no_guarded_attributes()
    {
        $this->assertEquals([], $this->blog->getGuarded());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $blog->user);
        $this->assertEquals($user->id, $blog->user->id);
    }

    /** @test */
    public function it_has_one_photo()
    {
        $blog = Blog::factory()->create();
        $photo = Photo::factory()->create(['blog_id' => $blog->id]);

        $this->assertInstanceOf(Photo::class, $blog->photo);
        $this->assertEquals($photo->id, $blog->photo->id);
    }

    /** @test */
    public function it_belongs_to_a_blog_category()
    {
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create(['blogcategory_id' => $category->id]);

        $this->assertInstanceOf(Blogcategory::class, $blog->blogcategory);
        $this->assertEquals($category->id, $blog->blogcategory->id);
    }

    /** @test */
    public function it_generates_correct_route_with_category_and_title()
    {
        $category = Blogcategory::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'blogcategory_id' => $category->id,
            'title' => 'Test Blog Title',
            'id' => 1
        ]);

        $expectedRoute = route('blog.read', [
            'id' => 1,
            'category' => urlencode('Test Category'),
            'title' => urlencode('Test Blog Title'),
        ]);

        $this->assertEquals($expectedRoute, $blog->getRoute());
    }

    /** @test */
    public function it_handles_special_characters_in_route_generation()
    {
        $category = Blogcategory::factory()->create(['title' => 'Category & Special Chars!']);
        $blog = Blog::factory()->create([
            'blogcategory_id' => $category->id,
            'title' => 'Blog Title with Spaces & Symbols!',
            'id' => 2
        ]);

        $route = $blog->getRoute();

        $this->assertStringContains(urlencode('Category & Special Chars!'), $route);
        $this->assertStringContains(urlencode('Blog Title with Spaces & Symbols!'), $route);
        $this->assertStringContains('id=2', $route);
    }

    /** @test */
    public function it_can_be_created_with_all_attributes()
    {
        $user = User::factory()->create();
        $category = Blogcategory::factory()->create();

        $blogData = [
            'title' => 'Test Blog Title',
            'content' => 'Test blog content',
            'excerpt' => 'Test excerpt',
            'meta_title' => 'Test Meta Title',
            'meta_description' => 'Test meta description',
            'published' => true,
            'featured' => false,
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
        ];

        $blog = Blog::create($blogData);

        $this->assertDatabaseHas('blogs', $blogData);
        $this->assertEquals($blogData['title'], $blog->title);
        $this->assertEquals($blogData['content'], $blog->content);
        $this->assertEquals($blogData['user_id'], $blog->user_id);
        $this->assertEquals($blogData['blogcategory_id'], $blog->blogcategory_id);
    }

    /** @test */
    public function it_can_be_soft_deleted()
    {
        $blog = Blog::factory()->create();
        $blogId = $blog->id;

        $blog->delete();

        $this->assertSoftDeleted('blogs', ['id' => $blogId]);
        $this->assertNotNull($blog->fresh()->deleted_at);
    }

    /** @test */
    public function it_can_be_restored_after_soft_delete()
    {
        $blog = Blog::factory()->create();
        $blog->delete();

        $this->assertSoftDeleted('blogs', ['id' => $blog->id]);

        $blog->restore();

        $this->assertDatabaseHas('blogs', [
            'id' => $blog->id,
            'deleted_at' => null
        ]);
    }

    /** @test */
    public function get_route_method_returns_string()
    {
        $category = Blogcategory::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'blogcategory_id' => $category->id,
            'title' => 'Test Title'
        ]);

        $route = $blog->getRoute();

        $this->assertIsString($route);
        $this->assertNotEmpty($route);
    }

    /** @test */
    public function user_relationship_returns_null_when_no_user_assigned()
    {
        $blog = Blog::factory()->create(['user_id' => null]);

        $this->assertNull($blog->user);
    }

    /** @test */
    public function photo_relationship_returns_null_when_no_photo_exists()
    {
        $blog = Blog::factory()->create();

        $this->assertNull($blog->photo);
    }

    /** @test */
    public function it_handles_empty_category_title_in_route()
    {
        $category = Blogcategory::factory()->create(['title' => '']);
        $blog = Blog::factory()->create([
            'blogcategory_id' => $category->id,
            'title' => 'Test Title'
        ]);

        $route = $blog->getRoute();

        $this->assertStringContains('category=', $route);
        $this->assertStringContains(urlencode('Test Title'), $route);
    }

    /** @test */
    public function it_handles_empty_blog_title_in_route()
    {
        $category = Blogcategory::factory()->create(['title' => 'Test Category']);
        $blog = Blog::factory()->create([
            'blogcategory_id' => $category->id,
            'title' => ''
        ]);

        $route = $blog->getRoute();

        $this->assertStringContains('title=', $route);
        $this->assertStringContains(urlencode('Test Category'), $route);
    }
}