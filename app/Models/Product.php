<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function pip()
    {
        return $this->hasOne(Pip::class);
    }

    public function getRoute()
    {
        return route('product.slug', [
            'category_slug' => $this->category->getSlug(),
            'product_slug' => $this->getSlug()
        ]);
    }

    public function getSlug()
    {
        return \Illuminate\Support\Str::slug($this->title);
    }

    public function getLegacyRoute()
    {
        return route('product', ['product_id' => $this->id, 'product_title' => $this->title]);
    }

    public function getAdminRoute()
    {
        return route('admin.products.product.edit', ['id' => $this->id]);
    }

    public function getHeroImageUrl()
    {
        // Use the first product photo for hero section
        if ($this->photos->count() > 0) {
            return asset('storage/' . $this->photos->first()->path);
        }

        // Fallback to category image if available
        if ($this->category && $this->category->image) {
            return asset('storage/' . $this->category->image);
        }

        return null;
    }

    public function hasHeroImage()
    {
        return $this->photos->count() > 0 || ($this->category && $this->category->image);
    }
}
