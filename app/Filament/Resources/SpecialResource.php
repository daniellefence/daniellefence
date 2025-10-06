<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use App\Filament\Forms\Components\ChatGPTRichEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\CreateAction;
use App\Filament\Resources\SpecialResource\Pages\ListSpecials;
use App\Filament\Resources\SpecialResource\Pages\CreateSpecial;
use App\Filament\Resources\SpecialResource\Pages\ViewSpecial;
use App\Filament\Resources\SpecialResource\Pages\EditSpecial;
use App\Filament\Resources\SpecialResource\Pages;
use App\Filament\Resources\SpecialResource\RelationManagers;
use App\Models\Special;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialResource extends Resource
{
    protected static ?string $model = Special::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-gift';

    protected static string | \UnitEnum | null $navigationGroup = 'Marketing & SEO';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Special Offer Information')
                    ->description('Manage special offers and promotions')
                    ->icon('heroicon-o-gift')
                    ->schema([
                        TextInput::make('title')
                            ->label('Offer Title')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., 20% Off All Vinyl Fencing')
                            ->helperText('The main headline for this special offer'),

                        TextInput::make('condition')
                            ->label('Terms & Conditions')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Valid through end of month')
                            ->helperText('Any restrictions or conditions for this offer'),

                        TextInput::make('brand')
                            ->label('Brand/Product')
                            ->maxLength(191)
                            ->placeholder('e.g., Vinyl Pro, Cedar Plus')
                            ->helperText('Specific brand or product this offer applies to (optional)'),
                    ])
                    ->columns(1),

                Section::make('Offer Details')
                    ->description('Configure the specifics of this promotion')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        ChatGPTRichEditor::make('content')
                            ->label('Offer Description')
                            ->columnSpanFull()
                            ->placeholder('Detailed description of the special offer')
                            ->helperText('Full details about what is included in this offer'),

                        TextInput::make('price')
                            ->label('Price/Discount')
                            ->maxLength(191)
                            ->placeholder('e.g., $499, 25% off, Starting at $1,200')
                            ->helperText('The promotional price or discount amount'),
                    ])
                    ->columns(1),

                Section::make('Display Settings')
                    ->description('Control how this offer appears on the website')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        TextInput::make('order')
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
                TextColumn::make('order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                TextColumn::make('title')
                    ->label('Offer Title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-gift')
                    ->limit(40),

                TextColumn::make('price')
                    ->label('Price/Discount')
                    ->badge()
                    ->color('success')
                    ->searchable(),

                TextColumn::make('brand')
                    ->label('Brand/Product')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('All Products')
                    ->toggleable(),

                TextColumn::make('condition')
                    ->label('Conditions')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('content')
                    ->label('Description')
                    ->html()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->filters([
                SelectFilter::make('brand')
                    ->options(function () {
                        return Special::whereNotNull('brand')
                            ->where('brand', '!=', '')
                            ->distinct()
                            ->pluck('brand', 'brand')
                            ->toArray();
                    })
                    ->placeholder('All Brands'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->color('info'),
                EditAction::make()
                    ->color('warning'),
                DeleteAction::make()
                    ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
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
            'index' => ListSpecials::route('/'),
            'create' => CreateSpecial::route('/create'),
            'view' => ViewSpecial::route('/{record}'),
            'edit' => EditSpecial::route('/{record}/edit'),
        ];
    }
}
