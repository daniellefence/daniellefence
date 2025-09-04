<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class Career extends Model
{
    use HasFactory, LogsActivity, HasTags, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'location',
        'requirements',
        'published',
        'published_at',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'location', 'published', 'published_at'])
            ->logOnlyDirty();
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }
}
