<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Contact;

class RecentContactsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Recent Contacts';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Contact::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->copyable(),
                TextColumn::make('phone')
                    ->icon('heroicon-m-phone')
                    ->copyable(),
                TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->message;
                    }),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('view')
                    ->url(fn (Contact $record): string => route('filament.admin.resources.contacts.view', $record))
                    ->icon('heroicon-m-eye'),
            ]);
    }
}