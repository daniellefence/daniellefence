<?php

namespace Tests\Feature\Middleware;

use App\Http\Middleware\RateLimitForms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Test suite for RateLimitForms Middleware.
 *
 * This comprehensive test suite validates the form rate limiting functionality
 * including different form types, rate limit thresholds, IP-based limiting,
 * user agent fingerprinting, and proper error responses.
 *
 * @package Tests\Feature\Middleware
 * @author Generated via PhpStorm MCP connector
 */
class RateLimitFormsTest extends TestCase
{
    protected RateLimitForms $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new RateLimitForms();
        RateLimiter::clear('form_rate_limit:*');
    }

    protected function tearDown(): void
    {
        RateLimiter::clear('form_rate_limit:*');
        parent::tearDown();
    }

    /** @test */
    public function it_allows_requests_under_rate_limit()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.1');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true, 'message' => 'Form processed']);
        }, 'contact');

        $this->assertEquals(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Form processed', $responseData['message']);
    }

    /** @test */
    public function it_blocks_contact_form_after_rate_limit_exceeded()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.2');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)');

        // Submit 5 requests (contact form limit)
        for ($i = 0; $i < 5; $i++) {
            $response = $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'contact');
            $this->assertEquals(200, $response->getStatusCode());
        }

        // 6th request should be blocked
        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        }, 'contact');

        $this->assertEquals(429, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertStringContains('Too many form submissions', $responseData['message']);
        $this->assertArrayHasKey('retry_after', $responseData);
    }

    /** @test */
    public function it_blocks_quote_form_after_rate_limit_exceeded()
    {
        $request = Request::create('/quote', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.3');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)');

        // Submit 3 requests (quote form limit)
        for ($i = 0; $i < 3; $i++) {
            $response = $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'quote');
            $this->assertEquals(200, $response->getStatusCode());
        }

        // 4th request should be blocked
        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        }, 'quote');

        $this->assertEquals(429, $response->getStatusCode());
    }

    /** @test */
    public function it_blocks_career_form_after_rate_limit_exceeded()
    {
        $request = Request::create('/careers', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.4');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Android 10; Mobile; rv:81.0)');

        // Submit 2 requests (career form limit)
        for ($i = 0; $i < 2; $i++) {
            $response = $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'career');
            $this->assertEquals(200, $response->getStatusCode());
        }

        // 3rd request should be blocked
        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        }, 'career');

        $this->assertEquals(429, $response->getStatusCode());
    }

    /** @test */
    public function it_uses_general_rate_limit_for_unknown_form_types()
    {
        $request = Request::create('/unknown-form', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.5');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (compatible; Test)');

        // Submit 10 requests (general form limit)
        for ($i = 0; $i < 10; $i++) {
            $response = $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'unknown');
            $this->assertEquals(200, $response->getStatusCode());
        }

        // 11th request should be blocked
        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should not reach the next middleware');
        }, 'unknown');

        $this->assertEquals(429, $response->getStatusCode());
    }

    /** @test */
    public function it_uses_different_keys_for_different_ip_addresses()
    {
        $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)';

        // First IP submits contact forms
        $request1 = Request::create('/contact', 'POST');
        $request1->server->set('REMOTE_ADDR', '192.168.1.10');
        $request1->headers->set('User-Agent', $userAgent);

        // Second IP submits contact forms
        $request2 = Request::create('/contact', 'POST');
        $request2->server->set('REMOTE_ADDR', '192.168.1.11');
        $request2->headers->set('User-Agent', $userAgent);

        // Both IPs should be able to submit 5 forms independently
        for ($i = 0; $i < 5; $i++) {
            $response1 = $this->middleware->handle($request1, function ($req) {
                return response()->json(['ip1_success' => true]);
            }, 'contact');
            $this->assertEquals(200, $response1->getStatusCode());

            $response2 = $this->middleware->handle($request2, function ($req) {
                return response()->json(['ip2_success' => true]);
            }, 'contact');
            $this->assertEquals(200, $response2->getStatusCode());
        }

        // Both IPs should now be rate limited
        $response1 = $this->middleware->handle($request1, function ($req) {
            $this->fail('IP1 should be rate limited');
        }, 'contact');
        $this->assertEquals(429, $response1->getStatusCode());

        $response2 = $this->middleware->handle($request2, function ($req) {
            $this->fail('IP2 should be rate limited');
        }, 'contact');
        $this->assertEquals(429, $response2->getStatusCode());
    }

    /** @test */
    public function it_includes_user_agent_hash_in_rate_limit_key()
    {
        $ip = '192.168.1.20';

        // Same IP but different user agents
        $request1 = Request::create('/contact', 'POST');
        $request1->server->set('REMOTE_ADDR', $ip);
        $request1->headers->set('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0');

        $request2 = Request::create('/contact', 'POST');
        $request2->server->set('REMOTE_ADDR', $ip);
        $request2->headers->set('User-Agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36');

        // Both user agents should be able to submit forms independently
        for ($i = 0; $i < 5; $i++) {
            $response1 = $this->middleware->handle($request1, function ($req) {
                return response()->json(['chrome_success' => true]);
            }, 'contact');
            $this->assertEquals(200, $response1->getStatusCode());

            $response2 = $this->middleware->handle($request2, function ($req) {
                return response()->json(['safari_success' => true]);
            }, 'contact');
            $this->assertEquals(200, $response2->getStatusCode());
        }
    }

    /** @test */
    public function it_provides_retry_after_information()
    {
        $request = Request::create('/quote', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.30');
        $request->headers->set('User-Agent', 'Test User Agent');

        // Exceed the quote form rate limit (3 requests)
        for ($i = 0; $i < 3; $i++) {
            $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'quote');
        }

        // Next request should include retry_after information
        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should be rate limited');
        }, 'quote');

        $this->assertEquals(429, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('retry_after', $responseData);
        $this->assertIsInt($responseData['retry_after']);
        $this->assertGreaterThan(0, $responseData['retry_after']);
        $this->assertLessThanOrEqual(3600, $responseData['retry_after']); // Should be within 1 hour
    }

    /** @test */
    public function it_increments_rate_limiter_on_each_request()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.40');
        $request->headers->set('User-Agent', 'Mozilla/5.0 (Test Browser)');

        $middleware = new RateLimitForms();

        // Make requests and verify rate limiter is incremented
        for ($i = 1; $i <= 4; $i++) {
            $response = $middleware->handle($request, function ($req) {
                return response()->json(['request_number' => time()]);
            }, 'contact');

            $this->assertEquals(200, $response->getStatusCode());

            // Check remaining attempts
            $key = 'form_rate_limit:contact:192.168.1.40:' . substr(md5('Mozilla/5.0 (Test Browser)'), 0, 8);
            $remaining = 5 - RateLimiter::attempts($key);
            $this->assertEquals(5 - $i, $remaining);
        }
    }

    /** @test */
    public function it_handles_missing_user_agent()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.50');
        // No User-Agent header set

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true]);
        }, 'contact');

        // Should still work even without User-Agent
        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_handles_null_user_agent()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.60');
        $request->headers->set('User-Agent', null);

        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true]);
        }, 'contact');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_uses_default_general_form_type_when_no_type_provided()
    {
        $request = Request::create('/form', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.70');
        $request->headers->set('User-Agent', 'Test Browser');

        // Call without specifying form type (should default to 'general')
        $response = $this->middleware->handle($request, function ($req) {
            return response()->json(['success' => true]);
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function it_generates_consistent_rate_limit_keys()
    {
        $middleware = new RateLimitForms();

        $request = Request::create('/test', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.80');
        $request->headers->set('User-Agent', 'Consistent User Agent');

        // Use reflection to test the protected method
        $reflection = new \ReflectionClass($middleware);
        $method = $reflection->getMethod('resolveRequestSignature');
        $method->setAccessible(true);

        $key1 = $method->invoke($middleware, $request, 'contact');
        $key2 = $method->invoke($middleware, $request, 'contact');

        $this->assertEquals($key1, $key2);
        $this->assertStringContains('form_rate_limit:contact:192.168.1.80:', $key1);
    }

    /** @test */
    public function it_returns_proper_json_error_response()
    {
        $request = Request::create('/contact', 'POST');
        $request->server->set('REMOTE_ADDR', '192.168.1.90');
        $request->headers->set('User-Agent', 'Test Agent');

        // Exceed rate limit
        for ($i = 0; $i < 5; $i++) {
            $this->middleware->handle($request, function ($req) {
                return response()->json(['success' => true]);
            }, 'contact');
        }

        $response = $this->middleware->handle($request, function ($req) {
            $this->fail('Should be rate limited');
        }, 'contact');

        $this->assertEquals(429, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('content-type'));

        $responseData = json_decode($response->getContent(), true);
        $this->assertIsArray($responseData);
        $this->assertArrayHasKey('message', $responseData);
        $this->assertArrayHasKey('retry_after', $responseData);
    }
}