<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Footer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Test suite for Footer Livewire component.
 *
 * Tests dynamic content display based on routes and footer functionality.
 */
class FooterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function component_renders_successfully()
    {
        Livewire::test(Footer::class)
            ->assertStatus(200)
            ->assertViewIs('livewire.footer');
    }

    /** @test */
    public function placeholder_returns_lazy_loader_view()
    {
        $component = new Footer();
        $view = $component->placeholder();

        $this->assertEquals('lazy-loader', $view->getName());
    }

    /** @test */
    public function component_handles_different_routes()
    {
        // Test that component doesn't break on different routes
        $routes = ['/', '/contact', '/about', '/services'];

        foreach ($routes as $route) {
            $this->get($route)->assertOk();
        }
    }

    /** @test */
    public function component_displays_contact_information()
    {
        Livewire::test(Footer::class)
            ->assertSee('Contact')
            ->assertSee('Address')
            ->assertSee('Phone');
    }

    /** @test */
    public function component_displays_service_links()
    {
        Livewire::test(Footer::class)
            ->assertSee('Services')
            ->assertSee('Fence')
            ->assertSee('Outdoor Living');
    }

    /** @test */
    public function component_displays_social_media_links()
    {
        Livewire::test(Footer::class)
            ->assertSee('Follow Us');
    }

    /** @test */
    public function component_displays_copyright_information()
    {
        $currentYear = date('Y');

        Livewire::test(Footer::class)
            ->assertSee($currentYear)
            ->assertSee('Danielle Fence');
    }

    /** @test */
    public function component_responsive_behavior()
    {
        // Test that footer content is properly structured for responsive design
        Livewire::test(Footer::class)
            ->assertViewHas('footer_content');
    }
}