<div class="text-center py-8">
    <div class="mx-auto w-24 h-24 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
        @php
            $fileTypeIcons = [
                'Image' => ['path' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'text-green-500'],
                'Video' => ['path' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'color' => 'text-purple-500'],
                'Audio' => ['path' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3', 'color' => 'text-blue-500'],
                'Document' => ['path' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'text-red-500'],
                'Archive' => ['path' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'text-yellow-500'],
                'Other' => ['path' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'text-gray-500'],
            ];
            
            $iconData = $fileTypeIcons[$type] ?? $fileTypeIcons['Other'];
        @endphp
        
        <svg class="w-12 h-12 {{ $iconData['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconData['path'] }}"></path>
        </svg>
    </div>
    
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
        {{ $type }} File
    </h3>
    
    <p class="text-gray-500 dark:text-gray-400 mb-4">
        {{ $record->file_name }}
    </p>
    
    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
        {{ $size }}
    </div>
    
    <div class="mt-6">
        <a href="{{ $url }}" 
           target="_blank"
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md  text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download File
        </a>
    </div>
</div>