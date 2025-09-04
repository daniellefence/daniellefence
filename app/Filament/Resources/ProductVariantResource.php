<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductVariantResource\Pages;
use App\Models\ProductVariant;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductVariantResource extends Resource
{
    protected static ?string $model = ProductVariant::class;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Products';
    protected static ?string $navigationLabel = 'Product Variants';
    protected static ?string $pluralLabel = 'Product Variants';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Variant Details')
                ->description('Basic information about this product variant including identification and specification.')
                ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name', fn (Builder $query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->helperText('Select the base product this variant belongs to.'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Descriptive name for this variant (e.g., "White 6ft Picket Fence").')
                    ->placeholder('Enter variant name...'),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->unique(ignoreRecord: true)
                    ->maxLength(100)
                    ->helperText('Unique stock keeping unit for inventory tracking.')
                    ->placeholder('WH-6FT-PK-001'),
            ])->columns(2),

            Forms\Components\Section::make('Variant Specifications')
                ->description('Physical characteristics and options for this product variant.')
                ->schema([
                Forms\Components\TextInput::make('color')
                    ->maxLength(100)
                    ->helperText('Color of this variant (e.g., White, Brown, Black).')
                    ->placeholder('White'),
                Forms\Components\TextInput::make('height')
                    ->maxLength(100)
                    ->helperText('Height specification (e.g., 6ft, 4ft, 8ft).')
                    ->placeholder('6ft'),
                Forms\Components\TextInput::make('picket_width')
                    ->label('Picket Width')
                    ->maxLength(100)
                    ->helperText('Width of pickets (e.g., 3in, 4in, 6in).')
                    ->placeholder('4in'),
                Forms\Components\TextInput::make('material')
                    ->maxLength(100)
                    ->helperText('Material used (e.g., Vinyl, Wood, Aluminum).')
                    ->placeholder('Vinyl'),
                Forms\Components\TextInput::make('finish')
                    ->maxLength(100)
                    ->helperText('Surface finish or treatment.')
                    ->placeholder('Smooth'),
            ])->columns(3),

            Forms\Components\Section::make('Pricing & Inventory')
                ->description('Pricing modifiers and stock management for this variant.')
                ->schema([
                Forms\Components\TextInput::make('price_modifier')
                    ->label('Price Modifier')
                    ->numeric()
                    ->step(0.01)
                    ->default(0)
                    ->helperText('Amount to add/subtract from base product price.')
                    ->prefix('$'),
                Forms\Components\Select::make('price_modifier_type')
                    ->label('Modifier Type')
                    ->options([
                        'fixed' => 'Fixed Amount ($)',
                        'percentage' => 'Percentage (%)',
                    ])
                    ->default('fixed')
                    ->required()
                    ->helperText('Whether the modifier is a fixed dollar amount or percentage.'),
                Forms\Components\TextInput::make('stock_quantity')
                    ->label('Stock Quantity')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Current quantity in stock.'),
                Forms\Components\TextInput::make('low_stock_threshold')
                    ->label('Low Stock Alert')
                    ->numeric()
                    ->default(5)
                    ->minValue(0)
                    ->helperText('Alert when stock falls below this number.'),
            ])->columns(2),

            Forms\Components\Section::make('Physical Properties')
                ->description('Weight, dimensions, and other physical characteristics.')
                ->schema([
                Forms\Components\TextInput::make('weight')
                    ->numeric()
                    ->step(0.01)
                    ->suffix('lbs')
                    ->helperText('Weight of the variant in pounds.'),
                Forms\Components\Repeater::make('dimensions')
                    ->schema([
                        Forms\Components\TextInput::make('measurement')
                            ->label('Measurement')
                            ->placeholder('Length, Width, Height, etc.'),
                        Forms\Components\TextInput::make('value')
                            ->label('Value')
                            ->placeholder('Enter measurement value'),
                        Forms\Components\TextInput::make('unit')
                            ->label('Unit')
                            ->placeholder('ft, in, cm, etc.'),
                    ])
                    ->columns(3)
                    ->helperText('Physical dimensions of this variant.')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Status & Organization')
                ->description('Control visibility and organization of this variant.')
                ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Enable this variant for display and ordering.'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first in variant lists.'),
            ])->columns(2),

            Forms\Components\Section::make('Media & Additional Data')
                ->description('Images and additional metadata for this variant.')
                ->schema([
                FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(10)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->directory('product-variants/images')
                    ->disk('public')
                    ->helperText('Main product images for this variant (max 10 images, 5MB each).')
                    ->columnSpanFull(),
                FileUpload::make('gallery')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(20)
                    ->maxSize(5120)
                    ->directory('product-variants/gallery')
                    ->disk('public')
                    ->helperText('Additional gallery images (max 20 images, 5MB each).')
                    ->columnSpanFull(),
                FileUpload::make('technical_drawings')
                    ->multiple()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                    ->maxFiles(5)
                    ->maxSize(10240)
                    ->directory('product-variants/technical')
                    ->disk('public')
                    ->helperText('Technical drawings, installation guides, or specifications (max 5 files, 10MB each).')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('meta_data')
                    ->label('Additional Properties')
                    ->keyLabel('Property')
                    ->valueLabel('Value')
                    ->helperText('Additional custom properties for this variant (e.g., warranty, installation_time, etc.).')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Image')
                    ->getStateUsing(function ($record): ?string {
                        $images = is_array($record->images) ? $record->images : json_decode($record->images ?? '[]', true);
                        return !empty($images) ? asset('storage/' . $images[0]) : null;
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('color')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('height')
                    ->badge()
                    ->color('warning')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('picket_width')
                    ->label('Width')
                    ->badge()
                    ->color('success')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('calculated_price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->calculated_price),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->badge()
                    ->color(fn ($state, $record) => $record->is_low_stock ? 'danger' : 'success')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('color')
                    ->options(function () {
                        return ProductVariant::whereNotNull('color')
                            ->distinct()
                            ->pluck('color', 'color')
                            ->toArray();
                    })
                    ->searchable(),
                Tables\Filters\SelectFilter::make('height')
                    ->options(function () {
                        return ProductVariant::whereNotNull('height')
                            ->distinct()
                            ->pluck('height', 'height')
                            ->toArray();
                    })
                    ->searchable(),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->nullable(),
                Tables\Filters\Filter::make('low_stock')
                    ->query(fn (Builder $query): Builder => $query->lowStock())
                    ->label('Low Stock'),
                Tables\Filters\Filter::make('has_images')
                    ->query(fn (Builder $query): Builder => $query->has('media'))
                    ->label('Has Images'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (ProductVariant $record) {
                        $newVariant = $record->replicate();
                        $newVariant->name = $record->name . ' (Copy)';
                        $newVariant->sku = null;
                        $newVariant->save();
                        
                        return redirect()->route('filament.admin.resources.product-variants.edit', $newVariant);
                    })
                    ->requiresConfirmation()
                    ->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-mark')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                    Tables\Actions\BulkAction::make('update_stock')
                        ->label('Update Stock')
                        ->icon('heroicon-o-cube')
                        ->form([
                            Forms\Components\TextInput::make('stock_quantity')
                                ->label('New Stock Quantity')
                                ->numeric()
                                ->required()
                                ->minValue(0),
                        ])
                        ->action(function (array $data, $records) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['stock_quantity' => $data['stock_quantity']]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('info'),
                ]),
            ])
            ->defaultSort('product_id', 'asc');
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
            'index' => Pages\ListProductVariants::route('/'),
            'create' => Pages\CreateProductVariant::route('/create'),
            'view' => Pages\ViewProductVariant::route('/{record}'),
            'edit' => Pages\EditProductVariant::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_product_variants') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_product_variants') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_product_variants') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_product_variants') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_product_variants') ?? false;
    }
}