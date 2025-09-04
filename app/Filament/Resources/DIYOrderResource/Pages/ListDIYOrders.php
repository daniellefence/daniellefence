<?php

namespace App\Filament\Resources\DIYOrderResource\Pages;

use App\Filament\Resources\DIYOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDIYOrders extends ListRecords
{
    protected static string $resource = DIYOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->badge($this->getModel()::count()),
                
            'pending' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending'))
                ->badge($this->getModel()::where('status', 'pending')->count()),
                
            'processing' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'processing'))
                ->badge($this->getModel()::where('status', 'processing')->count()),
                
            'ready' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'ready'))
                ->badge($this->getModel()::where('status', 'ready')->count()),
                
            'completed' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'completed'))
                ->badge($this->getModel()::where('status', 'completed')->count()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return DIYOrderResource::getWidgets();
    }
}