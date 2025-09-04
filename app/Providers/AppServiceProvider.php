<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\QuoteRequest;
use App\Models\Product;
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
    }
}
