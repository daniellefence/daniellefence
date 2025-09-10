<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialResource\Pages;
use App\Models\Special;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialResource extends Resource
{
    protected static ?string $model = Special::class;
    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'SEO & Marketing';
    protected static ?string $navigationLabel = 'Specials & Promotions';
    protected static ?string $pluralLabel = 'Specials & Promotions';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Special Details')
                ->description('Basic information about your promotional offer including title, description, and promo code.')
                ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->helperText('The main title of your promotional offer. This will automatically generate a URL slug.')
                    ->placeholder('Enter an attractive special offer title...'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('URL-friendly version of the title. Only letters, numbers, and dashes allowed.')
                    ->placeholder('auto-generated-from-title'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Detailed description of the special offer. Explain the value and terms to your customers.')
                    ->placeholder('Describe your special offer, terms, and conditions...')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('promo_code')
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->helperText('Optional promo code customers can use. Leave blank if no code is needed.')
                    ->placeholder('SAVE20, SUMMER2024, etc.'),
            ])->columns(2),

            Forms\Components\Section::make('Discount Configuration')
                ->description('Set up the discount type and amount. Choose either percentage or fixed amount discount.')
                ->schema([
                Forms\Components\TextInput::make('discount_percentage')
                    ->label('Discount Percentage (%)')
                    ->numeric()
                    ->suffix('%')
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->helperText('Percentage discount (0-100%). Leave blank if using fixed amount discount.'),
                Forms\Components\TextInput::make('discount_amount')
                    ->label('Fixed Discount Amount')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Fixed dollar amount discount. Leave blank if using percentage discount.'),
                Forms\Components\TextInput::make('min_purchase_amount')
                    ->label('Minimum Purchase Amount')
                    ->numeric()
                    ->prefix('$')
                    ->minValue(0)
                    ->step(0.01)
                    ->helperText('Optional minimum purchase amount required to use this special offer.'),
            ])->columns(3),

            Forms\Components\Section::make('Usage & Timing')
                ->description('Control when the special is active and how many times it can be used.')
                ->schema([
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start Date & Time')
                    ->helperText('When this special offer becomes active. Leave blank to activate immediately.'),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('End Date & Time')
                    ->after('start_date')
                    ->helperText('When this special offer expires. Leave blank for no expiration.'),
                Forms\Components\TextInput::make('usage_limit')
                    ->label('Usage Limit')
                    ->numeric()
                    ->minValue(1)
                    ->helperText('Maximum number of times this offer can be used. Leave blank for unlimited usage.'),
                Forms\Components\TextInput::make('usage_count')
                    ->label('Times Used')
                    ->numeric()
                    ->disabled()
                    ->default(0)
                    ->helperText('Number of times this offer has been used (automatically tracked).'),
            ])->columns(2),

            Forms\Components\Section::make('Applicable Products & Categories')
                ->description('Choose which products or categories this special applies to. Leave both empty to apply to all products.')
                ->schema([
                Forms\Components\Select::make('applicable_products')
                    ->label('Applicable Products')
                    ->multiple()
                    ->options(Product::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->helperText('Select specific products this special applies to. Leave empty to apply to all products.')
                    ->columnSpanFull(),
                Forms\Components\Select::make('applicable_categories')
                    ->label('Applicable Categories')
                    ->multiple()
                    ->options(Category::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->helperText('Select specific categories this special applies to. Leave empty to apply to all categories.')
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Status & Media')
                ->description('Control the visibility and add promotional images for your special offer.')
                ->schema([
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Enable this special offer. Inactive offers won\'t be available to customers.'),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(false)
                    ->helperText('Feature this special prominently on your website homepage and promotional areas.'),
                Forms\Components\FileUpload::make('banner')
                    ->label('Promotional Banner')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->maxSize(5120)
                    ->directory('specials/banners')
                    ->helperText('Upload a promotional banner image (max 5MB). Recommended: 1200x400px for best display.')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('thumbnails')
                    ->label('Additional Images')
                    ->multiple()
                    ->image()
                    ->reorderable()
                    ->maxFiles(5)
                    ->maxSize(5120)
                    ->directory('specials/thumbnails')
                    ->helperText('Additional promotional images (max 5 images, 5MB each). Use for gallery displays.')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('banner_image')
                    ->getStateUsing(function ($record): ?string {
                        return $record->getFirstMediaUrl('banner');
                    })
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('promo_code')
                    ->badge()
                    ->color('info')
                    ->copyable()
                    ->placeholder('No code'),
                Tables\Columns\TextColumn::make('discount_percentage')
                    ->label('Discount %')
                    ->suffix('%')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Discount $')
                    ->money('USD')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Starts')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Immediate'),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Ends')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('No expiration'),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Used')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Status')
                    ->trueLabel('Featured Only')
                    ->falseLabel('Not Featured')
                    ->nullable(),
                Tables\Filters\Filter::make('has_promo_code')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('promo_code'))
                    ->label('Has Promo Code'),
                Tables\Filters\Filter::make('currently_active')
                    ->query(fn (Builder $query): Builder => 
                        $query->where('is_active', true)
                              ->where(function($q) {
                                  $q->whereNull('start_date')->orWhere('start_date', '<=', now());
                              })
                              ->where(function($q) {
                                  $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                              })
                    )
                    ->label('Currently Active'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-mark')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpecials::route('/'),
            'create' => Pages\CreateSpecial::route('/create'),
            'edit' => Pages\EditSpecial::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_specials') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_specials') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_specials') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_specials') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_specials') ?? false;
    }
}
