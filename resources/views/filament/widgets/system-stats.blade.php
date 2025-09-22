<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            System Overview
        </x-slot>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <x-heroicon-m-users class="w-4 h-4 mr-2 text-gray-500" />
                        Total Users
                    </span>
                    <span class="text-sm font-semibold">{{ $totalUsers }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <x-heroicon-m-document-text class="w-4 h-4 mr-2 text-gray-500" />
                        Blog Posts
                    </span>
                    <span class="text-sm font-semibold">{{ $totalBlogs }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center ml-6">
                        <x-heroicon-m-eye class="w-4 h-4 mr-2 text-green-500" />
                        Published
                    </span>
                    <span class="text-sm font-semibold text-green-600">{{ $publishedBlogs }}</span>
                </div>
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <x-heroicon-m-cube class="w-4 h-4 mr-2 text-gray-500" />
                        Products
                    </span>
                    <span class="text-sm font-semibold">{{ $totalProducts }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <x-heroicon-m-tag class="w-4 h-4 mr-2 text-gray-500" />
                        Categories
                    </span>
                    <span class="text-sm font-semibold">{{ $totalCategories }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <span class="text-sm text-gray-600 flex items-center">
                        <x-heroicon-m-question-mark-circle class="w-4 h-4 mr-2 text-gray-500" />
                        FAQ Items
                    </span>
                    <span class="text-sm font-semibold">{{ $totalFaqs }}</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>