<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Conversion;
use App\Services\MediaOptimizationService;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Product extends Model implements HasMedia
{
    use HasFactory, LogsActivity, HasTags, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'product_category_id','name','slug','description','stock_code','base_price','is_diy','available_colors','available_heights','available_picket_widths','published','published_at','rating'
    ];

    protected $casts = [
        'is_diy' => 'boolean',
        'published' => 'boolean',
        'published_at' => 'datetime',
        'available_colors' => 'array',
        'available_heights' => 'array',
        'available_picket_widths' => 'array',
        'base_price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','slug','stock_code','base_price','is_diy','published'])
            ->logOnlyDirty();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
    
    // Add scopes for published content
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
    
    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    public function modifiers(): HasMany
    {
        return $this->hasMany(Modifier::class);
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useDisk(config('media-library.disk_name', 'public'))
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
            
        $this->addMediaCollection('gallery')
            ->useDisk(config('media-library.disk_name', 'public'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
            
        $this->addMediaCollection('documents')
            ->useDisk(config('media-library.disk_name', 'public'))
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Add optimized product image conversions
        MediaOptimizationService::addProductConversions($this->mediaConversions(), 'images');
        MediaOptimizationService::addGalleryConversions($this->mediaConversions(), 'gallery');
        
        // Generate responsive images
        $this->addMediaConversion('responsive')
            ->performOnCollections('images', 'gallery')
            ->withResponsiveImages();
    }

    /**
     * Get SEO data for product pages
     */
    public function getDynamicSEOData(): SEOData
    {
        $title = $this->name . ' - Danielle Fence';
        $description = $this->description 
            ? substr(strip_tags($this->description), 0, 155) . '...'
            : "High-quality {$this->name} from Danielle Fence. Professional fence installation and DIY supplies in Central Florida.";

        $seoData = new SEOData(
            title: $title,
            description: $description,
            author: 'Danielle Fence',
        );

        // Add product-specific structured data
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $this->name,
            'description' => $this->description,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Danielle Fence'
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $this->base_price,
                'priceCurrency' => 'USD',
                'availability' => $this->published ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            ],
        ];

        if ($this->rating) {
            $structuredData['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $this->rating,
                'bestRating' => 5,
            ];
        }

        if ($this->getFirstMediaUrl()) {
            $structuredData['image'] = $this->getFirstMediaUrl();
            $seoData->image = $this->getFirstMediaUrl();
        }

        $seoData->schema = collect([$structuredData]);

        return $seoData;
    }
}
