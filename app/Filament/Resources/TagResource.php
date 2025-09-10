<?php

namespace App\Filament\Resources;

use Spatie\Tags\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\TagResource\Pages;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $navigationIcon = 'heroicon-o-hashtag';
    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        $locale = app()->getLocale();

        return $form->schema([
            // Virtual field for the localized name; transformed in Create/Edit pages
            Forms\Components\TextInput::make('name_localized')
                ->label("Name ({$locale})")
                ->required()
                ->maxLength(255)
                ->afterStateHydrated(function (Forms\Get $get, ?Tag $record, Forms\Components\TextInput $component) use ($locale) {
                    if ($record) {
                        $component->state($record->getTranslation('name', $locale) ?? $record->name);
                    }
                })
                ->dehydrated(false),

            Forms\Components\TextInput::make('type')
                ->label('Type')
                ->maxLength(150)
                ->helperText('Optional: assign a type/bucket to your tags.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        $locale = app()->getLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->state(function (Tag $record) use ($locale) {
                        return $record->getTranslation('name', $locale) ?? (is_array($record->name) ? reset($record->name) : $record->name);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->since(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTagResource::route('/'),
            'create' => Pages\CreateTagResource::route('/create'),
            'edit' => Pages\EditTagResource::route('/{record}/edit'),
        ];
    }
}
