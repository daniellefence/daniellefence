<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'User Management';
    
    protected static ?string $navigationLabel = 'Users';
    
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Information')
                ->description('Basic user account information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Full name of the user'),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Email address for login and notifications'),

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                        ->dehydrated(fn ($state) => filled($state))
                        ->minLength(8)
                        ->helperText('Minimum 8 characters. Leave blank to keep current password when editing.')
                        ->placeholder(fn ($context) => $context === 'edit' ? 'Leave blank to keep current password' : 'Enter password'),

                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->label('Email Verified At')
                        ->helperText('When the user verified their email address. Leave blank for unverified accounts.')
                        ->nullable(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Roles & Permissions')
                ->description('Assign roles to grant specific permissions to this user')
                ->schema([
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->helperText('Select one or more roles to assign to this user. Roles determine what the user can access.')
                        ->options(Role::all()->pluck('name', 'id'))
                        ->getOptionLabelFromRecordUsing(fn (Role $record): string => 
                            $record->name . ' (' . $record->permissions->count() . ' permissions)'
                        )
                        ->columnSpanFull(),

                    Forms\Components\Placeholder::make('permissions_info')
                        ->label('Permissions Preview')
                        ->content(function (Forms\Get $get) {
                            $roleIds = $get('roles') ?? [];
                            if (empty($roleIds)) {
                                return 'No roles selected - user will have no permissions.';
                            }
                            
                            $roles = Role::whereIn('id', $roleIds)->with('permissions')->get();
                            $allPermissions = $roles->flatMap(fn($role) => $role->permissions)->unique('id');
                            
                            if ($allPermissions->isEmpty()) {
                                return 'Selected roles have no permissions assigned.';
                            }

                            $permissionGroups = $allPermissions->groupBy(function ($permission) {
                                $parts = explode('_', $permission->name, 2);
                                return isset($parts[1]) ? ucfirst($parts[1]) : 'Other';
                            });

                            $preview = [];
                            foreach ($permissionGroups as $group => $permissions) {
                                $permissionNames = $permissions->pluck('name')->sort()->implode(', ');
                                $preview[] = "<strong>{$group}:</strong> {$permissionNames}";
                            }

                            return new \Illuminate\Support\HtmlString(implode('<br>', $preview));
                        })
                        ->columnSpanFull()
                        ->visible(fn (Forms\Get $get) => !empty($get('roles'))),
                ])
                ->collapsible()
                ->collapsed(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('roles.name')
                    ->badge()
                    ->label('Roles')
                    ->separator(', ')
                    ->color(fn (string $state): string => match ($state) {
                        'Super Admin' => 'danger',
                        'Admin' => 'warning',
                        'Editor' => 'info',
                        'Author' => 'success',
                        'Viewer' => 'gray',
                        default => 'primary',
                    }),

                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Permissions')
                    ->badge()
                    ->state(function (User $record): int {
                        return $record->getAllPermissions()->count();
                    })
                    ->color('info')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\Filter::make('email_verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Email Verified')
                    ->toggle(),

                Tables\Filters\Filter::make('email_unverified')
                    ->query(fn (Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->label('Email Unverified')
                    ->toggle(),

                Tables\Filters\Filter::make('created_last_week')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subWeek()))
                    ->label('Created Last Week'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('verify_email')
                        ->icon('heroicon-o-check-badge')
                        ->action(fn (User $record) => $record->markEmailAsVerified())
                        ->requiresConfirmation()
                        ->visible(fn (User $record) => !$record->hasVerifiedEmail())
                        ->color('success'),
                    Tables\Actions\Action::make('unverify_email')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn (User $record) => $record->update(['email_verified_at' => null]))
                        ->requiresConfirmation()
                        ->visible(fn (User $record) => $record->hasVerifiedEmail())
                        ->color('danger'),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (User $record) => auth()->id() !== $record->id), // Can't delete yourself
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify_emails')
                        ->label('Verify Emails')
                        ->icon('heroicon-o-check-badge')
                        ->action(fn ($records) => $records->each(fn($user) => $user->markEmailAsVerified()))
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            // Prevent deleting the current user
                            $records->filter(fn($user) => auth()->id() !== $user->id)->each->delete();
                        }),
                ]),
            ])
            ->emptyStateHeading('No users found')
            ->emptyStateDescription('Create your first user account to get started.')
            ->emptyStateIcon('heroicon-o-users')
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
            'index' => Pages\ListUserResource::route('/'),
            'create' => Pages\CreateUserResource::route('/create'),
            'view' => Pages\ViewUserResource::route('/{record}'),
            'edit' => Pages\EditUserResource::route('/{record}/edit'),
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
