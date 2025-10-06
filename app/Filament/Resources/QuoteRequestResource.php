<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\QuoteRequestResource\Pages\ListQuoteRequests;
use App\Filament\Resources\QuoteRequestResource\Pages\CreateQuoteRequest;
use App\Filament\Resources\QuoteRequestResource\Pages\ViewQuoteRequest;
use App\Filament\Resources\QuoteRequestResource\Pages\EditQuoteRequest;
use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Filament\Resources\QuoteRequestResource\RelationManagers;
use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static string | \UnitEnum | null $navigationGroup = 'Customers & Reviews';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fence_type')
                    ->maxLength(191),
                TextInput::make('product_name')
                    ->maxLength(191),
                Textarea::make('design_options')
                    ->columnSpanFull(),
                TextInput::make('size_of_area')
                    ->maxLength(191),
                TextInput::make('will_you_need_pavers')
                    ->maxLength(191),
                TextInput::make('will_you_need_a_screen_pergola_or_pavilion')
                    ->maxLength(191),
                Textarea::make('what_will_this_area_be_used_for')
                    ->columnSpanFull(),
                Textarea::make('features')
                    ->columnSpanFull(),
                TextInput::make('style_options')
                    ->maxLength(191),
                TextInput::make('how_many_gates')
                    ->maxLength(191),
                Textarea::make('additional_comments')
                    ->columnSpanFull(),
                Textarea::make('appliances')
                    ->columnSpanFull(),
                TextInput::make('counter_top')
                    ->maxLength(191),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(191),
                TextInput::make('paver_type')
                    ->maxLength(191),
                TextInput::make('color_options')
                    ->maxLength(191),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(191),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(191),
                TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(191),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
                TextInput::make('address_line_one')
                    ->required()
                    ->maxLength(191),
                TextInput::make('address_line_two')
                    ->maxLength(191),
                TextInput::make('city')
                    ->required()
                    ->maxLength(191),
                TextInput::make('state')
                    ->required()
                    ->maxLength(191),
                TextInput::make('zip_code')
                    ->required()
                    ->maxLength(191),
                TextInput::make('haul_away')
                    ->maxLength(191),
                TextInput::make('fence_height')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Customer')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),
                TextColumn::make('fence_type')
                    ->label('Service Type')
                    ->searchable(),
                TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('state')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('haul_away')
                    ->searchable(),
                TextColumn::make('fence_height')
                    ->searchable(),
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
            'index' => ListQuoteRequests::route('/'),
            'create' => CreateQuoteRequest::route('/create'),
            'view' => ViewQuoteRequest::route('/{record}'),
            'edit' => EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
