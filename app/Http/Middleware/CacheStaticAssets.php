<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheStaticAssets
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only apply caching to static assets
        if ($this->isStaticAsset($request)) {
            // Cache for 1 year for images, fonts, and build assets
            if ($this->isLongTermCacheable($request)) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
            }
            // Cache for 1 day for other static assets
            else {
                $response->headers->set('Cache-Control', 'public, max-age=86400');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
            }

            // Add ETag for better caching
            $response->headers->set('ETag', '"' . md5($response->getContent()) . '"');
        }

        return $response;
    }

    private function isStaticAsset(Request $request): bool
    {
        $path = $request->path();

        return str_starts_with($path, 'build/') ||
               str_starts_with($path, 'storage/') ||
               str_starts_with($path, 'images/') ||
               preg_match('/\.(css|js|png|jpg|jpeg|gif|webp|svg|woff|woff2|ttf|eot|ico|mp4|webm)$/i', $path);
    }

    private function isLongTermCacheable(Request $request): bool
    {
        $path = $request->path();

        // Build assets with hashes can be cached longer
        return str_starts_with($path, 'build/') ||
               preg_match('/\.(woff|woff2|ttf|eot)$/i', $path) ||
               preg_match('/-[a-f0-9]{8,}\.(css|js|png|jpg|jpeg|gif|webp|svg)$/i', $path);
    }
}
