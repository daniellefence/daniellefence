<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DiyCategory extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'photo_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function diyProducts(): HasMany
    {
        return $this->hasMany(DiyProduct::class)->orderBy('order');
    }
}