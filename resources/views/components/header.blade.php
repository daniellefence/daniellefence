<div x-data="{ showMobile: false, showProducts: false, showServices: false, showCompany: false }">
    <header class="relative z-[100] bg-white/80 backdrop-blur-xl border-b border-slate-200/50">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <!-- Main navigation row -->
            <nav class="py-4">
                <div class="flex items-center justify-between">
                    <!-- Logo on Left -->
                    <div class="relative" id="logo-holder">
                        <a aria-label="Danielle Fence Logo" href="{{route('home')}}" class="inline-block bg-danielle p-[14px] rounded-lg relative">
                            <span class="sr-only">{{env('APP_NAME')}}</span>
                            <!-- Screw circles in corners -->
                            <div class="absolute top-[5px] left-[5px] w-2 h-2 bg-white rounded-full shadow-sm"></div>
                            <div class="absolute top-[5px] right-[5px] w-2 h-2 bg-white rounded-full shadow-sm"></div>
                            <div class="absolute bottom-[5px] left-[5px] w-2 h-2 bg-white rounded-full shadow-sm"></div>
                            <div class="absolute bottom-[5px] right-[5px] w-2 h-2 bg-white rounded-full shadow-sm"></div>
                            <img
                                class="h-16 sm:h-20 lg:h-24 xl:h-28 w-auto relative z-10"
                                style="aspect-ratio: 288/147; min-height: 64px;"
                                src="{{Vite::asset('resources/images/logo.webp')}}"
                                alt="Danielle Fence & Outdoor Living Logo"
                                width="288"
                                height="147"
                                decoding="sync"
                                fetchpriority="high"
                                loading="eager">
                        </a>
                    </div>

            <!-- Navigation on Right -->
            <div class="flex gap-3 lg:hidden">
                <button
                    @click="showMobile = !showMobile"
                    @keyup.escape.window="showMobile = false"
                    type="button"
                    class="flex items-center justify-center w-12 h-12 text-white bg-danielle hover:bg-danielle/90 shadow-lg hover:shadow-xl transition-all duration-200 border-2 border-white/20 rounded-lg">
                    <span class="sr-only">Open main menu</span>
                    <i class="fa-solid fa-bars text-white text-lg"></i>
                </button>
            </div>
                    <!-- Desktop Navigation and Phone Numbers -->
                    <div class="hidden lg:flex lg:flex-col lg:items-end lg:gap-y-4">
                        <!-- Menu Items -->
                        <div class="flex items-center gap-x-4">
                <!-- Products Dropdown -->
                <div @click.away="showProducts=false" @keyup.window.escape="showProducts=false" class="relative z-[150]">
                    <button @click="showProducts=!showProducts" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Products</span>
                        <i class="fa-solid fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showProducts ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showProducts" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-[200] mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
                        <div class="w-screen max-w-sm flex-auto rounded-2xl bg-white/95 backdrop-blur-xl p-3 text-sm leading-6 shadow-2xl ring-1 ring-slate-900/5 border border-slate-200/20">
                            @foreach(\App\Services\CacheService::getProductCategories() as $productCategory)
                                <a aria-label="{{$productCategory->title}}" href="{{$productCategory->getRoute()}}"
                                   class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                    <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200">
                                        {{$productCategory->title}}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Services Dropdown -->
                <div @click.away="showServices=false" @keyup.window.escape="showServices=false" class="relative z-[150]">
                    <button @click="showServices=!showServices" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Services</span>
                        <i class="fa-solid fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showServices ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showServices" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-[200] mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
                        <div class="w-screen max-w-xs flex-auto rounded-2xl bg-white/95 backdrop-blur-xl p-3 text-sm leading-6 shadow-2xl ring-1 ring-slate-900/5 border border-slate-200/20">
                            <a aria-label="Request a Quote" href="{{route('request-a-quote')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-clipboard w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Request a Quote
                                </div>
                            </a>
                            <a aria-label="Specials" href="{{route('specials')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-tags w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Specials
                                </div>
                            </a>
                            <a aria-label="Careers" href="{{route('careers')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-user-tie w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Careers
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Company Dropdown -->
                <div @click.away="showCompany=false" @keyup.window.escape="showCompany=false" class="relative z-[150]">
                    <button @click="showCompany=!showCompany" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Company</span>
                        <i class="fa-solid fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showCompany ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showCompany" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-[200] mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
                        <div class="w-screen max-w-xs flex-auto rounded-2xl bg-white/95 backdrop-blur-xl p-3 text-sm leading-6 shadow-2xl ring-1 ring-slate-900/5 border border-slate-200/20">
                            <a aria-label="About Us" href="{{route('about-us')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-circle-info w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    About Us
                                </div>
                            </a>
                            <a aria-label="Why Danielle Fence" href="{{route('why-danielle-fence')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-shield-check w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Why Danielle Fence
                                </div>
                            </a>
                            <a aria-label="Blog" href="{{route('blog')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-newspaper w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Blog
                                </div>
                            </a>
                            <a aria-label="FAQ" href="{{route('faq')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-circle-question w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    FAQ
                                </div>
                            </a>
                            <a aria-label="Reviews" href="{{route('reviews')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-star w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Reviews
                                </div>
                            </a>
                            <a aria-label="Hardware Catalog" href="/hardware-catalog.pdf" target="_blank"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-shield-halved w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Hardware Catalog
                                </div>
                            </a>
                            <a aria-label="Showcase" href="/showcase.pdf" target="_blank"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-images w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Showcase
                                </div>
                            </a>
                            <a aria-label="Fire Features Catalogs" href="{{route('fire-feature-catalogs')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-fire-flame-curved w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Fire Feature Catalogs
                                </div>
                            </a>
                            <a aria-label="The Pickett Pals!" href="{{route('pickett-pals')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-users w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    The Pickett Pals!
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Us -->
                <a aria-label="Contact Us" href="{{route('contact')}}" class="relative px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30">
                    Contact Us
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                </a>

                            <!-- Free Estimate -->
                            <a href="{{route('request-a-quote')}}" class="inline-flex items-center px-5 py-2 bg-outdoor-primary text-white font-semibold rounded-full hover:bg-outdoor-primary/90 transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-0.5 text-sm">
                                <i class="fa-solid fa-file-invoice w-4 h-4 mr-2"></i>
                                Free Estimate
                            </a>
                        </div>

                        <!-- Phone Numbers -->
                        <div class="flex items-center space-x-4 text-sm pt-4">
                            <div class="flex items-center space-x-2 text-slate-600">
                                <i class="fa-solid fa-phone-volume w-3.5 h-3.5 text-outdoor-primary"></i>
                                <span class="font-medium">Call:</span>
                            </div>
                            <a href="tel:8634253182" class="font-semibold text-outdoor-primary hover:text-outdoor-primary/80 transition-all duration-200">(863) 425-3182</a>
                            <span class="text-slate-300 font-bold">•</span>
                            <a href="tel:8136816181" class="font-semibold text-outdoor-primary hover:text-outdoor-primary/80 transition-all duration-200">(813) 681-6181</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
        <!-- Background backdrop -->
        <div x-show="showMobile" x-cloak
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999]"></div>

        <!-- Mobile menu panel -->
        <div x-show="showMobile" @click.outside="showMobile=false" x-cloak
         x-transition:enter="transform transition ease-in-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transform transition ease-in-out duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 z-[9999] w-full max-w-sm overflow-y-auto bg-white shadow-2xl">
                <!-- Header with close button -->
                <div class="bg-danielle text-white p-6 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img class="h-8 w-auto bg-white rounded-lg p-1" style="aspect-ratio: 288/147;" src="{{Vite::asset('resources/images/logo.webp')}}" alt="Danielle Fence Logo" width="288" height="147">
                            <span class="text-xl font-bold">Menu</span>
                        </div>
                        <button @click="showMobile = false" type="button" class="rounded-lg p-2 text-white hover:bg-white/20 transition-all duration-200">
                            <span class="sr-only">Close menu</span>
                            <i class="fa-solid fa-xmark h-5 w-5"></i>
                        </button>
                    </div>
                </div>

                <!-- Contact info -->
                <div class="px-6 py-4 bg-outdoor-mint/10 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="bg-outdoor-primary rounded-full p-2">
                            <i class="fa-solid fa-phone w-4 h-4 text-white"></i>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600 uppercase tracking-wide font-medium">Call us now</div>
                            <a aria-label="Phone Number" href="tel:863-425-3182" class="text-lg font-bold text-outdoor-primary hover:text-outdoor-primary/80 transition-colors">(863) 425-3182</a>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <div class="px-6 py-6">
                    <div class="space-y-2">
                        <!-- Products Dropdown -->
                        <div>
                            <button @click="showProducts = !showProducts" type="button"
                                    class="flex w-full items-center justify-between rounded-lg px-4 py-3 text-base font-semibold text-slate-800 hover:bg-gray-50 transition-all duration-200">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-house-building w-5 h-5 mr-3 text-outdoor-primary"></i>
                                    Products
                                </span>
                                <i class="fa-solid fa-chevron-down w-4 h-4 text-slate-500 transition-transform duration-200" :class="showProducts ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="showProducts" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="ml-8 mt-2 space-y-1">
                                @foreach(\App\Services\CacheService::getProductCategories() as $productCategory)
                                    <a aria-label="{{$productCategory->title}}" href="{{$productCategory->getRoute()}}"
                                       class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                        {{$productCategory->title}}
                                    </a>
                                @endforeach
                                </div>
                            </div>

                        <!-- Services Dropdown -->
                        <div>
                            <button @click="showServices = !showServices" type="button"
                                    class="flex w-full items-center justify-between rounded-lg px-4 py-3 text-base font-semibold text-slate-800 hover:bg-gray-50 transition-all duration-200">
                                <span class="flex items-center">
                                    <i class="fa-solid fa-screwdriver-wrench w-5 h-5 mr-3 text-outdoor-primary"></i>
                                    Services
                                </span>
                                <i class="fa-solid fa-chevron-down w-4 h-4 text-slate-500 transition-transform duration-200" :class="showServices ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="showServices" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="ml-6 mt-2 space-y-1">
                                <a aria-label="Request a Quote" href="{{route('request-a-quote')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-file-invoice w-4 h-4 mr-2"></i>
                                    Request a Quote
                                </a>
                                <a aria-label="Specials" href="{{route('specials')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-percent w-4 h-4 mr-2"></i>
                                    Specials
                                </a>
                                <a aria-label="Careers" href="{{route('careers')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-user-tie w-4 h-4 mr-2"></i>
                                    Careers
                                </a>
                            </div>
                        </div>

                        <!-- Company Dropdown -->
                        <div>
                            <button @click="showCompany = !showCompany" type="button"
                                    class="flex w-full items-center justify-between rounded-lg px-3 py-3 text-base font-semibold text-slate-800 hover:bg-gray-50 transition-all duration-200">
                                <span class="flex items-center">
                                    <i class="fad fa-building w-5 h-5 mr-3 text-outdoor-primary"></i>
                                    Company
                                </span>
                                <i class="fa-solid fa-chevron-down w-4 h-4 text-slate-500 transition-transform duration-200" :class="showCompany ? 'rotate-180' : ''"></i>
                            </button>
                            <div x-show="showCompany" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-1"
                                 class="ml-6 mt-2 space-y-1">
                                <a aria-label="About Us" href="{{route('about-us')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-info-circle w-4 h-4 mr-2"></i>
                                    About Us
                                </a>
                                <a aria-label="Why Danielle Fence" href="{{route('why-danielle-fence')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-shield-check w-4 h-4 mr-2"></i>
                                    Why Danielle Fence
                                </a>
                                <a aria-label="Blog" href="{{route('blog')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-blog w-4 h-4 mr-2"></i>
                                    Blog
                                </a>
                                <a aria-label="FAQ" href="{{route('faq')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-question-circle w-4 h-4 mr-2"></i>
                                    FAQ
                                </a>
                                <a aria-label="Reviews" href="{{route('reviews')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-star w-4 h-4 mr-2"></i>
                                    Reviews
                                </a>
                                <a aria-label="Hardware Catalog" href="/hardware-catalog.pdf" target="_blank"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-file w-4 h-4 mr-2"></i>
                                    Hardware Catalog
                                </a>
                                <a aria-label="Showcase" href="/showcase.pdf" target="_blank"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-images w-4 h-4 mr-2"></i>
                                    Showcase
                                </a>
                                <a aria-label="Fire Features Catalogs" href="{{route('fire-feature-catalogs')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fad fa-fire w-4 h-4 mr-2"></i>
                                    Fire Feature Catalogs
                                </a>
                                <a aria-label="The Pickett Pals!" href="{{route('pickett-pals')}}"
                                   class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:text-outdoor-primary hover:bg-gray-50 transition-all duration-200">
                                    <i class="fa-solid fa-users w-4 h-4 mr-2"></i>
                                    The Pickett Pals!
                                </a>
                            </div>
                        </div>

                        <!-- Contact Us -->
                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <a aria-label="Contact Us" href="{{route('contact')}}"
                               class="flex items-center rounded-lg px-3 py-3 text-base font-semibold text-slate-800 hover:bg-gray-50 transition-all duration-200">
                                <i class="fad fa-envelope w-5 h-5 mr-3 text-outdoor-primary"></i>
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
