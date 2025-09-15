{{-- Filament Pulse Dashboard --}}
<x-filament-panels::page>
    <div class="pulse-dashboard space-y-6">
        {{-- Performance Overview Cards --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Response Time</p>
                        <p class="text-lg font-semibold text-gray-900" id="avg-response-time">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Throughput</p>
                        <p class="text-lg font-semibold text-gray-900" id="throughput">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 18.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Slow Queries</p>
                        <p class="text-lg font-semibold text-gray-900" id="slow-queries">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Exceptions</p>
                        <p class="text-lg font-semibold text-gray-900" id="exceptions">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pulse Dashboard iframe --}}
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Laravel Pulse Dashboard</h3>
                    <div class="flex items-center space-x-2">
                        <button 
                            onclick="refreshPulseDashboard()" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300  text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh
                        </button>
                        <a 
                            href="{{ route('pulse') }}" 
                            target="_blank"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Open Full Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-0">
                <iframe 
                    id="pulse-iframe"
                    src="{{ route('pulse') }}" 
                    class="w-full border-0"
                    style="min-height: 800px;"
                    onload="adjustIframeHeight(this)"
                ></iframe>
            </div>
        </div>

        {{-- Performance Tips --}}
        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Performance Optimization Tips</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Monitor slow queries and optimize database indexes</li>
                            <li>Use caching for frequently accessed data</li>
                            <li>Keep an eye on exception rates and resolve issues promptly</li>
                            <li>Monitor user activity patterns to optimize resource allocation</li>
                            <li>Set up alerts for performance threshold breaches</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshPulseDashboard() {
            const iframe = document.getElementById('pulse-iframe');
            iframe.src = iframe.src;
            
            // Show loading state
            const cards = ['avg-response-time', 'throughput', 'slow-queries', 'exceptions'];
            cards.forEach(id => {
                document.getElementById(id).textContent = 'Loading...';
            });
            
            // Simulate data refresh (in real implementation, you'd fetch actual data)
            setTimeout(() => {
                document.getElementById('avg-response-time').textContent = Math.floor(Math.random() * 200 + 50) + 'ms';
                document.getElementById('throughput').textContent = Math.floor(Math.random() * 500 + 100) + ' req/min';
                document.getElementById('slow-queries').textContent = Math.floor(Math.random() * 10);
                document.getElementById('exceptions').textContent = Math.floor(Math.random() * 5);
            }, 1000);
        }

        function adjustIframeHeight(iframe) {
            try {
                iframe.style.height = Math.max(800, iframe.contentWindow.document.body.scrollHeight) + 'px';
            } catch (e) {
                // Cross-origin restrictions - keep default height
                iframe.style.height = '800px';
            }
        }

        // Initial load of mock data
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.getElementById('avg-response-time').textContent = Math.floor(Math.random() * 200 + 50) + 'ms';
                document.getElementById('throughput').textContent = Math.floor(Math.random() * 500 + 100) + ' req/min';
                document.getElementById('slow-queries').textContent = Math.floor(Math.random() * 10);
                document.getElementById('exceptions').textContent = Math.floor(Math.random() * 5);
            }, 500);
        });

        // Auto-refresh every 30 seconds
        setInterval(refreshPulseDashboard, 30000);
    </script>
</x-filament-panels::page>