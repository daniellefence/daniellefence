<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\HoneypotProtection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * Test suite for HoneypotProtection Middleware.
 *
 * This comprehensive test suite validates the honeypot spam protection functionality
 * including honeypot field detection, timing-based protection, logging of suspicious
 * activity, and proper response handling for both legitimate users and spam bots.
 *
 * @package Tests\Feature\Middleware
 * @author Generated via PhpStorm MCP connector
 */
class HoneypotProtectionTest extends TestCase
{
    protected HoneypotProtection $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new HoneypotProtection();
    }

    /** @test */
    public function it_allows_requests_with_empty_honeypot_fields()
    {
        $request = Request::create('/test', 'POST', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            // Honeypot fields are empty (as they should be for legitimate users)
            'website' => '',
            'url' => '',
            'homepage' => '',
            'bot_field' => '',
            'spam_check' => '',
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'Form processed']);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Form processed', $responseData['message']);
    }

    /** @test */
    public function it_blocks_requests_with_filled_website_field()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'first_name' => 'Bot',
            'last_name' => 'Spam',
            'email' => 'bot@spam.com',
            'website' => 'http://spam-website.com', // Bot filled this field
        ]);

        $request->server->set('REMOTE_ADDR', '192.168.1.100');
        $request->headers->set('User-Agent', 'SpamBot/1.0');

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => false, 'message' => 'Should not reach here']);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);
        $this->assertEquals('Form submitted successfully', $responseData['message']);

        // Verify spam attempt was logged
        Log::assertLogged('warning', function ($message, $context) {
            return $message === 'Honeypot field filled' &&
                   $context['field'] === 'website' &&
                   $context['value'] === 'http://spam-website.com';
        });
    }

    /** @test */
    public function it_blocks_requests_with_filled_url_field()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'first_name' => 'Automated',
            'last_name' => 'Bot',
            'email' => 'auto@bot.com',
            'url' => 'malicious-url.com', // Bot filled this field
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);

        Log::assertLogged('warning', function ($message, $context) {
            return $context['field'] === 'url' && $context['value'] === 'malicious-url.com';
        });
    }

    /** @test */
    public function it_blocks_requests_with_filled_homepage_field()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'homepage' => 'spam-homepage.org', // Bot filled this field
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);

        Log::assertLogged('warning', function ($message, $context) {
            return $context['field'] === 'homepage';
        });
    }

    /** @test */
    public function it_blocks_requests_with_filled_bot_field()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'bot_field' => 'I am a bot', // Bot filled this field
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);

        Log::assertLogged('warning', function ($message, $context) {
            return $context['field'] === 'bot_field' && $context['value'] === 'I am a bot';
        });
    }

    /** @test */
    public function it_blocks_requests_with_filled_spam_check_field()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'spam_check' => 'spam content', // Bot filled this field
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);

        Log::assertLogged('warning', function ($message, $context) {
            return $context['field'] === 'spam_check';
        });
    }

    /** @test */
    public function it_allows_requests_with_appropriate_timing()
    {
        $formStartTime = time() - 10; // Form was displayed 10 seconds ago

        $request = Request::create('/test', 'POST', [
            'first_name' => 'Legitimate',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'form_start_time' => $formStartTime,
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'Valid timing']);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Valid timing', $responseData['message']);
    }

    /** @test */
    public function it_blocks_requests_submitted_too_quickly()
    {
        Log::fake();

        $formStartTime = time(); // Form submitted immediately

        $request = Request::create('/test', 'POST', [
            'first_name' => 'Fast',
            'last_name' => 'Bot',
            'email' => 'fast@bot.com',
            'form_start_time' => $formStartTime,
        ]);

        $request->server->set('REMOTE_ADDR', '10.0.0.1');

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $this->assertEquals(422, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertFalse($responseData['success']);
        $this->assertEquals('Please take a moment to fill out the form properly.', $responseData['message']);

        Log::assertLogged('warning', function ($message, $context) {
            return $message === 'Form submitted too quickly' && $context['time_diff'] < 3;
        });
    }

    /** @test */
    public function it_handles_missing_form_start_time()
    {
        $request = Request::create('/test', 'POST', [
            'first_name' => 'No',
            'last_name' => 'Timing',
            'email' => 'notiming@example.com',
            // No form_start_time provided
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'No timing check']);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('No timing check', $responseData['message']);
    }

    /** @test */
    public function it_logs_comprehensive_spam_attempt_details()
    {
        Log::fake();

        $request = Request::create('https://example.com/contact', 'POST', [
            'website' => 'spam-site.com',
        ]);

        $request->server->set('REMOTE_ADDR', '203.0.113.1');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (compatible; SpamBot/2.0)');

        $this->middleware->handle($request, function ($req) {
            return response('next');
        });

        Log::assertLogged('warning', function ($message, $context) {
            return $message === 'Honeypot field filled' &&
                   $context['ip'] === '203.0.113.1' &&
                   $context['user_agent'] === 'Mozilla/5.0 (compatible; SpamBot/2.0)' &&
                   $context['field'] === 'website' &&
                   $context['value'] === 'spam-site.com' &&
                   $context['url'] === 'https://example.com/contact';
        });
    }

    /** @test */
    public function it_logs_timing_based_rejections_with_details()
    {
        Log::fake();

        $request = Request::create('https://example.com/quote', 'POST', [
            'form_start_time' => time() - 1, // Submitted after 1 second
        ]);

        $request->server->set('REMOTE_ADDR', '198.51.100.1');

        $this->middleware->handle($request, function ($req) {
            return response('next');
        });

        Log::assertLogged('warning', function ($message, $context) {
            return $message === 'Form submitted too quickly' &&
                   $context['ip'] === '198.51.100.1' &&
                   $context['time_diff'] < 3 &&
                   $context['url'] === 'https://example.com/quote';
        });
    }

    /** @test */
    public function it_handles_multiple_honeypot_fields_filled()
    {
        Log::fake();

        $request = Request::create('/test', 'POST', [
            'website' => 'spam1.com',
            'url' => 'spam2.com',
            'homepage' => 'spam3.com',
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        });

        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['success']);

        // Should log the first detected honeypot field
        Log::assertLogged('warning', function ($message, $context) {
            return $context['field'] === 'website' && $context['value'] === 'spam1.com';
        });
    }

    /** @test */
    public function it_returns_fake_success_response_for_honeypot_detection()
    {
        $request = Request::create('/test', 'POST', [
            'website' => 'detected-spam.com',
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['processed' => true]);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

        // Should return fake success, not the actual response
        $this->assertTrue($responseData['success']);
        $this->assertEquals('Form submitted successfully', $responseData['message']);
        $this->assertArrayNotHasKey('processed', $responseData);
    }

    /** @test */
    public function it_allows_forms_with_minimal_timing_threshold()
    {
        $formStartTime = time() - 3; // Exactly 3 seconds (minimum threshold)

        $request = Request::create('/test', 'POST', [
            'form_start_time' => $formStartTime,
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'Timing valid']);
        });

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Timing valid', $responseData['message']);
    }

    /** @test */
    public function it_handles_edge_case_timing_values()
    {
        // Test with future timestamp (should be handled gracefully)
        $futureTime = time() + 100;

        $request = Request::create('/test', 'POST', [
            'form_start_time' => $futureTime,
        ]);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'Future time handled']);
        });

        // Should still process (negative time difference should be handled)
        $this->assertEquals(200, $response->getStatusCode());
    }
}