<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrashBinResource\Pages;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Special;
use App\Models\ServiceArea;
use App\Models\YouTubeVideo;
use App\Models\Career;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrashBinResource extends Resource
{
    protected static ?string $model = Blog::class; // Default model, will be overridden

    protected static ?string $navigationIcon = 'heroicon-o-trash';
    protected static ?string $navigationGroup = 'System Management';
    protected static ?string $navigationLabel = 'Trash Bin';
    protected static ?string $pluralLabel = 'Trash Bin';
    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('restore_notice')
                ->label('Restore Item')
                ->content('Use the restore action to bring this item back to active status.')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title/Name')
                    ->getStateUsing(function ($record) {
                        return $record->title ?? $record->name ?? $record->id;
                    })
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->getStateUsing(function ($record) {
                        return class_basename($record);
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Blog' => 'info',
                        'Product' => 'success',
                        'Special' => 'danger',
                        'ServiceArea' => 'purple',
                        'YouTubeVideo' => 'red',
                        'Career' => 'orange',
                        'Contact' => 'blue',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Originally Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Blog' => 'Blogs',
                        'Product' => 'Products',
                        'Special' => 'Specials',
                        'ServiceArea' => 'Service Areas',
                        'YouTubeVideo' => 'YouTube Videos',
                        'Career' => 'Careers',
                        'Contact' => 'Contacts',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        // This will be handled in the page class
                        return $query;
                    }),
                Tables\Filters\Filter::make('deleted_this_week')
                    ->query(fn (Builder $query): Builder => $query->where('deleted_at', '>=', now()->subWeek()))
                    ->label('Deleted This Week'),
                Tables\Filters\Filter::make('deleted_this_month')
                    ->query(fn (Builder $query): Builder => $query->where('deleted_at', '>=', now()->subMonth()))
                    ->label('Deleted This Month'),
            ])
            ->actions([
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->action(function ($record) {
                        $record->restore();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Restore Item')
                    ->modalDescription('Are you sure you want to restore this item? It will be moved back to its original location.')
                    ->color('success'),
                Tables\Actions\Action::make('force_delete')
                    ->label('Delete Permanently')
                    ->icon('heroicon-o-x-mark')
                    ->action(function ($record) {
                        $record->forceDelete();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Permanently Delete')
                    ->modalDescription('Are you sure you want to permanently delete this item? This action cannot be undone.')
                    ->color('danger'),
                Tables\Actions\ViewAction::make()
                    ->modalHeading('View Deleted Item')
                    ->modalWidth('4xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('restore_selected')
                        ->label('Restore Selected')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->restore();
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Restore Selected Items')
                        ->modalDescription('Are you sure you want to restore all selected items?')
                        ->color('success'),
                    Tables\Actions\BulkAction::make('force_delete_selected')
                        ->label('Delete Permanently')
                        ->icon('heroicon-o-x-mark')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->forceDelete();
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Permanently Delete Selected')
                        ->modalDescription('Are you sure you want to permanently delete all selected items? This action cannot be undone.')
                        ->color('danger'),
                ]),
            ])
            ->emptyStateHeading('Trash is Empty')
            ->emptyStateDescription('No deleted items found. Items will appear here when they are soft-deleted.')
            ->emptyStateIcon('heroicon-o-trash')
            ->defaultSort('deleted_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrashBin::route('/'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('manage_trash') ?? false;
    }

    public static function canCreate(): bool
    {
        return false; // No creating in trash
    }

    public static function canEdit($record): bool
    {
        return false; // No editing in trash
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('manage_trash') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('manage_trash') ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->onlyTrashed();
    }
}