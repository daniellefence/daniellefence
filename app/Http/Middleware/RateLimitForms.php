<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class RateLimitForms
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $formType = 'general'): Response
    {
        // Create rate limiting key based on IP and form type
        $key = $this->resolveRequestSignature($request, $formType);

        // Define rate limits based on form type
        $limits = [
            'contact' => [5, 60], // 5 attempts per minute
            'quote' => [3, 60], // 3 attempts per minute
            'career' => [2, 60], // 2 attempts per minute
            'general' => [10, 60], // 10 attempts per minute
        ];

        [$maxAttempts, $decayMinutes] = $limits[$formType] ?? $limits['general'];

        // Check if rate limit is exceeded
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);

            return response()->json([
                'message' => 'Too many form submissions. Please try again in ' . $retryAfter . ' seconds.',
                'retry_after' => $retryAfter
            ], 429);
        }

        // Increment the rate limiter
        RateLimiter::hit($key, $decayMinutes * 60);

        return $next($request);
    }

    /**
     * Resolve request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request, string $formType): string
    {
        // Use IP address and form type as the rate limiting key
        $ip = $request->ip();
        $userAgent = substr(md5($request->userAgent()), 0, 8);

        return "form_rate_limit:{$formType}:{$ip}:{$userAgent}";
    }
}