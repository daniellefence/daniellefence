<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Special extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, LogsActivity, HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'discount_percentage',
        'discount_amount',
        'min_purchase_amount',
        'start_date',
        'end_date',
        'is_active',
        'is_featured',
        'promo_code',
        'usage_limit',
        'usage_count',
        'applicable_products',
        'applicable_categories',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'min_purchase_amount' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('banner')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('thumbnails')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('small')
            ->width(300)
            ->height(200)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('banner-large')
            ->width(1200)
            ->height(400)
            ->sharpen(10)
            ->performOnCollections('banner')
            ->nonQueued();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'is_active', 'is_featured', 'start_date', 'end_date'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->description,
            image: $this->getFirstMediaUrl('banner'),
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('start_date')->orWhere('start_date', '<=', now());
                    })
                    ->where(function($q) {
                        $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function isCurrentlyActive(): bool
    {
        if (!$this->is_active) return false;
        
        $now = now();
        
        if ($this->start_date && $this->start_date->gt($now)) return false;
        if ($this->end_date && $this->end_date->lt($now)) return false;
        
        return true;
    }

    public function hasUsageLimitReached(): bool
    {
        return $this->usage_limit && $this->usage_count >= $this->usage_limit;
    }

    public function canBeUsed(): bool
    {
        return $this->isCurrentlyActive() && !$this->hasUsageLimitReached();
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }
}
