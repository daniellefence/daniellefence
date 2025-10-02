<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiyProductResource\Pages;
use App\Filament\Resources\DiyProductResource\RelationManagers;
use App\Models\DiyProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiyProductResource extends Resource
{
    protected static ?string $model = DiyProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'DIY System';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('diy_category_id')
                    ->relationship('diyCategory', 'name')
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'title')
                    ->label('Related Product (for photo gallery)')
                    ->searchable()
                    ->preload()
                    ->helperText('Select the product whose photos will be displayed in the gallery'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('photos')
                    ->collection('product-photos')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->reorderable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\Toggle::make('is_best_seller')
                    ->label('Best Seller')
                    ->helperText('Mark this product as a best seller'),
                Forms\Components\TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('relatedProducts')
                    ->relationship('relatedProducts', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull()
                    ->helperText('Select related products to display on the product page'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('product-photos')
                    ->circular(),
                Tables\Columns\TextColumn::make('diyCategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_best_seller')
                    ->boolean()
                    ->label('Best Seller')
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListDiyProducts::route('/'),
            'create' => Pages\CreateDiyProduct::route('/create'),
            'view' => Pages\ViewDiyProduct::route('/{record}'),
            'edit' => Pages\EditDiyProduct::route('/{record}/edit'),
        ];
    }
}
