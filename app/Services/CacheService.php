<?php

namespace App\Services;

use App\Models\AreasWeServe;
use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\Blogcategory;
use App\Models\Category;
use App\Models\Modifier;
use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

/**
 * Service class for managing application-wide caching strategies.
 *
 * This service provides centralized caching for frequently accessed data such as
 * product categories, service areas, SEO data, and pricing calculations. It implements
 * different cache durations based on data volatility and includes cache invalidation methods.
 *
 * @package App\Services
 * @author Shane Barron
 */
class CacheService
{
    /**
     * Standard cache duration in minutes (1 hour).
     *
     * Used for frequently changing data like categories and areas we serve.
     *
     * @var int
     */
    const CACHE_DURATION = 60;

    /**
     * Long cache duration in minutes (24 hours).
     *
     * Used for relatively static data like colors, heights, and SEO data.
     *
     * @var int
     */
    const LONG_CACHE_DURATION = 1440;

    /**
     * Get cached list of areas the company serves.
     *
     * Returns a cached collection of published service areas ordered by
     * sort order and title for display in forms and location validation.
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
     * Get cached product categories for header menu navigation.
     *
     * Returns top-level product categories that are published and ordered
     * for display in the main navigation menu.
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
     * Get cached blog categories for content organization.
     *
     * Returns published blog categories ordered by sort order and title
     * for use in blog navigation and content filtering.
     *
     * @return \Illuminate\Database\Eloquent\Collection
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
     * Get cached available colors
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
     * Get cached available heights
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
            case 'available_colors':
                Cache::forget('available_colors');
                break;
            case 'available_heights':
                Cache::forget('available_heights');
                break;
            case 'seo':
                // Clear all SEO cache entries
                Cache::flush(); // In production, consider using cache tags
                break;
        }
    }

    /**
     * Calculate price with modifiers applied (cached).
     *
     * Applies price modifiers to a base price using different adjustment types:
     * - add: Add fixed amount
     * - subtract: Subtract fixed amount
     * - multiply: Multiply by factor
     * - percentage: Add percentage of current price
     *
     * @param float $basePrice The base price before modifiers
     * @param array $modifierIds Array of modifier IDs to apply
     * @return float The calculated price with all modifiers applied (minimum 0)
     */
    public static function calculatePriceWithModifiers($basePrice, $modifierIds = [])
    {
        if (empty($modifierIds)) {
            return $basePrice;
        }

        $modifiers = self::getModifiers($modifierIds);
        $totalPrice = $basePrice;

        // Apply each modifier based on its adjustment type
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

        // Ensure price doesn't go below 0
        return max(0, $totalPrice);
    }

    /**
     * Validate if a service area is supported (cached).
     *
     * Checks if the provided area name matches any of the published
     * service areas. Used for form validation and service area verification.
     *
     * @param string|null $area The area name to validate
     * @return bool True if the area is in the service list, false otherwise
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