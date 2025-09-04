<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Application extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'career_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'cover_letter',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['career_id', 'first_name', 'last_name', 'email', 'phone', 'status'])
            ->logOnlyDirty();
    }

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewing($query)
    {
        return $query->where('status', 'reviewing');
    }

    public function scopeInterviewed($query)
    {
        return $query->where('status', 'interviewed');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('resume')
            ->singleFile()
            ->useDisk(config('media-library.disk_name', 'public'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // No conversions needed for resume files
    }
}
