<?php

namespace App\Observers;

use App\Services\CacheService;

class CacheInvalidationObserver
{
    /**
     * Handle the model "created" event.
     */
    public function created($model)
    {
        $this->clearRelatedCache($model);
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated($model)
    {
        $this->clearRelatedCache($model);
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted($model)
    {
        $this->clearRelatedCache($model);
    }

    /**
     * Clear cache based on model type
     */
    private function clearRelatedCache($model)
    {
        $modelClass = class_basename($model);

        switch ($modelClass) {
            case 'AreasWeServe':
                CacheService::clearByType('areas');
                break;
            case 'Category':
                CacheService::clearByType('categories');
                break;
            case 'Blogcategory':
                CacheService::clearByType('blog_categories');
                break;
            case 'AvailableColor':
                CacheService::clearByType('available_colors');
                break;
            case 'AvailableHeight':
                CacheService::clearByType('available_heights');
                break;
            case 'Seo':
                CacheService::clearByType('seo');
                break;
        }
    }
}