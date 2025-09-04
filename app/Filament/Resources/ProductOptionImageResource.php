<?php

namespace App\Filament\Resources;

use App\Models\ProductOptionImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductOptionImageResource\Pages;

class ProductOptionImageResource extends Resource
{
    protected static ?string $model = ProductOptionImage::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'DIY Configurator';
    protected static ?string $navigationLabel = 'Variant Images';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')->relationship('product','name')->searchable()->required(),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make('color'),
                Forms\Components\TextInput::make('height'),
                Forms\Components\TextInput::make('picket_width'),
            ]),
            Forms\Components\Select::make('media_id')
                ->label('Media')
                ->searchable()
                ->options(\Spatie\MediaLibrary\MediaCollections\Models\Media::query()
                    ->selectRaw("CONCAT(id, ' — ', file_name) as label, id")
                    ->pluck('label','id')
                    ->toArray())
                ->helperText('Pick an uploaded image from Media.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')->label('Product')->searchable(),
                Tables\Columns\TextColumn::make('color'),
                Tables\Columns\TextColumn::make('height'),
                Tables\Columns\TextColumn::make('picket_width'),
                Tables\Columns\ImageColumn::make('preview')->getStateUsing(fn ($r) => optional($r->media)->getUrl('thumb') ?: optional($r->media)->getUrl())->square(),
                Tables\Columns\TextColumn::make('media.file_name')->label('File'),
                Tables\Columns\TextColumn::make('updated_at')->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductOptionImageResource::route('/'),
            'create' => Pages\CreateProductOptionImageResource::route('/create'),
            'edit' => Pages\EditProductOptionImageResource::route('/{record}/edit'),
        ];
    }
}
