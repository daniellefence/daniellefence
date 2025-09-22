<?php

namespace Tests\Unit\Models;

use App\Models\AreasWeServe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AreasWeServeTest extends TestCase
{
    use RefreshDatabase;

    private AreasWeServe $area;

    protected function setUp(): void
    {
        parent::setUp();
        $this->area = new AreasWeServe();
    }

    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $expectedFillable = [
            'title',
            'slug',
            'county',
            'meta_title',
            'meta_description',
            'page_content',
            'services_content',
            'latitude',
            'longitude',
            'published',
            'sort_order'
        ];

        $this->assertEquals($expectedFillable, $this->area->getFillable());
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $expectedCasts = [
            'published' => 'boolean',
            'sort_order' => 'integer',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8'
        ];

        $casts = $this->area->getCasts();

        foreach ($expectedCasts as $attribute => $expectedCast) {
            $this->assertEquals($expectedCast, $casts[$attribute]);
        }
    }

    /** @test */
    public function it_uses_slug_as_route_key()
    {
        $this->assertEquals('slug', $this->area->getRouteKeyName());
    }

    /** @test */
    public function it_generates_unique_slug_from_title()
    {
        $area = AreasWeServe::factory()->create(['title' => 'Test City']);

        $slug = $area->generateSlug();

        $this->assertEquals('test-city', $slug);
    }

    /** @test */
    public function it_generates_unique_slug_when_duplicate_exists()
    {
        // Create existing area with slug
        AreasWeServe::factory()->create(['title' => 'Test City', 'slug' => 'test-city']);

        $newArea = new AreasWeServe(['title' => 'Test City']);
        $slug = $newArea->generateSlug();

        $this->assertEquals('test-city-1', $slug);
    }

    /** @test */
    public function it_generates_incremented_slug_for_multiple_duplicates()
    {
        // Create existing areas
        AreasWeServe::factory()->create(['slug' => 'test-city']);
        AreasWeServe::factory()->create(['slug' => 'test-city-1']);
        AreasWeServe::factory()->create(['slug' => 'test-city-2']);

        $newArea = new AreasWeServe(['title' => 'Test City']);
        $slug = $newArea->generateSlug();

        $this->assertEquals('test-city-3', $slug);
    }

    /** @test */
    public function it_excludes_current_record_when_generating_slug()
    {
        $area = AreasWeServe::factory()->create(['title' => 'Test City', 'slug' => 'test-city']);

        // Should not increment since it's the same record
        $slug = $area->generateSlug();

        $this->assertEquals('test-city', $slug);
    }

    /** @test */
    public function it_returns_default_meta_title_when_none_provided()
    {
        $area = AreasWeServe::factory()->create([
            'title' => 'Miami',
            'meta_title' => null
        ]);

        $expectedMetaTitle = "Fence Installation in Miami, FL | Danielle Fence";

        $this->assertEquals($expectedMetaTitle, $area->meta_title);
    }

    /** @test */
    public function it_returns_custom_meta_title_when_provided()
    {
        $customMetaTitle = "Custom Meta Title for Miami";
        $area = AreasWeServe::factory()->create([
            'title' => 'Miami',
            'meta_title' => $customMetaTitle
        ]);

        $this->assertEquals($customMetaTitle, $area->meta_title);
    }

    /** @test */
    public function it_returns_default_meta_description_when_none_provided()
    {
        $area = AreasWeServe::factory()->create([
            'title' => 'Miami',
            'meta_description' => null
        ]);

        $expectedMetaDescription = "Professional fence installation services in Miami, Florida. Commercial & residential fencing, vinyl, wood, chain link. Licensed & insured. Free estimates!";

        $this->assertEquals($expectedMetaDescription, $area->meta_description);
    }

    /** @test */
    public function it_returns_custom_meta_description_when_provided()
    {
        $customMetaDescription = "Custom meta description for Miami";
        $area = AreasWeServe::factory()->create([
            'title' => 'Miami',
            'meta_description' => $customMetaDescription
        ]);

        $this->assertEquals($customMetaDescription, $area->meta_description);
    }

    /** @test */
    public function published_scope_returns_only_published_areas()
    {
        AreasWeServe::factory()->create(['published' => true, 'title' => 'Published Area']);
        AreasWeServe::factory()->create(['published' => false, 'title' => 'Unpublished Area']);

        $publishedAreas = AreasWeServe::published()->get();

        $this->assertCount(1, $publishedAreas);
        $this->assertEquals('Published Area', $publishedAreas->first()->title);
    }

    /** @test */
    public function by_county_scope_filters_by_county()
    {
        AreasWeServe::factory()->create(['county' => 'Miami-Dade', 'title' => 'Miami']);
        AreasWeServe::factory()->create(['county' => 'Broward', 'title' => 'Fort Lauderdale']);
        AreasWeServe::factory()->create(['county' => 'Miami-Dade', 'title' => 'Homestead']);

        $miamiDadeAreas = AreasWeServe::byCounty('Miami-Dade')->get();

        $this->assertCount(2, $miamiDadeAreas);
        $this->assertEquals('Miami-Dade', $miamiDadeAreas->first()->county);
        $this->assertEquals('Miami-Dade', $miamiDadeAreas->last()->county);
    }

    /** @test */
    public function it_returns_null_map_background_url_when_no_coordinates()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => null,
            'longitude' => null
        ]);

        $this->assertNull($area->getMapBackgroundUrl());
    }

    /** @test */
    public function it_returns_null_map_background_url_when_no_api_key()
    {
        Config::shouldReceive('services.google_maps.api_key')->andReturn(null);

        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => -80.1918
        ]);

        $this->assertNull($area->getMapBackgroundUrl());
    }

    /** @test */
    public function it_generates_correct_map_background_url_with_coordinates_and_api_key()
    {
        Config::shouldReceive('services.google_maps.api_key')->andReturn('test-api-key');

        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => -80.1918
        ]);

        $url = $area->getMapBackgroundUrl();

        $this->assertStringContains('https://maps.googleapis.com/maps/api/staticmap', $url);
        $this->assertStringContains('center=25.7617%2C-80.1918', $url);
        $this->assertStringContains('zoom=11', $url);
        $this->assertStringContains('size=1920x1080', $url);
        $this->assertStringContains('key=test-api-key', $url);
    }

    /** @test */
    public function it_accepts_custom_dimensions_for_map_background_url()
    {
        Config::shouldReceive('services.google_maps.api_key')->andReturn('test-api-key');

        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => -80.1918
        ]);

        $url = $area->getMapBackgroundUrl(800, 600, 15);

        $this->assertStringContains('size=800x600', $url);
        $this->assertStringContains('zoom=15', $url);
    }

    /** @test */
    public function has_coordinates_returns_true_when_both_coordinates_present()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => -80.1918
        ]);

        $this->assertTrue($area->hasCoordinates());
    }

    /** @test */
    public function has_coordinates_returns_false_when_latitude_missing()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => null,
            'longitude' => -80.1918
        ]);

        $this->assertFalse($area->hasCoordinates());
    }

    /** @test */
    public function has_coordinates_returns_false_when_longitude_missing()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => null
        ]);

        $this->assertFalse($area->hasCoordinates());
    }

    /** @test */
    public function has_coordinates_returns_false_when_both_coordinates_missing()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => null,
            'longitude' => null
        ]);

        $this->assertFalse($area->hasCoordinates());
    }

    /** @test */
    public function it_casts_published_to_boolean()
    {
        $area = AreasWeServe::factory()->create(['published' => 1]);

        $this->assertIsBool($area->published);
        $this->assertTrue($area->published);
    }

    /** @test */
    public function it_casts_sort_order_to_integer()
    {
        $area = AreasWeServe::factory()->create(['sort_order' => '10']);

        $this->assertIsInt($area->sort_order);
        $this->assertEquals(10, $area->sort_order);
    }

    /** @test */
    public function it_casts_coordinates_to_decimal()
    {
        $area = AreasWeServe::factory()->create([
            'latitude' => '25.76170000',
            'longitude' => '-80.19180000'
        ]);

        $this->assertEquals('25.76170000', $area->latitude);
        $this->assertEquals('-80.19180000', $area->longitude);
    }

    /** @test */
    public function it_can_be_created_with_all_fillable_attributes()
    {
        $areaData = [
            'title' => 'Test City',
            'slug' => 'test-city',
            'county' => 'Test County',
            'meta_title' => 'Custom Meta Title',
            'meta_description' => 'Custom meta description',
            'page_content' => 'Page content here',
            'services_content' => 'Services content here',
            'latitude' => 25.7617,
            'longitude' => -80.1918,
            'published' => true,
            'sort_order' => 1
        ];

        $area = AreasWeServe::create($areaData);

        $this->assertDatabaseHas('areas_we_serves', $areaData);
        foreach ($areaData as $key => $value) {
            $this->assertEquals($value, $area->$key);
        }
    }

    /** @test */
    public function it_includes_map_styles_in_background_url()
    {
        Config::shouldReceive('services.google_maps.api_key')->andReturn('test-api-key');

        $area = AreasWeServe::factory()->create([
            'latitude' => 25.7617,
            'longitude' => -80.1918
        ]);

        $url = $area->getMapBackgroundUrl();

        $this->assertStringContains('style=', $url);
        $this->assertStringContains('feature%3Awater', $url);
        $this->assertStringContains('color%3A0x46bcec', $url);
    }
}