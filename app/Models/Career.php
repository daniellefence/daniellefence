<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Career extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'published' => 'boolean',
        'hidden' => 'boolean',
    ];

    public function getRoute()
    {
        return route('career-read', ['id' => $this->id]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
