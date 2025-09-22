<?php

namespace App\Services;

use App\Models\AreasWeServe;
use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\DiyProductCategory;
use App\Models\Modifier;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Cache duration in minutes
     */
    const CACHE_DURATION = 60; // 1 hour
    const LONG_CACHE_DURATION = 1440; // 24 hours

    /**
     * Get cached areas we serve
     */
    public static function getAreasWeServe()
    {
        return Cache::remember('areas_we_serve', self::CACHE_DURATION, function () {
            return AreasWeServe::where('published', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();
        });
    }

    /**
     * Get cached product categories for header menu
     */
    public static function getProductCategories()
    {
        return Cache::remember('product_categories_header', self::CACHE_DURATION, function () {
            return Category::whereNull('parent_id')
                ->where('published', true)
                ->orderBy('order', 'asc')
                ->get();
        });
    }

    /**
     * Get cached blog categories
     */
    public static function getBlogCategories()
    {
        return Cache::remember('blog_categories', self::CACHE_DURATION, function () {
            return Blogcategory::where('published', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();
        });
    }

    /**
     * Get cached DIY product categories
     */
    public static function getDiyCategories()
    {
        return Cache::remember('diy_categories', self::CACHE_DURATION, function () {
            return DiyProductCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get cached available colors for DIY products
     */
    public static function getAvailableColors()
    {
        return Cache::remember('available_colors', self::LONG_CACHE_DURATION, function () {
            return AvailableColor::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get cached available heights for DIY products
     */
    public static function getAvailableHeights()
    {
        return Cache::remember('available_heights', self::LONG_CACHE_DURATION, function () {
            return AvailableHeight::where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('height_feet')
                ->get();
        });
    }

    /**
     * Get cached modifiers for price calculations
     */
    public static function getModifiers($modifierIds = [])
    {
        if (empty($modifierIds)) {
            return collect();
        }

        $cacheKey = 'modifiers_' . implode('_', sort($modifierIds));

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($modifierIds) {
            return Modifier::whereIn('id', $modifierIds)->get();
        });
    }

    /**
     * Get cached SEO data for a route
     */
    public static function getSeoForRoute($route)
    {
        $cacheKey = 'seo_' . md5($route);

        return Cache::remember($cacheKey, self::LONG_CACHE_DURATION, function () use ($route) {
            $seo = Seo::where('route', $route)->first();

            if ($seo) {
                return [
                    'title' => $seo->title,
                    'description' => $seo->description,
                    'keywords' => $seo->keywords,
                    'og_title' => $seo->og_title ?? $seo->title,
                    'og_description' => $seo->og_description ?? $seo->description,
                    'og_image' => $seo->og_image
                ];
            }

            // Fallback SEO data
            return [
                'title' => 'Danielle Fence & Outdoor Living',
                'description' => 'Professional fencing and outdoor living solutions in Florida',
                'keywords' => 'fence, fencing, outdoor living, Tampa, Florida',
                'og_title' => 'Danielle Fence & Outdoor Living',
                'og_description' => 'Professional fencing and outdoor living solutions in Florida',
                'og_image' => '/images/og-default.jpg'
            ];
        });
    }

    /**
     * Clear all cached data (useful for admin updates)
     */
    public static function clearAll()
    {
        $keys = [
            'areas_we_serve',
            'product_categories_header',
            'blog_categories',
            'diy_categories',
            'available_colors',
            'available_heights'
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear SEO cache (pattern-based)
        Cache::flush(); // Note: This clears all cache, consider using tags for better control
    }

    /**
     * Clear specific cache by type
     */
    public static function clearByType($type)
    {
        switch ($type) {
            case 'areas':
                Cache::forget('areas_we_serve');
                break;
            case 'categories':
                Cache::forget('product_categories_header');
                break;
            case 'blog_categories':
                Cache::forget('blog_categories');
                break;
            case 'diy_categories':
                Cache::forget('diy_categories');
                break;
            case 'diy_colors':
                Cache::forget('available_colors');
                break;
            case 'diy_heights':
                Cache::forget('available_heights');
                break;
            case 'seo':
                // Clear all SEO cache entries
                Cache::flush(); // In production, consider using cache tags
                break;
        }
    }

    /**
     * Calculate price with modifiers (cached)
     */
    public static function calculatePriceWithModifiers($basePrice, $modifierIds = [])
    {
        if (empty($modifierIds)) {
            return $basePrice;
        }

        $modifiers = self::getModifiers($modifierIds);
        $totalPrice = $basePrice;

        foreach ($modifiers as $modifier) {
            switch ($modifier->adjustment_type) {
                case 'add':
                    $totalPrice += $modifier->price_adjustment;
                    break;
                case 'subtract':
                    $totalPrice -= $modifier->price_adjustment;
                    break;
                case 'multiply':
                    $totalPrice *= $modifier->price_adjustment;
                    break;
                case 'percentage':
                    $totalPrice += ($totalPrice * ($modifier->price_adjustment / 100));
                    break;
            }
        }

        return max(0, $totalPrice); // Ensure price doesn't go below 0
    }

    /**
     * Validate service area (cached)
     */
    public static function isServiceAreaValid($area)
    {
        if (empty($area)) {
            return false;
        }

        $areas = self::getAreasWeServe();
        return $areas->pluck('title')->contains($area);
    }
}