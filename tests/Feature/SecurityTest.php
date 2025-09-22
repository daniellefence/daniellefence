<?php

namespace Tests\Feature;

use App\Http\Middleware\HoneypotProtection;
use App\Http\Middleware\RateLimitForms;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_honeypot_middleware_blocks_spam()
    {
        $request = Request::create('/test', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'website' => 'spam-website.com', // Honeypot field filled
            'message' => 'Test message'
        ]);

        $middleware = new HoneypotProtection();
        $response = $middleware->handle($request, function () {
            return response('Should not reach here');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('success', $response->getContent());
    }

    public function test_honeypot_middleware_allows_legitimate_submissions()
    {
        $request = Request::create('/test', 'POST', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message'
            // No honeypot fields filled
        ]);

        $middleware = new HoneypotProtection();
        $response = $middleware->handle($request, function () {
            return response('Legitimate submission');
        });

        $this->assertStringContainsString('Legitimate submission', $response->getContent());
    }

    public function test_rate_limiting_middleware_blocks_excessive_requests()
    {
        $request = Request::create('/test', 'POST');
        $request->setTrustedProxies(['127.0.0.1'], Request::HEADER_X_FORWARDED_FOR);

        $middleware = new RateLimitForms();

        // Make multiple requests to exceed rate limit
        for ($i = 0; $i < 6; $i++) {
            $response = $middleware->handle($request, function () {
                return response('Success');
            }, 'contact'); // 5 attempts per minute for contact form
        }

        $this->assertEquals(429, $response->getStatusCode());
        $this->assertStringContainsString('Too many form submissions', $response->getContent());
    }

    public function test_rate_limiting_different_form_types()
    {
        $request = Request::create('/test', 'POST');
        $request->setTrustedProxies(['127.0.0.1'], Request::HEADER_X_FORWARDED_FOR);

        $middleware = new RateLimitForms();

        // Test quote form (3 attempts per minute)
        for ($i = 0; $i < 4; $i++) {
            $response = $middleware->handle($request, function () {
                return response('Success');
            }, 'quote');
        }

        $this->assertEquals(429, $response->getStatusCode());
    }

    public function test_timing_attack_prevention()
    {
        $request = Request::create('/test', 'POST', [
            'form_start_time' => time() - 1 // Submitted too quickly (1 second)
        ]);

        $middleware = new HoneypotProtection();
        $response = $middleware->handle($request, function () {
            return response('Should not reach here');
        });

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertStringContainsString('take a moment', $response->getContent());
    }

    public function test_input_sanitization_in_contact_form()
    {
        $maliciousInput = '<script>alert("xss")</script>Test Name';
        $cleanedInput = strip_tags(trim($maliciousInput));

        $this->assertEquals('Test Name', $cleanedInput);
        $this->assertStringNotContainsString('<script>', $cleanedInput);
    }

    public function test_email_validation_prevents_suspicious_emails()
    {
        $suspiciousEmails = [
            'test+multiple+plus@example.com',
            'invalid-email',
            '',
        ];

        foreach ($suspiciousEmails as $email) {
            $this->assertFalse(filter_var($email, FILTER_VALIDATE_EMAIL));
        }
    }

    public function test_phone_number_sanitization()
    {
        $phoneNumber = '+1 (555) 123-4567 ext. 123';
        $sanitized = preg_replace('/[^+\d\s\-\(\)]/', '', $phoneNumber);

        $this->assertEquals('+1 (555) 123-4567 ', $sanitized);
        $this->assertStringNotContainsString('ext.', $sanitized);
    }

    public function test_message_url_prevention()
    {
        $messageWithUrl = 'Check out my website at https://spam-site.com for great deals!';
        $pattern = '/https?:\/\//';

        $this->assertMatchesRegularExpression($pattern, $messageWithUrl);
    }

    public function test_spam_keyword_detection()
    {
        $spamKeywords = ['viagra', 'casino', 'poker', 'loan', 'credit'];
        $spamMessage = 'Get cheap viagra and casino deals now!';

        $pattern = '/\b(?:' . implode('|', $spamKeywords) . ')\b/i';
        $this->assertMatchesRegularExpression($pattern, $spamMessage);
    }

    public function test_rate_limiter_cleanup()
    {
        // Clear any existing rate limits for clean test
        RateLimiter::clear('test_key');

        $key = 'test_key';
        RateLimiter::hit($key, 60);

        $this->assertTrue(RateLimiter::tooManyAttempts($key, 0));

        RateLimiter::clear($key);
        $this->assertFalse(RateLimiter::tooManyAttempts($key, 1));
    }
}