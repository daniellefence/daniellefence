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
                        <p class="text-sm text-slate-600 mb-3">A living, red-and-silver BBQ grill who's the heart of the party. Sizzles when excited, puffs smoke when thinking, and his lid clanks like laughter. This enthusiastic grill on wheels loves rolling into adventures!</p>
                        <p class="text-xs text-slate-500 italic">Lead guitarist • The enthusiast</p>
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
                        <p class="text-sm text-slate-600 mb-3">The daredevil cowboy spatula who yells "Yee-haw!" before every adventure. Reckless and bold, he initiates most of the chaos with wild fence "durability tests" that never go as planned. Always ready for action!</p>
                        <p class="text-xs text-slate-500 italic">Banjo player • The daredevil • "Hold yer horses!"</p>
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
                        <p class="text-sm text-slate-600 mb-3">The cautious bug perched on Flip's cowboy hat, serving as the voice of reason nobody listens to. Provides deadpan commentary and warnings with his catchphrase "I got a bad feeling about this" right before chaos ensues.</p>
                        <p class="text-xs text-slate-500 italic">Banjo duo with Flip • The straight man • Professional worrier</p>
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
                        <p class="text-sm text-slate-600 mb-3">The scientific vinyl fence genius with clipboard in hand, always calculating and measuring. The doomed voice of reason who tries preventing disasters with logic and calculations, but inevitably gets swept into the chaos anyway. Hosts "Testimonial Tuesday" segments!</p>
                        <p class="text-xs text-slate-500 italic">Drummer • The scientist • "Actually, Technically, Basically..."</p>
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
                        <p class="text-sm text-slate-600 mb-3">The zen master host of "No Offense" - providing calm, meditative wisdom about fencing and life. While others panic, Noah focuses on inner peace and staying grounded, offering philosophical insights between the chaos.</p>
                        <p class="text-xs text-slate-500 italic">The philosopher • Master of inner peace • "Stay grounded"</p>
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