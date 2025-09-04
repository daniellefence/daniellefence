<?php

namespace App\Filament\Resources\FAQResource\Pages;

use App\Filament\Resources\FAQResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFAQ extends CreateRecord
{
    protected static string $resource = FAQResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If no order is set, put it at the end
        if (!isset($data['order']) || $data['order'] === null) {
            $data['order'] = \App\Models\FAQ::max('order') + 1;
        }
        
        return $data;
    }
}