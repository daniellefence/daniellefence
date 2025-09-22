<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Analytics Status Banner -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <x-heroicon-o-chart-bar class="h-8 w-8 text-blue-600" />
                </div>
                <div>
                    <h3 class="text-lg font-medium text-blue-900">Google Analytics Integration</h3>
                    <p class="text-blue-700">Configure and manage your website analytics tracking</p>
                </div>
            </div>
        </div>

        <!-- Configuration Form -->
        <form wire:submit="save">
            {{ $this->form }}

            <div class="flex justify-end mt-6">
                {{ $this->saveAction }}
            </div>
        </form>

        <!-- Analytics Insights Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Stats -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <x-heroicon-m-eye class="h-5 w-5 mr-2 text-gray-400" />
                    Website Traffic Overview
                </h3>
                <div class="text-center py-8 text-gray-500">
                    <x-heroicon-o-chart-pie class="h-12 w-12 mx-auto mb-3 text-gray-300" />
                    <p>Connect Google Analytics to see traffic data</p>
                    <p class="text-sm">Real-time visitor statistics will appear here</p>
                </div>
            </div>

            <!-- Integration Status -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <x-heroicon-m-cog-6-tooth class="h-5 w-5 mr-2 text-gray-400" />
                    Integration Status
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Google Analytics 4</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Pending Setup
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Google Tag Manager</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Optional
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">E-commerce Tracking</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Available
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Helpful Links -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <x-heroicon-m-book-open class="h-5 w-5 mr-2 text-gray-400" />
                Helpful Resources
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="https://analytics.google.com" target="_blank" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors">
                    <h4 class="font-medium text-gray-900">Google Analytics</h4>
                    <p class="text-sm text-gray-600 mt-1">Access your analytics dashboard</p>
                </a>
                <a href="https://tagmanager.google.com" target="_blank" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors">
                    <h4 class="font-medium text-gray-900">Tag Manager</h4>
                    <p class="text-sm text-gray-600 mt-1">Manage your tracking tags</p>
                </a>
                <a href="https://support.google.com/analytics" target="_blank" class="block p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors">
                    <h4 class="font-medium text-gray-900">Help Center</h4>
                    <p class="text-sm text-gray-600 mt-1">Analytics documentation</p>
                </a>
            </div>
        </div>
    </div>
</x-filament-panels::page>