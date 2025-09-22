<x-filament-widgets::widget>
    <x-filament::section>
        @if($pulse_enabled)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Requests -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        📊 Recent Requests
                    </h3>
                    <div class="space-y-2">
                        @forelse($requests as $request)
                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-800 rounded">
                                <div>
                                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">
                                        {{ $request->key['method'] ?? 'GET' }}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $request->key['path'] ?? 'Unknown' }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-500">
                                    {{ $request->value ?? 0 }} hits
                                </span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No request data available</p>
                        @endforelse
                    </div>
                </div>

                <!-- Application Health -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        🏥 Application Health
                    </h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="font-medium text-green-800 dark:text-green-200">
                                    Pulse Monitoring Active
                                </span>
                            </div>
                            <p class="text-sm text-green-600 dark:text-green-300 mt-1">
                                Laravel Pulse is collecting application metrics
                            </p>
                        </div>

                        @if($exceptions->isNotEmpty())
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-red-800 dark:text-red-200">
                                        {{ $exceptions->count() }} Recent Exceptions
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if($slow_queries->isNotEmpty())
                            <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="font-medium text-yellow-800 dark:text-yellow-200">
                                        {{ $slow_queries->count() }} Slow Queries Detected
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-500">Monitoring</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                <a href="/pulse" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    View Full Pulse Dashboard →
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Pulse Metrics Unavailable
                </h3>
                <p class="text-gray-500">
                    @if(isset($error))
                        Error: {{ $error }}
                    @else
                        Laravel Pulse is not collecting data yet. Start the Pulse worker with: <code>php artisan pulse:work</code>
                    @endif
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>