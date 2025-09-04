<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class Review extends Model
{
    use HasFactory, LogsActivity, HasTags;

    protected $fillable = [
        'author',
        'rating',
        'content',
        'source',
        'published',
        'reviewed_at',
        'google_review_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'reviewed_at' => 'datetime',
        'rating' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['author', 'rating', 'content', 'source', 'published', 'reviewed_at'])
            ->logOnlyDirty();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeBySource($query, string $source)
    {
        return $query->where('source', $source);
    }

    public function scopeByRating($query, int $rating)
    {
        return $query->where('rating', $rating);
    }

    public function scopeMinRating($query, int $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    public function scopeFiveStars($query)
    {
        return $query->where('rating', 5);
    }

    public function scopeGoogleReviews($query)
    {
        return $query->where('source', 'google')->whereNotNull('google_review_id');
    }
}
