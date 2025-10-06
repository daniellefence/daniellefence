<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\JobApplicationResource\Pages\ListJobApplications;
use App\Filament\Resources\JobApplicationResource\Pages\CreateJobApplication;
use App\Filament\Resources\JobApplicationResource\Pages\ViewJobApplication;
use App\Filament\Resources\JobApplicationResource\Pages\EditJobApplication;
use App\Filament\Resources\JobApplicationResource\Pages;
use App\Filament\Resources\JobApplicationResource\RelationManagers;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | \UnitEnum | null $navigationGroup = 'Customers & Reviews';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('job_application_id')
                    ->numeric(),
                TextInput::make('job_position')
                    ->maxLength(191),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(191),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(191),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(191),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(191),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Applicant')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                TextColumn::make('job_position')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListJobApplications::route('/'),
            'create' => CreateJobApplication::route('/create'),
            'view' => ViewJobApplication::route('/{record}'),
            'edit' => EditJobApplication::route('/{record}/edit'),
        ];
    }
}
