<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Blog model for managing blog posts and articles.
 *
 * This model represents blog posts with categories, authors, and associated media.
 * It includes soft deletes for data retention and provides URL generation for SEO-friendly routes.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $excerpt
 * @property string|null $meta_description
 * @property string|null $slug
 * @property int $user_id Author's user ID
 * @property int $blogcategory_id Category ID
 * @property bool $published
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the user (author) who created this blog post.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the featured photo associated with this blog post.
     *
     * @return HasOne
     */
    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    /**
     * Get the category this blog post belongs to.
     *
     * @return BelongsTo
     */
    public function blogcategory()
    {
        return $this->belongsTo(Blogcategory::class);
    }

    /**
     * Get all tags associated with this blog post via polymorphic relationship.
     *
     * @return MorphToMany
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Generate SEO-friendly URL for this blog post.
     *
     * Creates a route with category and title for better SEO and user experience.
     * URLs follow the pattern: /blog/{category}/{title}/{id}
     *
     * @return string The full URL to this blog post
     */
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
