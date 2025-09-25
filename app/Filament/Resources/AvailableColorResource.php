<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailableColorResource\Pages;
use App\Filament\Resources\AvailableColorResource\RelationManagers;
use App\Models\AvailableColor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailableColorResource extends Resource
{
    protected static ?string $model = AvailableColor::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'DIY Configuration';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Color Information')
                    ->description('Manage available fence colors for DIY products')
                    ->icon('heroicon-o-swatch')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Color Name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., Forest Green, Classic White')
                            ->helperText('Enter the display name for this color'),

                        Forms\Components\FileUpload::make('image_url')
                            ->label('Color Sample Image')
                            ->image()
                            ->imageEditor()
                            ->directory('colors')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048)
                            ->helperText('Upload a sample image showing this color (max 2MB)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this color appears in the product configurator')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\TextInput::make('display_order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in color selection'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Show this color in the product configurator')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('display_order')
                    ->label('Order')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->width('80px'),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Sample')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('/images/no-color-sample.png'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Color Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-swatch'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable(),

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
            ->defaultSort('display_order', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active colors')
                    ->falseLabel('Inactive colors')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Deactivate' : 'Activate')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                    ->action(function ($record) {
                        $record->update(['is_active' => !$record->is_active]);
                    })
                    ->requiresConfirmation(),
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                        })
                        ->requiresConfirmation(),
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
            'index' => Pages\ListAvailableColors::route('/'),
            'create' => Pages\CreateAvailableColor::route('/create'),
            'edit' => Pages\EditAvailableColor::route('/{record}/edit'),
        ];
    }
}
