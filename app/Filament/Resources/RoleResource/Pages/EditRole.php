<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->visible(fn (): bool => 
                    (auth()->user()?->can('delete_users') ?? false) && 
                    $this->record->users->count() === 0
                ),
        ];
    }

    protected function afterSave(): void
    {
        // Clear permission cache after updating a role
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}