<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource as Resource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductResource extends CreateRecord
{
    protected static string $resource = Resource::class;
}
