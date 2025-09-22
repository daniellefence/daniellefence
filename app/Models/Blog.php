<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function blogcategory()
    {
        return $this->belongsTo(Blogcategory::class);
    }

    public function getRoute()
    {
        $category = urlencode($this->blogcategory->title);
        $title = urlencode($this->title);

        return route('blog.read', [
            'id' => $this->id,
            'category' => $category,
            'title' => $title,
        ]);

    }
}
