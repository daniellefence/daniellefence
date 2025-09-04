<?php

namespace App\Observers;

use App\Models\QuoteRequest;
use App\Services\DiyPriceCalculator;

class QuoteRequestObserver
{
    public function saving(QuoteRequest $qr): void
    {
        if (! $qr->product) {
            $qr->calculated_price = $qr->base_price ?? 0;
            return;
        }

        $attrs = [
            'color' => $qr->color,
            'height' => $qr->height,
            'picket_width' => $qr->picket_width,
        ];

        $calculator = app(DiyPriceCalculator::class);
        $qr->calculated_price = $calculator->calculate($qr->product, $attrs, $qr->base_price);
    }
}
