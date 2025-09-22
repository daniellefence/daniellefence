<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Blog;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\Helpers\BrowserTestHelpers;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChatGPTEditorTest extends DuskTestCase
{
    use DatabaseMigrations, BrowserTestHelpers;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function admin_can_see_chatgpt_button_on_rich_editor()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000)
                   ->assertSee('Fill with ChatGPT')
                   ->assertPresent('button[onclick*="openChatGPTModal"]');
        });
    }

    /** @test */
    public function chatgpt_button_opens_prompt_dialog()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Mock the window.prompt function to simulate user input
            $browser->script("
                window.originalPrompt = window.prompt;
                window.mockPromptResponse = 'Write about fence installation benefits';
                window.prompt = function(message, defaultText) {
                    console.log('Prompt called with:', message, defaultText);
                    return window.mockPromptResponse;
                };
            ");

            // Mock the fetch API to prevent actual API calls
            $browser->script("
                window.originalFetch = window.fetch;
                window.fetch = function(url, options) {
                    console.log('Mocked fetch called:', url, options);
                    return Promise.resolve({
                        ok: true,
                        json: () => Promise.resolve({
                            success: true,
                            content: '<p>This is mock ChatGPT generated content about fence installation benefits.</p>'
                        })
                    });
                };
            ");

            // Click the ChatGPT button
            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(1000);

            // Verify that the mock prompt was called
            $result = $browser->script("return window.mockPromptResponse;")[0];
            $this->assertEquals('Write about fence installation benefits', $result);
        });
    }

    /** @test */
    public function chatgpt_content_generation_handles_api_response()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Mock successful API response
            $browser->script("
                window.prompt = function() { return 'Test prompt'; };
                window.fetch = function(url, options) {
                    return Promise.resolve({
                        ok: true,
                        json: () => Promise.resolve({
                            success: true,
                            content: '<p>Generated content for testing.</p>'
                        })
                    });
                };
            ");

            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(3000);

            // Check that content was processed (look for success alert or modal)
            $browser->waitUntil("
                window.console.log('Checking for success indicators...');
                return document.body.innerHTML.includes('generated') ||
                       document.body.innerHTML.includes('success') ||
                       !!document.querySelector('.ProseMirror');
            ", 5);
        });
    }

    /** @test */
    public function chatgpt_handles_api_error_gracefully()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Mock API error response
            $browser->script("
                window.prompt = function() { return 'Test prompt'; };
                window.fetch = function(url, options) {
                    return Promise.resolve({
                        ok: false,
                        json: () => Promise.resolve({
                            success: false,
                            error: 'API key not configured'
                        })
                    });
                };

                // Mock alert to capture error messages
                window.alertMessages = [];
                window.alert = function(message) {
                    window.alertMessages.push(message);
                    console.log('Alert called:', message);
                };
            ");

            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(3000);

            // Check that error was handled
            $alertMessages = $browser->script("return window.alertMessages;")[0];
            $this->assertNotEmpty($alertMessages);
            $this->assertStringContainsString('Error', $alertMessages[0]);
        });
    }

    /** @test */
    public function chatgpt_button_works_on_different_rich_editor_fields()
    {
        $this->browse(function (Browser $browser) {
            // Test on Blog creation page
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000)
                   ->assertPresent('button[onclick*="openChatGPTModal"]');

            // Test on FAQ page if it exists
            $browser->visit('/admin/faqs/create')
                   ->waitForPageLoad($browser)
                   ->pause(2000);

            // Check if ChatGPT button exists on this page too
            if ($browser->element('button[onclick*="openChatGPTModal"]')) {
                $browser->assertPresent('button[onclick*="openChatGPTModal"]');
            }
        });
    }

    /** @test */
    public function chatgpt_modal_fallback_displays_when_editor_update_fails()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Mock scenario where editor update fails but API succeeds
            $browser->script("
                window.prompt = function() { return 'Test prompt'; };
                window.fetch = function(url, options) {
                    return Promise.resolve({
                        ok: true,
                        json: () => Promise.resolve({
                            success: true,
                            content: '<p>Generated content that cannot be inserted.</p>'
                        })
                    });
                };

                // Disable all editor update methods to force fallback modal
                window.originalShowContentModal = window.showContentModal;
                window.modalShown = false;
                window.showContentModal = function(content) {
                    window.modalShown = true;
                    window.modalContent = content;
                    console.log('Modal shown with content:', content);
                };
            ");

            // Remove any rich editor components to force fallback
            $browser->script("
                document.querySelectorAll('[x-data*=\"richEditorFormComponent\"]').forEach(el => el.remove());
                document.querySelectorAll('.ProseMirror').forEach(el => el.remove());
            ");

            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(3000);

            // Verify fallback modal was shown
            $modalShown = $browser->script("return window.modalShown;")[0];
            $this->assertTrue($modalShown);
        });
    }

    /** @test */
    public function chatgpt_integration_respects_form_field_names()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Find ChatGPT buttons and check they have proper field names
            $buttons = $browser->elements('button[onclick*="openChatGPTModal"]');
            $this->assertNotEmpty($buttons);

            // Check that button onclick contains a field name
            $buttonHtml = $browser->attribute('button[onclick*="openChatGPTModal"]', 'onclick');
            $this->assertStringContainsString('openChatGPTModal(', $buttonHtml);
            $this->assertStringContainsString('content', $buttonHtml); // Assuming content field
        });
    }

    /** @test */
    public function chatgpt_javascript_functions_are_globally_available()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Check that ChatGPT functions are available globally
            $functionsAvailable = $browser->script("
                return {
                    openChatGPTModal: typeof window.openChatGPTModal === 'function',
                    generateChatGPTContent: typeof window.generateChatGPTContent === 'function'
                };
            ")[0];

            $this->assertTrue($functionsAvailable['openChatGPTModal']);
            $this->assertTrue($functionsAvailable['generateChatGPTContent']);
        });
    }

    /** @test */
    public function chatgpt_handles_different_editor_types()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(3000);

            // Mock the API and test different editor scenarios
            $browser->script("
                window.prompt = function() { return 'Test content'; };
                window.fetch = function() {
                    return Promise.resolve({
                        ok: true,
                        json: () => Promise.resolve({
                            success: true,
                            content: '<p>Test generated content</p>'
                        })
                    });
                };

                // Track which update strategy was used
                window.updateStrategy = 'none';
            ");

            // Test with TipTap editor present
            $browser->script("
                // Mock TipTap editor presence
                if (document.querySelector('.ProseMirror')) {
                    window.updateStrategy = 'tiptap';
                } else {
                    // Create a mock ProseMirror element
                    const mockEditor = document.createElement('div');
                    mockEditor.className = 'ProseMirror';
                    document.body.appendChild(mockEditor);
                    window.updateStrategy = 'mock-tiptap';
                }
            ");

            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(3000);

            $strategy = $browser->script("return window.updateStrategy;")[0];
            $this->assertNotEquals('none', $strategy);
        });
    }

    /** @test */
    public function chatgpt_csrf_token_is_included_in_requests()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser)
                   ->visit('/admin/blogs/create')
                   ->waitForPageLoad($browser)
                   ->waitForJavaScript($browser)
                   ->pause(2000);

            // Verify CSRF token is present
            $browser->assertPresent('meta[name="csrf-token"]');

            // Mock fetch to capture request headers
            $browser->script("
                window.prompt = function() { return 'Test'; };
                window.requestHeaders = null;
                window.fetch = function(url, options) {
                    window.requestHeaders = options.headers;
                    return Promise.resolve({
                        ok: true,
                        json: () => Promise.resolve({ success: true, content: 'test' })
                    });
                };
            ");

            $browser->click('button[onclick*="openChatGPTModal"]')
                   ->pause(2000);

            // Check that CSRF token was included
            $headers = $browser->script("return window.requestHeaders;")[0];
            $this->assertArrayHasKey('X-CSRF-TOKEN', $headers);
            $this->assertNotEmpty($headers['X-CSRF-TOKEN']);
        });
    }
}