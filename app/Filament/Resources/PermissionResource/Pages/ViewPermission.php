<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewPermission extends ViewRecord
{
    protected static string $resource = PermissionResource::class;

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
                Infolists\Components\Section::make('Permission Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Permission Name')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->default('No description provided'),

                        Infolists\Components\TextEntry::make('guard_name')
                            ->label('Guard')
                            ->badge(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Usage Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('roles')
                            ->label('Used by Roles')
                            ->state(fn ($record) => $record->roles->count())
                            ->badge()
                            ->color(fn ($record) => match (true) {
                                $record->roles->count() === 0 => 'gray',
                                $record->roles->count() <= 2 => 'success',
                                default => 'warning'
                            }),

                        Infolists\Components\TextEntry::make('users')
                            ->label('Total Users')
                            ->state(function ($record) {
                                return $record->roles->sum(function ($role) {
                                    return $role->users->count();
                                });
                            })
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Roles with this Permission')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('roles')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Role')
                                    ->badge()
                                    ->color('primary'),

                                Infolists\Components\TextEntry::make('users_count')
                                    ->label('Users')
                                    ->state(fn ($record) => $record->users->count())
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
                    ->visible(fn ($record) => $record->roles->count() > 0)
                    ->collapsible(),
            ]);
    }
}