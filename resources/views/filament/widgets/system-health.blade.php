@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            System Health Monitor
        </x-slot>

        <x-slot name="description">
            Real-time system health and performance indicators
        </x-slot>

        <div class="space-y-4">
            {{-- Services Status --}}
            <div class="grid gap-4 md:grid-cols-3">
                {{-- Database Status --}}
                <div class="flex items-center p-3 rounded-lg border {{ $data['database']['color'] === 'success' ? 'bg-green-50 border-green-200' : ($data['database']['color'] === 'warning' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200') }}">
                    <div class="flex-shrink-0">
                        @if($data['database']['color'] === 'success')
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Database</p>
                        <p class="text-xs text-gray-600">{{ $data['database']['message'] }}</p>
                    </div>
                </div>

                {{-- Cache Status --}}
                <div class="flex items-center p-3 rounded-lg border {{ $data['cache']['color'] === 'success' ? 'bg-green-50 border-green-200' : ($data['cache']['color'] === 'warning' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200') }}">
                    <div class="flex-shrink-0">
                        @if($data['cache']['color'] === 'success')
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Cache</p>
                        <p class="text-xs text-gray-600">{{ $data['cache']['message'] }}</p>
                    </div>
                </div>

                {{-- Storage Status --}}
                <div class="flex items-center p-3 rounded-lg border {{ $data['storage']['color'] === 'success' ? 'bg-green-50 border-green-200' : ($data['storage']['color'] === 'warning' ? 'bg-yellow-50 border-yellow-200' : 'bg-red-50 border-red-200') }}">
                    <div class="flex-shrink-0">
                        @if($data['storage']['color'] === 'success')
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Storage</p>
                        <p class="text-xs text-gray-600">{{ $data['storage']['message'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Resource Usage --}}
            <div class="grid gap-4 md:grid-cols-2">
                {{-- Memory Usage --}}
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-900">Memory Usage</h4>
                        <span class="text-xs px-2 py-1 rounded-full {{ $data['memory']['color'] === 'success' ? 'bg-green-100 text-green-800' : ($data['memory']['color'] === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $data['memory']['percent'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $data['memory']['color'] === 'success' ? 'bg-green-500' : ($data['memory']['color'] === 'warning' ? 'bg-yellow-500' : 'bg-red-500') }}" 
                             style="width: {{ min(100, $data['memory']['percent']) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">{{ $data['memory']['usage'] }} / {{ $data['memory']['limit'] }}</p>
                </div>

                {{-- Disk Usage --}}
                <div class="p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-sm font-medium text-gray-900">Disk Usage</h4>
                        <span class="text-xs px-2 py-1 rounded-full {{ $data['disk']['color'] === 'success' ? 'bg-green-100 text-green-800' : ($data['disk']['color'] === 'warning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $data['disk']['percent'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $data['disk']['color'] === 'success' ? 'bg-green-500' : ($data['disk']['color'] === 'warning' ? 'bg-yellow-500' : 'bg-red-500') }}" 
                             style="width: {{ min(100, $data['disk']['percent']) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-1">{{ $data['disk']['used'] }} / {{ $data['disk']['total'] }} ({{ $data['disk']['free'] }} free)</p>
                </div>
            </div>

            {{-- Last Updated --}}
            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                <p class="text-xs text-gray-500">Last updated: {{ now()->format('M j, Y g:i A') }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Auto-refresh: 30s
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>