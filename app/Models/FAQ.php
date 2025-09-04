<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class FAQ extends Model
{
    use HasFactory, LogsActivity, HasTags;

    protected $fillable = [
        'question',
        'answer',
        'published',
        'order',
    ];

    protected $casts = [
        'published' => 'boolean',
        'order' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['question', 'answer', 'published', 'order'])
            ->logOnlyDirty();
    }

    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
