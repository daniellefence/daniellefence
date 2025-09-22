<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneypotProtection
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for honeypot fields (these should be empty)
        $honeypotFields = [
            'website',
            'url',
            'homepage',
            'bot_field',
            'spam_check'
        ];

        foreach ($honeypotFields as $field) {
            if ($request->filled($field)) {
                // Log the spam attempt
                \Log::warning('Honeypot field filled', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'field' => $field,
                    'value' => $request->input($field),
                    'url' => $request->fullUrl()
                ]);

                // Return a fake success response to not alert the bot
                return response()->json([
                    'success' => true,
                    'message' => 'Form submitted successfully'
                ], 200);
            }
        }

        // Check for suspicious form submission timing (too fast)
        $formStartTime = $request->input('form_start_time');
        if ($formStartTime) {
            $timeDiff = time() - $formStartTime;
            if ($timeDiff < 3) { // Less than 3 seconds
                \Log::warning('Form submitted too quickly', [
                    'ip' => $request->ip(),
                    'time_diff' => $timeDiff,
                    'url' => $request->fullUrl()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Please take a moment to fill out the form properly.'
                ], 422);
            }
        }

        return $next($request);
    }
}