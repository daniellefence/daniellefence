<x-app-layout>

    <x-slot name="title">The Pickett Pals! | Danielle Fence & Outdoor Living</x-slot>
    <x-slot name="description">Meet the Pickett Pals! The beloved mascot family of Danielle Fence & Outdoor Living, featuring Grillbert, Dr. Fencestopher, and their fun-loving crew.</x-slot>

    <div class="bg-slate-100/50">

        <x-page-heading subheading="The beloved mascot family of Danielle Fence & Outdoor Living">
            Meet The Pickett Pals!
        </x-page-heading>

        <!-- All Characters Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-6">
                    Meet The Complete Cast
                </h2>
                <div class="w-24 h-1 bg-brand-primary mx-auto rounded-full mb-8"></div>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                    Our beloved characters bringing joy and expertise to all your outdoor living needs
                </p>
            </div>

            <!-- Characters Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">

                <!-- Grillbert -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 lg:col-span-2">
                    <div class="bg-white h-64 flex items-center justify-center pt-4">
                        <img src="{{Vite::asset('resources/images/profile-photos/grillbertwebp.webp')}}"
                             alt="Grillbert"
                             class="h-48 w-auto object-contain">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Grillbert</h3>
                        <p class="text-sm text-slate-600 mb-3">An animated BBQ grill with big, expressive eyes. His round hood lifts to release smoke—and fire when excited!</p>
                        <p class="text-xs text-slate-500 italic">Plays guitar</p>
                    </div>
                </div>

                <!-- Flip Grillson -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 lg:col-span-2">
                    <div class="bg-white h-64 flex items-center justify-center pt-4">
                        <img src="{{Vite::asset('resources/images/profile-photos/flip.webp')}}"
                             alt="Flip Grillson"
                             class="h-48 w-auto object-contain">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Flip Grillson</h3>
                        <p class="text-sm text-slate-600 mb-3">A burger flipper with cowboy hat and mustache. Afraid to flip burgers—his hat might catch fire!</p>
                        <p class="text-xs text-slate-500 italic">Plays banjo</p>
                    </div>
                </div>

                <!-- Jimmy -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 lg:col-span-2">
                    <div class="bg-white h-64 flex items-center justify-center pt-4">
                        <img src="{{Vite::asset('resources/images/profile-photos/jimmy.webp')}}"
                             alt="Jimmy"
                             class="h-48 w-auto object-contain">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Jimmy D. Pickett</h3>
                        <p class="text-sm text-slate-600 mb-3">An animated bug with big eyes and expressive antennae. Polite, curious about the backyard world.</p>
                        <p class="text-xs text-slate-500 italic">Often on Flip's hat • Plays banjo</p>
                    </div>
                </div>

                <!-- Empty space -->
                <div class="lg:col-span-1 hidden lg:block"></div>

                <!-- Dr. Fencestopher -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 lg:col-span-2">
                    <div class="bg-white h-64 flex items-center justify-center pt-4">
                        <img src="{{Vite::asset('resources/images/profile-photos/fencestopher.webp')}}"
                             alt="Dr. Fencestopher"
                             class="h-48 w-auto object-contain">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Dr. Fencestopher</h3>
                        <p class="text-sm text-slate-600 mb-3">Vinyl fence character with lab coat and tie. Knowledgeable about all things fence-related.</p>
                        <p class="text-xs text-slate-500 italic">Plays drums</p>
                    </div>
                </div>

                <!-- Noah Fence -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 lg:col-span-2">
                    <div class="bg-white h-64 flex items-center justify-center pt-4">
                        <img src="{{Vite::asset('resources/images/profile-photos/noah.webp')}}"
                             alt="Noah Fence"
                             class="h-48 w-auto object-contain">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Noah Fence</h3>
                        <p class="text-sm text-slate-600 mb-3">Host of "No Offense" - the fence industry's most trusted Q&A show. Noah provides expert advice on choosing contractors, materials, and designs.</p>
                        <p class="text-xs text-slate-500 italic">The Fence Industry Expert</p>
                    </div>
                </div>

                <!-- Empty space -->
                <div class="lg:col-span-1 hidden lg:block"></div>

            </div>
        </div>

        <!-- YouTube Videos Section -->
        <div class="bg-white py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-6">
                        Watch The Pickett Pals in Action!
                    </h2>
                    <div class="w-24 h-1 bg-brand-primary mx-auto rounded-full mb-8"></div>
                    <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                        Join our characters on their adventures and learn about fencing, outdoor living, and more!
                    </p>
                </div>

                <!-- Main Introduction Video -->
                <div class="max-w-4xl mx-auto mb-16">
                    <div class="relative" style="padding-bottom: 56.25%;">
                        <iframe
                            src="https://www.youtube.com/embed/eJg2zUZyURQ"
                            title="Meet The Pickett Pals - Introduction Video"
                            class="absolute top-0 left-0 w-full h-full rounded-xl shadow-2xl"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

                <!-- More Videos from Playlist -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">More Episodes</h3>
                    <p class="text-slate-600">Browse through all the Pickett Pals adventures below</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Additional Video 1 -->
                    <div class="bg-slate-50 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="relative" style="padding-bottom: 56.25%;">
                            <iframe
                                src="https://www.youtube.com/embed/?listType=playlist&list=PLHY-XE9obsIAu20PVtt8bM6mc3WW3bw-S&index=1"
                                title="Pickett Pals Episodes"
                                class="absolute top-0 left-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Additional Video 2 -->
                    <div class="bg-slate-50 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="relative" style="padding-bottom: 56.25%;">
                            <iframe
                                src="https://www.youtube.com/embed/?listType=playlist&list=PLHY-XE9obsIAu20PVtt8bM6mc3WW3bw-S&index=2"
                                title="Pickett Pals Episodes"
                                class="absolute top-0 left-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Additional Video 3 -->
                    <div class="bg-slate-50 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="relative" style="padding-bottom: 56.25%;">
                            <iframe
                                src="https://www.youtube.com/embed/?listType=playlist&list=PLHY-XE9obsIAu20PVtt8bM6mc3WW3bw-S&index=3"
                                title="Pickett Pals Episodes"
                                class="absolute top-0 left-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <!-- Additional Video 4 -->
                    <div class="bg-slate-50 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow">
                        <div class="relative" style="padding-bottom: 56.25%;">
                            <iframe
                                src="https://www.youtube.com/embed/?listType=playlist&list=PLHY-XE9obsIAu20PVtt8bM6mc3WW3bw-S&index=4"
                                title="Pickett Pals Episodes"
                                class="absolute top-0 left-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- CTA Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-brand-primary rounded-3xl p-12 lg:p-16 text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    Ready to Start Your Fencing Journey?
                </h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                    Let Dr. Fencestopher and the team at Danielle Fence help you find the perfect fencing solution for your property.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('request-a-quote') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-brand-primary bg-white rounded-xl hover:bg-gray-50 transition-colors duration-200 shadow-lg hover:shadow-xl">
                        Get Free Quote
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white border-2 border-white rounded-xl hover:bg-white hover:text-brand-primary transition-colors duration-200">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>