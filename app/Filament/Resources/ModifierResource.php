<?php

namespace App\Filament\Resources;

use App\Models\Modifier;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ModifierResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class ModifierResource extends Resource
{
    protected static ?string $model = Modifier::class;
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';
    // protected static ?string $navigationGroup = 'DIY Configurator';
    protected static ?int $navigationSort = 12;
    protected static ?string $navigationLabel = 'Price Modifiers';
    protected static ?string $pluralLabel = 'Price Modifiers';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Modifier Details')->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name', fn (Builder $query) => $query->where('is_diy', true))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(),
                Forms\Components\Select::make('attribute')
                    ->options([
                        'color' => 'Color',
                        'height' => 'Height',
                        'picket_width' => 'Picket Width',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(100)
                    ->helperText('e.g., White, Black, 6ft, 4ft, 3in, 4in'),
            ])->columns(3),

            Forms\Components\Section::make('Price Adjustment')->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'add' => 'Add to Price',
                        'subtract' => 'Subtract from Price',
                    ])
                    ->required()
                    ->default('add')
                    ->live(),
                Forms\Components\Select::make('operation')
                    ->options([
                        'percent' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->required()
                    ->default('percent')
                    ->live(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->minValue(0)
                    ->suffix(fn (Forms\Get $get) => $get('operation') === 'percent' ? '%' : '$')
                    ->helperText(fn (Forms\Get $get) => $get('operation') === 'percent' ? 'Enter percentage (e.g., 10 for 10%)' : 'Enter dollar amount'),
            ])->columns(3),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->maxLength(500)
                    ->columnSpanFull()
                    ->placeholder('Optional description for this modifier'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('attribute')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'color' => 'success',
                        'height' => 'warning',
                        'picket_width' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'add' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('operation')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                Tables\Columns\TextColumn::make('amount')
                    ->sortable()
                    ->formatStateUsing(fn ($record, $state) => $record->operation === 'percent' ? $state . '%' : '$' . number_format($state, 2)),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('attribute')
                    ->options([
                        'color' => 'Color',
                        'height' => 'Height',
                        'picket_width' => 'Picket Width',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'add' => 'Add to Price',
                        'subtract' => 'Subtract from Price',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('operation')
                    ->options([
                        'percent' => 'Percentage',
                        'fixed' => 'Fixed Amount',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('duplicate')
                        ->label('Duplicate Selected')
                        ->icon('heroicon-o-document-duplicate')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $newRecord = $record->replicate();
                                $newRecord->value = $newRecord->value . ' (Copy)';
                                $newRecord->save();
                            });
                        })
                        ->requiresConfirmation()
                        ->color('info'),
                ]),
            ])
            ->defaultSort('product_id', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModifierResource::route('/'),
            'create' => Pages\CreateModifierResource::route('/create'),
            'view' => Pages\ViewModifierResource::route('/{record}'),
            'edit' => Pages\EditModifierResource::route('/{record}/edit'),
        ];
    }
}
