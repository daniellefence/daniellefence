<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Pulse\Facades\Pulse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for tracking website traffic and analytics.
 *
 * This middleware captures visitor data for each request, including IP addresses,
 * user agents, referrers, and routes. It records data both to the traditional
 * database and to Laravel Pulse for real-time analytics and monitoring.
 *
 * @package App\Http\Middleware
 * @author Shane Barron
 */
class Traffic
{
    /**
     * Handle an incoming request and track visitor analytics.
     *
     * This method processes each request to capture comprehensive traffic data:
     * - Determines the real IP address (accounting for proxies/load balancers)
     * - Records traditional traffic data to the database
     * - Records real-time metrics to Laravel Pulse
     * - Tracks page views, route hits, user agents, and traffic sources
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next The next middleware
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Determine the real IP address, accounting for proxies and load balancers
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Create traditional traffic record in the database
        \App\Models\Traffic::create([
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'method' => $request->server('REQUEST_METHOD'),
            'source' => $request->server('HTTP_REFERER'),
            'ip' => $ip,
            'route' => \Illuminate\Support\Facades\Route::currentRouteName(),
        ]);

        // Record metrics to Laravel Pulse for real-time analytics
        $routeName = \Illuminate\Support\Facades\Route::currentRouteName() ?? $request->path();

        // Track total page views
        Pulse::record('page_views', 'total', 1);

        // Track hits per route for popular page analysis
        Pulse::record('route_hits', $routeName, 1);

        // Track user agents for device/browser analytics (truncated to prevent storage bloat)
        Pulse::record('user_agents', substr($request->server('HTTP_USER_AGENT', 'Unknown'), 0, 100), 1);

        // Track traffic sources and referrers
        if ($request->server('HTTP_REFERER')) {
            $referer = parse_url($request->server('HTTP_REFERER'), PHP_URL_HOST) ?? 'direct';
            Pulse::record('traffic_sources', $referer, 1);
        }

        return $next($request);
    }
}
