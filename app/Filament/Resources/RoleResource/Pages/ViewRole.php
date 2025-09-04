<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

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
                Infolists\Components\Section::make('Role Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Role Name')
                            ->size(Infolists\Components\TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Description')
                            ->default('No description provided'),

                        Infolists\Components\TextEntry::make('guard_name')
                            ->label('Guard')
                            ->badge(),
                    ])
                    ->columns(2),

                Infolists\Components\Section::make('Statistics')
                    ->schema([
                        Infolists\Components\TextEntry::make('permissions')
                            ->label('Total Permissions')
                            ->state(fn ($record) => $record->permissions->count())
                            ->badge()
                            ->color('info'),

                        Infolists\Components\TextEntry::make('users')
                            ->label('Users with this Role')
                            ->state(fn ($record) => $record->users->count())
                            ->badge()
                            ->color(fn ($record) => match (true) {
                                $record->users->count() === 0 => 'gray',
                                $record->users->count() <= 5 => 'success',
                                default => 'warning'
                            }),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
                    ])
                    ->columns(4),

                Infolists\Components\Section::make('Permissions')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('permissions')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Permission')
                                    ->badge()
                                    ->color('primary'),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => $record->permissions->count() > 10),

                Infolists\Components\Section::make('Users with this Role')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('users')
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('User')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Joined')
                                    ->date(),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->users->count() > 0)
                    ->collapsible()
                    ->collapsed(fn ($record) => $record->users->count() > 5),
            ]);
    }
}