<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Video;
use App\Models\Photo;
use App\Models\QuoteRequest;
use App\Models\AreasWeServe;
use App\Models\Blogcategory;
use App\Models\AvailableColor;
use App\Models\AvailableHeight;
use App\Models\Seo;
use App\Observers\ActivityObserver;
use App\Observers\CacheInvalidationObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Blade::directive('permission', function ($expression) {
            return "<?php if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->hasPermission($expression)) { ?>";
        });
        Blade::directive('end_permission', function () {
            return '<?php } ?>';
        });
        Gate::define('viewPulse', function ($user) {
            return $user && ($user->hasRole('SuperAdmin') || $user->hasRole('super_admin'));
        });

        // SuperAdmin bypasses all permission checks
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('SuperAdmin') || $user->hasRole('super_admin')) {
                return true;
            }
        });

        // Register ActivityObserver for all models except Activity
        $modelsToObserve = [
            User::class,
            Product::class,
            Category::class,
            Video::class,
            Photo::class,
            QuoteRequest::class,
        ];

        foreach ($modelsToObserve as $model) {
            $model::observe(ActivityObserver::class);
        }

        // Register CacheInvalidationObserver for frequently cached models
        $cacheModelsToObserve = [
            AreasWeServe::class,
            Category::class,
            Blogcategory::class,
            AvailableColor::class,
            AvailableHeight::class,
            Seo::class,
        ];

        foreach ($cacheModelsToObserve as $model) {
            $model::observe(CacheInvalidationObserver::class);
        }
    }
}
