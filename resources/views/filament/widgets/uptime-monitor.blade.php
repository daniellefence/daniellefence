<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Site Status -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    🌐 Site Status
                </h3>
                <div class="space-y-3">
                    @foreach($sites as $name => $site)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 rounded-full {{ $site['status'] === 'up' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $name }}</p>
                                    <p class="text-sm text-gray-500">{{ $site['url'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium {{ $site['status'] === 'up' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $site['status'] === 'up' ? 'Online' : 'Offline' }}
                                </p>
                                @if($site['status'] === 'up')
                                    <p class="text-xs text-gray-500">
                                        {{ round($site['response_time'] * 1000) }}ms
                                    </p>
                                @else
                                    <p class="text-xs text-red-500">
                                        Code: {{ $site['status_code'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Last checked: {{ $sites[array_key_first($sites)]['checked_at']->diffForHumans() }}
                </p>
            </div>

            <!-- System Metrics -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    ⚙️ System Metrics
                </h3>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-500">Server Time</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $system['server_time'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-500">Memory Usage</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $system['memory_usage'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-500">PHP Version</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $system['php_version'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-500">Laravel</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $system['laravel_version'] }}</p>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                        <p class="text-sm text-gray-500">Disk Usage</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $system['disk_usage'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>