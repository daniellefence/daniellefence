<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialResource\Pages;
use App\Filament\Resources\SpecialResource\RelationManagers;
use App\Models\Special;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialResource extends Resource
{
    protected static ?string $model = Special::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Marketing & SEO';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Special Offer Information')
                    ->description('Manage special offers and promotions')
                    ->icon('heroicon-o-gift')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Offer Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., 20% Off All Vinyl Fencing')
                            ->helperText('The main headline for this special offer'),

                        Forms\Components\TextInput::make('condition')
                            ->label('Terms & Conditions')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Valid through end of month')
                            ->helperText('Any restrictions or conditions for this offer'),

                        Forms\Components\TextInput::make('brand')
                            ->label('Brand/Product')
                            ->maxLength(191)
                            ->placeholder('e.g., Vinyl Pro, Cedar Plus')
                            ->helperText('Specific brand or product this offer applies to (optional)'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Offer Details')
                    ->description('Configure the specifics of this promotion')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        \App\Filament\Forms\Components\ChatGPTTiptapEditor::make('content')
                            ->label('Offer Description')
                            ->profile('default')
                            ->columnSpanFull()
                            ->placeholder('Detailed description of the special offer')
                            ->helperText('Full details about what is included in this offer'),

                        Forms\Components\TextInput::make('price')
                            ->label('Price/Discount')
                            ->maxLength(191)
                            ->placeholder('e.g., $499, 25% off, Starting at $1,200')
                            ->helperText('The promotional price or discount amount'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this offer appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in offer listings'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Offer Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-gift')
                    ->limit(40),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price/Discount')
                    ->badge()
                    ->color('success')
                    ->searchable(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Brand/Product')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('All Products')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('condition')
                    ->label('Conditions')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('content')
                    ->label('Description')
                    ->html()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->options(function () {
                        return Special::whereNotNull('brand')
                            ->where('brand', '!=', '')
                            ->distinct()
                            ->pluck('brand', 'brand')
                            ->toArray();
                    })
                    ->placeholder('All Brands'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->recordUrl(fn ($record) => null);
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
            'index' => Pages\ListSpecials::route('/'),
            'create' => Pages\CreateSpecial::route('/create'),
            'view' => Pages\ViewSpecial::route('/{record}'),
            'edit' => Pages\EditSpecial::route('/{record}/edit'),
        ];
    }
}
