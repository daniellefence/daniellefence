<?php

namespace App\Services;

use App\Models\Product;

class DiyPriceCalculator
{
    /**
     * $attrs = ['color' => 'white', 'height' => '6ft', 'picket_width' => '3in']
     */
    public function calculate(Product $product, array $attrs = [], ?float $basePrice = null): float
    {
        $price = $basePrice ?? (float) $product->base_price;

        foreach ($product->modifiers as $mod) {
            $attr = $mod->attribute; // color|height|picket_width
            if (! array_key_exists($attr, $attrs)) {
                continue;
            }
            if (strcasecmp((string) $attrs[$attr], (string) $mod->value) !== 0) {
                continue;
            }

            $amount = (float) $mod->amount;
            $delta = $mod->operation === 'percent'
                ? ($price * ($amount / 100))
                : $amount;

            if ($mod->type === 'subtract') {
                $price -= $delta;
            } else {
                $price += $delta;
            }
        }

        return round($price, 2);
    }
}
