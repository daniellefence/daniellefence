<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailableSpacingResource\Pages;
use App\Filament\Resources\AvailableSpacingResource\RelationManagers;
use App\Models\AvailableSpacing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailableSpacingResource extends Resource
{
    protected static ?string $model = AvailableSpacing::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Spacing Information')
                    ->description('Manage available fence post spacing for DIY products')
                    ->icon('heroicon-o-arrows-right-left')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Spacing Name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., 6 feet, 8 feet')
                            ->helperText('Enter the display name for this spacing'),

                        Forms\Components\TextInput::make('value_feet')
                            ->label('Spacing (Feet)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(20)
                            ->suffix('ft')
                            ->helperText('Distance between fence posts in feet'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this spacing appears in the product configurator')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\TextInput::make('display_order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in spacing selection'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Show this spacing in the product configurator')
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

                Tables\Columns\TextColumn::make('name')
                    ->label('Spacing Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-arrows-right-left'),

                Tables\Columns\TextColumn::make('value_feet')
                    ->label('Distance')
                    ->numeric()
                    ->suffix(' ft')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('spacing_description')
                    ->label('Description')
                    ->state(function ($record) {
                        if ($record->value_feet <= 6) {
                            return 'Standard spacing';
                        } elseif ($record->value_feet <= 8) {
                            return 'Wide spacing';
                        } else {
                            return 'Extra wide spacing';
                        }
                    })
                    ->color(function ($record) {
                        if ($record->value_feet <= 6) {
                            return 'success';
                        } elseif ($record->value_feet <= 8) {
                            return 'warning';
                        } else {
                            return 'danger';
                        }
                    })
                    ->badge(),

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
                    ->trueLabel('Active spacings')
                    ->falseLabel('Inactive spacings')
                    ->native(false),
                Tables\Filters\SelectFilter::make('value_feet')
                    ->label('Spacing Distance')
                    ->options([
                        6 => '6 feet',
                        7 => '7 feet',
                        8 => '8 feet',
                        10 => '10 feet',
                    ])
                    ->multiple(),
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
            'index' => Pages\ListAvailableSpacings::route('/'),
            'create' => Pages\CreateAvailableSpacing::route('/create'),
            'edit' => Pages\EditAvailableSpacing::route('/{record}/edit'),
        ];
    }
}
