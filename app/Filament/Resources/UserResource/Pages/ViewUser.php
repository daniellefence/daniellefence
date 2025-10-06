<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Support\Enums\TextSize;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $infolist
            ->schema([
                Section::make('User Profile')
                    ->schema([
                        Flex::make([
                            Grid::make(2)
                                ->schema([
                                    Group::make([
                                        TextEntry::make('name')
                                            ->label('Full Name')
                                            ->size(TextSize::Large)
                                            ->weight('bold'),
                                        TextEntry::make('email')
                                            ->icon('heroicon-m-envelope')
                                            ->copyable(),
                                        TextEntry::make('title')
                                            ->label('Job Title')
                                            ->placeholder('No title set')
                                            ->icon('heroicon-m-briefcase'),
                                    ]),
                                    Group::make([
                                        ImageEntry::make('profile_photo_path')
                                            ->label('Profile Photo')
                                            ->circular()
                                            ->size(120)
                                            ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->name).'&color=7F9CF5&background=EBF4FF&size=120'),
                                    ])->extraAttributes(['class' => 'flex justify-center']),
                                ]),
                        ]),
                    ]),

                Section::make('Account Information')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Member Since')
                                    ->dateTime('M j, Y')
                                    ->icon('heroicon-m-calendar'),
                                IconEntry::make('email_verified_at')
                                    ->label('Email Verified')
                                    ->boolean()
                                    ->getStateUsing(fn ($record) => !is_null($record->email_verified_at))
                                    ->icon(fn ($state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
                                IconEntry::make('two_factor_confirmed_at')
                                    ->label('Two-Factor Auth')
                                    ->boolean()
                                    ->getStateUsing(fn ($record) => !is_null($record->two_factor_confirmed_at))
                                    ->icon(fn ($state): string => $state ? 'heroicon-o-shield-check' : 'heroicon-o-shield-exclamation'),
                            ]),
                    ])->collapsible(),

                Section::make('Security Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime()
                                    ->placeholder('Not verified'),
                                TextEntry::make('two_factor_confirmed_at')
                                    ->label('Two-Factor Enabled At')
                                    ->dateTime()
                                    ->placeholder('Not enabled'),
                                TextEntry::make('updated_at')
                                    ->label('Last Updated')
                                    ->dateTime()
                                    ->since(),
                                TextEntry::make('deleted_at')
                                    ->label('Deleted At')
                                    ->dateTime()
                                    ->placeholder('Active')
                                    ->visible(fn ($record) => !is_null($record->deleted_at)),
                            ]),
                    ])->collapsible()->collapsed(),
            ]);
    }
}
