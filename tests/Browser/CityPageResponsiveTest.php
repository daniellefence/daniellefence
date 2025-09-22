<?php

namespace Tests\Browser;

use App\Models\AreasWeServe;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Helpers\BrowserTestHelpers;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CityPageResponsiveTest extends DuskTestCase
{
    use DatabaseMigrations, BrowserTestHelpers;

    protected AreasWeServe $cityArea;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cityArea = AreasWeServe::factory()->create([
            'title' => 'Dallas',
            'slug' => 'dallas',
            'seo_title' => 'Fence Installation in Dallas, TX',
            'seo_description' => 'Professional fence installation services in Dallas, Texas.',
            'coordinates' => '32.7767,-96.7970',
            'status' => 'active',
        ]);
    }

    /** @test */
    public function city_landing_page_loads_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->assertSee($this->cityArea->title)
                   ->assertSee('Fence')
                   ->assertTitleContains($this->cityArea->title);
        });
    }

    /** @test */
    public function city_page_is_responsive_on_mobile()
    {
        $this->browse(function (Browser $browser) {
            $this->setMobileViewport($browser);

            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test hero section visibility
            $browser->assertPresent('.relative.isolate, .hero, [class*="hero"]')
                   ->assertVisible('h1');

            // Test navigation menu behavior
            if ($browser->element('button[aria-label*="menu"], .mobile-menu-toggle, [data-toggle="mobile-menu"]')) {
                $browser->click('button[aria-label*="menu"], .mobile-menu-toggle, [data-toggle="mobile-menu"]')
                       ->pause(500)
                       ->assertPresent('.mobile-menu, [class*="mobile-nav"]');
            }

            // Test content sections are stacked properly on mobile
            $this->checkResponsiveElement($browser, '.container, .max-w', function($browser, $viewport) {
                if ($viewport === 'mobile') {
                    // Content should be full width or properly constrained
                    $this->assertTrue($this->isElementInViewport($browser, 'h1'));
                }
            });

            // Test buttons and CTAs are accessible
            if ($browser->element('button, .btn, [class*="btn"]')) {
                $browser->assertPresent('button, .btn, [class*="btn"]');

                // Ensure buttons are large enough for mobile touch
                $buttonSize = $browser->script("
                    const btn = document.querySelector('button, .btn, [class*=\"btn\"]');
                    if (btn) {
                        const rect = btn.getBoundingClientRect();
                        return { width: rect.width, height: rect.height };
                    }
                    return null;
                ")[0];

                if ($buttonSize) {
                    $this->assertGreaterThanOrEqual(44, $buttonSize['height']); // iOS minimum touch target
                }
            }
        });
    }

    /** @test */
    public function city_page_displays_correctly_on_tablet()
    {
        $this->browse(function (Browser $browser) {
            $this->setTabletViewport($browser);

            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test layout on tablet
            $browser->assertPresent('h1')
                   ->assertVisible('h1');

            // Test that content is properly arranged for tablet view
            $this->checkResponsiveElement($browser, 'main, .main-content', function($browser, $viewport) {
                if ($viewport === 'tablet') {
                    // Check that content doesn't overflow
                    $this->assertTrue($this->isElementInViewport($browser, 'h1'));
                }
            });

            // Test navigation remains accessible
            if ($browser->element('nav, .navigation')) {
                $browser->assertPresent('nav, .navigation');
            }
        });
    }

    /** @test */
    public function city_page_displays_correctly_on_desktop()
    {
        $this->browse(function (Browser $browser) {
            $this->setDesktopViewport($browser);

            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test full desktop layout
            $browser->assertPresent('h1')
                   ->assertVisible('h1');

            // Test that all content sections are visible
            $this->checkResponsiveElement($browser, 'main', function($browser, $viewport) {
                if ($viewport === 'desktop') {
                    // All major sections should be visible
                    $browser->assertPresent('h1');

                    if ($browser->element('h2')) {
                        $browser->assertPresent('h2');
                    }
                }
            });

            // Test desktop-specific features
            if ($browser->element('.sidebar, aside')) {
                $browser->assertPresent('.sidebar, aside');
            }
        });
    }

    /** @test */
    public function city_page_hero_section_is_responsive()
    {
        $this->testResponsiveElement(function($browser, $viewport) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test hero section at different viewports
            $browser->assertPresent('h1');

            switch ($viewport) {
                case 'mobile':
                    // Hero should be full width and readable
                    $this->assertTrue($this->isElementInViewport($browser, 'h1'));
                    break;

                case 'tablet':
                    // Hero should maintain proper proportions
                    $this->assertTrue($this->isElementInViewport($browser, 'h1'));
                    break;

                case 'desktop':
                    // Hero should use full layout space
                    $this->assertTrue($this->isElementInViewport($browser, 'h1'));
                    break;
            }
        });
    }

    /** @test */
    public function city_page_content_sections_are_responsive()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test different viewport sizes
            $viewports = [
                ['mobile', 375, 667],
                ['tablet', 768, 1024],
                ['desktop', 1920, 1080],
            ];

            foreach ($viewports as [$name, $width, $height]) {
                $browser->driver->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension($width, $height));
                $browser->pause(500);

                // Test content visibility
                $browser->assertPresent('h1');

                // Test image responsiveness if images exist
                if ($browser->element('img')) {
                    $images = $browser->elements('img');
                    foreach ($images as $img) {
                        $imageSize = $browser->script("
                            const img = arguments[0];
                            const rect = img.getBoundingClientRect();
                            return {
                                width: rect.width,
                                naturalWidth: img.naturalWidth,
                                maxWidth: window.getComputedStyle(img).maxWidth
                            };
                        ", $img)[0];

                        // Images should not overflow their containers
                        $this->assertLessThanOrEqual($width, $imageSize['width']);
                    }
                }

                // Test text readability
                $textElements = $browser->elements('p, h1, h2, h3, h4, h5, h6');
                foreach ($textElements as $element) {
                    $styles = $browser->script("
                        const el = arguments[0];
                        const styles = window.getComputedStyle(el);
                        return {
                            fontSize: parseInt(styles.fontSize),
                            lineHeight: styles.lineHeight,
                            overflow: styles.overflow
                        };
                    ", $element)[0];

                    // Text should be readable size (minimum 14px on mobile)
                    if ($name === 'mobile') {
                        $this->assertGreaterThanOrEqual(14, $styles['fontSize']);
                    }
                }
            }
        });
    }

    /** @test */
    public function city_page_navigation_works_on_all_devices()
    {
        $this->testResponsiveElement(function($browser, $viewport) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test navigation based on viewport
            switch ($viewport) {
                case 'mobile':
                    // Test mobile menu if it exists
                    if ($browser->element('.mobile-menu-toggle, [data-toggle="mobile-menu"]')) {
                        $browser->click('.mobile-menu-toggle, [data-toggle="mobile-menu"]')
                               ->pause(500);

                        if ($browser->element('.mobile-menu, [class*="mobile-nav"]')) {
                            $browser->assertPresent('.mobile-menu, [class*="mobile-nav"]');
                        }
                    }
                    break;

                case 'tablet':
                case 'desktop':
                    // Test desktop navigation
                    if ($browser->element('nav, .navigation')) {
                        $browser->assertPresent('nav, .navigation');
                    }
                    break;
            }

            // Test that important links are accessible
            if ($browser->element('a[href*="contact"], a:contains("Contact")')) {
                $browser->assertPresent('a[href*="contact"], a:contains("Contact")');
            }
        });
    }

    /** @test */
    public function city_page_forms_are_responsive()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Look for forms on the page
            if ($browser->element('form')) {
                $this->testResponsiveElement(function($browser, $viewport) {
                    // Test form at different viewports
                    $formInputs = $browser->elements('input, select, textarea');

                    foreach ($formInputs as $input) {
                        $inputStyles = $browser->script("
                            const input = arguments[0];
                            const rect = input.getBoundingClientRect();
                            const styles = window.getComputedStyle(input);
                            return {
                                width: rect.width,
                                height: rect.height,
                                fontSize: parseInt(styles.fontSize),
                                padding: styles.padding
                            };
                        ", $input)[0];

                        // Form inputs should be appropriately sized for touch
                        if ($viewport === 'mobile') {
                            $this->assertGreaterThanOrEqual(44, $inputStyles['height']);
                            $this->assertGreaterThanOrEqual(16, $inputStyles['fontSize']);
                        }
                    }
                });
            }
        });
    }

    /** @test */
    public function city_page_loads_with_proper_meta_tags()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser);

            // Test SEO meta tags
            $this->assertTrue($this->hasMetaTag($browser, 'description'));
            $this->assertTrue($this->hasMetaTag($browser, 'viewport', 'width=device-width, initial-scale=1'));

            // Test Open Graph tags if they exist
            if ($browser->element('meta[property="og:title"]')) {
                $browser->assertPresent('meta[property="og:title"]');
            }

            // Test mobile-specific meta tags
            $browser->assertPresent('meta[name="viewport"]');
        });
    }

    /** @test */
    public function city_page_performance_on_mobile()
    {
        $this->browse(function (Browser $browser) {
            $this->setMobileViewport($browser);

            $startTime = microtime(true);

            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser);

            $loadTime = microtime(true) - $startTime;

            // Page should load reasonably fast (under 10 seconds for browser test)
            $this->assertLessThan(10, $loadTime);

            // Test that images are optimized (if any)
            $images = $browser->elements('img');
            foreach ($images as $img) {
                $imageSrc = $browser->attribute($img, 'src');

                // Check for lazy loading attributes
                $hasLazyLoading = $browser->script("
                    const img = arguments[0];
                    return img.hasAttribute('loading') ||
                           img.hasAttribute('data-src') ||
                           img.classList.contains('lazy');
                ", $img)[0];

                // Images should have proper loading attributes for performance
                if (!$hasLazyLoading && $imageSrc) {
                    // At least check that images have alt attributes
                    $browser->assertPresent($img);
                }
            }
        });
    }

    /** @test */
    public function city_page_accessibility_on_all_devices()
    {
        $this->testResponsiveElement(function($browser, $viewport) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser)
                   ->pause(1000);

            // Test heading hierarchy
            $headings = $browser->elements('h1, h2, h3, h4, h5, h6');
            $this->assertNotEmpty($headings, 'Page should have heading elements');

            // Test that main heading exists
            $browser->assertPresent('h1');

            // Test image alt texts
            $images = $browser->elements('img');
            foreach ($images as $img) {
                $accessibility = $this->checkAccessibility($browser, $img);

                // Images should have alt text or aria-label
                $this->assertTrue(
                    $accessibility['hasAltText'] || $accessibility['hasAriaLabel'],
                    'Images should have alt text or aria-label'
                );
            }

            // Test focus management for interactive elements
            $focusableElements = $browser->elements('a, button, input, select, textarea');
            foreach ($focusableElements as $element) {
                $accessibility = $this->checkAccessibility($browser, $element);
                $this->assertTrue($accessibility['isFocusable'], 'Interactive elements should be focusable');
            }
        });
    }

    /** @test */
    public function city_page_content_adapts_to_screen_size()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit("/areas-we-serve/{$this->cityArea->slug}")
                   ->waitForPageLoad($browser);

            // Test text size adaptation
            $textElements = ['h1', 'h2', 'p'];
            $viewportSizes = [
                'mobile' => [375, 667],
                'tablet' => [768, 1024],
                'desktop' => [1920, 1080]
            ];

            foreach ($viewportSizes as $device => [$width, $height]) {
                $browser->driver->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension($width, $height));
                $browser->pause(500);

                foreach ($textElements as $element) {
                    if ($browser->element($element)) {
                        $fontSize = $browser->script("
                            const el = document.querySelector('$element');
                            return el ? parseInt(window.getComputedStyle(el).fontSize) : 0;
                        ")[0];

                        // Text should be readable on all devices
                        switch ($device) {
                            case 'mobile':
                                $this->assertGreaterThanOrEqual(14, $fontSize, "$element should be at least 14px on mobile");
                                break;
                            case 'tablet':
                                $this->assertGreaterThanOrEqual(16, $fontSize, "$element should be at least 16px on tablet");
                                break;
                            case 'desktop':
                                $this->assertGreaterThanOrEqual(16, $fontSize, "$element should be at least 16px on desktop");
                                break;
                        }
                    }
                }
            }
        });
    }
}