<div x-data="{
        showMobile:false
    }">
    <div class="upper-header hidden lg:block sticky py-2 text-white top-0 z-20">
        <div class="container mx-auto">
            <div class="flex items-center justify-between">
                <div>
                    Call <a href="tel:8634253182">(863) 425-3182</a> or <a href="tel:8136816181">(813) 681-6181</a>
                </div>
                <div>
                    <a href="{{ route('diy.quote') }}">
                        <button class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-danielle bg-white hover:bg-gray-100 border-0 ring-0">
                            Request an estimate
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <header class="relative z-10">
        <nav class="mx-auto flex max-w-7xl items-center justify-between py-4 pr-4">
            <div class="flex lg:flex-1 relative" id="logo-holder">
                <a aria-label="Danielle Fence Logo" href="{{ route('welcome') }}" class="-m-1.5 p-1.5 header-logo">
                    <span class="sr-only">{{ config('app.name') }}</span>
                    <img
                        class="h-10 ml-4 sm:ml-0 xl:h-36 lg:h-24 w-auto border-2 border-white rounded-lg shadow-xl hover:shadow-none"
                        src="{{ asset('images/logo.webp') }}"
                        alt="Danielle Fence Logo">
                </a>
            </div>
            <div class="flex gap-6 lg:hidden">
                <button
                    @click="showMobile = true"
                    @keyup.escape.window="showMobile = false"
                    type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-1 text-white bg-danielle">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-6">
                <a aria-label="DIY Products" href="{{ route('diy.products') }}" class="nav-item">DIY Products</a>
                <a aria-label="Request Quote" href="{{ route('diy.quote') }}" class="nav-item">Get Quote</a>
                <a aria-label="Order Supplies" href="{{ route('diy.order') }}" class="nav-item">Order Supplies</a>
                <a aria-label="Contact Us" href="{{ route('contact') ?? '#' }}" class="nav-item">Contact</a>
            </div>
        </nav>
        
        <div x-data="{
            showProducts:false,
        }" class="lg:hidden" role="dialog" aria-modal="true" aria-label="Menu">
            <div x-show="showMobile" x-cloak class="fixed inset-0 z-10"></div>
            <div x-show="showMobile" x-cloak @click.outside="showMobile=false"
                 class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-danielle px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <div class="text-white">
                        Call <a aria-label="Phone Number" href="tel:863-425-3182">(863) 425-3182</a>
                    </div>
                    <button @click="showMobile = false" type="button" class="-m-2.5 rounded-md p-2.5 text-danielle">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6 fill-white" viewBox="0 0 24 24" stroke-width="1.5">
                            <path class="stroke-white" stroke-linecap="round" stroke-linejoin="round"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a aria-label="DIY Products" href="{{ route('diy.products') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white focus:text-gray-900 hover:text-black hover:bg-gray-50">DIY Products</a>
                            <a aria-label="Request Quote" href="{{ route('diy.quote') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white focus:text-gray-900 hover:text-black hover:bg-gray-50">Get Quote</a>
                            <a aria-label="Order Supplies" href="{{ route('diy.order') }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white focus:text-gray-900 hover:text-black hover:bg-gray-50">Order Supplies</a>
                            <a aria-label="Contact Us" href="{{ route('contact') ?? '#' }}"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-white focus:text-gray-900 hover:text-black hover:bg-gray-50">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>