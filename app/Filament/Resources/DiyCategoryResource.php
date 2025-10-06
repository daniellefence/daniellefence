<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\DiyCategoryResource\Pages\ListDiyCategories;
use App\Filament\Resources\DiyCategoryResource\Pages\CreateDiyCategory;
use App\Filament\Resources\DiyCategoryResource\Pages\ViewDiyCategory;
use App\Filament\Resources\DiyCategoryResource\Pages\EditDiyCategory;
use App\Filament\Resources\DiyCategoryResource\Pages;
use App\Filament\Resources\DiyCategoryResource\RelationManagers;
use App\Models\DiyCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiyCategoryResource extends Resource
{
    protected static ?string $model = DiyCategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder';

    protected static string | \UnitEnum | null $navigationGroup = 'DIY System';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(191),
                Textarea::make('description')
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('photo')
                    ->collection('category-photos')
                    ->image()
                    ->imageEditor()
                    ->columnSpanFull(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('photo')
                    ->collection('category-photos')
                    ->circular(),
                TextColumn::make('name')
                    ->searchable(),
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
            'index' => ListDiyCategories::route('/'),
            'create' => CreateDiyCategory::route('/create'),
            'view' => ViewDiyCategory::route('/{record}'),
            'edit' => EditDiyCategory::route('/{record}/edit'),
        ];
    }
}
