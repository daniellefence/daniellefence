<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Auto-generate slug from name if missing.
     */
    protected static function booted(): void
    {
        static::saving(function (self $category) {
            if (empty($category->slug) && !empty($category->name)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }
}
