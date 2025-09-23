<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'key',
        'title',
        'description',
        'image',
        'order',
        'parent_id'
    ];

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->children();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getRoute()
    {
        return route('category.slug', ['category_slug' => $this->getSlug()]);
    }

    public function getSlug()
    {
        return \Illuminate\Support\Str::slug($this->title);
    }

    public function getLegacyRoute()
    {
        return route('category', ['category_id' => $this->id, 'category_title' => $this->title]);
    }

    public function getAdminRoute()
    {
        return route('admin.products.subcategories', [
            'parent' => 'category',
            'parent_id' => $this->id,
        ]);
    }

    public function getHeroImageUrl()
    {
        // Use the category image for hero section
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Fallback to photo if available
        if ($this->photo) {
            return asset('storage/' . $this->photo->path);
        }

        return null;
    }

    public function hasHeroImage()
    {
        return !empty($this->image) || !empty($this->photo);
    }
}
