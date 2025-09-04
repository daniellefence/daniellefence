<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;

    protected function afterCreate(): void
    {
        // Clear permission cache after creating a permission
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}