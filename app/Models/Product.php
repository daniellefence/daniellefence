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
}
