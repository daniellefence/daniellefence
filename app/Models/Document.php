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

class Document extends Model implements HasMedia
{
    use HasFactory, LogsActivity, HasTags, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'documents',
        'document_category_id',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
        'documents' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'file_path', 'document_category_id', 'published'])
            ->logOnlyDirty();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->singleFile()
            ->useDisk(config('media-library.disk_name', 'public'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // No conversions needed for document files
    }

    public function getFileExtensionAttribute(): ?string
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    public function getFileSizeAttribute(): ?int
    {
        if (file_exists($this->file_path)) {
            return filesize($this->file_path);
        }
        return null;
    }
}
