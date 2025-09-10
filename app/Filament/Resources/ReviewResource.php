<?php

namespace App\Filament\Resources;

use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ReviewResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationGroup = 'Customer Management';
    protected static ?string $navigationLabel = 'Reviews';
    protected static ?string $pluralLabel = 'Reviews';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Review Details')
                ->description('Basic information about the customer review including rating, source, and publication status.')
                ->schema([
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The name of the person who wrote this review')
                    ->placeholder('e.g., John Smith, Sarah M., Anonymous'),
                \Yepsua\Filament\Forms\Components\Rating::make('rating')
                    ->label('Customer Rating')
                    ->max(5)
                    ->required()
                    ->default(5)
                    ->helperText('Star rating given by the reviewer (1-5 stars)'),
                Forms\Components\Select::make('source')
                    ->options([
                        'google' => 'Google',
                        'yelp' => 'Yelp',
                        'facebook' => 'Facebook',
                        'website' => 'Website',
                        'other' => 'Other',
                    ])
                    ->default('google')
                    ->required()
                    ->helperText('Where this review was originally posted. Google reviews are auto-imported, but you can manually add reviews from other sources.'),
                Forms\Components\Toggle::make('published')
                    ->default(true)
                    ->helperText('Enable this to display the review on your website. Unpublished reviews are hidden from visitors.'),
            ])->columns(2),

            Forms\Components\Section::make('Review Content')
                ->description('The actual review text written by the customer.')
                ->schema([
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(2000)
                    ->helperText('The full text of the customer review (max 2000 characters). For Google reviews, this is automatically imported. For manual reviews, paste or type the review content.')
                    ->placeholder('Enter the customer review text here...'),
            ]),

            Forms\Components\Section::make('Review Metadata')
                ->description('Additional information about when and where the review was posted.')
                ->schema([
                Forms\Components\TextInput::make('google_review_id')
                    ->label('Google Review ID')
                    ->maxLength(255)
                    ->hint('Automatically populated for Google reviews')
                    ->helperText('Leave empty for non-Google reviews. This is used to track Google-imported reviews and prevent duplicates.')
                    ->disabled(fn ($context) => $context === 'edit'),
                Forms\Components\DateTimePicker::make('reviewed_at')
                    ->label('Review Date')
                    ->required()
                    ->default(now())
                    ->helperText('When the review was originally posted. For imported reviews, this matches the original date.'),
            ])->columns(2),

            Forms\Components\Section::make('Tags')
                ->description('Categorize reviews with tags for better organization and filtering.')
                ->schema([
                Forms\Components\Select::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->helperText('Tag name for categorization'),
                    ])
                    ->columnSpanFull()
                    ->helperText('Add tags to categorize reviews by service type, location, or any other criteria that helps with organization.'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\ViewColumn::make('rating')
                    ->label('Rating')
                    ->view('filament.tables.columns.star-rating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->limit(100)
                    ->html()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = strip_tags($column->getState());
                        if (strlen($state) <= 100) {
                            return null;
                        }
                        return $state;
                    }),
                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'google' => 'success',
                        'yelp' => 'danger',
                        'facebook' => 'info',
                        'website' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Review Date')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ])
                    ->multiple(),
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'google' => 'Google',
                        'yelp' => 'Yelp',
                        'facebook' => 'Facebook',
                        'website' => 'Website',
                        'other' => 'Other',
                    ])
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('published')
                    ->label('Published Status')
                    ->trueLabel('Published')
                    ->falseLabel('Unpublished')
                    ->nullable(),
                Tables\Filters\Filter::make('five_stars')
                    ->query(fn (Builder $query): Builder => $query->where('rating', 5))
                    ->label('5 Star Reviews'),
                Tables\Filters\Filter::make('google_reviews')
                    ->query(fn (Builder $query): Builder => $query->googleReviews())
                    ->label('Google Reviews Only'),
                Tables\Filters\Filter::make('reviewed_this_month')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('reviewed_at', now()->month))
                    ->label('Reviewed This Month'),
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
                                $record->update(['published' => true]);
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
            ->defaultSort('reviewed_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}