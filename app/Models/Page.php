<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity, HasSEO, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_data',
        'published',
        'published_at',
        'author_id',
        'sort_order',
        'template',
    ];

    protected $casts = [
        'meta_data' => 'array',
        'published' => 'boolean',
        'published_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hero')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);

        $this->addMediaCollection('thumbnails')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('page-content')
            ->acceptsMimeTypes([
                'image/jpeg', 'image/png', 'image/webp', 'image/gif',
                'application/pdf', 'text/plain', 
                'application/msword', 
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ]);
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
            ->height(300)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('hero-desktop')
            ->width(1920)
            ->height(1080)
            ->sharpen(10)
            ->performOnCollections('hero')
            ->nonQueued();

        $this->addMediaConversion('hero-tablet')
            ->width(1024)
            ->height(768)
            ->sharpen(10)
            ->performOnCollections('hero')
            ->nonQueued();

        $this->addMediaConversion('hero-mobile')
            ->width(768)
            ->height(576)
            ->sharpen(10)
            ->performOnCollections('hero')
            ->nonQueued();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'published', 'published_at', 'template'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->excerpt,
            image: $this->getFirstMediaUrl('hero'),
        );
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function getHeroImageUrl(string $conversion = ''): string
    {
        return \App\Helpers\MediaUrlHelper::getMediaUrl(
            $this->getFirstMedia('hero') ?: new \Spatie\MediaLibrary\MediaCollections\Models\Media(),
            $conversion
        );
    }

    public function getGalleryImages(): \Illuminate\Support\Collection
    {
        return $this->getMedia('gallery')->map(function($media) {
            return \App\Helpers\MediaUrlHelper::getMediaForEditor($media);
        });
    }

    public function getThumbnailUrl(string $conversion = 'thumb'): string
    {
        $thumbnail = $this->getFirstMedia('thumbnails') ?: $this->getFirstMedia('hero');
        
        if (!$thumbnail) {
            return \App\Helpers\MediaUrlHelper::getPlaceholder(150, 150, 'Page');
        }

        return \App\Helpers\MediaUrlHelper::getMediaUrl($thumbnail, $conversion);
    }

    public function isPublished(): bool
    {
        return $this->published && 
               ($this->published_at === null || $this->published_at->lte(now()));
    }
}
