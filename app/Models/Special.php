<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Special offer model for managing promotional deals and discounts.
 *
 * This model represents special offers, promotions, and seasonal deals
 * that the company provides to customers. It supports multiple photos
 * and generates URLs for individual special offer pages.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string|null $terms_conditions
 * @property string|null $discount_amount
 * @property string|null $discount_type (percentage, dollar, etc.)
 * @property \Carbon\Carbon|null $start_date
 * @property \Carbon\Carbon|null $end_date
 * @property bool $active
 * @property bool $featured
 * @property int|null $usage_limit
 * @property int $usage_count
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Special extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get all photos associated with this special offer.
     *
     * Special offers can have multiple promotional photos and images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Generate URL for this special offer.
     *
     * Creates a route to the individual special offer detail page.
     *
     * @return string The full URL to this special offer
     */
    public function getRoute()
    {
        return route('special', ['id' => $this->id]);
    }
}
