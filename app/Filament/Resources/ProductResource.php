<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Product Details')->schema([
                Forms\Components\Select::make('product_category_id')
                    ->label('Category')
                    ->relationship('category', 'name', fn ($query) => $query->published())
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('slug')->required(),
                        Forms\Components\RichEditor::make('description'),
                        Forms\Components\Toggle::make('published')->default(true),
                    ]),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash']),
                Forms\Components\TextInput::make('stock_code')
                    ->label('Stock Code')
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('base_price')
                    ->numeric()
                    ->prefix('$')
                    ->step(0.01)
                    ->minValue(0),
                Forms\Components\Toggle::make('is_diy')
                    ->label('DIY Enabled'),
                \Yepsua\Filament\Forms\Components\Rating::make('rating')
                    ->label('Product Rating')
                    ->max(5)
                    ->helperText('Rate this product from 1 to 5 stars'),
            ])->columns(2),

            Forms\Components\Section::make('Description')->schema([
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull()
                    ->fileAttachmentsDirectory('product-attachments'),
            ]),

            Forms\Components\Section::make('DIY Options')->schema([
                Forms\Components\TagsInput::make('available_colors')
                    ->label('Available Colors')
                    ->placeholder('Add color options'),
                Forms\Components\TagsInput::make('available_heights')
                    ->label('Available Heights')
                    ->placeholder('Add height options'),
                Forms\Components\TagsInput::make('available_picket_widths')
                    ->label('Available Picket Widths')
                    ->placeholder('Add width options'),
            ])->columns(3)->visible(fn (Forms\Get $get) => $get('is_diy')),

            Forms\Components\Section::make('Publishing')->schema([
                Forms\Components\Toggle::make('published')
                    ->default(false)
                    ->live(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label('Publish Date')
                    ->visible(fn (Forms\Get $get) => $get('published'))
                    ->default(now()),
            ])->columns(2),

            Forms\Components\Section::make('Tags & Media')->schema([
                Forms\Components\Select::make('tags')
                    ->relationship('tags','name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required(),
                    ])
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(20)
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->directory('products/images'),
                Forms\Components\FileUpload::make('documents')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(10)
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240)
                    ->directory('products/documents'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->getStateUsing(function ($record): ?string {
                        return $record->getFirstMediaUrl('images');
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('stock_code')
                    ->label('Stock Code')
                    ->searchable()
                    ->copyable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_diy')
                    ->label('DIY')
                    ->boolean(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\ViewColumn::make('rating')
                    ->label('Rating')
                    ->view('filament.tables.columns.star-rating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('product_category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Draft')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('is_diy')
                    ->label('DIY Enabled')
                    ->trueLabel('DIY Enabled')
                    ->falseLabel('Not DIY')
                    ->nullable(),
                Tables\Filters\Filter::make('published_this_month')
                    ->query(fn ($query) => $query->whereMonth('published_at', now()->month))
                    ->label('Published This Month'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'published' => true,
                                    'published_at' => now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-eye-slash')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['published' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProductResource::route('/'),
            'create' => Pages\CreateProductResource::route('/create'),
            'view' => Pages\ViewProductResource::route('/{record}'),
            'edit' => Pages\EditProductResource::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_products') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_products') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_products') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_products') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_products') ?? false;
    }
}
