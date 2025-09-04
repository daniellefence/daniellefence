<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\CacheService;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    public function __construct(private CacheService $cacheService)
    {
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->clearProductCaches($product, 'created');
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->clearProductCaches($product, 'updated');
        
        // If DIY status or published status changed, clear DIY cache
        if ($product->wasChanged(['is_diy', 'published'])) {
            $this->cacheService->clearProductCaches();
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->clearProductCaches($product, 'deleted');
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->clearProductCaches($product, 'restored');
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->clearProductCaches($product, 'force_deleted');
    }

    /**
     * Clear product-related caches
     */
    private function clearProductCaches(Product $product, string $action): void
    {
        try {
            $this->cacheService->clearProductCaches($product->slug);
            
            Log::debug('Product cache cleared', [
                'product_id' => $product->id,
                'product_slug' => $product->slug,
                'action' => $action,
                'is_diy' => $product->is_diy,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to clear product cache', [
                'product_id' => $product->id,
                'action' => $action,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
