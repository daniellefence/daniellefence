<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Filament\Resources\QuoteRequestResource\RelationManagers;
use App\Models\QuoteRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Customer Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('fence_type')
                    ->maxLength(191),
                Forms\Components\TextInput::make('product_name')
                    ->maxLength(191),
                Forms\Components\Textarea::make('design_options')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('size_of_area')
                    ->maxLength(191),
                Forms\Components\TextInput::make('will_you_need_pavers')
                    ->maxLength(191),
                Forms\Components\TextInput::make('will_you_need_a_screen_pergola_or_pavilion')
                    ->maxLength(191),
                Forms\Components\Textarea::make('what_will_this_area_be_used_for')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('features')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('style_options')
                    ->maxLength(191),
                Forms\Components\TextInput::make('how_many_gates')
                    ->maxLength(191),
                Forms\Components\Textarea::make('additional_comments')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('appliances')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('counter_top')
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(191),
                Forms\Components\TextInput::make('paver_type')
                    ->maxLength(191),
                Forms\Components\TextInput::make('color_options')
                    ->maxLength(191),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('phone_number')
                    ->tel()
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('address_line_one')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('address_line_two')
                    ->maxLength(191),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('state')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('zip_code')
                    ->required()
                    ->maxLength(191),
                Forms\Components\TextInput::make('haul_away')
                    ->maxLength(191),
                Forms\Components\TextInput::make('fence_height')
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Customer')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),
                Tables\Columns\TextColumn::make('fence_type')
                    ->label('Service Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product_name')
                    ->label('Product')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('haul_away')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fence_height')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListQuoteRequests::route('/'),
            'create' => Pages\CreateQuoteRequest::route('/create'),
            'view' => Pages\ViewQuoteRequest::route('/{record}'),
            'edit' => Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
