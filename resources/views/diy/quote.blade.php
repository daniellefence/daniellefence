<x-app-layout>
    <div class="min-h-screen bg-gradient-to-r from-gray-50 to-brand-cream/20">
        <!-- Header -->
        <div class="bg-gradient-to-r from-white to-brand-cream/30 ">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6">
                    <h1 class="text-3xl font-bold text-gray-900">Request a DIY Fence Quote</h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Get a personalized quote for your DIY fence project. Our experts will help you calculate exactly what you need.
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-gradient-to-br from-white to-brand-cream/30  sm:rounded-lg">
                <form action="{{ route('diy.quote.store') }}" method="POST" class="space-y-6 p-6">
                    @csrf
                    
                    <!-- Project Details -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Project Details</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="fence_type" class="block text-sm font-medium text-gray-700">Fence Type</label>
                                <select id="fence_type" name="fence_type" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                    <option value="">Select fence type</option>
                                    <option value="aluminum">Aluminum</option>
                                    <option value="vinyl">Vinyl</option>
                                    <option value="wood">Wood</option>
                                    <option value="chain_link">Chain Link</option>
                                </select>
                                @error('fence_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fence_height" class="block text-sm font-medium text-gray-700">Fence Height</label>
                                <select id="fence_height" name="fence_height" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                    <option value="">Select height</option>
                                    <option value="3ft">3 feet</option>
                                    <option value="4ft">4 feet</option>
                                    <option value="5ft">5 feet</option>
                                    <option value="6ft">6 feet</option>
                                    <option value="8ft">8 feet</option>
                                </select>
                                @error('fence_height')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="linear_feet" class="block text-sm font-medium text-gray-700">Approximate Linear Feet</label>
                                <input type="number" id="linear_feet" name="linear_feet" min="1" max="10000" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="e.g., 100" required>
                                @error('linear_feet')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gates_needed" class="block text-sm font-medium text-gray-700">Gates Needed</label>
                                <select id="gates_needed" name="gates_needed" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm">
                                    <option value="0">No gates</option>
                                    <option value="1">1 gate</option>
                                    <option value="2">2 gates</option>
                                    <option value="3">3 gates</option>
                                    <option value="4">4+ gates</option>
                                </select>
                                @error('gates_needed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="project_description" class="block text-sm font-medium text-gray-700">Project Description</label>
                            <textarea id="project_description" name="project_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="Tell us about your project, including any special requirements or questions..."></textarea>
                            @error('project_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" required>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="address" class="block text-sm font-medium text-gray-700">Project Address</label>
                            <input type="text" id="address" name="address" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm" placeholder="Street address">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mt-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" id="city" name="city" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                <select id="state" name="state" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm">
                                    <option value="">Select state</option>
                                    <option value="FL" selected>Florida</option>
                                    <!-- Add other states as needed -->
                                </select>
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="zip" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                <input type="text" id="zip" name="zip" class="mt-1 block w-full rounded-md border-gray-300  focus:border-danielle focus:ring-danielle sm:text-sm">
                                @error('zip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-danielle hover:bg-daniellealt text-white font-bold py-2 px-4 rounded focus:outline-none">
                            Request Free Quote
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-danielle">
            <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    <span class="block">Need help right away?</span>
                </h2>
                <p class="mt-4 text-lg leading-6 text-white">
                    Call our fence experts directly for immediate assistance with your project.
                </p>
                <a href="tel:863-425-3182" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-danielle bg-white hover:bg-gray-50 sm:w-auto">
                    Call (863) 425-3182
                </a>
            </div>
        </div>
    </div>
</x-app-layout>