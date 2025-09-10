<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Activitylog\Models\Activity;
use App\Filament\Resources\ActivityLogResource\Pages;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'System Management';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')->searchable(),
                Tables\Columns\TextColumn::make('subject_type')->label('Subject'),
                Tables\Columns\TextColumn::make('subject_id')->label('Subject ID'),
                Tables\Columns\TextColumn::make('causer_type')->label('Causer'),
                Tables\Columns\TextColumn::make('causer_id')->label('Causer ID'),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('subject_type')
                    ->options(fn () => Activity::query()->distinct()->pluck('subject_type','subject_type')->filter()->toArray()),
                Tables\Filters\SelectFilter::make('causer_type')
                    ->options(fn () => Activity::query()->distinct()->pluck('causer_type','causer_type')->filter()->toArray()),
                Tables\Filters\Filter::make('date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('to'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['to'] ?? null, fn ($q, $d) => $q->whereDate('created_at', '<=', $d));
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\ActivityLogResource\Pages\ListActivityLogResource::route('/'),
        ];
    }
}
