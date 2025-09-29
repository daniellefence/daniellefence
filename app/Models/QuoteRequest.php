<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Quote request model for managing customer quote submissions.
 *
 * This model represents customer requests for fencing, outdoor kitchen, paver,
 * and outdoor space quotes. It stores customer information, project specifications,
 * and any uploaded attachments for accurate quote preparation.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone_number
 * @property string $address_line_one
 * @property string|null $address_line_two
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string|null $fence_type Type of fence (PVCVinyl, Wood, etc.)
 * @property string|null $fence_height Height in inches
 * @property string|null $style_options
 * @property int|null $how_many_gates
 * @property string|null $haul_away Whether to haul away old fence
 * @property string|null $additional_comments
 * @property string|null $quote_type Type of quote (fence, kitchen, paver, outdoor)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class QuoteRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get all file attachments for this quote request.
     *
     * Attachments can include photos, plans, drawings, or other files
     * that help provide context for the quote request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
