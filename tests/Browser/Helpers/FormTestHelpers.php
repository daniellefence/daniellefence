<?php

namespace Tests\Browser\Helpers;

use Laravel\Dusk\Browser;

trait FormTestHelpers
{
    /**
     * Fill out a quote request form with test data.
     */
    protected function fillQuoteForm(Browser $browser, array $data = []): Browser
    {
        $defaultData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '555-123-4567',
            'address' => '123 Main St',
            'city' => 'Dallas',
            'state' => 'TX',
            'zip' => '75201',
            'service_type' => 'residential-fencing',
            'message' => 'I need a fence installed in my backyard.',
        ];

        $formData = array_merge($defaultData, $data);

        return $browser
            ->type('input[name="first_name"]', $formData['first_name'])
            ->type('input[name="last_name"]', $formData['last_name'])
            ->type('input[name="email"]', $formData['email'])
            ->type('input[name="phone"]', $formData['phone'])
            ->type('input[name="address"]', $formData['address'])
            ->type('input[name="city"]', $formData['city'])
            ->type('input[name="state"]', $formData['state'])
            ->type('input[name="zip"]', $formData['zip'])
            ->select('select[name="service_type"]', $formData['service_type'])
            ->type('textarea[name="message"]', $formData['message']);
    }

    /**
     * Fill out a contact form with test data.
     */
    protected function fillContactForm(Browser $browser, array $data = []): Browser
    {
        $defaultData = [
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'phone' => '555-987-6543',
            'subject' => 'General Inquiry',
            'message' => 'I have a question about your services.',
        ];

        $formData = array_merge($defaultData, $data);

        return $browser
            ->type('input[name="name"]', $formData['name'])
            ->type('input[name="email"]', $formData['email'])
            ->type('input[name="phone"]', $formData['phone'])
            ->type('input[name="subject"]', $formData['subject'])
            ->type('textarea[name="message"]', $formData['message']);
    }

    /**
     * Test form validation by submitting empty form.
     */
    protected function testFormValidation(Browser $browser, array $requiredFields): Browser
    {
        // Submit empty form
        $browser->press('Submit')
                ->pause(1000);

        // Check for validation errors
        foreach ($requiredFields as $field) {
            $browser->assertSee("The $field field is required")
                   ->orWhere(function ($browser) use ($field) {
                       $browser->assertPresent("input[name='$field'].is-invalid")
                              ->orWhere(function ($browser) use ($field) {
                                  $browser->assertPresent("select[name='$field'].is-invalid");
                              })
                              ->orWhere(function ($browser) use ($field) {
                                  $browser->assertPresent("textarea[name='$field'].is-invalid");
                              });
                   });
        }

        return $browser;
    }

    /**
     * Test email validation.
     */
    protected function testEmailValidation(Browser $browser, string $emailField = 'email'): Browser
    {
        // Test invalid email
        $browser->type("input[name='$emailField']", 'invalid-email')
                ->press('Submit')
                ->pause(1000)
                ->assertSee('Please enter a valid email address')
                ->orWhere(function ($browser) use ($emailField) {
                    $browser->assertPresent("input[name='$emailField'].is-invalid");
                });

        // Test valid email
        $browser->clear("input[name='$emailField']")
                ->type("input[name='$emailField']", 'valid@example.com');

        return $browser;
    }

    /**
     * Test phone number validation.
     */
    protected function testPhoneValidation(Browser $browser, string $phoneField = 'phone'): Browser
    {
        // Test invalid phone
        $browser->type("input[name='$phoneField']", '123')
                ->press('Submit')
                ->pause(1000)
                ->assertSee('Please enter a valid phone number')
                ->orWhere(function ($browser) use ($phoneField) {
                    $browser->assertPresent("input[name='$phoneField'].is-invalid");
                });

        // Test valid phone
        $browser->clear("input[name='$phoneField']")
                ->type("input[name='$phoneField']", '555-123-4567');

        return $browser;
    }

    /**
     * Submit form and wait for response.
     */
    protected function submitFormAndWait(Browser $browser, string $submitButton = 'Submit'): Browser
    {
        return $browser->press($submitButton)
                      ->pause(2000)
                      ->waitForPageLoad($browser);
    }

    /**
     * Check for successful form submission.
     */
    protected function assertFormSuccess(Browser $browser): Browser
    {
        return $browser->assertSee('Thank you')
                      ->orWhere(function ($browser) {
                          $browser->assertSee('Success')
                                 ->orWhere(function ($browser) {
                                     $browser->assertSee('Message sent')
                                            ->orWhere(function ($browser) {
                                                $browser->assertPresent('.alert-success');
                                            });
                                 });
                      });
    }

    /**
     * Fill out career application form.
     */
    protected function fillCareerForm(Browser $browser, array $data = []): Browser
    {
        $defaultData = [
            'first_name' => 'Michael',
            'last_name' => 'Johnson',
            'email' => 'michael.johnson@example.com',
            'phone' => '555-456-7890',
            'position' => 'Fence Installer',
            'experience' => '3',
            'availability' => 'full-time',
            'message' => 'I am interested in working for your company.',
        ];

        $formData = array_merge($defaultData, $data);

        return $browser
            ->type('input[name="first_name"]', $formData['first_name'])
            ->type('input[name="last_name"]', $formData['last_name'])
            ->type('input[name="email"]', $formData['email'])
            ->type('input[name="phone"]', $formData['phone'])
            ->type('input[name="position"]', $formData['position'])
            ->select('select[name="experience"]', $formData['experience'])
            ->select('select[name="availability"]', $formData['availability'])
            ->type('textarea[name="message"]', $formData['message']);
    }

    /**
     * Test file upload functionality.
     */
    protected function testFileUpload(Browser $browser, string $fileField, string $filePath): Browser
    {
        return $browser->attach("input[name='$fileField']", $filePath)
                      ->pause(1000)
                      ->assertPresent("input[name='$fileField'][value*='" . basename($filePath) . "']")
                      ->orWhere(function ($browser) use ($fileField, $filePath) {
                          $browser->assertSee(basename($filePath));
                      });
    }

    /**
     * Clear form fields.
     */
    protected function clearForm(Browser $browser, array $fields): Browser
    {
        foreach ($fields as $field) {
            $browser->clear("input[name='$field']")
                   ->clear("select[name='$field']")
                   ->clear("textarea[name='$field']");
        }

        return $browser;
    }

    /**
     * Test form field focus and blur events.
     */
    protected function testFieldInteractions(Browser $browser, string $fieldSelector): Browser
    {
        return $browser->click($fieldSelector)
                      ->assertFocused($fieldSelector)
                      ->click('body') // Click outside to blur
                      ->assertNotFocused($fieldSelector);
    }

    /**
     * Test dropdown/select functionality.
     */
    protected function testSelectField(Browser $browser, string $selectSelector, array $options): Browser
    {
        foreach ($options as $option) {
            $browser->select($selectSelector, $option)
                   ->assertSelected($selectSelector, $option);
        }

        return $browser;
    }

    /**
     * Test checkbox/radio button functionality.
     */
    protected function testCheckboxField(Browser $browser, string $checkboxSelector): Browser
    {
        return $browser->check($checkboxSelector)
                      ->assertChecked($checkboxSelector)
                      ->uncheck($checkboxSelector)
                      ->assertNotChecked($checkboxSelector);
    }

    /**
     * Test form submission with CSRF protection.
     */
    protected function testCSRFProtection(Browser $browser): Browser
    {
        // Remove CSRF token
        $browser->script("document.querySelector('input[name=\"_token\"]').remove();");

        // Try to submit form
        $browser->press('Submit')
                ->pause(1000)
                ->assertSee('419')
                ->orWhere(function ($browser) {
                    $browser->assertSee('Page Expired')
                           ->orWhere(function ($browser) {
                               $browser->assertSee('CSRF token mismatch');
                           });
                });

        return $browser;
    }
}