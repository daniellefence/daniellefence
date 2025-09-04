<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\ProductVariant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Variant Details')
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Descriptive name for this variant.')
                        ->placeholder('Enter variant name...'),
                    Forms\Components\TextInput::make('sku')
                        ->label('SKU')
                        ->unique(ProductVariant::class, 'sku', ignoreRecord: true)
                        ->maxLength(100)
                        ->helperText('Unique stock keeping unit.')
                        ->placeholder('VARIANT-SKU-001'),
                ])->columns(2),

                Forms\Components\Section::make('Specifications')
                    ->schema([
                    Forms\Components\TextInput::make('color')
                        ->maxLength(100)
                        ->placeholder('White'),
                    Forms\Components\TextInput::make('height')
                        ->maxLength(100)
                        ->placeholder('6ft'),
                    Forms\Components\TextInput::make('picket_width')
                        ->label('Picket Width')
                        ->maxLength(100)
                        ->placeholder('4in'),
                    Forms\Components\TextInput::make('material')
                        ->maxLength(100)
                        ->placeholder('Vinyl'),
                ])->columns(2),

                Forms\Components\Section::make('Pricing & Stock')
                    ->schema([
                    Forms\Components\TextInput::make('price_modifier')
                        ->label('Price Modifier')
                        ->numeric()
                        ->step(0.01)
                        ->default(0)
                        ->prefix('$'),
                    Forms\Components\Select::make('price_modifier_type')
                        ->label('Modifier Type')
                        ->options([
                            'fixed' => 'Fixed Amount ($)',
                            'percentage' => 'Percentage (%)',
                        ])
                        ->default('fixed')
                        ->required(),
                    Forms\Components\TextInput::make('stock_quantity')
                        ->label('Stock Quantity')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                ])->columns(2),

                Forms\Components\Section::make('Images')
                    ->schema([
                    FileUpload::make('images')
                        ->multiple()
                        ->image()
                        ->reorderable()
                        ->maxFiles(5)
                        ->maxSize(5120)
                        ->directory('product-variants/images')
                        ->disk('public')
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Image')
                    ->getStateUsing(function ($record): ?string {
                        $images = is_array($record->images) ? $record->images : json_decode($record->images ?? '[]', true);
                        return !empty($images) ? asset('storage/' . $images[0]) : null;
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
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
                Tables\Columns\TextColumn::make('calculated_price')
                    ->label('Price')
                    ->money('USD')
                    ->getStateUsing(fn ($record) => $record->calculated_price),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->badge()
                    ->color(fn ($state, $record) => $record->is_low_stock ? 'danger' : 'success'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
                Tables\Filters\Filter::make('low_stock')
                    ->query(fn ($query) => $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold'))
                    ->label('Low Stock'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Create Product Variant')
                    ->modalWidth('4xl'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Product Variant')
                    ->modalWidth('4xl'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('duplicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (ProductVariant $record) {
                        $newVariant = $record->replicate();
                        $newVariant->name = $record->name . ' (Copy)';
                        $newVariant->sku = null;
                        $newVariant->save();
                    })
                    ->requiresConfirmation()
                    ->color('warning'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->color('warning'),
                ]),
            ])
            ->emptyStateHeading('No variants created')
            ->emptyStateDescription('Create variants to offer different options for this product.')
            ->emptyStateIcon('heroicon-o-squares-2x2');
    }
}