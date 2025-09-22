<?php

namespace Tests\Unit;

use App\Models\Seo;
use App\Seo as SeoHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_seo_route_resolution()
    {
        Seo::factory()->create([
            'route' => '/test-page',
            'title' => 'Test Page Title',
            'description' => 'Test page meta description',
            'keywords' => 'test, page, keywords'
        ]);

        $seoData = SeoHelper::getSeoForRoute('/test-page');

        $this->assertEquals('Test Page Title', $seoData['title']);
        $this->assertEquals('Test page meta description', $seoData['description']);
        $this->assertEquals('test, page, keywords', $seoData['keywords']);
    }

    public function test_seo_fallback_for_unknown_route()
    {
        $seoData = SeoHelper::getSeoForRoute('/unknown-page');

        $this->assertArrayHasKey('title', $seoData);
        $this->assertArrayHasKey('description', $seoData);
        $this->assertArrayHasKey('keywords', $seoData);
    }

    public function test_seo_title_generation()
    {
        $title = SeoHelper::generateTitle('Custom Page');

        $this->assertStringContainsString('Custom Page', $title);
        $this->assertStringContainsString('Danielle Fence', $title);
    }

    public function test_seo_meta_description_length()
    {
        $longDescription = str_repeat('This is a very long description. ', 20);

        Seo::factory()->create([
            'route' => '/long-desc-page',
            'description' => $longDescription
        ]);

        $seoData = SeoHelper::getSeoForRoute('/long-desc-page');

        // Meta descriptions should be under 160 characters for optimal SEO
        $this->assertLessThanOrEqual(160, strlen($seoData['description']));
    }

    public function test_seo_keywords_formatting()
    {
        $keywords = 'fence, outdoor living, Tampa, residential, commercial';

        Seo::factory()->create([
            'route' => '/keywords-test',
            'keywords' => $keywords
        ]);

        $seoData = SeoHelper::getSeoForRoute('/keywords-test');

        $this->assertEquals($keywords, $seoData['keywords']);
        $this->assertStringContainsString('fence', $seoData['keywords']);
        $this->assertStringContainsString('Tampa', $seoData['keywords']);
    }

    public function test_seo_canonical_url_generation()
    {
        $canonicalUrl = SeoHelper::getCanonicalUrl('/test-page');

        $this->assertStringStartsWith('https://', $canonicalUrl);
        $this->assertStringEndsWith('/test-page', $canonicalUrl);
    }

    public function test_seo_og_tags_generation()
    {
        Seo::factory()->create([
            'route' => '/og-test',
            'title' => 'OG Test Page',
            'description' => 'Open Graph test description',
            'og_image' => '/images/og-test.jpg'
        ]);

        $seoData = SeoHelper::getSeoForRoute('/og-test');

        $this->assertEquals('OG Test Page', $seoData['og_title']);
        $this->assertEquals('Open Graph test description', $seoData['og_description']);
        $this->assertEquals('/images/og-test.jpg', $seoData['og_image']);
    }
}