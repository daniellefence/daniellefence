<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\QuoteRequest;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Models\Activity;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = '30s';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getRecentActivitiesQuery())
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Activity')
                    ->searchable()
                    ->formatStateUsing(function (string $state, $record) {
                        $icon = $this->getActivityIcon($record->log_name);
                        return $icon . ' ' . $state;
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state) => class_basename($state))
                    ->badge()
                    ->color(fn (string $state) => match (class_basename($state)) {
                        'QuoteRequest' => 'success',
                        'Contact' => 'warning',
                        'Blog' => 'info',
                        'User' => 'primary',
                        'Product' => 'secondary',
                        default => 'gray'
                    }),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('System')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50])
            ->heading('Recent Activity Feed')
            ->description('Latest system activities and user actions');
    }

    protected function getRecentActivitiesQuery(): Builder
    {
        return Activity::query()
            ->with(['causer', 'subject'])
            ->latest()
            ->limit(100);
    }

    private function getActivityIcon(string $logName): string
    {
        return match ($logName) {
            'created' => '<span class="text-green-600">📝</span>',
            'updated' => '<span class="text-blue-600">✏️</span>',
            'deleted' => '<span class="text-red-600">🗑️</span>',
            'restored' => '<span class="text-green-600">♻️</span>',
            'login' => '<span class="text-purple-600">🔐</span>',
            'logout' => '<span class="text-gray-600">🚪</span>',
            default => '<span class="text-gray-600">📄</span>',
        };
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_activity_log') ?? false;
    }
}