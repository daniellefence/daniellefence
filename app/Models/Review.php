<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Customer review model for managing testimonials and feedback.
 *
 * This model represents customer reviews with ratings, comments, and associated photos.
 * It includes soft deletes for data retention and supports multiple photos per review.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $customer_name
 * @property string|null $customer_email
 * @property string $review_text
 * @property int $rating Star rating (1-5)
 * @property string|null $project_type Type of project reviewed
 * @property string|null $location Project location
 * @property bool $featured Whether this review is featured
 * @property bool $approved Whether this review is approved for display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Review extends Model
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
     * Get all photos associated with this review.
     *
     * Reviews can have multiple photos showing the completed project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
