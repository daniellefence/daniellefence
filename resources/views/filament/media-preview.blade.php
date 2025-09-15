<div class="space-y-6">
    {{-- Header with file info --}}
    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
        <div class="space-y-1">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $name }}</h3>
            <div class="flex flex-wrap gap-2 text-sm text-gray-500 dark:text-gray-400">
                <span class="inline-flex items-center px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300">
                    {{ $collection }}
                </span>
                <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                    {{ $type ?? 'Unknown' }}
                </span>
                <span class="inline-flex items-center px-2 py-1 rounded-md bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300">
                    {{ $size ?? 'Unknown size' }}
                </span>
            </div>
        </div>
        
        <a href="{{ $url }}" 
           target="_blank" 
           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md  text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download
        </a>
    </div>

    {{-- Main preview area --}}
    <div class="flex justify-center">
        @php
            $isImage = str_starts_with($type ?? '', 'image/');
            $isVideo = str_starts_with($type ?? '', 'video/');
            $isAudio = str_starts_with($type ?? '', 'audio/');
            $isPdf = $type === 'application/pdf';
        @endphp

        @if($isImage)
            <div class="max-w-full">
                <img src="{{ $url }}" 
                     alt="{{ $alt ?? $name }}" 
                     class="max-w-full max-h-96 rounded-lg  {{ isset($fullPreview) && $fullPreview ? 'max-h-none' : '' }}" />
            </div>
        @elseif($isVideo)
            <div class="max-w-full">
                <video controls class="max-w-full max-h-96 rounded-lg  {{ isset($fullPreview) && $fullPreview ? 'max-h-none' : '' }}">
                    <source src="{{ $url }}" type="{{ $type }}">
                    Your browser does not support the video tag.
                </video>
            </div>
        @elseif($isAudio)
            <div class="w-full max-w-md">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Audio File</h4>
                    <audio controls class="w-full">
                        <source src="{{ $url }}" type="{{ $type }}">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        @elseif($isPdf)
            <div class="w-full">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 text-center mb-4">
                    <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">PDF Document</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Click download to view the PDF file</p>
                </div>
                @if(isset($fullPreview) && $fullPreview)
                    <iframe src="{{ $url }}" class="w-full h-96 rounded-lg border border-gray-200 dark:border-gray-700"></iframe>
                @endif
            </div>
        @else
            {{-- Generic file preview --}}
            <div class="w-full max-w-sm">
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 text-center">
                    <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        @php
                            $fileTypeIcons = [
                                'document' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                                'archive' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                                'default' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                            ];
                            
                            $iconPath = $fileTypeIcons['default'];
                            if (str_contains($type ?? '', 'zip') || str_contains($type ?? '', 'rar') || str_contains($type ?? '', 'tar')) {
                                $iconPath = $fileTypeIcons['archive'];
                            } elseif (str_contains($type ?? '', 'document') || str_contains($type ?? '', 'text') || str_contains($type ?? '', 'application')) {
                                $iconPath = $fileTypeIcons['document'];
                            }
                        @endphp
                        
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">{{ pathinfo($name, PATHINFO_EXTENSION) ? strtoupper(pathinfo($name, PATHINFO_EXTENSION)) : 'File' }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $type ?? 'Unknown file type' }}</p>
                    <p class="text-xs text-gray-400">Preview not available for this file type</p>
                </div>
            </div>
        @endif
    </div>

    {{-- Metadata section --}}
    @if($alt || $description)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Metadata</h4>
            <div class="space-y-2">
                @if($alt)
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Alt Text:</span>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $alt }}</p>
                    </div>
                @endif
                
                @if($description)
                    <div>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Description:</span>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $description }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
    
    {{-- File details --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">File Details</h4>
        <dl class="grid grid-cols-1 gap-2 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">File Name</dt>
                <dd class="text-sm text-gray-900 dark:text-white font-mono">{{ $record->file_name ?? $name }}</dd>
            </div>
            @if(isset($record) && $record->created_at)
                <div>
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Uploaded</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $record->created_at->format('M j, Y g:i A') }}</dd>
                </div>
            @endif
            @if(isset($record) && isset($record->custom_properties['width']) && isset($record->custom_properties['height']))
                <div>
                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Dimensions</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $record->custom_properties['width'] }} × {{ $record->custom_properties['height'] }} pixels</dd>
                </div>
            @endif
        </dl>
    </div>
</div>