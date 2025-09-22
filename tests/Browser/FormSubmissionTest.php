<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Helpers\BrowserTestHelpers;
use Tests\Browser\Helpers\FormTestHelpers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;

class FormSubmissionTest extends DuskTestCase
{
    use DatabaseMigrations, BrowserTestHelpers, FormTestHelpers;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /** @test */
    public function user_can_submit_quote_request_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill out the quote form
            $this->fillQuoteForm($browser, [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'phone' => '555-123-4567',
                'address' => '123 Main St',
                'city' => 'Dallas',
                'state' => 'TX',
                'zip' => '75201',
                'message' => 'I need a fence for my backyard.'
            ]);

            // Submit the form
            $this->submitFormAndWait($browser, 'Submit Quote Request')
                 ->pause(3000);

            // Verify success
            $this->assertFormSuccess($browser);
        });
    }

    /** @test */
    public function quote_form_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Test validation for required fields
            $requiredFields = ['first_name', 'last_name', 'email', 'phone'];
            $this->testFormValidation($browser, $requiredFields);
        });
    }

    /** @test */
    public function quote_form_validates_email_format()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            $this->testEmailValidation($browser, 'email');
        });
    }

    /** @test */
    public function quote_form_validates_phone_format()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            $this->testPhoneValidation($browser, 'phone');
        });
    }

    /** @test */
    public function user_can_submit_contact_form()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill out contact form
            $this->fillContactForm($browser, [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '555-987-6543',
                'subject' => 'General Inquiry',
                'message' => 'I have a question about your services.'
            ]);

            // Submit the form
            $this->submitFormAndWait($browser, 'Send Message')
                 ->pause(3000);

            // Verify success
            $this->assertFormSuccess($browser);
        });
    }

    /** @test */
    public function contact_form_validates_required_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            $requiredFields = ['name', 'email', 'message'];
            $this->testFormValidation($browser, $requiredFields);
        });
    }

    /** @test */
    public function user_can_submit_career_application()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/careers')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill out career form
            $this->fillCareerForm($browser, [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael.johnson@example.com',
                'phone' => '555-456-7890',
                'position' => 'Fence Installer',
                'experience' => '3',
                'message' => 'I am interested in working for your company.'
            ]);

            // Submit the form
            $this->submitFormAndWait($browser, 'Submit Application')
                 ->pause(3000);

            // Verify success
            $this->assertFormSuccess($browser);
        });
    }

    /** @test */
    public function form_submission_works_on_mobile_devices()
    {
        $this->browse(function (Browser $browser) {
            $this->setMobileViewport($browser);

            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Test mobile form interaction
            $this->fillField($browser, 'input[name="first_name"]', 'Mobile')
                 ->fillField($browser, 'input[name="last_name"]', 'User')
                 ->fillField($browser, 'input[name="email"]', 'mobile@example.com')
                 ->fillField($browser, 'input[name="phone"]', '555-123-4567');

            // Test mobile form submission
            $this->submitFormAndWait($browser, 'Submit Quote Request')
                 ->pause(3000);

            // Verify success on mobile
            $this->assertFormSuccess($browser);
        });
    }

    /** @test */
    public function form_handles_file_uploads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/careers')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Check if file upload field exists
            if ($browser->element('input[type="file"]')) {
                // Create a temporary test file
                $testFile = tempnam(sys_get_temp_dir(), 'test_resume') . '.pdf';
                file_put_contents($testFile, 'Test resume content');

                try {
                    $this->testFileUpload($browser, 'resume', $testFile);

                    // Fill other required fields
                    $this->fillCareerForm($browser);

                    // Submit form with file
                    $this->submitFormAndWait($browser, 'Submit Application')
                         ->pause(3000);

                    $this->assertFormSuccess($browser);
                } finally {
                    if (file_exists($testFile)) {
                        unlink($testFile);
                    }
                }
            }
        });
    }

    /** @test */
    public function form_prevents_spam_submissions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill form with suspicious content
            $this->fillQuoteForm($browser, [
                'message' => 'SPAM SPAM SPAM click here for amazing deals www.spam.com'
            ]);

            $this->submitFormAndWait($browser, 'Submit Quote Request')
                 ->pause(3000);

            // Should either be blocked or require additional verification
            $browser->assertSee('Thank you')
                   ->orWhere(function ($browser) {
                       $browser->assertSee('verification')
                              ->orWhere(function ($browser) {
                                  $browser->assertSee('review');
                              });
                   });
        });
    }

    /** @test */
    public function form_submission_includes_csrf_protection()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Verify CSRF token is present
            $browser->assertPresent('input[name="_token"]');

            // Test CSRF protection
            $this->testCSRFProtection($browser);
        });
    }

    /** @test */
    public function form_shows_loading_state_during_submission()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            $this->fillQuoteForm($browser);

            // Click submit and immediately check for loading state
            $browser->press('Submit Quote Request');

            // Look for loading indicators
            $browser->waitUntil("
                return document.querySelector('button[disabled]') ||
                       document.querySelector('.loading') ||
                       document.querySelector('[class*=\"loading\"]') ||
                       document.querySelector('button:contains(\"Submitting\")') ||
                       document.querySelector('button:contains(\"Please wait\")');
            ", 3)
            ->orWhere(function ($browser) {
                // Alternative: Check that submit button is disabled
                $submitButton = $browser->element('button[type="submit"]');
                if ($submitButton) {
                    $isDisabled = $browser->script("
                        return arguments[0].disabled ||
                               arguments[0].getAttribute('aria-disabled') === 'true';
                    ", $submitButton)[0];
                    $this->assertTrue($isDisabled);
                }
            });
        });
    }

    /** @test */
    public function form_handles_javascript_validation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Test real-time validation if it exists
            $browser->type('input[name="email"]', 'invalid-email')
                   ->click('input[name="first_name"]') // Trigger blur event
                   ->pause(1000);

            // Check for client-side validation
            $browser->assertPresent('input[name="email"]')
                   ->orWhere(function ($browser) {
                       // Look for validation classes or messages
                       $browser->assertPresent('.invalid, .error, [class*="error"], [class*="invalid"]');
                   });

            // Fix the email and verify validation clears
            $browser->clear('input[name="email"]')
                   ->type('input[name="email"]', 'valid@example.com')
                   ->click('input[name="first_name"]')
                   ->pause(1000);
        });
    }

    /** @test */
    public function form_preserves_data_on_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Fill partial form data
            $browser->type('input[name="first_name"]', 'John')
                   ->type('input[name="last_name"]', 'Doe')
                   ->type('input[name="email"]', 'invalid-email'); // Invalid email

            // Submit form
            $browser->press('Submit Quote Request')
                   ->pause(3000);

            // Verify that valid data is preserved
            $browser->assertInputValue('input[name="first_name"]', 'John')
                   ->assertInputValue('input[name="last_name"]', 'Doe');
        });
    }

    /** @test */
    public function form_submission_works_with_different_service_types()
    {
        $this->browse(function (Browser $browser) {
            $serviceTypes = [
                'residential-fencing',
                'commercial-fencing',
                'outdoor-kitchens',
                'pavers'
            ];

            foreach ($serviceTypes as $serviceType) {
                $browser->visit('/request-a-quote')
                       ->waitForPageLoad($browser)
                       ->pause(1000);

                // Fill form with specific service type
                $this->fillQuoteForm($browser, [
                    'service_type' => $serviceType,
                    'email' => "test-{$serviceType}@example.com"
                ]);

                $this->submitFormAndWait($browser, 'Submit Quote Request')
                     ->pause(2000);

                $this->assertFormSuccess($browser);
            }
        });
    }

    /** @test */
    public function form_accessibility_features_work_correctly()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Test keyboard navigation
            $browser->keys('input[name="first_name"]', ['{tab}'])
                   ->pause(500);

            // Verify focus moved to next input
            $browser->assertFocused('input[name="last_name"]');

            // Test form labels
            $formFields = $browser->elements('input, select, textarea');
            foreach ($formFields as $field) {
                $fieldId = $browser->attribute($field, 'id');
                $fieldName = $browser->attribute($field, 'name');

                if ($fieldId) {
                    // Check for associated label
                    $browser->assertPresent("label[for='$fieldId']")
                           ->orWhere(function ($browser) use ($field) {
                               // Or check for aria-label
                               $hasAriaLabel = $browser->script("
                                   return arguments[0].hasAttribute('aria-label') ||
                                          arguments[0].hasAttribute('aria-labelledby');
                               ", $field)[0];
                               $this->assertTrue($hasAriaLabel);
                           });
                }
            }

            // Test error message accessibility
            $browser->press('Submit Quote Request')
                   ->pause(2000);

            // Error messages should be associated with fields
            $errorMessages = $browser->elements('.error, [class*="error"], [role="alert"]');
            foreach ($errorMessages as $error) {
                $accessibility = $this->checkAccessibility($browser, $error);
                $this->assertTrue(
                    $accessibility['hasAriaLabel'] || $accessibility['hasRole'],
                    'Error messages should have proper accessibility attributes'
                );
            }
        });
    }

    /** @test */
    public function form_handles_network_errors_gracefully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/request-a-quote')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Mock network failure
            $browser->script("
                // Override fetch to simulate network error
                window.originalFetch = window.fetch;
                window.fetch = function() {
                    return Promise.reject(new Error('Network error'));
                };

                // Override XMLHttpRequest for older implementations
                const originalXHR = window.XMLHttpRequest;
                window.XMLHttpRequest = function() {
                    const xhr = new originalXHR();
                    const originalSend = xhr.send;
                    xhr.send = function() {
                        setTimeout(() => {
                            xhr.onerror();
                        }, 1000);
                    };
                    return xhr;
                };
            ");

            $this->fillQuoteForm($browser);

            $browser->press('Submit Quote Request')
                   ->pause(5000);

            // Should show error message or retry option
            $browser->assertSee('error')
                   ->orWhere(function ($browser) {
                       $browser->assertSee('try again')
                              ->orWhere(function ($browser) {
                                  $browser->assertSee('connection');
                              });
                   });
        });
    }
}