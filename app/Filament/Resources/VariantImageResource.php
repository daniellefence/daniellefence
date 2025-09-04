<?php

namespace App\Filament\Resources;

use App\Models\VariantImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\VariantImageResource\Pages;

class VariantImageResource extends Resource
{
    protected static ?string $model = VariantImage::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'DIY Configurator';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('product_id')->relationship('product','name')->required()->searchable(),
            Forms\Components\TextInput::make('color'),
            Forms\Components\TextInput::make('height'),
            Forms\Components\TextInput::make('picket_width'),
            Forms\Components\FileUpload::make('image_path')
                ->disk(config('media-library.disk_name','public'))
                ->directory('variant-images')
                ->image()->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->getStateUsing(fn ($record) => Storage::disk(config('media-library.disk_name','public'))->url($record->image_path))
                    ->label('Image')
                    ->circular(),
                Tables\Columns\TextColumn::make('product.name')->label('Product')->searchable(),
                Tables\Columns\TextColumn::make('color')->badge(),
                Tables\Columns\TextColumn::make('height')->badge(),
                Tables\Columns\TextColumn::make('picket_width')->badge(),
                Tables\Columns\TextColumn::make('updated_at')->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->modalHeading('Preview')
                    ->modalContent(fn ($record) => view('filament.variant-image-preview', [
                        'url' => Storage::disk(config('media-library.disk_name','public'))->url($record->image_path),
                        'combo' => "{$record->color} / {$record->height} / {$record->picket_width}",
                        'product' => $record->product?->name,
                    ]))
                    ->modalSubmitAction(false),
                Tables\Actions\EditAction::make()
                    ->visible(fn () => auth()->user()?->can('manage modifiers')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn () => auth()->user()?->can('manage modifiers')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()?->can('manage modifiers')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVariantImageResource::route('/'),
            'create' => Pages\CreateVariantImageResource::route('/create'),
            'edit' => Pages\EditVariantImageResource::route('/{record}/edit'),
        ];
    }
}
