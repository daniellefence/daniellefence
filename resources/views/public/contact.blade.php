<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-[#8e2a2a] to-[#7a2525] py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Contact Us</h1>
                    <p class="text-xl text-white mb-8">
                        Get in touch with Central Florida's most trusted fence company since 1976.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Information & Form -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-12">
                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-8">Get In Touch</h2>
                        
                        <div class="space-y-6">
                            <!-- Phone Numbers -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-[#8e2a2a] rounded-full p-3">
                                        <i class="fas fa-phone text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold mb-2">Phone</h3>
                                    <p class="text-gray-600">
                                        <a href="tel:863-425-3182" class="text-[#8e2a2a] hover:underline font-semibold">(863) 425-3182</a><br>
                                        <a href="tel:813-681-6181" class="text-[#8e2a2a] hover:underline font-semibold">(813) 681-6181</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-[#8e2a2a] rounded-full p-3">
                                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold mb-2">Address</h3>
                                    <p class="text-gray-600">
                                        4855 State Road 60 West<br>
                                        Mulberry, FL 33860
                                    </p>
                                </div>
                            </div>

                            <!-- Hours -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="bg-[#8e2a2a] rounded-full p-3">
                                        <i class="fas fa-clock text-white text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold mb-2">Hours</h3>
                                    <p class="text-gray-600">
                                        Monday - Friday: 8:00 AM - 5:00 PM<br>
                                        Saturday: 9:00 AM - 3:00 PM<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Service Areas -->
                        <div class="mt-12">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">Service Areas</h3>
                            <div class="grid grid-cols-2 gap-2 text-gray-600">
                                <div>• Lakeland</div>
                                <div>• Winter Haven</div>
                                <div>• Auburndale</div>
                                <div>• Plant City</div>
                                <div>• Bartow</div>
                                <div>• Mulberry</div>
                                <div>• Haines City</div>
                                <div>• And More!</div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>
                        
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" name="first_name" id="first_name" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" id="email" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                            </div>

                            <div class="mt-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="tel" name="phone" id="phone"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                            </div>

                            <div class="mt-6">
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                                <select name="subject" id="subject" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                                    <option value="">Select a subject</option>
                                    <option value="quote">Request Quote</option>
                                    <option value="service">Service Inquiry</option>
                                    <option value="support">Customer Support</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="mt-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                <textarea name="message" id="message" rows="5" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent"
                                          placeholder="Tell us about your project..."></textarea>
                            </div>

                            <div class="mt-8">
                                <button type="submit"
                                        class="w-full bg-[#8e2a2a] hover:bg-[#9c3030] text-white font-semibold py-3 px-6 rounded-md transition-colors duration-200">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>