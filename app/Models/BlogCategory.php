<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class BlogCategory extends Model
{
    use HasFactory, LogsActivity, HasTags;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'published'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'slug', 'description', 'parent_id', 'published'])
            ->logOnlyDirty();
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'blog_category_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function allChildren(): HasMany
    {
        return $this->children()->with('allChildren');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id');
    }
}
