<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiyAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'sort',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->hasMany(DiyOption::class);
    }
}
