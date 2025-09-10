<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\QuoteRequest;
use App\Models\Product;
use App\Models\Category;
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
        
        // Share categories with header component
        View::composer('components.header', function ($view) {
            $categories = Category::published()
                ->rootCategories()
                ->with('children')
                ->orderBy('name')
                ->get();
            
            $view->with('categories', $categories);
        });
    }
}
