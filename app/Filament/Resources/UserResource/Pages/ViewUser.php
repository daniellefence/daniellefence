<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('User Profile')
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('name')
                                            ->label('Full Name')
                                            ->size(Components\TextEntry\TextEntrySize::Large)
                                            ->weight('bold'),
                                        Components\TextEntry::make('email')
                                            ->icon('heroicon-m-envelope')
                                            ->copyable(),
                                        Components\TextEntry::make('title')
                                            ->label('Job Title')
                                            ->placeholder('No title set')
                                            ->icon('heroicon-m-briefcase'),
                                    ]),
                                    Components\Group::make([
                                        Components\ImageEntry::make('profile_photo_path')
                                            ->label('Profile Photo')
                                            ->circular()
                                            ->size(120)
                                            ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&color=7F9CF5&background=EBF4FF&size=120'),
                                    ])->extraAttributes(['class' => 'flex justify-center']),
                                ]),
                        ]),
                    ]),

                Components\Section::make('Account Information')
                    ->schema([
                        Components\Grid::make(3)
                            ->schema([
                                Components\TextEntry::make('created_at')
                                    ->label('Member Since')
                                    ->dateTime('M j, Y')
                                    ->icon('heroicon-m-calendar'),
                                Components\IconEntry::make('email_verified_at')
                                    ->label('Email Verified')
                                    ->boolean()
                                    ->getStateUsing(fn ($record) => !is_null($record->email_verified_at))
                                    ->icon(fn ($state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
                                Components\IconEntry::make('two_factor_confirmed_at')
                                    ->label('Two-Factor Auth')
                                    ->boolean()
                                    ->getStateUsing(fn ($record) => !is_null($record->two_factor_confirmed_at))
                                    ->icon(fn ($state): string => $state ? 'heroicon-o-shield-check' : 'heroicon-o-shield-exclamation'),
                            ]),
                    ])->collapsible(),

                Components\Section::make('Security Details')
                    ->schema([
                        Components\Grid::make(2)
                            ->schema([
                                Components\TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime()
                                    ->placeholder('Not verified'),
                                Components\TextEntry::make('two_factor_confirmed_at')
                                    ->label('Two-Factor Enabled At')
                                    ->dateTime()
                                    ->placeholder('Not enabled'),
                                Components\TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->since(),
                                Components\TextEntry::make('deleted_at')
                                    ->label('Deleted At')
                                    ->dateTime()
                                    ->placeholder('Active')
                                    ->visible(fn ($record) => !is_null($record->deleted_at)),
                            ]),
                    ])->collapsible()->collapsed(),
            ]);
    }
}
