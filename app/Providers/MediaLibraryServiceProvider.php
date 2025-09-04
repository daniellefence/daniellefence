<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;
use Spatie\MediaLibrary\ResponsiveImages\WidthCalculator\FileSizeOptimizedWidthCalculator;

class MediaLibraryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Configure responsive image generation
        $this->app->bind(WidthCalculator::class, function () {
            return new FileSizeOptimizedWidthCalculator([
                320,  // Mobile portrait
                480,  // Mobile landscape
                768,  // Tablet portrait
                1024, // Tablet landscape / small desktop
                1200, // Desktop
                1600, // Large desktop
                1920, // Full HD
            ]);
        });

        // Configure lazy loading attributes
        config([
            'media-library.default_loading_attribute_value' => 'lazy'
        ]);

        // Set default image optimization quality
        config([
            'media-library.image_optimizers.Spatie\ImageOptimizer\Optimizers\Jpegoptim.quality' => 80,
            'media-library.image_optimizers.Spatie\ImageOptimizer\Optimizers\Cwebp.quality' => 85,
        ]);
    }
}