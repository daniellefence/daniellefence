<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
    ];

    public function getYouTubeUrlAttribute(): ?string
    {
        if (! $this->code) {
            return null;
        }

        // Check if code is already a full URL
        if (str_contains($this->code, 'youtube.com') || str_contains($this->code, 'youtu.be')) {
            return $this->code;
        }

        // Assume it's a video ID
        return "https://www.youtube.com/watch?v={$this->code}";
    }

    public function getYouTubeEmbedUrlAttribute(): ?string
    {
        $videoId = $this->getYouTubeVideoId();

        if (! $videoId) {
            return null;
        }

        return "https://www.youtube.com/embed/{$videoId}";
    }

    public function getYouTubeVideoId(): ?string
    {
        if (! $this->code) {
            return null;
        }

        // If it's already just a video ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $this->code)) {
            return $this->code;
        }

        // Extract from various YouTube URL formats
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->code, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
