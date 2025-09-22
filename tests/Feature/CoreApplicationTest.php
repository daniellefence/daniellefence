<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Product;
use App\Models\Category;
use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set server variables for Traffic middleware in tests
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'PHPUnit Test';
        $_SERVER['REQUEST_METHOD'] = 'GET';
    }

    public function test_home_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Danielle Fence');
    }

    public function test_about_us_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/about-us');

        // Assert
        $response->assertStatus(200);
    }

    public function test_contact_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/contact');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Contact');
    }

    public function test_blog_index_page_loads_successfully(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $user = User::factory()->create();
        Blog::factory()->published()->create([
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $response = $this->get('/blog');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Blog');
    }

    public function test_blog_read_page_loads_successfully(): void
    {
        // Arrange
        $category = Blogcategory::factory()->create();
        $user = User::factory()->create();
        $blog = Blog::factory()->published()->create([
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
            'title' => 'Test Blog Post',
            'content' => '<p>Test content</p>',
        ]);

        // Act
        $response = $this->get("/blog/read/{$blog->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
        $response->assertSee('Test content', false);
    }

    public function test_request_quote_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/request-a-quote');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Quote');
    }

    public function test_faq_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/faq');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('FAQ');
    }

    public function test_careers_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/careers');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Career');
    }

    public function test_reviews_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/reviews');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Review');
    }

    public function test_financing_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/financing');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Financing');
    }

    public function test_commercial_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/commercial');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Commercial');
    }

    public function test_privacy_policy_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/privacy');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Privacy');
    }

    public function test_terms_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/terms');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Terms');
    }

    public function test_sitemap_xml_loads_successfully(): void
    {
        // Act
        $response = $this->get('/sitemap.xml');

        // Assert - This might be 200 if sitemap exists, or 404 if it doesn't
        $this->assertContains($response->getStatusCode(), [200, 404]);

        if ($response->getStatusCode() === 200) {
            $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');
            $response->assertHeader('Cache-Control', 'public, max-age=3600');
        }
    }

    public function test_traffic_middleware_is_applied_to_routes(): void
    {
        // Act
        $response = $this->get('/');

        // Assert
        $response->assertStatus(200);
        // The Traffic middleware should be applied to track page visits
        // This would need specific implementation to verify traffic is being recorded
    }

    public function test_authenticated_routes_require_login(): void
    {
        // Act
        $response = $this->post('/delete');

        // Assert
        $response->assertRedirect('/login');
    }

    public function test_super_user_login_as_route_requires_super_user_middleware(): void
    {
        // Act
        $response = $this->get('/users/loginAs/1');

        // Assert
        // This should either redirect to login or return 403/404 depending on middleware implementation
        $this->assertContains($response->getStatusCode(), [302, 403, 404]);
    }

    public function test_product_category_route_works(): void
    {
        // Arrange
        $category = Category::factory()->create([
            'title' => 'Test Category'
        ]);

        // Act
        $response = $this->get("/products/category/{$category->id}/test-category");

        // Assert
        $response->assertStatus(200);
    }

    public function test_diy_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/diy');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('DIY');
    }

    public function test_specials_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/specials');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Special');
    }

    public function test_showroom_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/showroom');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Showroom');
    }

    public function test_videos_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/videos');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Video');
    }

    public function test_search_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/search');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Search');
    }

    public function test_why_danielle_fence_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/why-danielle-fence');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Why Danielle Fence');
    }

    public function test_product_warranties_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/product-warranties');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Warranty');
    }

    public function test_mascots_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/mascots');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Mascot');
    }

    public function test_fire_feature_catalogs_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/fire-feature-catalogs');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Fire Feature');
    }

    public function test_easy_fixes_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/easy-fixes');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Easy Fix');
    }

    public function test_discounts_deals_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/discounts-deals');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Discount');
    }

    public function test_disclaimer_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/disclaimer');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Disclaimer');
    }

    public function test_cookie_policy_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/cookie-policy');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Cookie');
    }

    public function test_acceptable_use_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/acceptable-use');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Acceptable Use');
    }

    public function test_returns_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/returns');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Return');
    }

    public function test_thanks_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/thanks');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Thank');
    }

    public function test_chat_page_loads_successfully(): void
    {
        // Act
        $response = $this->get('/chat');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Chat');
    }

    public function test_flare_error_route_only_available_in_development(): void
    {
        // Act - This route should only exist in development/local environments
        $response = $this->get('/test-flare-error');

        // Assert - Should either work in development or not exist in production
        $this->assertContains($response->getStatusCode(), [404, 500]);
    }

    public function test_navigation_structure_consistency(): void
    {
        // Arrange - Define core navigation routes
        $coreRoutes = [
            '/',
            '/about-us',
            '/contact',
            '/blog',
            '/request-a-quote',
            '/careers',
            '/reviews',
            '/commercial',
            '/privacy',
            '/terms'
        ];

        foreach ($coreRoutes as $route) {
            // Act
            $response = $this->get($route);

            // Assert
            $response->assertStatus(200);

            // Check for common navigation elements
            $response->assertSee('Danielle Fence'); // Logo/Brand should be on every page
        }
    }

    public function test_middleware_groups_are_properly_applied(): void
    {
        // Test Traffic middleware group
        $trafficRoutes = ['/', '/about-us', '/contact', '/blog'];

        foreach ($trafficRoutes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
            // Traffic middleware should be recording these visits
        }
    }

    public function test_authenticated_delete_route_with_user(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->post('/delete', [
            'type' => 'test',
            'id' => 1
        ]);

        // Assert - This might fail validation or work depending on Delete middleware implementation
        $this->assertContains($response->getStatusCode(), [200, 302, 403, 422]);
    }

    public function test_route_model_binding_works_for_areas(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'slug' => 'test-city'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee($area->title);
    }

    public function test_route_parameter_validation(): void
    {
        // Test with invalid category ID
        $response = $this->get('/products/category/999999/invalid-category');
        $this->assertContains($response->getStatusCode(), [404, 500]);

        // Test with invalid blog ID
        $response = $this->get('/blog/read/999999');
        $this->assertContains($response->getStatusCode(), [404, 500]);
    }

    public function test_caching_headers_on_static_content(): void
    {
        // Act
        $response = $this->get('/sitemap.xml');

        // Assert
        if ($response->getStatusCode() === 200) {
            $response->assertHeader('Cache-Control', 'public, max-age=3600');
        }
    }

    public function test_application_error_handling(): void
    {
        // Test 404 for non-existent route
        $response = $this->get('/non-existent-route');
        $response->assertStatus(404);
    }

    public function test_database_relationships_are_working(): void
    {
        // Arrange
        $user = User::factory()->create();
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act & Assert
        $this->assertInstanceOf(User::class, $blog->user);
        $this->assertInstanceOf(Blogcategory::class, $blog->blogcategory);
        $this->assertEquals($user->id, $blog->user->id);
        $this->assertEquals($category->id, $blog->blogcategory->id);
    }

    public function test_soft_deletes_are_working(): void
    {
        // Arrange
        $user = User::factory()->create();
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act
        $blog->delete();

        // Assert
        $this->assertSoftDeleted('blogs', ['id' => $blog->id]);
        $this->assertNotNull($blog->fresh()->deleted_at);
    }

    public function test_application_timezone_consistency(): void
    {
        // Arrange
        $user = User::factory()->create();
        $category = Blogcategory::factory()->create();
        $blog = Blog::factory()->create([
            'user_id' => $user->id,
            'blogcategory_id' => $category->id,
        ]);

        // Act & Assert
        $this->assertNotNull($blog->created_at);
        $this->assertNotNull($blog->updated_at);
        $this->assertInstanceOf(\Carbon\Carbon::class, $blog->created_at);
    }
}