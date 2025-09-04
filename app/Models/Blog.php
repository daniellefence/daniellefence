<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Services\MediaOptimizationService;

class Blog extends Model implements HasMedia
{
    use HasFactory, LogsActivity, HasTags, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'published',
        'published_at',
        'blog_category_id',
        'author_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'published', 'published_at', 'blog_category_id'])
            ->logOnlyDirty();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)->whereNotNull('published_at');
    }

    public function scopeDraft($query)
    {
        return $query->where('published', false);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->useDisk(config('media-library.disk_name', 'public'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
        
        $this->addMediaCollection('gallery')
            ->useDisk(config('media-library.disk_name', 'public'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
            
        $this->addMediaCollection('content_images')
            ->useDisk(config('media-library.disk_name', 'public'))
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Add optimized blog image conversions
        MediaOptimizationService::addBlogConversions($this->mediaConversions, 'featured_image');
        MediaOptimizationService::addGalleryConversions($this->mediaConversions, 'gallery');
        MediaOptimizationService::addWebOptimizedConversions($this->mediaConversions, 'content_images');
        
        // Generate responsive images for all collections
        $this->addMediaConversion('responsive')
            ->performOnCollections('featured_image', 'gallery', 'content_images')
            ->withResponsiveImages();
    }
}
