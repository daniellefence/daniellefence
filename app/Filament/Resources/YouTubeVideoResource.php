<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YouTubeVideoResource\Pages;
use App\Filament\Resources\YouTubeVideoResource\RelationManagers;
use App\Models\YouTubeVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YouTubeVideoResource extends Resource
{
    protected static ?string $model = YouTubeVideo::class;
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationGroup = 'Content';
    protected static ?string $navigationLabel = 'YouTube Videos';
    protected static ?string $pluralLabel = 'YouTube Videos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Video Information')
                ->description('Enter the YouTube video URL and configure display settings.')
                ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->helperText('The title of the YouTube video.')
                    ->placeholder('Enter video title...'),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->required()
                    ->url()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $context, $state, callable $set) {
                        if ($context === 'create' && $state) {
                            $youtubeId = \App\Models\YouTubeVideo::extractYouTubeId($state);
                            if ($youtubeId) {
                                $set('youtube_id', $youtubeId);
                            }
                        }
                    })
                    ->helperText('Full YouTube video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)')
                    ->placeholder('https://www.youtube.com/watch?v=...'),
                Forms\Components\TextInput::make('youtube_id')
                    ->label('YouTube Video ID')
                    ->required()
                    ->maxLength(50)
                    ->helperText('This will be auto-extracted from the URL, but you can edit it if needed.')
                    ->placeholder('dQw4w9WgXcQ'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000)
                    ->helperText('Description of the video content.')
                    ->placeholder('Describe what this video is about...')
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Display Settings')
                ->description('Control how and where this video appears on your website.')
                ->schema([
                Forms\Components\Toggle::make('show_on_videos_page')
                    ->label('Show on Videos Page')
                    ->default(true)
                    ->helperText('Display this video on the main videos page.'),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Featured Video')
                    ->default(false)
                    ->helperText('Feature this video prominently on your website.'),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first. Use this to control the display order.'),
                Forms\Components\Select::make('category')
                    ->options([
                        'fence_installation' => 'Fence Installation',
                        'fence_repair' => 'Fence Repair', 
                        'tutorials' => 'Tutorials',
                        'testimonials' => 'Customer Testimonials',
                        'company' => 'Company Videos',
                        'projects' => 'Project Showcases',
                        'other' => 'Other',
                    ])
                    ->helperText('Categorize this video for better organization.'),
            ])->columns(2),

            Forms\Components\Section::make('Video Details')
                ->description('Additional video information (these can be auto-populated from YouTube API).')
                ->schema([
                Forms\Components\TextInput::make('duration')
                    ->label('Duration (seconds)')
                    ->numeric()
                    ->helperText('Video duration in seconds (will be auto-fetched if YouTube API is configured).'),
                Forms\Components\TextInput::make('thumbnail_url')
                    ->label('Thumbnail URL')
                    ->url()
                    ->helperText('Video thumbnail image URL (will be auto-fetched if YouTube API is configured).'),
                Forms\Components\TagsInput::make('tags')
                    ->helperText('Add tags to help categorize and search for this video.')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('youtube_id')
                    ->label('Video ID')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\IconColumn::make('show_on_videos_page')
                    ->label('Show on Page')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '—';
                        $minutes = floor($state / 60);
                        $seconds = $state % 60;
                        return sprintf('%d:%02d', $minutes, $seconds);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'fence_installation' => 'Fence Installation',
                        'fence_repair' => 'Fence Repair',
                        'tutorials' => 'Tutorials', 
                        'testimonials' => 'Customer Testimonials',
                        'company' => 'Company Videos',
                        'projects' => 'Project Showcases',
                        'other' => 'Other',
                    ]),
                Tables\Filters\TernaryFilter::make('show_on_videos_page')
                    ->label('Show on Videos Page'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Videos'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('watch')
                    ->label('Watch')
                    ->icon('heroicon-o-play')
                    ->url(fn (YouTubeVideo $record): string => $record->watch_url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListYouTubeVideos::route('/'),
            'create' => Pages\CreateYouTubeVideo::route('/create'),
            'edit' => Pages\EditYouTubeVideo::route('/{record}/edit'),
        ];
    }
}
