<?php

namespace App\Filament\Resources;

use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ContactResource\Pages;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'CRM';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Information')->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('company')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(20),
                Forms\Components\Select::make('how_did_you_hear_about_us')
                    ->label('How did you hear about us?')
                    ->options([
                        'google_search' => 'Google Search',
                        'social_media' => 'Social Media',
                        'referral' => 'Referral',
                        'advertisement' => 'Advertisement',
                        'website' => 'Website',
                        'other' => 'Other',
                    ])
                    ->placeholder('Select option'),
            ])->columns(2),
            
            Forms\Components\Section::make('Message')->schema([
                Forms\Components\RichEditor::make('message')
                    ->columnSpanFull()
                    ->maxLength(2000),
            ]),
            
            Forms\Components\Section::make('Internal Notes')->schema([
                Forms\Components\Textarea::make('notes')
                    ->rows(4)
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ]),
            
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
                    ->maxFiles(10)
                    ->directory('contacts/images'),
                Forms\Components\FileUpload::make('documents')
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(10)
                    ->directory('contacts/documents'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('how_did_you_hear_about_us')
                    ->label('Source')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'google_search' => 'Google Search',
                        'social_media' => 'Social Media',
                        'referral' => 'Referral',
                        'advertisement' => 'Advertisement',
                        'website' => 'Website',
                        'other' => 'Other',
                        default => $state,
                    })
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->separator(',')
                    ->limit(3)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('how_did_you_hear_about_us')
                    ->label('Source')
                    ->options([
                        'google_search' => 'Google Search',
                        'social_media' => 'Social Media',
                        'referral' => 'Referral',
                        'advertisement' => 'Advertisement',
                        'website' => 'Website',
                        'other' => 'Other',
                    ])
                    ->multiple(),
                Tables\Filters\Filter::make('has_company')
                    ->query(fn ($query) => $query->whereNotNull('company'))
                    ->label('Has Company'),
                Tables\Filters\Filter::make('contacted_this_week')
                    ->query(fn ($query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
                    ->label('Contacted This Week'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactResource::route('/'),
            'create' => Pages\CreateContactResource::route('/create'),
            'view' => Pages\ViewContactResource::route('/{record}'),
            'edit' => Pages\EditContactResource::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view_contacts') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_contacts') ?? false;
    }

    public static function canEdit($record): bool
    {
        return auth()->user()?->can('edit_contacts') ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->can('delete_contacts') ?? false;
    }

    public static function canView($record): bool
    {
        return auth()->user()?->can('view_contacts') ?? false;
    }
}
