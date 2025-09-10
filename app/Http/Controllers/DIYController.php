<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\NotificationService;
use App\Services\CacheService;
use App\Http\Requests\QuoteRequest;
use Illuminate\Support\Facades\Log;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\SchemaCollection;

class DIYController extends Controller
{
    /**
     * Display DIY section landing page
     */
    public function index(CacheService $cacheService)
    {
        $products = $cacheService->getDIYProducts();

        // SEO data for DIY landing page
        $seoData = new SEOData(
            title: 'DIY Fence Installation - Do It Yourself Fencing Supplies | Danielle Fence',
            description: 'Professional-grade DIY fence materials and supplies. Get everything you need for aluminum, vinyl, and wood fence installation. 49 years serving Central Florida.',
            author: 'Danielle Fence',
            image: asset('images/diy-hero.jpg'),
        );

        $seoData->schema = new SchemaCollection([[
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => 'DIY Fence Installation Supplies',
            'description' => 'Complete DIY fence installation materials and supplies',
            'brand' => [
                '@type' => 'Organization',
                'name' => 'Danielle Fence',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => '4855 State Road 60 West',
                    'addressLocality' => 'Mulberry',
                    'addressRegion' => 'FL',
                    'postalCode' => '33860',
                ],
                'telephone' => '(863) 425-3182',
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'USD',
                'lowPrice' => $products->min('base_price') ?? 99,
                'highPrice' => $products->max('base_price') ?? 999,
                'offerCount' => $products->count(),
            ]
        ]]);

        return view('diy.index', compact('products'))->with('seoData', $seoData);
    }

    /**
     * Display DIY products page
     */
    public function products(CacheService $cacheService)
    {
        $products = $cacheService->getDIYProducts();

        // SEO data for DIY products page
        $seoData = new SEOData(
            title: 'DIY Fence Products - Professional Fence Materials | Danielle Fence',
            description: 'Browse our complete selection of DIY fence products. Aluminum, vinyl, and wood fencing materials with expert installation guides.',
            author: 'Danielle Fence',
        );

        return view('diy.products', compact('products'))->with('seoData', $seoData);
    }

    /**
     * Show specific DIY product
     */
    public function show($slug, CacheService $cacheService)
    {
        $product = $cacheService->getProductBySlug($slug);
        
        if (!$product || !$product->is_diy) {
            abort(404);
        }

        // Special logic for 8' tall fences
        $railPositioning = null;
        if ($product->available_heights && 
            (in_array('8\'', $product->available_heights) || 
             in_array('8ft', $product->available_heights) ||
             str_contains(strtolower($product->name), '8'))) {
            $railPositioning = 'not-centered'; // Middle rail is NOT centered
        }

        // Get SEO data from product model
        $seoData = $product->getDynamicSEOData();

        return view('diy.product', compact('product', 'railPositioning'))->with('seoData', $seoData);
    }

    /**
     * Show quote request form
     */
    public function quote()
    {
        $seoData = new SEOData(
            title: 'Request DIY Fence Quote - Free Estimates | Danielle Fence',
            description: 'Get a free quote for your DIY fence project. Expert guidance and professional materials at wholesale prices.',
            author: 'Danielle Fence',
        );

        return view('diy.quote')->with('seoData', $seoData);
    }

    /**
     * Process quote request
     */
    public function storeQuote(QuoteRequest $request)
    {
        // This will be handled by the existing quote system
        return app(QuoteRequestController::class)->store($request);
    }


    /**
     * Thank you page after quote submission
     */
    public function thankYou()
    {
        return view('diy.thank-you');
    }

    /**
     * DIY installation guide
     */
    public function guide($type = null)
    {
        $guides = [
            'aluminum' => 'Aluminum Fence Installation Guide',
            'vinyl' => 'Vinyl Fence Installation Guide',
            'wood' => 'Wood Fence Installation Guide',
            'gate' => 'Gate Installation Guide',
        ];

        if ($type && !isset($guides[$type])) {
            abort(404);
        }

        return view('diy.guide', compact('guides', 'type'));
    }

    /**
     * Easy fixes page
     */
    public function easyFixes()
    {
        $fixes = [
            [
                'title' => 'Fixing a Sagging Gate',
                'difficulty' => 'Easy',
                'time' => '30 minutes',
                'tools' => ['Screwdriver', 'Level', 'Adjustable Wrench'],
            ],
            [
                'title' => 'Replacing a Fence Picket',
                'difficulty' => 'Easy',
                'time' => '15 minutes',
                'tools' => ['Hammer', 'Nails', 'Saw'],
            ],
            [
                'title' => 'Cleaning Vinyl Fence',
                'difficulty' => 'Easy',
                'time' => '1 hour',
                'tools' => ['Hose', 'Soft Brush', 'Mild Detergent'],
            ],
            [
                'title' => 'Adjusting Gate Hinges',
                'difficulty' => 'Medium',
                'time' => '45 minutes',
                'tools' => ['Drill', 'Screws', 'Level'],
            ],
        ];

        return view('diy.easy-fixes', compact('fixes'));
    }
}
