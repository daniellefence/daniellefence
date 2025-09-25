<?php

namespace App\Providers;

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
            \App\Models\User::class,
            \App\Models\Product::class,
            \App\Models\Category::class,
            \App\Models\Video::class,
            \App\Models\Photo::class,
            \App\Models\QuoteRequest::class,
        ];

        foreach ($modelsToObserve as $model) {
            $model::observe(ActivityObserver::class);
        }

        // Register CacheInvalidationObserver for frequently cached models
        $cacheModelsToObserve = [
            \App\Models\AreasWeServe::class,
            \App\Models\Category::class,
            \App\Models\Blogcategory::class,
            \App\Models\DiyProductCategory::class,
            \App\Models\AvailableColor::class,
            \App\Models\AvailableHeight::class,
            \App\Models\Seo::class,
        ];

        foreach ($cacheModelsToObserve as $model) {
            $model::observe(CacheInvalidationObserver::class);
        }
    }
}
