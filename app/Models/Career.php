<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Career model for managing job postings and employment opportunities.
 *
 * This model represents career opportunities and job postings at the company.
 * It includes job descriptions, requirements, and publishing controls with soft deletes.
 *
 * @package App\Models
 * @author Shane Barron
 *
 * @property int $id
 * @property string $title Job title
 * @property string $description Job description
 * @property string|null $requirements Job requirements and qualifications
 * @property string|null $salary Salary range or compensation details
 * @property string|null $employment_type (full-time, part-time, contract, etc.)
 * @property string|null $location Work location
 * @property bool $published Whether the job posting is published
 * @property bool $hidden Whether the job posting is hidden from public view
 * @property int $user_id ID of user who created the posting
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class Career extends Model
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published' => 'boolean',
        'hidden' => 'boolean',
    ];

    /**
     * Generate URL for this career posting.
     *
     * Creates a route to the individual career detail page.
     *
     * @return string The full URL to this career posting
     */
    public function getRoute()
    {
        return route('career-read', ['id' => $this->id]);
    }

    /**
     * Get the user who created this career posting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
