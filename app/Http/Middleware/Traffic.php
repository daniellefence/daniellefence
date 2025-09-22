<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Traffic
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        \App\Models\Traffic::create([
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'method' => $request->server('REQUEST_METHOD'),
            'source' => $request->server('HTTP_REFERER'),
            'ip' => $ip,
            'route' => \Illuminate\Support\Facades\Route::currentRouteName(),
        ]);

        return $next($request);
    }
}
