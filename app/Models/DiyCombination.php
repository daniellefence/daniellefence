<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiyCombination extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_option_id',
        'height_option_id',
        'picket_width_option_id',
        'price_modifier_percent',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function colorOption()
    {
        return $this->belongsTo(DiyOption::class, 'color_option_id');
    }

    public function heightOption()
    {
        return $this->belongsTo(DiyOption::class, 'height_option_id');
    }

    public function picketWidthOption()
    {
        return $this->belongsTo(DiyOption::class, 'picket_width_option_id');
    }
}
