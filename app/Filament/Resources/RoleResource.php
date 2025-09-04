<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\RoleResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    
    protected static ?string $navigationGroup = 'User Management';
    
    protected static ?string $navigationLabel = 'Roles';
    
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Role Information')
                    ->description('Configure the role name and description')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Role name must be unique. Use descriptive names like "Editor" or "Content Manager".')
                            ->placeholder('e.g. Content Editor'),

                        Forms\Components\Textarea::make('description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Optional description explaining what this role is for and what access it provides.')
                            ->placeholder('Describe the purpose and scope of this role...'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Permissions')
                    ->description('Select which permissions this role should have')
                    ->schema([
                        Forms\Components\CheckboxList::make('permissions')
                            ->relationship('permissions', 'name')
                            ->searchable()
                            ->columns(2)
                            ->gridDirection('row')
                            ->options(function () {
                                return Permission::all()->groupBy(function ($permission) {
                                    // Group permissions by their prefix (e.g., 'view_', 'create_', etc.)
                                    $parts = explode('_', $permission->name, 2);
                                    return isset($parts[1]) ? ucfirst($parts[1]) : 'Other';
                                })->map(function ($permissions, $group) {
                                    return $permissions->pluck('name', 'name');
                                })->toArray();
                            })
                            ->descriptions(function () {
                                $descriptions = [
                                    // Blog permissions
                                    'view_blogs' => 'View blog posts in admin panel',
                                    'create_blogs' => 'Create new blog posts',
                                    'edit_blogs' => 'Edit existing blog posts',
                                    'delete_blogs' => 'Delete blog posts',
                                    'publish_blogs' => 'Publish/unpublish blog posts',

                                    // Product permissions
                                    'view_products' => 'View products in admin panel',
                                    'create_products' => 'Create new products',
                                    'edit_products' => 'Edit existing products',
                                    'delete_products' => 'Delete products',
                                    'publish_products' => 'Publish/unpublish products',

                                    // Media permissions
                                    'view_media' => 'View media library',
                                    'upload_media' => 'Upload new media files',
                                    'edit_media' => 'Edit media information and metadata',
                                    'delete_media' => 'Delete media files',

                                    // User permissions
                                    'view_users' => 'View user accounts',
                                    'create_users' => 'Create new user accounts',
                                    'edit_users' => 'Edit user information',
                                    'delete_users' => 'Delete user accounts',
                                    'assign_roles' => 'Assign roles to users',

                                    // Contact permissions
                                    'view_contacts' => 'View contact submissions',
                                    'create_contacts' => 'Create new contacts',
                                    'edit_contacts' => 'Edit contact information',
                                    'delete_contacts' => 'Delete contacts',

                                    // System permissions
                                    'manage_settings' => 'Access system settings and configuration',
                                    'view_activity_logs' => 'View system activity and audit logs',
                                    'view_visitors' => 'View visitor analytics',
                                    'view_reviews' => 'View customer reviews',
                                ];

                                return $descriptions;
                            })
                            ->helperText('Select the specific permissions this role should have. Permissions are grouped by functionality.')
                    ])
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
                    ->description(fn (Role $record): ?string => $record->description),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->badge()
                    ->state(fn (Role $record): string => $record->permissions->count())
                    ->color('info'),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Users')
                    ->badge()
                    ->state(fn (Role $record): string => $record->users->count())
                    ->color(fn (Role $record): string => match (true) {
                        $record->users->count() === 0 => 'gray',
                        $record->users->count() <= 5 => 'success',
                        $record->users->count() <= 10 => 'warning',
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

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_users')
                    ->query(fn (Builder $query): Builder => $query->has('users'))
                    ->label('Has Users')
                    ->toggle(),

                Tables\Filters\Filter::make('no_users')
                    ->query(fn (Builder $query): Builder => $query->doesntHave('users'))
                    ->label('No Users')
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('duplicate')
                        ->icon('heroicon-o-document-duplicate')
                        ->form([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label('New Role Name')
                                ->helperText('Enter a name for the duplicated role'),
                        ])
                        ->action(function (Role $record, array $data): void {
                            $newRole = Role::create([
                                'name' => $data['name'],
                                'guard_name' => $record->guard_name,
                                'description' => $record->description,
                            ]);
                            
                            $newRole->syncPermissions($record->permissions);
                        })
                        ->successNotificationTitle('Role duplicated successfully')
                        ->visible(fn (): bool => auth()->user()?->can('create', Role::class) ?? false),
                    
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (Role $record): bool => 
                            (auth()->user()?->can('delete', Role::class) ?? false) && 
                            $record->users->count() === 0
                        ),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            $records->each(function (Role $record) {
                                if ($record->users->count() === 0) {
                                    $record->delete();
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateHeading('No roles found')
            ->emptyStateDescription('Create your first role to start managing user permissions.')
            ->emptyStateIcon('heroicon-o-shield-check')
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
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