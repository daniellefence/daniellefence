<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Career;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ServiceArea;
use App\Models\Special;
use App\Models\FAQ;
use App\Models\Review;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PublicPagesController extends Controller
{
    /**
     * Display the homepage
     */
    public function home()
    {
        $data = [
            'featured_products' => Product::where('is_featured', true)
                ->where('is_active', true)
                ->with('media')
                ->limit(6)
                ->get(),
            'recent_blogs' => Blog::published()
                ->with(['category', 'media'])
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'specials' => Special::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where(function($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->limit(3)
                ->get(),
            'reviews' => Review::where('published', true)
                ->where('rating', '>=', 4)
                ->latest()
                ->limit(10) // Get more for marquee
                ->get(),
            'marquee_reviews' => Review::where('published', true)
                ->where('rating', '>=', 4)
                ->latest()
                ->limit(15) // Get enough for seamless scrolling
                ->get(),
            'service_areas' => ServiceArea::where('is_active', true)
                ->orderBy('sort_order')
                ->limit(30)
                ->get(),
        ];

        return view('welcome', $data);
    }

    /**
     * Display blog listing page
     */
    public function blogIndex(Request $request)
    {
        $query = Blog::published()->with(['category', 'media']);

        // Filter by category if provided
        if ($request->has('category')) {
            $category = BlogCategory::where('slug', $request->category)->firstOrFail();
            $query->where('blog_category_id', $category->id);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest('published_at')->paginate(12);
        $categories = BlogCategory::withCount('blogs')->get();

        return view('public.blog.index', compact('blogs', 'categories'));
    }

    /**
     * Display single blog post
     */
    public function blogShow($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with(['category', 'media'])
            ->firstOrFail();

        // Increment view count
        $blog->increment('view_count');

        // Get related posts
        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->limit(3)
            ->get();

        return view('public.blog.show', compact('blog', 'related'));
    }

    /**
     * Display careers listing page
     */
    public function careersIndex()
    {
        $careers = Career::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.careers.index', compact('careers'));
    }

    /**
     * Display single career page
     */
    public function careerShow($slug)
    {
        $career = Career::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.careers.show', compact('career'));
    }

    /**
     * Display products listing page
     */
    public function productsIndex(Request $request)
    {
        $query = Product::where('is_active', true)->with(['media', 'category']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price-low':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('base_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('sort_order', 'asc');
        }

        $products = $query->paginate(16);

        return view('public.products.index', compact('products'));
    }

    /**
     * Display single product page
     */
    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['media', 'category', 'variants'])
            ->firstOrFail();

        // Get related products
        $related = Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->limit(4)
            ->get();

        return view('public.products.show', compact('product', 'related'));
    }

    /**
     * Display service areas listing
     */
    public function serviceAreasIndex()
    {
        $serviceAreas = ServiceArea::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('public.service-areas.index', compact('serviceAreas'));
    }

    /**
     * Display single service area page
     */
    public function serviceAreaShow($slug)
    {
        $serviceArea = ServiceArea::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.service-areas.show', compact('serviceArea'));
    }

    /**
     * Display specials page
     */
    public function specials()
    {
        $specials = Special::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where(function($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('sort_order')
            ->get();

        return view('public.specials', compact('specials'));
    }

    /**
     * Display FAQ page
     */
    public function faq()
    {
        $faqs = FAQ::where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        return view('public.faq', compact('faqs'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display quote request page
     */
    public function quote()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.quote', compact('products'));
    }

    /**
     * Display dynamic page by slug
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.page', compact('page'));
    }

    /**
     * Display residential page
     */
    public function residential()
    {
        return view('pages.residential');
    }

    /**
     * Display commercial page
     */
    public function commercial()
    {
        return view('pages.commercial');
    }

    /**
     * Display financing page
     */
    public function financing()
    {
        return view('pages.financing');
    }

    /**
     * Display fire feature catalogs page
     */
    public function fireFeatureCatalogs()
    {
        return view('pages.fire-feature-catalogs');
    }

    /**
     * Display mascots page
     */
    public function mascots()
    {
        return view('pages.mascots');
    }

    /**
     * Display showroom page
     */
    public function showroom()
    {
        return view('pages.showroom');
    }

    /**
     * Display product warranties page
     */
    public function productWarranties()
    {
        return view('pages.product-warranties');
    }

    /**
     * Display why danielle fence page
     */
    public function whyDanielleFence()
    {
        return view('pages.why-danielle-fence');
    }

    /**
     * Display acceptable use page
     */
    public function acceptableUse()
    {
        return view('pages.acceptable-use');
    }

    /**
     * Display cookie policy page
     */
    public function cookiePolicy()
    {
        return view('pages.cookie-policy');
    }

    /**
     * Display terms page
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Display privacy page
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Display returns page
     */
    public function returns()
    {
        return view('pages.returns');
    }

    /**
     * Display disclaimer page
     */
    public function disclaimer()
    {
        return view('pages.disclaimer');
    }

    /**
     * Display thanks page
     */
    public function thanks()
    {
        return view('pages.thanks');
    }

    /**
     * Display search page
     */
    public function search()
    {
        return view('pages.search');
    }

    /**
     * Display company history page
     */
    public function companyHistory()
    {
        $seoData = new SEOData(
            title: 'Company History - Since 1976 | Danielle Fence',
            description: 'Discover nearly 50 years of Danielle Fence history. From Disney World to your backyard - family-owned, American-made quality since 1976.',
            author: 'Danielle Fence',
        );

        return view('pages.company-history')->with('seoData', $seoData);
    }

    /**
     * Display company story page (alias for company history)
     */
    public function story()
    {
        return $this->companyHistory();
    }

    /**
     * Display gallery page
     */
    public function gallery()
    {
        $seoData = new SEOData(
            title: 'Gallery - Our Work Showcase | Danielle Fence',
            description: 'View our portfolio of residential and commercial fence installations. Quality workmanship since 1976.',
            author: 'Danielle Fence',
        );

        return view('pages.gallery')->with('seoData', $seoData);
    }

    /**
     * Display reviews page
     */
    public function reviews()
    {
        $reviews = Review::where('published', true)
            ->where('rating', '>=', 4)
            ->latest()
            ->paginate(20);

        $seoData = new SEOData(
            title: 'Customer Reviews | Danielle Fence',
            description: 'Read what our customers say about our fence installation services. 49 years of satisfied customers in Central Florida.',
            author: 'Danielle Fence',
        );

        return view('pages.reviews', compact('reviews'))->with('seoData', $seoData);
    }
}