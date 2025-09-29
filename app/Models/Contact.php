<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Contact model for managing customer contact form submissions.
 *
 * This model represents customer inquiries and contact form submissions
 * from the website. It stores customer information and messages for
 * follow-up by the sales team.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string|null $phone
 * @property string|null $company
 * @property string $message
 * @property string|null $service_area
 * @property string|null $how_did_you_hear_about_us Marketing source tracking
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
}
