<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\AvailableHeightResource\Pages\ListAvailableHeights;
use App\Filament\Resources\AvailableHeightResource\Pages\CreateAvailableHeight;
use App\Filament\Resources\AvailableHeightResource\Pages\EditAvailableHeight;
use App\Filament\Resources\AvailableHeightResource\Pages;
use App\Filament\Resources\AvailableHeightResource\RelationManagers;
use App\Models\AvailableHeight;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailableHeightResource extends Resource
{
    protected static ?string $model = AvailableHeight::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrows-up-down';

    protected static string | \UnitEnum | null $navigationGroup = 'DIY System';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Heights';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('price_per_panel')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('value_feet')
                    ->numeric(),
                TextInput::make('value_inches')
                    ->numeric(),
                TextInput::make('display_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('price_per_panel')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('value_feet')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('value_inches')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('display_order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAvailableHeights::route('/'),
            'create' => CreateAvailableHeight::route('/create'),
            'edit' => EditAvailableHeight::route('/{record}/edit'),
        ];
    }
}
