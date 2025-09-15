<x-app-layout>

    {{-- Product Header --}}
    <div class="bg-gradient-to-r from-white to-brand-cream/30 ">
        <div class="container mx-auto px-4 py-6">
            <nav class="text-sm mb-4">
                <a href="{{ route('diy.index') }}" class="text-danielle hover:text-daniellealt">DIY Products</a>
                <span class="mx-2">/</span>
                <a href="{{ route('diy.index') }}" class="text-danielle hover:text-daniellealt">{{ $product->category->name ?? 'Products' }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $product->name }}</span>
            </nav>
            
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <p class="text-lg text-gray-600 mt-2">{{ $product->category->name ?? 'Fencing' }} Panel System</p>
                </div>
                @if($product->base_price)
                <div class="text-right">
                    <div class="text-3xl font-bold text-danielle">${{ number_format($product->base_price, 2) }}</div>
                    <div class="text-sm text-gray-600">per panel</div>
                </div>
                @endif
            </div>
            
            {{-- Special 8' fence notice --}}
            @if($railPositioning == 'not-centered')
                <div class="bg-gradient-to-r from-blue-50 to-brand-light/30 border border-blue-200 rounded-lg p-4 mt-4 ">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-blue-800 mb-1">Important: 8-Foot Fence Rail Positioning</h3>
                            <p class="text-blue-700">
                                For 8-foot tall fences, the middle rail is <strong>NOT</strong> centered in the panel. 
                                Please coordinate with our team for exact positioning specifications before installation.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Product Images & Description --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Product Images --}}
                <div class="space-y-4">
                    @if($product->getFirstMediaUrl())
                        <div class="aspect-[4/3] bg-gradient-to-br from-white to-brand-cream/30 rounded-lg  overflow-hidden">
                            <img src="{{ $product->getFirstMediaUrl() }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-brand-cream/20 rounded-lg  flex items-center justify-center">
                            <div class="text-center text-gray-400">
                                <i class="fas fa-image text-6xl mb-4"></i>
                                <p class="text-lg">Product image coming soon</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- What's Included in Standard Panel --}}
                <div class="bg-gradient-to-br from-green-50 to-white rounded-lg p-6  border border-green-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        What's Included in Each Panel
                    </h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Example components for Vinyl fence --}}
                        <div class="space-y-2">
                            <div class="flex items-center justify-between py-2 border-b border-green-200">
                                <span class="font-medium">Top Rail (1.5" x 5.5")</span>
                                <span class="text-green-700 font-semibold">1 piece</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-green-200">
                                <span class="font-medium">Bottom Rail (2" x 7")</span>
                                <span class="text-green-700 font-semibold">1 piece</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-green-200">
                                <span class="font-medium">Privacy Pickets</span>
                                <span class="text-green-700 font-semibold">13 pieces</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between py-2 border-b border-green-200">
                                <span class="font-medium">U-Channel</span>
                                <span class="text-green-700 font-semibold">2 pieces</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-green-200">
                                <span class="font-medium">Screws</span>
                                <span class="text-green-700 font-semibold">26 pieces</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="font-medium">Installation Instructions</span>
                                <span class="text-green-700 font-semibold">Included</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3 bg-gradient-to-r from-white to-brand-cream/20 rounded border border-green-300 ">
                        <p class="text-sm text-gray-700">
                            <strong>Panel Dimensions:</strong> 6' W x {{ $product->available_heights ? implode(', ', $product->available_heights) : '6' }}' H (height varies by selection)
                        </p>
                    </div>
                </div>

                {{-- Product Description --}}
                <div class="prose prose-lg max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900">Product Description</h2>
                    <div class="text-gray-700">
                        {{ $product->description }}
                    </div>
                </div>

                {{-- Gates Available --}}
                <div class="bg-gradient-to-br from-blue-50 to-white rounded-lg p-6  border border-blue-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-door-open text-blue-600 mr-3"></i>
                        Matching Gates Available
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-white to-brand-cream/20 p-4 rounded border ">
                            <h4 class="font-semibold text-gray-900">Single Walk Gate</h4>
                            <p class="text-sm text-gray-600 mt-1">3' or 4' wide opening</p>
                            <p class="text-blue-700 font-semibold mt-2">Starting at $199</p>
                        </div>
                        <div class="bg-gradient-to-br from-white to-brand-cream/20 p-4 rounded border ">
                            <h4 class="font-semibold text-gray-900">Double Drive Gate</h4>
                            <p class="text-sm text-gray-600 mt-1">8', 10', or 12' wide opening</p>
                            <p class="text-blue-700 font-semibold mt-2">Starting at $449</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Gates include hinges, latch hardware, and installation instructions
                    </p>
                </div>
            </div>

            {{-- Right Column: Ordering & Configuration --}}
            <div class="space-y-6">
                {{-- Panel Configuration --}}
                <div class="bg-gradient-to-br from-white to-brand-cream/30 p-6 rounded-lg  border-2 border-danielle/20">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Configure Your Order</h3>
                    
                    <form action="{{ route('diy.quote.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Panel Specifications --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 border-b pb-2">Panel Specifications</h4>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Height <span class="text-red-500">*</span>
                                </label>
                                <select name="height" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <option value="">Select Height</option>
                                    <option value="4'">4 feet</option>
                                    <option value="5'">5 feet</option>
                                    <option value="6'">6 feet (most common)</option>
                                    <option value="8'">8 feet</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Number of Panels <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="panels" required min="1" value="1" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                <p class="text-xs text-gray-500 mt-1">Each panel covers 6 linear feet</p>
                            </div>
                        </div>

                        {{-- Post Configuration --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 border-b pb-2">Post Requirements</h4>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Line Posts</label>
                                    <input type="number" name="line_posts" min="0" value="0" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <p class="text-xs text-gray-500">Between panels</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">End Posts</label>
                                    <input type="number" name="end_posts" min="0" value="2" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <p class="text-xs text-gray-500">Fence terminators</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Corner Posts</label>
                                    <input type="number" name="corner_posts" min="0" value="0" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <p class="text-xs text-gray-500">Direction changes</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Gate Posts</label>
                                    <input type="number" name="gate_posts" min="0" value="0" 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <p class="text-xs text-gray-500">For gates</p>
                                </div>
                            </div>
                        </div>

                        {{-- Post Cap Style --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Post Cap Style</label>
                            <select name="cap_style" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                <option value="flat">Flat Cap</option>
                                <option value="pyramid">Pyramid Cap</option>
                                <option value="ball">Ball Cap</option>
                                <option value="gothic">Gothic Cap</option>
                            </select>
                        </div>

                        {{-- Gates --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 border-b pb-2">Add Gates (Optional)</h4>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_walk_gate" value="1" class="mr-2 text-danielle">
                                    <span class="text-sm">Include Walk Gate (3' wide)</span>
                                </label>
                            </div>
                            
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="include_drive_gate" value="1" class="mr-2 text-danielle">
                                    <span class="text-sm">Include Drive Gate</span>
                                </label>
                                <select name="drive_gate_width" class="w-full mt-2 border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                    <option value="">Select Width</option>
                                    <option value="8'">8 feet</option>
                                    <option value="10'">10 feet</option>
                                    <option value="12'">12 feet</option>
                                </select>
                            </div>
                        </div>

                        {{-- Contact Information --}}
                        <div class="space-y-4">
                            <h4 class="font-semibold text-gray-900 border-b pb-2">Contact Information</h4>
                            
                            <div class="grid grid-cols-1 gap-3">
                                <input type="text" name="customer_name" required placeholder="Your Name *" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                <input type="email" name="customer_email" required placeholder="Email Address *" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                <input type="tel" name="customer_phone" required placeholder="Phone Number *" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                                <input type="text" name="project_address" placeholder="Project Address" 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle">
                            </div>
                        </div>

                        {{-- Special Instructions --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Special Instructions / Custom Requirements
                            </label>
                            <textarea name="notes" rows="4" placeholder="Describe any special requirements, measurements, or questions..." 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danielle focus:border-danielle"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Include route sheet info or specific measurements</p>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                                class="w-full bg-danielle text-white px-6 py-3 rounded-lg font-semibold text-lg hover:bg-daniellealt transition-colors">
                            Get My Custom Quote
                        </button>
                    </form>
                </div>

                {{-- No Returns Policy --}}
                <div class="bg-gradient-to-br from-red-50 to-white rounded-lg p-4  border border-red-200">
                    <h4 class="font-bold text-red-800 flex items-center mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important: No Returns Policy
                    </h4>
                    <p class="text-sm text-red-700">
                        Due to the custom nature of DIY fence orders, <strong>all sales are final</strong>. 
                        Please double-check measurements and specifications before ordering. 
                        Our team is available to help ensure accuracy.
                    </p>
                </div>

                {{-- Need Help Box --}}
                <div class="bg-gradient-to-r from-success/10 to-brand-cream/20 border border-success/30 rounded-lg p-4 ">
                    <h4 class="font-bold text-success mb-2">Need Help?</h4>
                    <p class="text-sm text-gray-700 mb-3">
                        Our DIY experts can help calculate materials and provide guidance.
                    </p>
                    <div class="space-y-2">
                        <a href="tel:863-425-3182" class="block text-center bg-success text-white px-4 py-2 rounded hover:bg-[#5da61e] transition-colors">
                            Call (863) 425-3182
                        </a>
                        <a href="{{ route('diy.guide') }}" class="block text-center border border-success text-success px-4 py-2 rounded hover:bg-success hover:text-white transition-colors">
                            View Installation Guide
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>