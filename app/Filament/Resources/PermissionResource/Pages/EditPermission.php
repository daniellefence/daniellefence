<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->visible(fn (): bool => 
                    (auth()->user()?->can('delete_users') ?? false) && 
                    $this->record->roles->count() === 0
                ),
        ];
    }

    protected function afterSave(): void
    {
        // Clear permission cache after updating a permission
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}