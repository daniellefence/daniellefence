<?php

namespace App\Filament\Resources\DiyOrderResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\DiyOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiyOrders extends ListRecords
{
    protected static string $resource = DiyOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
