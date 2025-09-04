<?php

namespace App\Filament\Resources\DIYOrderResource\Pages;

use App\Filament\Resources\DIYOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDIYOrder extends CreateRecord
{
    protected static string $resource = DIYOrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['order_number'])) {
            $data['order_number'] = 'DIY-' . date('Ymd') . '-' . strtoupper(uniqid());
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}