<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewUserResource extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn (): bool => auth()->user()?->can('edit_users') ?? false),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('User Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Full Name')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('email')
                            ->label('Email Address')
                            ->copyable()
                            ->icon('heroicon-m-envelope'),

                        Infolists\Components\IconEntry::make('email_verified_at')
                            ->label('Email Verified')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-badge')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        Infolists\Components\TextEntry::make('email_verified_at')
                            ->label('Verified At')
                            ->dateTime()
                            ->placeholder('Not verified')
                            ->visible(fn ($record) => $record->email_verified_at !== null),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Account Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Account Created')
                            ->dateTime()
                            ->since(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime()
                            ->since(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Roles & Permissions')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('roles')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Role')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Super Admin' => 'danger',
                                        'Admin' => 'warning',
                                        'Editor' => 'info',
                                        'Author' => 'success',
                                        'Viewer' => 'gray',
                                        default => 'primary',
                                    }),

                                Infolists\Components\TextEntry::make('permissions_count')
                                    ->label('Permissions')
                                    ->state(fn ($record) => $record->permissions->count())
                                    ->badge()
                                    ->color('info'),

                                Infolists\Components\TextEntry::make('description')
                                    ->label('Description')
                                    ->default('No description')
                                    ->color('gray'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->roles->count() > 0),

                Infolists\Components\Section::make('All Permissions')
                    ->schema([
                        Infolists\Components\TextEntry::make('all_permissions')
                            ->label('Effective Permissions')
                            ->state(function ($record) {
                                $permissions = $record->getAllPermissions();
                                
                                if ($permissions->isEmpty()) {
                                    return 'No permissions assigned';
                                }

                                // Group permissions by category
                                $grouped = $permissions->groupBy(function ($permission) {
                                    $parts = explode('_', $permission->name, 2);
                                    return isset($parts[1]) ? ucfirst($parts[1]) : 'Other';
                                });

                                $result = [];
                                foreach ($grouped as $category => $categoryPermissions) {
                                    $permissionNames = $categoryPermissions->pluck('name')->sort()->implode(', ');
                                    $result[] = "<strong>{$category}:</strong> {$permissionNames}";
                                }

                                return implode('<br><br>', $result);
                            })
                            ->html()
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => $record->getAllPermissions()->count() > 10),

                Infolists\Components\Section::make('Security Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('password')
                            ->label('Password Status')
                            ->state('Password is set and secured')
                            ->icon('heroicon-o-shield-check')
                            ->color('success'),

                        Infolists\Components\TextEntry::make('two_factor_enabled')
                            ->label('Two Factor Authentication')
                            ->state(fn ($record) => $record->two_factor_secret ? 'Enabled' : 'Disabled')
                            ->color(fn ($record) => $record->two_factor_secret ? 'success' : 'warning')
                            ->icon(fn ($record) => $record->two_factor_secret ? 'heroicon-o-shield-check' : 'heroicon-o-shield-exclamation'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}