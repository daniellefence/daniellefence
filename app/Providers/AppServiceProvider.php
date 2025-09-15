<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\QuoteRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Review;
use App\Observers\QuoteRequestObserver;
use App\Observers\ProductObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        QuoteRequest::observe(QuoteRequestObserver::class);
        Product::observe(ProductObserver::class);
        
        // Share categories and reviews with header component
        View::composer('components.header', function ($view) {
            $categories = ProductCategory::active()
                ->roots()
                ->orderBy('sort_order')
                ->get();

            $marquee_reviews = Review::where('published', true)
                ->where('rating', '>=', 4)
                ->latest()
                ->limit(15)
                ->get();

            $view->with([
                'categories' => $categories,
                'marquee_reviews' => $marquee_reviews
            ]);
        });
    }
}
