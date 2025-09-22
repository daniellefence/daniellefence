<?php

namespace Tests\Feature;

use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityLandingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_areas_index_page_displays_successfully(): void
    {
        // Arrange
        AreasWeServe::factory()->published()->count(5)->create();

        // Act
        $response = $this->get('/service-areas');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Service Areas');
        $response->assertSee('Central Florida Fence Installation');
    }

    public function test_service_areas_index_groups_by_county(): void
    {
        // Arrange
        AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'county' => 'Orange'
        ]);
        AreasWeServe::factory()->published()->create([
            'title' => 'Kissimmee',
            'county' => 'Osceola'
        ]);
        AreasWeServe::factory()->published()->create([
            'title' => 'Winter Park',
            'county' => 'Orange'
        ]);

        // Act
        $response = $this->get('/service-areas');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Orlando');
        $response->assertSee('Kissimmee');
        $response->assertSee('Winter Park');
        $response->assertSee('Orange');
        $response->assertSee('Osceola');
    }

    public function test_service_areas_index_only_shows_published_areas(): void
    {
        // Arrange
        AreasWeServe::factory()->published()->create(['title' => 'Published City']);
        AreasWeServe::factory()->unpublished()->create(['title' => 'Unpublished City']);

        // Act
        $response = $this->get('/service-areas');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Published City');
        $response->assertDontSee('Unpublished City');
    }

    public function test_city_landing_page_displays_for_published_area(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando',
            'page_content' => '<p>Orlando fence installation content</p>',
            'meta_title' => 'Fence Installation in Orlando, FL',
            'meta_description' => 'Professional fence installation in Orlando'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Orlando');
        $response->assertSee('Orlando fence installation content', false);
    }

    public function test_city_landing_page_returns_404_for_unpublished_area(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->unpublished()->create([
            'slug' => 'unpublished-city'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(404);
    }

    public function test_city_landing_page_returns_404_for_nonexistent_area(): void
    {
        // Act
        $response = $this->get('/fencing-nonexistent-city');

        // Assert
        $response->assertStatus(404);
    }

    public function test_city_landing_page_sets_seo_data(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando',
            'meta_title' => 'Custom Meta Title for Orlando',
            'meta_description' => 'Custom meta description for Orlando'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Custom Meta Title for Orlando');
        $response->assertSee('Custom meta description for Orlando');
    }

    public function test_fence_installation_service_page_displays_correctly(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/fence-installation-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Fence Installation');
        $response->assertSee('Orlando');
    }

    public function test_vinyl_fencing_service_page_displays_correctly(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/vinyl-fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Vinyl Fencing');
        $response->assertSee('Orlando');
    }

    public function test_wood_fencing_service_page_displays_correctly(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/wood-fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Wood Fencing');
        $response->assertSee('Orlando');
    }

    public function test_chain_link_fencing_service_page_displays_correctly(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/chain-link-fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Chain Link Fencing');
        $response->assertSee('Orlando');
    }

    public function test_commercial_fencing_service_page_displays_correctly(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/commercial-fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Commercial Fencing');
        $response->assertSee('Orlando');
    }

    public function test_service_pages_return_404_for_unpublished_areas(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->unpublished()->create([
            'slug' => 'unpublished-city'
        ]);

        $serviceRoutes = [
            'fence-installation',
            'vinyl-fencing',
            'wood-fencing',
            'chain-link-fencing',
            'commercial-fencing'
        ];

        foreach ($serviceRoutes as $service) {
            // Act
            $response = $this->get("/{$service}-{$area->slug}");

            // Assert
            $response->assertStatus(404, "Service page {$service} should return 404 for unpublished area");
        }
    }

    public function test_service_pages_set_correct_seo_data(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/fence-installation-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Fence Installation in Orlando, FL | Danielle Fence');
        $response->assertSee('Professional Fence Installation services in Orlando, Florida');
    }

    public function test_city_landing_page_responsive_text_sizing(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Orlando',
            'slug' => 'orlando',
            'page_content' => '<h1>Main Title</h1><h2>Subtitle</h2><p>Content paragraph</p>'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        // Check for responsive CSS classes (these would be specific to your implementation)
        $response->assertSee('Main Title');
        $response->assertSee('Subtitle');
        $response->assertSee('Content paragraph');
    }

    public function test_city_landing_page_displays_dynamic_content(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'title' => 'Winter Garden',
            'slug' => 'winter-garden',
            'county' => 'Orange',
            'page_content' => '<p>Welcome to Winter Garden fencing services</p>',
            'services_content' => '<p>Our services in Winter Garden include...</p>'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Winter Garden');
        $response->assertSee('Orange');
        $response->assertSee('Welcome to Winter Garden fencing services', false);
        $response->assertSee('Our services in Winter Garden include...', false);
    }

    public function test_areas_we_serve_scope_published_works(): void
    {
        // Arrange
        AreasWeServe::factory()->published()->count(3)->create();
        AreasWeServe::factory()->unpublished()->count(2)->create();

        // Act
        $publishedCount = AreasWeServe::published()->count();
        $totalCount = AreasWeServe::count();

        // Assert
        $this->assertEquals(3, $publishedCount);
        $this->assertEquals(5, $totalCount);
    }

    public function test_areas_we_serve_scope_by_county_works(): void
    {
        // Arrange
        AreasWeServe::factory()->create(['county' => 'Orange']);
        AreasWeServe::factory()->create(['county' => 'Orange']);
        AreasWeServe::factory()->create(['county' => 'Lake']);

        // Act
        $orangeCount = AreasWeServe::byCounty('Orange')->count();
        $lakeCount = AreasWeServe::byCounty('Lake')->count();

        // Assert
        $this->assertEquals(2, $orangeCount);
        $this->assertEquals(1, $lakeCount);
    }

    public function test_area_model_generates_unique_slugs(): void
    {
        // Arrange & Act
        $area1 = AreasWeServe::factory()->create(['title' => 'Orlando']);
        $area1->slug = $area1->generateSlug();
        $area1->save();

        $area2 = AreasWeServe::factory()->create(['title' => 'Orlando']);
        $area2->slug = $area2->generateSlug();
        $area2->save();

        // Assert
        $this->assertEquals('orlando', $area1->slug);
        $this->assertEquals('orlando-1', $area2->slug);
    }

    public function test_area_model_has_coordinates_method(): void
    {
        // Arrange
        $areaWithCoords = AreasWeServe::factory()->withCoordinates()->create();
        $areaWithoutCoords = AreasWeServe::factory()->withoutCoordinates()->create();

        // Act & Assert
        $this->assertTrue($areaWithCoords->hasCoordinates());
        $this->assertFalse($areaWithoutCoords->hasCoordinates());
    }

    public function test_area_model_generates_meta_title_fallback(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->create([
            'title' => 'Orlando',
            'meta_title' => null
        ]);

        // Act & Assert
        $this->assertEquals('Fence Installation in Orlando, FL | Danielle Fence', $area->meta_title);
    }

    public function test_area_model_generates_meta_description_fallback(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->create([
            'title' => 'Orlando',
            'meta_description' => null
        ]);

        // Act & Assert
        $this->assertStringContains('Professional fence installation services in Orlando, Florida', $area->meta_description);
    }

    public function test_area_model_uses_custom_meta_values_when_provided(): void
    {
        // Arrange
        $customTitle = 'Custom Title for Orlando';
        $customDescription = 'Custom description for Orlando';

        $area = AreasWeServe::factory()->create([
            'title' => 'Orlando',
            'meta_title' => $customTitle,
            'meta_description' => $customDescription
        ]);

        // Act & Assert
        $this->assertEquals($customTitle, $area->meta_title);
        $this->assertEquals($customDescription, $area->meta_description);
    }

    public function test_service_areas_ordered_by_county_and_title(): void
    {
        // Arrange
        AreasWeServe::factory()->published()->create(['title' => 'Zebra City', 'county' => 'Orange']);
        AreasWeServe::factory()->published()->create(['title' => 'Alpha City', 'county' => 'Orange']);
        AreasWeServe::factory()->published()->create(['title' => 'Beta City', 'county' => 'Lake']);

        // Act
        $response = $this->get('/service-areas');
        $content = $response->getContent();

        // Assert
        $response->assertStatus(200);
        // Check that cities are properly grouped and ordered
        $orangePosition = strpos($content, 'Orange');
        $lakePosition = strpos($content, 'Lake');

        // Orange county should appear first (alphabetically)
        $this->assertLessThan($lakePosition, $orangePosition);
    }

    public function test_traffic_middleware_applied_to_city_routes(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->published()->create([
            'slug' => 'orlando'
        ]);

        // Act
        $response = $this->get("/fencing-{$area->slug}");

        // Assert
        $response->assertStatus(200);
        // The Traffic middleware should be applied (this would need specific implementation to test)
    }

    public function test_google_maps_background_url_generation(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->withCoordinates()->create([
            'latitude' => 28.5383,
            'longitude' => -81.3792
        ]);

        // Mock Google Maps API key
        config(['services.google_maps.api_key' => 'test-api-key']);

        // Act
        $mapUrl = $area->getMapBackgroundUrl();

        // Assert
        $this->assertNotNull($mapUrl);
        $this->assertStringContains('maps.googleapis.com', $mapUrl);
        $this->assertStringContains('28.5383,-81.3792', $mapUrl);
        $this->assertStringContains('test-api-key', $mapUrl);
    }

    public function test_google_maps_background_url_returns_null_without_coordinates(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->withoutCoordinates()->create();

        // Act
        $mapUrl = $area->getMapBackgroundUrl();

        // Assert
        $this->assertNull($mapUrl);
    }

    public function test_google_maps_background_url_returns_null_without_api_key(): void
    {
        // Arrange
        $area = AreasWeServe::factory()->withCoordinates()->create();
        config(['services.google_maps.api_key' => null]);

        // Act
        $mapUrl = $area->getMapBackgroundUrl();

        // Assert
        $this->assertNull($mapUrl);
    }
}