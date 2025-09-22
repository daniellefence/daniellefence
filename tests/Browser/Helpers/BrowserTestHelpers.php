<?php

namespace Tests\Browser\Helpers;

use Laravel\Dusk\Browser;
use App\Models\User;

trait BrowserTestHelpers
{
    /**
     * Login as admin user for testing.
     */
    protected function loginAsAdmin(Browser $browser): Browser
    {
        $admin = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        return $browser->loginAs($admin);
    }

    /**
     * Login as regular user for testing.
     */
    protected function loginAsUser(Browser $browser): Browser
    {
        $user = User::factory()->create([
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        return $browser->loginAs($user);
    }

    /**
     * Wait for element to be visible and clickable.
     */
    protected function waitForClickable(Browser $browser, string $selector, int $seconds = 5): Browser
    {
        return $browser->waitFor($selector, $seconds)
                      ->waitUntilEnabled($selector, $seconds);
    }

    /**
     * Wait for JavaScript to load and execute.
     */
    protected function waitForJavaScript(Browser $browser, int $seconds = 3): Browser
    {
        $browser->pause($seconds * 1000);
        return $browser->waitUntil('typeof jQuery !== "undefined"', $seconds);
    }

    /**
     * Wait for AJAX requests to complete.
     */
    protected function waitForAjax(Browser $browser, int $seconds = 5): Browser
    {
        return $browser->waitUntil('jQuery.active == 0', $seconds);
    }

    /**
     * Scroll element into view.
     */
    protected function scrollToElement(Browser $browser, string $selector): Browser
    {
        $browser->script("document.querySelector('$selector').scrollIntoView({behavior: 'smooth', block: 'center'});");
        $browser->pause(500);
        return $browser;
    }

    /**
     * Check if element is visible in current viewport.
     */
    protected function isElementInViewport(Browser $browser, string $selector): bool
    {
        return $browser->script("
            var element = document.querySelector('$selector');
            if (!element) return false;
            var rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        ")[0];
    }

    /**
     * Take screenshot with custom name for debugging.
     */
    protected function takeScreenshot(Browser $browser, string $name): Browser
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        return $browser->screenshot("{$name}_{$timestamp}");
    }

    /**
     * Fill form field with proper focus handling.
     */
    protected function fillField(Browser $browser, string $selector, string $value): Browser
    {
        return $browser->click($selector)
                      ->clear($selector)
                      ->type($selector, $value);
    }

    /**
     * Wait for modal to appear and be interactive.
     */
    protected function waitForModal(Browser $browser, string $modalSelector = '.modal', int $seconds = 5): Browser
    {
        return $browser->waitFor($modalSelector, $seconds)
                      ->waitUntil("document.querySelector('$modalSelector').classList.contains('show') || document.querySelector('$modalSelector').style.display !== 'none'", $seconds);
    }

    /**
     * Close modal by clicking backdrop or close button.
     */
    protected function closeModal(Browser $browser, string $modalSelector = '.modal'): Browser
    {
        // Try close button first
        if ($browser->element('.modal .btn-close') || $browser->element('.modal [data-bs-dismiss="modal"]')) {
            $browser->click('.modal .btn-close, .modal [data-bs-dismiss="modal"]');
        } else {
            // Click backdrop
            $browser->click($modalSelector);
        }

        return $browser->waitUntilMissing($modalSelector, 3);
    }

    /**
     * Wait for page to load completely including all assets.
     */
    protected function waitForPageLoad(Browser $browser, int $seconds = 10): Browser
    {
        return $browser->waitUntil('document.readyState === "complete"', $seconds);
    }

    /**
     * Check if page has specific meta tag.
     */
    protected function hasMetaTag(Browser $browser, string $name, string $content = null): bool
    {
        $selector = "meta[name='$name']";
        if ($content) {
            $selector .= "[content='$content']";
        }

        return $browser->element($selector) !== null;
    }

    /**
     * Simulate mobile touch interaction.
     */
    protected function mobileTouch(Browser $browser, string $selector): Browser
    {
        $browser->script("
            var element = document.querySelector('$selector');
            if (element) {
                var touchEvent = new Touch({
                    identifier: Date.now(),
                    target: element,
                    clientX: element.getBoundingClientRect().left + element.offsetWidth / 2,
                    clientY: element.getBoundingClientRect().top + element.offsetHeight / 2,
                    radiusX: 2.5,
                    radiusY: 2.5,
                    rotationAngle: 10,
                    force: 0.5,
                });

                var touchStartEvent = new TouchEvent('touchstart', {
                    cancelable: true,
                    bubbles: true,
                    touches: [touchEvent],
                    targetTouches: [],
                    changedTouches: [touchEvent],
                    shiftKey: true,
                });

                element.dispatchEvent(touchStartEvent);
            }
        ");

        return $browser->pause(100);
    }

    /**
     * Check responsive behavior by testing different viewports.
     */
    protected function testResponsiveElement(Browser $browser, string $selector, callable $callback): void
    {
        // Test mobile
        $this->setMobileViewport($browser);
        $browser->pause(500);
        $callback($browser, 'mobile');

        // Test tablet
        $this->setTabletViewport($browser);
        $browser->pause(500);
        $callback($browser, 'tablet');

        // Test desktop
        $this->setDesktopViewport($browser);
        $browser->pause(500);
        $callback($browser, 'desktop');
    }

    /**
     * Verify accessibility attributes.
     */
    protected function checkAccessibility(Browser $browser, string $selector): array
    {
        return $browser->script("
            var element = document.querySelector('$selector');
            if (!element) return {};

            return {
                hasAltText: element.hasAttribute('alt'),
                hasAriaLabel: element.hasAttribute('aria-label'),
                hasAriaDescribedBy: element.hasAttribute('aria-describedby'),
                hasRole: element.hasAttribute('role'),
                isFocusable: element.tabIndex >= 0 || ['A', 'BUTTON', 'INPUT', 'SELECT', 'TEXTAREA'].includes(element.tagName),
                colorContrast: window.getComputedStyle(element).color !== window.getComputedStyle(element).backgroundColor
            };
        ")[0];
    }
}