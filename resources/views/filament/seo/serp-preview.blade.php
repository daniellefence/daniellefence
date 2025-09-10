<div class="space-y-4">
    <div class="text-sm text-gray-600 mb-4">
        This preview shows how your page might appear in Google search results. Actual results may vary based on the search query and Google's algorithms.
    </div>
    
    <div class="bg-white border border-gray-200 rounded-lg p-4 max-w-2xl">
        <!-- Breadcrumb/URL Display -->
        <div class="text-xs text-green-700 mb-1">
            {{ parse_url($url, PHP_URL_HOST) ?? 'yoursite.com' }} › {{ basename(parse_url($url, PHP_URL_PATH) ?? '/') }}
        </div>
        
        <!-- Title -->
        <h3 class="text-xl text-blue-600 hover:underline cursor-pointer mb-1 font-normal">
            {{ $title }}
        </h3>
        
        <!-- URL -->
        <div class="text-sm text-gray-600 mb-2">
            {{ $url }}
        </div>
        
        <!-- Description -->
        <p class="text-sm text-gray-700 leading-relaxed">
            {{ $description }}
        </p>
        
        <!-- Additional Elements (sitelinks, etc.) -->
        <div class="mt-3 text-xs text-gray-500">
            <div class="flex space-x-4">
                <span class="hover:underline cursor-pointer">About</span>
                <span class="hover:underline cursor-pointer">Services</span>
                <span class="hover:underline cursor-pointer">Contact</span>
                <span class="hover:underline cursor-pointer">Reviews</span>
            </div>
        </div>
    </div>
    
    <div class="text-xs text-gray-500 mt-4">
        <strong>Tips:</strong>
        <ul class="list-disc list-inside mt-1 space-y-1">
            <li>Keep titles between 50-60 characters for optimal display</li>
            <li>Write descriptions between 150-160 characters</li>
            <li>Include target keywords naturally in both title and description</li>
            <li>Make titles compelling to encourage clicks</li>
        </ul>
    </div>
</div>