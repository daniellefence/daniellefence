<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class UserManagementWidget extends Widget
{
    protected static string $view = 'filament.widgets.user-management';
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = '2m';

    public function getViewData(): array
    {
        return Cache::remember('user_management_widget', 120, function () {
            $totalUsers = User::count();
            $activeUsers = User::whereNotNull('email_verified_at')->count();
            $onlineUsers = User::where('last_login_at', '>=', now()->subMinutes(15))->count();
            
            return [
                'stats' => [
                    'total' => $totalUsers,
                    'active' => $activeUsers,
                    'online' => $onlineUsers,
                    'inactive' => $totalUsers - $activeUsers,
                    'applications' => Application::count(),
                    'pending_applications' => Application::where('status', 'pending')->count(),
                ],
                'roles' => $this->getRoleDistribution(),
                'recent_users' => $this->getRecentUsers(),
                'user_activity' => $this->getUserActivity(),
            ];
        });
    }

    private function getRoleDistribution(): array
    {
        $roles = Role::withCount('users')->get();
        $distribution = [];
        
        foreach ($roles as $role) {
            $distribution[] = [
                'name' => $role->name,
                'count' => $role->users_count,
                'color' => $this->getRoleColor($role->name),
            ];
        }
        
        return $distribution;
    }

    private function getRecentUsers(): array
    {
        return User::latest()
            ->take(5)
            ->get(['id', 'name', 'email', 'created_at', 'last_login_at'])
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'joined' => $user->created_at->diffForHumans(),
                    'last_login' => $user->last_login_at?->diffForHumans() ?? 'Never',
                    'is_online' => $user->last_login_at && $user->last_login_at->isAfter(now()->subMinutes(15)),
                ];
            })
            ->toArray();
    }

    private function getUserActivity(): array
    {
        $today = User::whereDate('last_login_at', today())->count();
        $week = User::where('last_login_at', '>=', now()->subWeek())->count();
        $month = User::where('last_login_at', '>=', now()->subMonth())->count();

        return [
            'today' => $today,
            'week' => $week,
            'month' => $month,
        ];
    }

    private function getRoleColor(string $roleName): string
    {
        return match (strtolower($roleName)) {
            'superadmin' => 'red',
            'owner' => 'purple',
            'human resources' => 'blue',
            'it' => 'green',
            'content writer' => 'yellow',
            'product manager' => 'orange',
            'marketing' => 'pink',
            'sales' => 'indigo',
            default => 'gray',
        };
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('view_users') ?? false;
    }
}