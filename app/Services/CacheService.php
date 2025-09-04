<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CacheService
{
    /**
     * Cache TTL in minutes
     */
    const DEFAULT_TTL = 60; // 1 hour
    const LONG_TTL = 1440;  // 24 hours
    const SHORT_TTL = 15;   // 15 minutes

    /**
     * Get cached DIY products
     *
     * @return Collection
     */
    public function getDIYProducts(): Collection
    {
        return Cache::remember('diy_products', self::DEFAULT_TTL, function () {
            return \App\Models\Product::where('is_diy', true)
                ->where('published', true)
                ->with(['media', 'category'])
                ->orderBy('base_price')
                ->get();
        });
    }

    /**
     * Get cached product by slug
     *
     * @param string $slug
     * @return \App\Models\Product|null
     */
    public function getProductBySlug(string $slug): ?\App\Models\Product
    {
        return Cache::remember("product_slug_{$slug}", self::DEFAULT_TTL, function () use ($slug) {
            return \App\Models\Product::where('slug', $slug)
                ->where('published', true)
                ->with(['media', 'variants', 'category'])
                ->first();
        });
    }

    /**
     * Get cached featured products
     *
     * @param int $limit
     * @return Collection
     */
    public function getFeaturedProducts(int $limit = 6): Collection
    {
        return Cache::remember("featured_products_{$limit}", self::DEFAULT_TTL, function () use ($limit) {
            return \App\Models\Product::where('is_featured', true)
                ->where('published', true)
                ->with('media')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get cached service areas
     *
     * @return Collection
     */
    public function getServiceAreas(): Collection
    {
        return Cache::remember('service_areas', self::LONG_TTL, function () {
            return \App\Models\ServiceArea::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get cached FAQ items
     *
     * @return Collection
     */
    public function getFAQs(): Collection
    {
        return Cache::remember('faqs_grouped', self::DEFAULT_TTL, function () {
            return \App\Models\FAQ::where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('category');
        });
    }

    /**
     * Get cached recent blog posts
     *
     * @param int $limit
     * @return Collection
     */
    public function getRecentBlogs(int $limit = 3): Collection
    {
        return Cache::remember("recent_blogs_{$limit}", self::SHORT_TTL, function () use ($limit) {
            return \App\Models\Blog::published()
                ->with(['category', 'media'])
                ->latest('published_at')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get cached active specials
     *
     * @param int $limit
     * @return Collection
     */
    public function getActiveSpecials(int $limit = 3): Collection
    {
        return Cache::remember("active_specials_{$limit}", self::SHORT_TTL, function () use ($limit) {
            return \App\Models\Special::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where(function($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get cached site settings
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSiteSettings(): \Illuminate\Support\Collection
    {
        return Cache::remember('site_settings', self::LONG_TTL, function () {
            return \App\Models\SiteSetting::pluck('value', 'key');
        });
    }

    /**
     * Clear product-related caches
     *
     * @param string|null $slug
     * @return void
     */
    public function clearProductCaches(?string $slug = null): void
    {
        $keys = [
            'diy_products',
            'featured_products_6',
        ];

        if ($slug) {
            $keys[] = "product_slug_{$slug}";
        }

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        Log::info('Product caches cleared', ['keys' => $keys]);
    }

    /**
     * Clear all content caches
     *
     * @return void
     */
    public function clearContentCaches(): void
    {
        $patterns = [
            'diy_products',
            'featured_products_*',
            'recent_blogs_*',
            'active_specials_*',
            'faqs_grouped',
            'service_areas',
            'product_slug_*',
        ];

        foreach ($patterns as $pattern) {
            if (str_contains($pattern, '*')) {
                // In production, you'd use Redis SCAN or similar
                // For now, we'll clear known keys
                $this->clearWildcardKeys($pattern);
            } else {
                Cache::forget($pattern);
            }
        }

        Log::info('Content caches cleared');
    }

    /**
     * Clear keys matching wildcard pattern
     *
     * @param string $pattern
     * @return void
     */
    private function clearWildcardKeys(string $pattern): void
    {
        // Simple implementation - in production use Redis SCAN
        $commonKeys = [
            'featured_products_3',
            'featured_products_6',
            'featured_products_12',
            'recent_blogs_3',
            'recent_blogs_5',
            'recent_blogs_10',
            'active_specials_3',
            'active_specials_5',
        ];

        $prefix = str_replace('*', '', $pattern);
        
        foreach ($commonKeys as $key) {
            if (str_starts_with($key, $prefix)) {
                Cache::forget($key);
            }
        }
    }

    /**
     * Warm up commonly used caches
     *
     * @return void
     */
    public function warmupCaches(): void
    {
        try {
            $this->getDIYProducts();
            $this->getFeaturedProducts(6);
            $this->getServiceAreas();
            $this->getFAQs();
            $this->getRecentBlogs(3);
            $this->getActiveSpecials(3);
            
            // Only warm up site settings if the model exists
            if (class_exists('\App\Models\SiteSetting')) {
                $this->getSiteSettings();
            }
            
            Log::info('Caches warmed up successfully');
        } catch (\Exception $e) {
            Log::error('Cache warmup failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Get cache statistics
     *
     * @return array
     */
    public function getCacheStats(): array
    {
        $keys = [
            'diy_products',
            'featured_products_6',
            'service_areas',
            'faqs_grouped',
            'recent_blogs_3',
            'active_specials_3',
            'site_settings',
        ];

        $stats = [
            'cached' => 0,
            'missing' => 0,
            'total' => count($keys),
        ];

        foreach ($keys as $key) {
            if (Cache::has($key)) {
                $stats['cached']++;
            } else {
                $stats['missing']++;
            }
        }

        $stats['hit_rate'] = $stats['total'] > 0 
            ? round(($stats['cached'] / $stats['total']) * 100, 1) 
            : 0;

        return $stats;
    }
}