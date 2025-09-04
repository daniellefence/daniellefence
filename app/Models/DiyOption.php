<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiyOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'diy_attribute_id',
        'value',
        'sort',
    ];

    public function attribute()
    {
        return $this->belongsTo(DiyAttribute::class, 'diy_attribute_id');
    }
}
