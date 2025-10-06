<?php

namespace App\Http\Middleware;

use Log;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for protecting forms against automated spam submissions.
 *
 * This middleware implements honeypot and timing-based protection to detect and block
 * automated bot submissions while allowing legitimate users to submit forms normally.
 * It uses hidden fields that bots typically fill and timing checks to identify suspicious activity.
 *
 * @package App\Http\Middleware
 * @author Shane Barron
 */
class HoneypotProtection
{
    /**
     * Handle an incoming request and apply spam protection.
     *
     * This method implements multiple layers of bot detection:
     * 1. Honeypot fields - Hidden fields that legitimate users won't fill but bots often do
     * 2. Timing checks - Forms submitted too quickly are likely automated
     * 3. Comprehensive logging - All suspicious activity is logged for analysis
     *
     * @param Request $request The incoming HTTP request
     * @param Closure $next The next middleware in the pipeline
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define honeypot fields that should remain empty for legitimate submissions
        $honeypotFields = [
            'website',      // Common field name bots auto-fill
            'url',          // Another common bot target
            'homepage',     // Variation of website field
            'bot_field',    // Explicitly named bot trap
            'spam_check'    // Generic spam protection field
        ];

        // Check each honeypot field - if any are filled, it's likely a bot
        foreach ($honeypotFields as $field) {
            if ($request->filled($field)) {
                // Log the spam attempt with comprehensive details
                Log::warning('Honeypot field filled', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'field' => $field,
                    'value' => $request->input($field),
                    'url' => $request->fullUrl()
                ]);

                // Return a fake success response to avoid alerting sophisticated bots
                return response()->json([
                    'success' => true,
                    'message' => 'Form submitted successfully'
                ], 200);
            }
        }

        // Check for suspicious form submission timing (forms filled too quickly)
        $formStartTime = $request->input('form_start_time');
        if ($formStartTime) {
            $timeDiff = time() - $formStartTime;

            // If submitted in less than 3 seconds, likely automated
            if ($timeDiff < 3) {
                Log::warning('Form submitted too quickly', [
                    'ip' => $request->ip(),
                    'time_diff' => $timeDiff,
                    'url' => $request->fullUrl()
                ]);

                // Return validation error for timing-based rejection
                return response()->json([
                    'success' => false,
                    'message' => 'Please take a moment to fill out the form properly.'
                ], 422);
            }
        }

        // All checks passed, continue with normal request processing
        return $next($request);
    }
}