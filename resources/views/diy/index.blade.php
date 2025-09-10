<x-app-layout>
<div class="bg-gray-50">
    {{-- Hero Section --}}
    <div class="bg-gradient-to-br from-[#8e2a2a] to-[#7a2525] text-white w-full p-10">
        <div class="container mx-auto aspect-video flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">DIY Fence Installation</h1>
                <p class="text-xl mb-8">Professional-grade fencing materials for the do-it-yourself installer</p>
            </div>
        </div>
        
    </div>

    {{-- Product Grid --}}
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8">Available DIY Products</h2>
        
        @if($products->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <i class="fas fa-tools text-6xl text-gray-400 mb-4"></i>
                <p class="text-xl text-gray-600 mb-4">
                    We're currently updating our DIY product catalog.
                </p>
                <p class="text-gray-500">
                    Please check back soon or contact us directly at (863) 425-3182
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        @if($product->featured_image)
                            <img src="{{ $product->featured_image }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-4xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2">{{ $product->name }}</h3>
                            
                            @if($product->description)
                                <p class="text-gray-600 mb-4">
                                    {{ Str::limit($product->description, 100) }}
                                </p>
                            @endif
                            
                            {{-- Special 8' fence note --}}
                            @if(str_contains(strtolower($product->name), '8') || str_contains(strtolower($product->name), 'eight'))
                                <div class="bg-blue-50 p-3 rounded mb-4">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Note: For 8' tall fences, middle rail is not centered
                                    </p>
                                </div>
                            @endif
                            
                            @if($product->base_price)
                                <p class="text-2xl font-bold text-red-800 mb-4">
                                    Starting at ${{ number_format($product->base_price, 2) }}
                                </p>
                            @endif
                            
                            <a href="{{ route('diy.product', $product->slug) }}" 
                               class="block w-full text-center bg-red-800 text-white py-3 rounded hover:bg-red-900 transition">
                                View Details & Order
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- DIY Resources Section --}}
    <div class="bg-white py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8">DIY Resources</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('diy.guide', 'aluminum') }}" 
                   class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-file-pdf text-3xl text-red-800 mb-4"></i>
                    <h3 class="font-bold mb-2">Aluminum Fence Guide</h3>
                    <p class="text-sm text-gray-600">Step-by-step installation instructions</p>
                </a>
                
                <a href="{{ route('diy.guide', 'vinyl') }}" 
                   class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-file-pdf text-3xl text-red-800 mb-4"></i>
                    <h3 class="font-bold mb-2">Vinyl Fence Guide</h3>
                    <p class="text-sm text-gray-600">Complete DIY installation manual</p>
                </a>
                
                <a href="{{ route('diy.guide', 'gate') }}" 
                   class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-door-open text-3xl text-red-800 mb-4"></i>
                    <h3 class="font-bold mb-2">Gate Installation</h3>
                    <p class="text-sm text-gray-600">How to install gates properly</p>
                </a>
                
                <a href="{{ route('diy.easy-fixes') }}" 
                   class="bg-gray-50 p-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-tools text-3xl text-red-800 mb-4"></i>
                    <h3 class="font-bold mb-2">Easy Fixes</h3>
                    <p class="text-sm text-gray-600">Common fence repairs made simple</p>
                </a>
            </div>
        </div>
    </div>

    {{-- Process Section --}}
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">How DIY Ordering Works</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-red-800 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">1</span>
                    </div>
                    <h3 class="font-bold mb-2">Choose Your Product</h3>
                    <p class="text-sm text-gray-600">Select from our DIY-friendly fence options</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-red-800 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">2</span>
                    </div>
                    <h3 class="font-bold mb-2">Specify Dimensions</h3>
                    <p class="text-sm text-gray-600">Enter your exact measurements and color choice</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-red-800 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">3</span>
                    </div>
                    <h3 class="font-bold mb-2">Place Your Order</h3>
                    <p class="text-sm text-gray-600">Submit your order and receive confirmation</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-red-800 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold">4</span>
                    </div>
                    <h3 class="font-bold mb-2">Pick Up & Install</h3>
                    <p class="text-sm text-gray-600">Collect your materials and start your project</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Contact Section --}}
    <div class="bg-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Need Help?</h2>
            <p class="text-xl text-gray-600 mb-8">
                Our experts are here to help you plan your DIY fence project
            </p>
            
            <div class="flex flex-col md:flex-row justify-center gap-6">
                <a href="tel:8634253182" 
                   class="inline-flex items-center justify-center bg-red-800 text-white px-8 py-3 rounded-lg hover:bg-red-900 transition">
                    <i class="fas fa-phone mr-2"></i>
                    Call (863) 425-3182
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center justify-center bg-gray-800 text-white px-8 py-3 rounded-lg hover:bg-gray-900 transition">
                    <i class="fas fa-envelope mr-2"></i>
                    Email Us
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Color Disclaimer Modal (optional) --}}
<div id="colorDisclaimer" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-8 max-w-md mx-4">
        <h3 class="text-xl font-bold mb-4">Important Color Notice</h3>
        <p class="text-gray-600 mb-6">
            The colors shown on this website are for reference only and may not accurately represent the actual product colors. 
            Screen settings, lighting conditions, and manufacturing variations can affect the appearance of colors.
        </p>
        <p class="text-gray-600 mb-6">
            We strongly recommend visiting our showroom or requesting physical samples before making your final selection.
        </p>
        <button onclick="document.getElementById('colorDisclaimer').classList.add('hidden')" 
                class="bg-red-800 text-white px-6 py-2 rounded hover:bg-red-900 transition">
            I Understand
        </button>
    </div>
</div>
<script>
    // Show color disclaimer on first visit
    if (!localStorage.getItem('colorDisclaimerShown')) {
        setTimeout(() => {
            document.getElementById('colorDisclaimer').classList.remove('hidden');
            localStorage.setItem('colorDisclaimerShown', 'true');
        }, 2000);
    }
</script>
</x-app-layout>
