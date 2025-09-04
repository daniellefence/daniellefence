<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Contact extends Model implements HasMedia
{
    use HasFactory, LogsActivity, HasTags, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'message',
        'how_did_you_hear_about_us',
        'notes'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name', 'last_name', 'company', 'email', 'phone', 'message', 'how_did_you_hear_about_us'])
            ->logOnlyDirty();
    }

    public function quoteRequests(): HasMany
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk(config('media-library.disk_name', 'public'));
        $this->addMediaCollection('documents')->useDisk(config('media-library.disk_name', 'public'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(300)->height(300)->nonQueued();
    }
}
