<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\PermissionResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationGroup = 'User Management';
    
    protected static ?string $navigationLabel = 'Permissions';
    
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Permission Information')
                    ->description('Configure the permission name and description')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->rules(['alpha_dash:ascii'])
                            ->helperText('Permission name must be unique and use underscores (e.g., "edit_posts", "manage_users"). Use lowercase letters, numbers, and underscores only.')
                            ->placeholder('e.g. view_products'),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Optional description explaining what this permission allows users to do.')
                            ->placeholder('Describe what this permission grants access to...'),

                        Forms\Components\Select::make('guard_name')
                            ->options([
                                'web' => 'Web',
                                'api' => 'API',
                            ])
                            ->default('web')
                            ->required()
                            ->helperText('Choose the guard this permission applies to. Most permissions use "web".'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Permission Grouping')
                    ->description('Categorize this permission for better organization')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->options([
                                'blog' => 'Blog Management',
                                'product' => 'Product Management',
                                'media' => 'Media Management',
                                'user' => 'User Management',
                                'contact' => 'Contact Management',
                                'analytics' => 'Analytics',
                                'hr' => 'HR Management',
                                'system' => 'System Settings',
                                'category' => 'Category Management',
                                'document' => 'Document Management',
                                'faq' => 'FAQ Management',
                                'quote' => 'Quote Management',
                                'other' => 'Other',
                            ])
                            ->searchable()
                            ->helperText('Select a category to group related permissions together')
                            ->nullable(),

                        Forms\Components\Select::make('action_type')
                            ->options([
                                'view' => 'View/Read',
                                'create' => 'Create',
                                'edit' => 'Edit/Update',
                                'delete' => 'Delete',
                                'publish' => 'Publish/Manage Status',
                                'manage' => 'Full Management',
                                'system' => 'System Action',
                            ])
                            ->helperText('Select the type of action this permission grants')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->description(fn (Permission $record): ?string => $record->description),

                Tables\Columns\TextColumn::make('category')
                    ->label('Category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'blog' => 'blue',
                        'product' => 'green',
                        'media' => 'purple',
                        'user' => 'orange',
                        'contact' => 'pink',
                        'system' => 'red',
                        default => 'gray',
                    })
                    ->getStateUsing(function (Permission $record): string {
                        // Extract category from permission name
                        $name = $record->name;
                        if (str_contains($name, 'blog')) return 'blog';
                        if (str_contains($name, 'product')) return 'product';
                        if (str_contains($name, 'media')) return 'media';
                        if (str_contains($name, 'user')) return 'user';
                        if (str_contains($name, 'contact')) return 'contact';
                        if (str_contains($name, 'visitor') || str_contains($name, 'review')) return 'analytics';
                        if (str_contains($name, 'career') || str_contains($name, 'application')) return 'hr';
                        if (str_contains($name, 'setting') || str_contains($name, 'log')) return 'system';
                        if (str_contains($name, 'categor')) return 'category';
                        if (str_contains($name, 'document')) return 'document';
                        if (str_contains($name, 'faq')) return 'faq';
                        if (str_contains($name, 'quote')) return 'quote';
                        return 'other';
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'blog' => 'Blog',
                        'product' => 'Product',
                        'media' => 'Media',
                        'user' => 'User',
                        'contact' => 'Contact',
                        'analytics' => 'Analytics',
                        'hr' => 'HR',
                        'system' => 'System',
                        'category' => 'Category',
                        'document' => 'Document',
                        'faq' => 'FAQ',
                        'quote' => 'Quote',
                        default => 'Other',
                    }),

                Tables\Columns\TextColumn::make('action_type')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'view' => 'info',
                        'create' => 'success',
                        'edit' => 'warning',
                        'delete' => 'danger',
                        'publish' => 'purple',
                        'manage' => 'orange',
                        default => 'gray',
                    })
                    ->getStateUsing(function (Permission $record): string {
                        $name = $record->name;
                        if (str_starts_with($name, 'view_')) return 'view';
                        if (str_starts_with($name, 'create_')) return 'create';
                        if (str_starts_with($name, 'edit_')) return 'edit';
                        if (str_starts_with($name, 'delete_')) return 'delete';
                        if (str_starts_with($name, 'publish_')) return 'publish';
                        if (str_starts_with($name, 'manage_')) return 'manage';
                        if (str_starts_with($name, 'upload_')) return 'create';
                        if (str_starts_with($name, 'assign_')) return 'manage';
                        return 'other';
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'view' => 'View',
                        'create' => 'Create',
                        'edit' => 'Edit',
                        'delete' => 'Delete',
                        'publish' => 'Publish',
                        'manage' => 'Manage',
                        default => 'Other',
                    }),

                Tables\Columns\TextColumn::make('roles_count')
                    ->label('Used by Roles')
                    ->badge()
                    ->state(fn (Permission $record): string => $record->roles->count())
                    ->color(fn (Permission $record): string => match (true) {
                        $record->roles->count() === 0 => 'gray',
                        $record->roles->count() <= 2 => 'success',
                        $record->roles->count() <= 4 => 'warning',
                        default => 'danger'
                    }),

                Tables\Columns\TextColumn::make('guard_name')
                    ->label('Guard')
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'blog' => 'Blog Management',
                        'product' => 'Product Management',
                        'media' => 'Media Management',
                        'user' => 'User Management',
                        'contact' => 'Contact Management',
                        'analytics' => 'Analytics',
                        'hr' => 'HR Management',
                        'system' => 'System Settings',
                        'category' => 'Category Management',
                        'document' => 'Document Management',
                        'faq' => 'FAQ Management',
                        'quote' => 'Quote Management',
                        'other' => 'Other',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        return $query->where(function (Builder $query) use ($data) {
                            foreach ($data['values'] as $category) {
                                match ($category) {
                                    'blog' => $query->orWhere('name', 'like', '%blog%'),
                                    'product' => $query->orWhere('name', 'like', '%product%'),
                                    'media' => $query->orWhere('name', 'like', '%media%'),
                                    'user' => $query->orWhere('name', 'like', '%user%'),
                                    'contact' => $query->orWhere('name', 'like', '%contact%'),
                                    'analytics' => $query->orWhere('name', 'like', '%visitor%')->orWhere('name', 'like', '%review%'),
                                    'hr' => $query->orWhere('name', 'like', '%career%')->orWhere('name', 'like', '%application%'),
                                    'system' => $query->orWhere('name', 'like', '%setting%')->orWhere('name', 'like', '%log%'),
                                    'category' => $query->orWhere('name', 'like', '%categor%'),
                                    'document' => $query->orWhere('name', 'like', '%document%'),
                                    'faq' => $query->orWhere('name', 'like', '%faq%'),
                                    'quote' => $query->orWhere('name', 'like', '%quote%'),
                                    default => null,
                                };
                            }
                        });
                    })
                    ->multiple(),

                Tables\Filters\SelectFilter::make('action_type')
                    ->options([
                        'view' => 'View/Read',
                        'create' => 'Create',
                        'edit' => 'Edit/Update',
                        'delete' => 'Delete',
                        'publish' => 'Publish/Manage Status',
                        'manage' => 'Full Management',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['values'])) {
                            return $query;
                        }

                        return $query->where(function (Builder $query) use ($data) {
                            foreach ($data['values'] as $action) {
                                match ($action) {
                                    'view' => $query->orWhere('name', 'like', 'view_%'),
                                    'create' => $query->orWhere('name', 'like', 'create_%')->orWhere('name', 'like', 'upload_%'),
                                    'edit' => $query->orWhere('name', 'like', 'edit_%'),
                                    'delete' => $query->orWhere('name', 'like', 'delete_%'),
                                    'publish' => $query->orWhere('name', 'like', 'publish_%'),
                                    'manage' => $query->orWhere('name', 'like', 'manage_%')->orWhere('name', 'like', 'assign_%'),
                                    default => null,
                                };
                            }
                        });
                    })
                    ->multiple(),

                Tables\Filters\Filter::make('unused')
                    ->query(fn (Builder $query): Builder => $query->doesntHave('roles'))
                    ->label('Unused Permissions')
                    ->toggle(),

                Tables\Filters\SelectFilter::make('guard_name')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ])
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (Permission $record): bool => 
                            (auth()->user()?->can('delete_users') ?? false) && 
                            $record->roles->count() === 0
                        ),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            $records->each(function (Permission $record) {
                                if ($record->roles->count() === 0) {
                                    $record->delete();
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateHeading('No permissions found')
            ->emptyStateDescription('Create your first permission to start managing user access.')
            ->emptyStateIcon('heroicon-o-key')
            ->defaultSort('name', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'view' => Pages\ViewPermission::route('/{record}'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_users') ?? false;
    }
}