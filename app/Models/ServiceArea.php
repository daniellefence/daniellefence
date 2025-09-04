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

class ServiceArea extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, LogsActivity, HasSEO;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'state',
        'county',
        'latitude',
        'longitude',
        'radius_miles',
        'is_primary',
        'is_active',
        'sort_order',
        'zip_codes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'radius_miles' => 'integer',
        'zip_codes' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('hero')
            ->singleFile()
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
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'is_primary', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->name . ' - Service Area',
            description: $this->description,
            image: $this->getFirstMediaUrl('hero'),
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getFullNameAttribute(): string
    {
        $parts = [$this->name];
        
        if ($this->county) {
            $parts[] = $this->county . ' County';
        }
        
        if ($this->state) {
            $parts[] = $this->state;
        }
        
        return implode(', ', $parts);
    }
}
