<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\DiyOrderResource\Pages\ListDiyOrders;
use App\Filament\Resources\DiyOrderResource\Pages\CreateDiyOrder;
use App\Filament\Resources\DiyOrderResource\Pages\ViewDiyOrder;
use App\Filament\Resources\DiyOrderResource\Pages\EditDiyOrder;
use App\Filament\Resources\DiyOrderResource\Pages;
use App\Filament\Resources\DiyOrderResource\RelationManagers;
use App\Models\DiyOrder;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiyOrderResource extends Resource
{
    protected static ?string $model = DiyOrder::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string | \UnitEnum | null $navigationGroup = 'DIY System';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('order_number')
                    ->required()
                    ->maxLength(191),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                TextInput::make('status')
                    ->required()
                    ->maxLength(191)
                    ->default('pending'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('ordered_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tax_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('ordered_at')
                    ->dateTime()
                    ->sortable(),
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
                ViewAction::make(),
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
            'index' => ListDiyOrders::route('/'),
            'create' => CreateDiyOrder::route('/create'),
            'view' => ViewDiyOrder::route('/{record}'),
            'edit' => EditDiyOrder::route('/{record}/edit'),
        ];
    }
}
