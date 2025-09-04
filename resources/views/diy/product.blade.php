@extends('layouts.app')

@section('title', $product->name . ' - DIY Installation')

@section('content')
<div class="bg-gray-50">
    {{-- Color Disclaimer Banner --}}
    <div class="bg-yellow-500 text-gray-900 py-3">
        <div class="container mx-auto px-4 text-center">
            <p class="font-semibold">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Important: Color shown is not exact replication of actual product
            </p>
        </div>
    </div>

    {{-- Product Header --}}
    <div class="bg-white shadow">
        <div class="container mx-auto px-4 py-6">
            <nav class="text-sm mb-4">
                <a href="{{ route('diy.index') }}" class="text-red-800 hover:text-red-900">DIY Products</a>
                <span class="mx-2">/</span>
                <span class="text-gray-600">{{ $product->name }}</span>
            </nav>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $product->name }}</h1>
            
            {{-- Special 8' fence notice --}}
            @if($railPositioning == 'not-centered')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Product Images --}}
            <div class="space-y-4">
                @if($product->getFirstMediaUrl())
                    <div class="aspect-square bg-white rounded-lg shadow-lg overflow-hidden">
                        <img src="{{ $product->getFirstMediaUrl() }}" 
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-6xl text-gray-400"></i>
                    </div>
                @endif

                {{-- Additional Images --}}
                @if($product->getMedia()->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->getMedia()->skip(1) as $media)
                            <div class="aspect-square bg-white rounded shadow overflow-hidden">
                                <img src="{{ $media->getUrl() }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover cursor-pointer hover:opacity-75">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Product Info & Order Form --}}
            <div class="space-y-6">
                {{-- Product Description --}}
                @if($product->description)
                    <div class="prose max-w-none">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                @endif

                {{-- Pricing --}}
                @if($product->base_price)
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-3xl font-bold text-red-800">
                            Starting at ${{ number_format($product->base_price, 2) }}
                        </p>
                        <p class="text-sm text-red-600">Pricing varies by specifications</p>
                    </div>
                @endif

                {{-- Order Form --}}
                <div class="bg-white p-6 rounded-lg shadow-lg border-2 border-red-100">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Place Your DIY Order</h3>
                    
                    <form action="{{ route('diy.order') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Specifications --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Height <span class="text-red-500">*</span>
                                </label>
                                <select name="height" required 
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select Height</option>
                                    <option value="3'">3 feet</option>
                                    <option value="4'">4 feet</option>
                                    <option value="5'">5 feet</option>
                                    <option value="6'">6 feet</option>
                                    <option value="8'">8 feet</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Width/Length <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="width" required placeholder="e.g., 100 linear feet"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity" required min="1" value="1"
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Color <span class="text-red-500">*</span>
                            </label>
                            <select name="color" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">Select Color</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Bronze">Bronze</option>
                                <option value="Green">Green</option>
                                <option value="Beige">Beige</option>
                                <option value="Custom">Custom Color (specify in notes)</option>
                            </select>
                        </div>

                        {{-- Customer Information --}}
                        <hr class="my-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Customer Information</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_name" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="customer_email" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="customer_phone" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_address" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    City <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_city" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    State <span class="text-red-500">*</span>
                                </label>
                                <select name="customer_state" required
                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select State</option>
                                    <option value="FL">Florida</option>
                                    <option value="AL">Alabama</option>
                                    <option value="GA">Georgia</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    ZIP Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_zip" required
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Additional Notes
                            </label>
                            <textarea name="notes" rows="3" placeholder="Any special requirements, questions, or custom color specifications..."
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>

                        {{-- Pickup Notice --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h5 class="font-bold text-yellow-800 mb-2">📍 Pickup Location</h5>
                            <p class="text-yellow-700">
                                <strong>4855 State Road 60 West, Mulberry, FL 33860</strong><br>
                                Phone: (863) 425-3182<br>
                                <small>Materials ready for pickup in 3-5 business days</small>
                            </p>
                        </div>

                        <button type="submit" 
                                class="w-full bg-red-800 text-white py-4 px-6 rounded-lg font-bold text-lg hover:bg-red-900 transition">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Place DIY Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Product Details & Installation Info --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Installation Difficulty --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4">Installation Info</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span>Difficulty:</span>
                        <span class="font-medium">Moderate</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Est. Time:</span>
                        <span class="font-medium">1-2 days</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tools Required:</span>
                        <span class="font-medium">Basic hand tools</span>
                    </div>
                </div>
            </div>

            {{-- What's Included --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4">What's Included</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Fence panels and posts
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Hardware and brackets
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        Installation instructions
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-times text-red-600 mr-2"></i>
                        Concrete and tools not included
                    </li>
                </ul>
            </div>

            {{-- Support --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold text-lg mb-4">Need Help?</h3>
                <div class="space-y-3">
                    <a href="tel:8634253182" class="flex items-center text-red-800 hover:text-red-900">
                        <i class="fas fa-phone mr-2"></i>
                        (863) 425-3182
                    </a>
                    <a href="{{ route('diy.guide') }}" class="flex items-center text-red-800 hover:text-red-900">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Installation Guides
                    </a>
                    <a href="{{ route('contact') }}" class="flex items-center text-red-800 hover:text-red-900">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white p-4 rounded-lg shadow-lg z-50" 
         x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50"
         x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 8000)">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="fixed bottom-4 right-4 bg-red-500 text-white p-4 rounded-lg shadow-lg z-50"
         x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 10000)">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        Please check the form for errors
    </div>
@endif
@endsection