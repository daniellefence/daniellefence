<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\DiyProductResource\Pages\ListDiyProducts;
use App\Filament\Resources\DiyProductResource\Pages\CreateDiyProduct;
use App\Filament\Resources\DiyProductResource\Pages\ViewDiyProduct;
use App\Filament\Resources\DiyProductResource\Pages\EditDiyProduct;
use App\Filament\Resources\DiyProductResource\Pages;
use App\Filament\Resources\DiyProductResource\RelationManagers;
use App\Models\DiyProduct;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiyProductResource extends Resource
{
    protected static ?string $model = DiyProduct::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';

    protected static string | \UnitEnum | null $navigationGroup = 'DIY System';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('diy_category_id')
                    ->relationship('diyCategory', 'name')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'title')
                    ->label('Related Product (for photo gallery)')
                    ->searchable()
                    ->preload()
                    ->helperText('Select the product whose photos will be displayed in the gallery'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Textarea::make('description')
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('photos')
                    ->collection('product-photos')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->reorderable()
                    ->columnSpanFull(),
                TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Toggle::make('is_best_seller')
                    ->label('Best Seller')
                    ->helperText('Mark this product as a best seller'),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('relatedProducts')
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
                SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('product-photos')
                    ->circular(),
                TextColumn::make('diyCategory.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                IconColumn::make('is_best_seller')
                    ->boolean()
                    ->label('Best Seller')
                    ->sortable(),
                TextColumn::make('base_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order')
                    ->numeric()
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
            'index' => ListDiyProducts::route('/'),
            'create' => CreateDiyProduct::route('/create'),
            'view' => ViewDiyProduct::route('/{record}'),
            'edit' => EditDiyProduct::route('/{record}/edit'),
        ];
    }
}
