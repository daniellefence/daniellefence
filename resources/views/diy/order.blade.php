<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <h1 class="text-3xl font-bold text-gray-900">Order DIY Fence Supplies</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Place your order for professional-grade fence materials with detailed installation instructions.
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('diy.order.store') }}" method="POST" class="space-y-6 p-6">
                    @csrf
                    
                    <!-- Product Selection -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Select Product</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="product_id" class="block text-sm font-medium text-gray-700">DIY Product</label>
                                <select id="product_id" name="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                    <option value="">Select a product</option>
                                    @foreach($products ?? [] as $product)
                                        <option value="{{ $product->id }}" 
                                                data-price="{{ $product->base_price }}"
                                                data-unit="{{ $product->price_unit }}">
                                            {{ $product->name }} - ${{ number_format($product->base_price, 2) }}{{ $product->price_unit ? '/' . $product->price_unit : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <div>
                                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" min="1" max="1000" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="e.g., 100" required>
                                    @error('quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                                    <select id="height" name="height" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                        <option value="">Select height</option>
                                        <option value="3ft">3 feet</option>
                                        <option value="4ft">4 feet</option>
                                        <option value="5ft">5 feet</option>
                                        <option value="6ft">6 feet</option>
                                        <option value="8ft">8 feet</option>
                                    </select>
                                    @error('height')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                                    <select id="color" name="color" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                        <option value="">Select color</option>
                                        <option value="white">White</option>
                                        <option value="black">Black</option>
                                        <option value="bronze">Bronze</option>
                                        <option value="green">Green</option>
                                        <option value="natural">Natural</option>
                                    </select>
                                    @error('color')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="width" class="block text-sm font-medium text-gray-700">Panel Width (feet)</label>
                                <input type="number" id="width" name="width" min="4" max="12" step="0.5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="e.g., 6" required>
                                @error('width')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" id="customer_name" name="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="customer_email" name="customer_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('customer_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" id="customer_phone" name="customer_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="customer_address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                            <input type="text" id="customer_address" name="customer_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="Street address" required>
                            @error('customer_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-4">
                            <div>
                                <label for="customer_city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" id="customer_city" name="customer_city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('customer_city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_state" class="block text-sm font-medium text-gray-700">State</label>
                                <select id="customer_state" name="customer_state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                    <option value="">Select state</option>
                                    <option value="FL" selected>Florida</option>
                                    <!-- Add other states as needed -->
                                </select>
                                @error('customer_state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                <input type="text" id="customer_zip" name="customer_zip" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('customer_zip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="Any special requirements or delivery instructions..."></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Order Summary</h4>
                        <div id="order-summary" class="text-sm text-gray-600">
                            <p>Select a product to see pricing details</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('diy.products') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Back to Products
                        </a>
                        <button type="submit" class="bg-danielle hover:bg-daniellealt text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Support Section -->
        <div class="bg-danielle">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Need help with your order?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-white">
                    Our fence experts are standing by to help with product selection and installation questions.
                </p>
                <a href="tel:863-425-3182" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-danielle bg-white hover:bg-gray-50 sm:w-auto">
                    Call (863) 425-3182
                </a>
            </div>
        </div>
    </div>

    <script>
        // Simple order summary calculator
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const orderSummary = document.getElementById('order-summary');
            
            function updateOrderSummary() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const quantity = parseInt(quantityInput.value) || 0;
                
                if (selectedOption.value && quantity > 0) {
                    const price = parseFloat(selectedOption.dataset.price) || 0;
                    const unit = selectedOption.dataset.unit || '';
                    const total = price * quantity;
                    
                    orderSummary.innerHTML = `
                        <div class="space-y-1">
                            <div class="flex justify-between">
                                <span>Product:</span>
                                <span>${selectedOption.text}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Quantity:</span>
                                <span>${quantity} ${unit}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-danielle">
                                <span>Estimated Total:</span>
                                <span>$${total.toFixed(2)}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">*Final pricing subject to verification and shipping costs</p>
                        </div>
                    `;
                } else {
                    orderSummary.innerHTML = '<p>Select a product and quantity to see pricing details</p>';
                }
            }
            
            productSelect.addEventListener('change', updateOrderSummary);
            quantityInput.addEventListener('input', updateOrderSummary);
        });
    </script>
</x-app-layout>