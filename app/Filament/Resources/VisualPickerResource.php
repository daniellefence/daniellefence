<?php

namespace App\Filament\Resources;

use App\Models\VisualPicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\VisualPickerResource\Pages;

class VisualPickerResource extends Resource
{
    protected static ?string $model = VisualPicker::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'DIY Configurator';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')->relationship('product','name')->required(),
            Forms\Components\TextInput::make('color'),
            Forms\Components\TextInput::make('height'),
            Forms\Components\TextInput::make('picket_width'),
            Forms\Components\TextInput::make('image_path')->helperText('Path or URL to image'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->label('Product'),
                Tables\Columns\TextColumn::make('color'),
                Tables\Columns\TextColumn::make('height'),
                Tables\Columns\TextColumn::make('picket_width'),
                Tables\Columns\TextColumn::make('image_path'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisualPickerResource::route('/'),
            'create' => Pages\CreateVisualPickerResource::route('/create'),
            'edit' => Pages\EditVisualPickerResource::route('/{record}/edit'),
        ];
    }
}
