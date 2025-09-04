<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VariantImage extends Model
{
    protected $fillable = ['product_id','color','height','picket_width','image_path'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
