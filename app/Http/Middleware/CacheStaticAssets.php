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

        // Return early if response is null or not a Response object
        if (!$response instanceof Response) {
            return $response;
        }

        // Only apply caching to static assets
        if ($this->isStaticAsset($request)) {
            // Cache for 1 year for images, fonts, and build assets
            if ($this->isLongTermCacheable($request)) {
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 31536000));
            }
            // Cache for 1 week for other static assets (longer than 1 day)
            else {
                $response->headers->set('Cache-Control', 'public, max-age=604800');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s \G\M\T', time() + 604800));
            }

            // Add ETag for better caching
            $response->headers->set('ETag', '"' . md5($response->getContent()) . '"');

            // Add image optimization headers
            if ($this->isImage($request)) {
                $response->headers->set('Vary', 'Accept');
                // Allow browsers to serve WebP when supported
                if (str_contains($request->header('Accept', ''), 'image/webp')) {
                    $response->headers->set('Content-Type', 'image/webp');
                }
            }
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
               str_starts_with($path, 'storage/') ||
               preg_match('/\.(woff|woff2|ttf|eot|png|jpg|jpeg|gif|webp|svg|ico|mp4|webm)$/i', $path) ||
               preg_match('/-[a-f0-9]{8,}\.(css|js|png|jpg|jpeg|gif|webp|svg)$/i', $path);
    }

    private function isImage(Request $request): bool
    {
        $path = $request->path();
        return preg_match('/\.(png|jpg|jpeg|gif|webp|svg|ico)$/i', $path);
    }
}
