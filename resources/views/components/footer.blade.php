<footer class="relative" style="background: linear-gradient(to bottom, transparent 0%, transparent 40%, #87CEEB 40%, #87CEEB 70%, #90EE90 70%, #90EE90 100%); min-height: 200px;">
    <!-- Fence Pattern -->
    <div class="absolute inset-x-0 z-0" style="top: 20%; bottom: 30%; background-image: url('{{ asset('images/fence.webp') }}'); background-repeat: repeat-x; background-position: center; background-size: auto 100%;"></div>
    
    <!-- Grass decoration at bottom -->
    <div class="absolute inset-x-0 bottom-0 z-0 h-24">
        <div class="absolute inset-0" style="background-image: url('{{ asset('images/grass.svg') }}'); background-repeat: repeat-x; background-position: bottom; background-size: auto 80%;"></div>
    </div>
    
    <!-- Footer Content -->
    <div class="relative z-10 mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
        <div class="flex justify-center space-x-6 md:order-2">
            <div class="text-center">
                <h3 class="text-sm font-semibold leading-6 text-gray-900">Contact Information</h3>
                <div class="mt-2 space-y-1 text-xs leading-5 text-gray-600">
                    <p>Call: (863) 425-3182 or (813) 681-6181</p>
                    <p>Email: info@daniellefence.net</p>
                </div>
            </div>
        </div>
        <div class="mt-8 md:order-1 md:mt-0">
            <p class="text-center text-xs leading-5 text-gray-500">
                &copy; {{ date('Y') }} Danielle Fence. All rights reserved.
            </p>
        </div>
    </div>
</footer>