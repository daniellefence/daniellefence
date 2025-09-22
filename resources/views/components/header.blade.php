<div x-data="{
        showMobile:false
    }">
    <div class="upper-header hidden lg:block sticky py-2 text-white top-0 z-30 bg-outdoor-mint backdrop-blur-md">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2 text-sm font-bold text-white">
                        <i class="fad fa-phone w-4 h-4"></i>
                        <span>Call:</span>
                    </div>
                    <a href="tel:8634253182" class="text-sm font-bold text-white hover:text-outdoor-gold transition-all duration-200">(863) 425-3182</a>
                    <span class="text-white/60 text-sm font-bold">•</span>
                    <a href="tel:8136816181" class="text-sm font-bold text-white hover:text-outdoor-gold transition-all duration-200">(813) 681-6181</a>
                </div>
                @if(!request()->routeIs("search"))
                    <form method="get" action="{{route('search')}}" class="flex-0 w-full max-w-xl">
                        @csrf
                        <label class="sr-only block text-sm font-medium leading-6 text-gray-900">Search
                            Everywhere</label>
                        <div class="flex rounded-md shadow-sm">
                            <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                <input type="text" name="q"
                                       class="search-input block w-full rounded-none rounded-r-none rounded-l-lg py-2 px-4 text-slate-900 placeholder:text-slate-500 bg-white/95 backdrop-blur-sm border border-white/30 focus:border-outdoor-primary focus:ring-2 focus:ring-outdoor-primary/20 text-sm transition-all duration-200"
                                       placeholder="Search products, services...">
                            </div>
                            <button type="submit"
                                    class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-lg px-4 py-2 text-sm font-medium text-slate-700 bg-white hover:bg-gray-50 transition-all duration-200 border border-l-0 border-white/30 ring-0 shadow-sm hover:shadow-md">
                                <i class="fad fa-search -ml-0.5 h-4 w-4 text-slate-700"></i>
                                Search
                            </button>
                        </div>
                    </form>
                @endif
                <div class="flex items-center gap-3">
                    <a href="{{route('request-a-quote')}}" class="inline-flex items-center px-5 py-2 bg-white text-black font-semibold rounded-full hover:bg-gray-50 transition-all duration-200 shadow-lg hover:shadow-2xl transform hover:-translate-y-0.5 text-sm">
                        <i class="fad fa-clipboard w-4 h-4 mr-2"></i>
                        Free Estimate
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header class="relative z-20 bg-white/80 backdrop-blur-xl border-b border-slate-200/50">
        <nav class="mx-auto max-w-7xl px-6 lg:px-8 py-6 flex items-center justify-between">
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
                        src="{{Vite::asset('resources/images/logo.webp')}}"
                        alt="Danielle Fence Logo">
                </a>
            </div>

            <!-- Navigation on Right -->
            <div class="flex gap-3 lg:hidden">
                <a class="inline-flex items-center justify-center rounded-lg p-2.5 text-white bg-gradient-to-r from-outdoor-primary to-outdoor-primary/90 shadow-md hover:shadow-lg transition-all duration-200"
                   href="{{route('search')}}" aria-label="Search Danielle Fence & Outdoor Living">
                    <i class="fad fa-search h-5 w-5 text-white"></i>
                </a>
                <button
                    @click="showMobile = true"
                    @keyup.escape.window="showMobile = true"
                    type="button"
                    class="inline-flex items-center justify-center rounded-lg p-2.5 text-white bg-gradient-to-r from-outdoor-secondary to-outdoor-secondary/90 shadow-md hover:shadow-lg transition-all duration-200">
                    <span class="sr-only">Open main menu</span>
                    <i class="fad fa-bars h-5 w-5"></i>
                </button>
            </div>
            <div class="hidden lg:flex lg:items-center lg:gap-x-4" x-data="{
                showProducts: false,
                showServices: false,
                showCompany: false
            }">
                <!-- Products Dropdown -->
                <div @click.away="showProducts=false" @keyup.window.escape="showProducts=false" class="relative">
                    <button @click="showProducts=!showProducts" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Products</span>
                        <i class="fad fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showProducts ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showProducts" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-50 mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
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
                <div @click.away="showServices=false" @keyup.window.escape="showServices=false" class="relative">
                    <button @click="showServices=!showServices" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Services</span>
                        <i class="fad fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showServices ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showServices" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-50 mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
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
                                    <i class="fad fa-dollar-sign w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Specials
                                </div>
                            </a>
                            <a aria-label="Careers" href="{{route('careers')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-briefcase w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Careers
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Company Dropdown -->
                <div @click.away="showCompany=false" @keyup.window.escape="showCompany=false" class="relative">
                    <button @click="showCompany=!showCompany" type="button"
                            class="relative inline-flex items-center gap-x-1 px-4 py-2 text-sm font-semibold text-slate-800 hover:text-outdoor-primary transition-all duration-200 group rounded-lg bg-slate-50/70 hover:bg-outdoor-light/60 shadow-sm hover:shadow-md border border-slate-200/50 hover:border-outdoor-primary/30"
                            aria-expanded="false">
                        <span>Company</span>
                        <i class="fad fa-chevron-down h-4 w-4 transition-transform duration-300" :class="showCompany ? 'rotate-180' : ''"></i>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-outdoor-primary to-outdoor-primary/80 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-center rounded-full"></span>
                    </button>
                    <div x-show="showCompany" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         class="absolute left-1/2 z-50 mt-2 flex w-screen max-w-max -translate-x-1/2 px-4">
                        <div class="w-screen max-w-xs flex-auto rounded-2xl bg-white/95 backdrop-blur-xl p-3 text-sm leading-6 shadow-2xl ring-1 ring-slate-900/5 border border-slate-200/20">
                            <a aria-label="About Us" href="{{route('about-us')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-info-circle w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    About Us
                                </div>
                            </a>
                            <a aria-label="Why Danielle Fence" href="{{route('why-danielle-fence')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-check-circle w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Why Danielle Fence
                                </div>
                            </a>
                            <a aria-label="Blog" href="{{route('blog')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-blog w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Blog
                                </div>
                            </a>
                            <a aria-label="FAQ" href="{{route('faq')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-question-circle w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    FAQ
                                </div>
                            </a>
                            <a aria-label="Reviews" href="{{route('reviews')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-star w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Reviews
                                </div>
                            </a>
                            <a aria-label="Hardware Catalog" href="/hardware-catalog.pdf" target="_blank"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-file w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Hardware Catalog
                                </div>
                            </a>
                            <a aria-label="Showcase" href="/showcase.pdf" target="_blank"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-images w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Showcase
                                </div>
                            </a>
                            <a aria-label="Fire Features Catalogs" href="{{route('fire-feature-catalogs')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-fire w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
                                    Fire Feature Catalogs
                                </div>
                            </a>
                            <a aria-label="The Pickett Pals!" href="{{route('pickett-pals')}}"
                               class="relative block rounded-xl p-3 group hover:bg-gradient-to-r hover:from-brand-light hover:to-brand-light/80 transition-all duration-200 border border-transparent hover:border-outdoor-primary/20">
                                <div class="font-medium text-slate-700 group-hover:text-outdoor-primary transition-colors duration-200 flex items-center">
                                    <i class="fad fa-users w-4 h-4 mr-2 text-slate-400 group-hover:text-outdoor-primary"></i>
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
            </div>
            </div>
        </nav>
	 
        <div x-data="{
            showProducts: false,
            showServices: false,
            showCompany: false,
        }"
             class="lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div x-show="showMobile" x-cloak class="fixed inset-0 z-10"></div>
            <div x-show="showMobile" x-cloak @click.outside="showMobile=false"
                 class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-gradient-to-br from-outdoor-primary to-outdoor-primary/95 backdrop-blur-sm px-6 py-6 sm:max-w-sm shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="text-white/90 text-sm">
                        Call <a aria-label="Phone Number" href="tel:863-425-3182" class="font-semibold text-white hover:text-brand-accent transition-colors">(863) 425-3182</a>
                    </div>
                    <button @click="showMobile = false" type="button" class="rounded-lg p-2 text-white hover:bg-white/10 transition-all duration-200">
                        <span class="sr-only">Close menu</span>
                        <i class="fad fa-times h-6 w-6"></i>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-white/10">
                        <div class="space-y-3 py-6">
                            <!-- Products Dropdown -->
                            <div class="-mx-3">
                                <button @click="showProducts = !showProducts" type="button"
                                        class="flex w-full items-center justify-between rounded-lg py-3 pl-4 pr-3.5 text-base font-semibold leading-7 text-white hover:bg-white/10 transition-all duration-200">
                                    Products
                                    <i class="fad fa-chevron-down" :class="showProducts ? 'rotate-180 h-5 w-5 flex-none':'h-5 w-5 flex-none'"></i>
                                </button>
                                <div x-show="showProducts" x-cloak class="mt-2 space-y-2">
                                    @foreach(\App\Services\CacheService::getProductCategories() as $productCategory)
                                        <a aria-label="{{$productCategory->title}}" href="{{$productCategory->getRoute()}}"
                                           class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">
                                            {{$productCategory->title}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Services Dropdown -->
                            <div class="-mx-3">
                                <button @click="showServices = !showServices" type="button"
                                        class="flex w-full items-center justify-between rounded-lg py-3 pl-4 pr-3.5 text-base font-semibold leading-7 text-white hover:bg-white/10 transition-all duration-200">
                                    Services
                                    <i class="fad fa-chevron-down" :class="showServices ? 'rotate-180 h-5 w-5 flex-none':'h-5 w-5 flex-none'"></i>
                                </button>
                                <div x-show="showServices" x-cloak class="mt-2 space-y-2">
                                    <a aria-label="Request a Quote" href="{{route('request-a-quote')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Request a Quote</a>
                                    <a aria-label="Specials" href="{{route('specials')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Specials</a>
                                    <a aria-label="Careers" href="{{route('careers')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Careers</a>
                                </div>
                            </div>

                            <!-- Company Dropdown -->
                            <div class="-mx-3">
                                <button @click="showCompany = !showCompany" type="button"
                                        class="flex w-full items-center justify-between rounded-lg py-3 pl-4 pr-3.5 text-base font-semibold leading-7 text-white hover:bg-white/10 transition-all duration-200">
                                    Company
                                    <i class="fad fa-chevron-down h-5 w-5 flex-none" :class="showCompany ? 'rotate-180':''"></i>
                                </button>
                                <div x-show="showCompany" x-cloak class="mt-2 space-y-2">
                                    <a aria-label="About Us" href="{{route('about-us')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">About Us</a>
                                    <a aria-label="Why Danielle Fence" href="{{route('why-danielle-fence')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Why Danielle Fence</a>
                                    <a aria-label="Blog" href="{{route('blog')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Blog</a>
                                    <a aria-label="FAQ" href="{{route('faq')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">FAQ</a>
                                    <a aria-label="Reviews" href="{{route('reviews')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Reviews</a>
                                    <a aria-label="Hardware Catalog" href="/hardware-catalog.pdf" target="_blank"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Hardware Catalog</a>
                                    <a aria-label="Showcase" href="/showcase.pdf" target="_blank"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Showcase</a>
                                    <a aria-label="Fire Features Catalogs" href="{{route('fire-feature-catalogs')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">Fire Feature Catalogs</a>
                                    <a aria-label="The Pickett Pals!" href="{{route('pickett-pals')}}"
                                       class="block rounded-lg py-2.5 pl-8 pr-3 text-sm font-medium leading-6 text-white/90 hover:text-white hover:bg-white/10 transition-all duration-200">The Pickett Pals!</a>
                                </div>
                            </div>

                            <!-- Contact Us -->
                            <a aria-label="Contact Us" href="{{route('contact')}}"
                               class="-mx-3 block rounded-lg px-4 py-3 text-base font-semibold leading-7 text-white hover:bg-white/10 transition-all duration-200">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <x-reviews-marquee />
</div>
