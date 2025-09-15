<x-app-layout>
<div class="bg-gradient-to-r from-gray-50 to-brand-cream/20 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            {{-- Success Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 text-white rounded-full mb-4">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Thank You!</h1>
                <p class="text-xl text-gray-600">Your DIY order has been successfully submitted</p>
            </div>

            {{-- Order Details Card --}}
            <div class="bg-gradient-to-br from-white to-brand-cream/30 rounded-lg  overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-red-800 to-danielle text-white px-6 py-4 ">
                    <h2 class="text-2xl font-bold">Order Confirmation</h2>
                </div>
                
                <div class="px-6 py-6">
                    {{-- Order Number --}}
                    <div class="bg-gradient-to-r from-blue-50 to-brand-light/30 border border-blue-200 rounded-lg p-4 mb-6 ">
                        <div class="text-center">
                            <p class="text-sm text-blue-600 font-medium">Order Number</p>
                            <p class="text-2xl font-bold text-blue-800 tracking-wider">{{ $order->order_number }}</p>
                            <p class="text-xs text-blue-600 mt-1">Keep this number for your records</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Product Information --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Product Details</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Product:</span>
                                    <span class="font-medium">{{ $order->product->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Quantity:</span>
                                    <span class="font-medium">{{ $order->quantity }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Specifications:</span>
                                    <span class="font-medium">{{ $order->getFormattedSpecifications() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Customer Information --}}
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Customer Information</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-medium">{{ $order->customer_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $order->customer_email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium">{{ $order->customer_phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Order Notes</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 italic">"{{ $order->notes }}"</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- What Happens Next --}}
            <div class="bg-white rounded-lg  p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">What Happens Next?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clipboard-check text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold mb-2">1. Order Review</h3>
                        <p class="text-sm text-gray-600">Our team reviews your specifications and checks inventory</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-cogs text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold mb-2">2. Material Prep</h3>
                        <p class="text-sm text-gray-600">We prepare and package your fence materials</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-phone text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold mb-2">3. Ready Call</h3>
                        <p class="text-sm text-gray-600">You'll receive a call when your order is ready</p>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-truck-pickup text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="font-bold mb-2">4. Pickup</h3>
                        <p class="text-sm text-gray-600">Come pick up your materials and start your project!</p>
                    </div>
                </div>
            </div>

            {{-- Pickup Information --}}
            <div class="bg-gradient-to-r from-danielle to-daniellealt text-white rounded-lg p-6 mb-8">
                <div class="flex items-start">
                    <i class="fas fa-map-marker-alt text-2xl mr-4 mt-1"></i>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold mb-2">Pickup Location</h3>
                        <p class="text-lg mb-2">
                            <strong>4855 State Road 60 West</strong><br>
                            Mulberry, FL 33860
                        </p>
                        <p class="mb-4">
                            <strong>Phone:</strong> (863) 425-3182<br>
                            <strong>Typical Ready Time:</strong> 3-5 business days
                        </p>
                        <div class="bg-red-700 p-3 rounded">
                            <p class="text-sm">
                                <strong>Important:</strong> Please bring a valid ID and this confirmation when picking up your materials.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Email Confirmation Notice --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                <div class="flex items-center">
                    <i class="fas fa-envelope text-blue-600 text-xl mr-3"></i>
                    <div>
                        <p class="font-medium text-blue-800">Confirmation Email Sent</p>
                        <p class="text-sm text-blue-600">
                            A detailed confirmation has been sent to <strong>{{ $order->customer_email }}</strong>
                        </p>
                    </div>
                </div>
            </div>

            {{-- DIY Resources --}}
            <div class="bg-white rounded-lg  p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">While You Wait - DIY Resources</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="{{ route('diy.guide', 'aluminum') }}" 
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-file-pdf text-red-600 text-2xl mr-4"></i>
                        <div>
                            <h4 class="font-bold">Installation Guides</h4>
                            <p class="text-sm text-gray-600">Step-by-step instructions</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('diy.easy-fixes') }}" 
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-wrench text-red-600 text-2xl mr-4"></i>
                        <div>
                            <h4 class="font-bold">Easy Fixes</h4>
                            <p class="text-sm text-gray-600">Common repair solutions</p>
                        </div>
                    </a>
                    
                    <a href="tel:8634253182" 
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-phone text-red-600 text-2xl mr-4"></i>
                        <div>
                            <h4 class="font-bold">Need Help?</h4>
                            <p class="text-sm text-gray-600">Call (863) 425-3182</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Actions --}}
            <div class="text-center mt-8 space-x-4">
                <a href="{{ route('diy.index') }}" 
                   class="inline-flex items-center bg-red-800 text-white px-6 py-3 rounded-lg hover:bg-red-900 transition">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to DIY Products
                </a>
                
                <button onclick="window.print()" 
                        class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-print mr-2"></i>
                    Print Confirmation
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style media="print">
    @media print {
        body { -webkit-print-color-adjust: exact; }
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        .bg-red-800 { background-color: #991b1b !important; }
        .text-white { color: white !important; }
    }
</style>
<script>
    // Auto-scroll to top on load
    window.addEventListener('load', function() {
        window.scrollTo(0, 0);
    });

    // Track conversion for analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'purchase', {
            'transaction_id': '{{ $order->order_number }}',
            'value': 1,
            'currency': 'USD',
            'items': [{
                'item_id': '{{ $order->product_id }}',
                'item_name': '{{ $order->product->name }}',
                'category': 'DIY',
                'quantity': {{ $order->quantity }},
                'price': 1
            }]
        });
    }
</script>
</x-app-layout>