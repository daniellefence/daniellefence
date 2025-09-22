@php
    $sitemapPath = public_path('sitemap.xml');
    $exists = file_exists($sitemapPath);
    $lastModified = $exists ? filemtime($sitemapPath) : null;
    $size = $exists ? filesize($sitemapPath) : 0;

    // Count URLs if file exists
    $urlCount = 0;
    if ($exists) {
        try {
            $content = file_get_contents($sitemapPath);
            $urlCount = substr_count($content, '<url>');
        } catch (\Exception $e) {
            // Ignore errors
        }
    }
@endphp

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <x-icon.map class="h-6 w-6 text-gray-400"/>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Sitemap.xml Status
                    </dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900">
                            @if($exists)
                                <span class="text-green-600">{{ number_format($urlCount) }} URLs</span>
                            @else
                                <span class="text-red-600">Missing</span>
                            @endif
                        </div>
                        @if($exists && $lastModified)
                            <div class="ml-2 flex items-baseline text-sm text-gray-600">
                                Updated {{ \Carbon\Carbon::createFromTimestamp($lastModified)->diffForHumans() }}
                            </div>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="bg-gray-50 px-5 py-3">
        <div class="text-sm">
            <div class="flex justify-between items-center">
                <div class="text-gray-600">
                    @if($exists)
                        File size: {{ number_format($size) }} bytes
                        @if($urlCount > 0)
                            • {{ $urlCount }} URLs indexed
                        @endif
                    @else
                        No sitemap found
                    @endif
                </div>
                <div class="flex gap-3">
                    <a href="{{ url('/sitemap.xml') }}" target="_blank" class="font-medium text-blue-600 hover:text-blue-500">
                        View Sitemap
                    </a>
                    <a href="{{ route('admin.sitemap.read') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        Edit
                    </a>
                    @if($exists && $urlCount > 0)
                        <span class="text-green-600 text-xs">✓ Active</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>