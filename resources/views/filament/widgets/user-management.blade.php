@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            User Management Overview
        </x-slot>

        <x-slot name="description">
            User statistics, roles, and recent activity
        </x-slot>

        <div class="space-y-6">
            {{-- User Statistics --}}
            <div class="grid gap-4 md:grid-cols-4">
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-blue-900">{{ $data['stats']['total'] }}</p>
                            <p class="text-sm text-blue-600">Total Users</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-green-900">{{ $data['stats']['active'] }}</p>
                            <p class="text-sm text-green-600">Active Users</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-purple-900">{{ $data['stats']['online'] }}</p>
                            <p class="text-sm text-purple-600">Online Now</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <div class="ml-3">
                            <p class="text-2xl font-bold text-orange-900">{{ $data['stats']['applications'] }}</p>
                            <p class="text-sm text-orange-600">Job Applications</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User Activity --}}
            <div class="grid gap-4 md:grid-cols-3">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Login Activity</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Today</span>
                            <span class="font-medium">{{ $data['user_activity']['today'] }} users</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">This Week</span>
                            <span class="font-medium">{{ $data['user_activity']['week'] }} users</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">This Month</span>
                            <span class="font-medium">{{ $data['user_activity']['month'] }} users</span>
                        </div>
                    </div>
                </div>

                {{-- Role Distribution --}}
                <div class="p-4 border border-gray-200 rounded-lg md:col-span-2">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Role Distribution</h4>
                    <div class="grid gap-2 grid-cols-2 lg:grid-cols-4">
                        @foreach($data['roles'] as $role)
                            <div class="flex items-center p-2 bg-{{ $role['color'] }}-50 border border-{{ $role['color'] }}-200 rounded">
                                <div class="w-3 h-3 bg-{{ $role['color'] }}-500 rounded-full mr-2"></div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-{{ $role['color'] }}-900">{{ $role['name'] }}</p>
                                    <p class="text-xs text-{{ $role['color'] }}-600">{{ $role['count'] }} users</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Recent Users --}}
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900">Recently Registered Users</h4>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($data['recent_users'] as $user)
                        <div class="px-4 py-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($user['is_online'])
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    @else
                                        <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $user['name'] }}</p>
                                    <p class="text-xs text-gray-600">{{ $user['email'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Joined {{ $user['joined'] }}</p>
                                <p class="text-xs text-gray-400">Last login: {{ $user['last_login'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                <p class="text-xs text-gray-500">Last updated: {{ now()->format('M j, Y g:i A') }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Auto-refresh: 2min
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>