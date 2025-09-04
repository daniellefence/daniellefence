<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class YouTubeVideo extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'title',
        'youtube_id',
        'youtube_url',
        'description',
        'thumbnail_url',
        'duration',
        'published_at',
        'tags',
        'show_on_videos_page',
        'is_featured',
        'sort_order',
        'category',
        'youtube_data',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'show_on_videos_page' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'duration' => 'integer',
        'tags' => 'array',
        'youtube_data' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'youtube_id', 'show_on_videos_page', 'is_featured'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function scopeVisibleOnPage($query)
    {
        return $query->where('show_on_videos_page', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    public function getEmbedUrlAttribute(): string
    {
        return "https://www.youtube.com/embed/{$this->youtube_id}";
    }

    public function getWatchUrlAttribute(): string
    {
        return "https://www.youtube.com/watch?v={$this->youtube_id}";
    }

    public function getFormattedDurationAttribute(): ?string
    {
        if (!$this->duration) return null;

        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public static function extractYouTubeId(string $url): ?string
    {
        $patterns = [
            '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/',
            '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
