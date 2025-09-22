<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailableHeightResource\Pages;
use App\Filament\Resources\AvailableHeightResource\RelationManagers;
use App\Models\AvailableHeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvailableHeightResource extends Resource
{
    protected static ?string $model = AvailableHeight::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-up-down';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Height Information')
                    ->description('Manage available fence heights for DIY products')
                    ->icon('heroicon-o-arrows-up-down')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Height Name')
                            ->required()
                            ->maxLength(191)
                            ->placeholder('e.g., 4 feet, 6 feet')
                            ->helperText('Enter the display name for this height'),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('value_feet')
                                    ->label('Height (Feet)')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(20)
                                    ->suffix('ft')
                                    ->helperText('Height in feet'),

                                Forms\Components\TextInput::make('value_inches')
                                    ->label('Additional Inches')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->maxValue(11)
                                    ->suffix('in')
                                    ->helperText('Additional inches (0-11)'),
                            ]),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Display Settings')
                    ->description('Control how this height appears in the product configurator')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Forms\Components\TextInput::make('display_order')
                            ->label('Display Order')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->helperText('Lower numbers appear first in height selection'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Show this height in the product configurator')
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
                    ->label('Height Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-arrows-up-down'),

                Tables\Columns\TextColumn::make('total_height')
                    ->label('Total Height')
                    ->state(function ($record) {
                        $total = $record->value_feet;
                        if ($record->value_inches > 0) {
                            $total .= "' {$record->value_inches}\"";
                        } else {
                            $total .= "'";
                        }
                        return $total;
                    })
                    ->badge()
                    ->color('info')
                    ->sortable(['value_feet', 'value_inches']),

                Tables\Columns\TextColumn::make('value_feet')
                    ->label('Feet')
                    ->numeric()
                    ->suffix(' ft')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('value_inches')
                    ->label('Inches')
                    ->numeric()
                    ->suffix(' in')
                    ->sortable()
                    ->toggleable(),

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
                    ->trueLabel('Active heights')
                    ->falseLabel('Inactive heights')
                    ->native(false),
                Tables\Filters\SelectFilter::make('value_feet')
                    ->label('Height (Feet)')
                    ->options([
                        3 => '3 feet',
                        4 => '4 feet',
                        5 => '5 feet',
                        6 => '6 feet',
                        8 => '8 feet',
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
            'index' => Pages\ListAvailableHeights::route('/'),
            'create' => Pages\CreateAvailableHeight::route('/create'),
            'edit' => Pages\EditAvailableHeight::route('/{record}/edit'),
        ];
    }
}
