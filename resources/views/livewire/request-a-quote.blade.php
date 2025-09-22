<div class="mx-auto max-w-7xl px-6 lg:px-8">
    <!-- Section Header -->
    <div class="mx-auto max-w-2xl text-center mb-16">
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Choose Your Project Type
        </h2>
        <p class="mt-4 text-lg text-gray-600">
            Select the service you're interested in below, complete the form, and we'll get back to you with a personalized estimate.
        </p>
    </div>

    <!-- Contact Options -->
    <div class="mb-12 rounded-2xl border border-gray-200 bg-white p-8 shadow-lg ring-1 ring-gray-900/5">
        <div class="flex items-center gap-4 mb-6">
            <div class="flex-shrink-0">
                <svg class="h-8 w-8 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Prefer to speak with someone?</h3>
                <p class="text-gray-600">We're here to help with any questions you might have.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                </svg>
                <div>
                    <p class="font-medium text-gray-900">Call us directly</p>
                    <div class="flex flex-wrap gap-x-4">
                        <a href="tel:8634253182" class="text-brand-primary hover:text-brand-primary/80 font-medium transition-colors">
                            (863) 425-3182
                        </a>
                        <a href="tel:8136816181" class="text-brand-primary hover:text-brand-primary/80 font-medium transition-colors">
                            (813) 681-6181
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                </svg>
                <div>
                    <p class="font-medium text-gray-900">Send us an email</p>
                    <a href="mailto:sales@daniellefence.net" class="text-brand-primary hover:text-brand-primary/80 font-medium transition-colors">
                        sales@daniellefence.net
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Type Selection -->
    <div class="mb-12">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 text-center">What type of project are you planning?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button wire:click="setType('fence')"
                    class="group relative overflow-hidden rounded-xl border-2 p-6 text-left transition-all duration-200 hover:shadow-lg
                           {{ $type == 'fence' ? 'border-brand-primary bg-brand-primary text-white shadow-lg ring-1 ring-brand-primary' : 'border-gray-200 bg-white text-gray-900 hover:border-brand-primary/50' }}">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 {{ $type == 'fence' ? 'text-white' : 'text-brand-primary' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205l3 1m1.5.5l-1.5-.5M6.75 7.364V3h-3v18m3-13.636l10.5-3.819" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold">Fence & Gate</h4>
                        <p class="text-sm {{ $type == 'fence' ? 'text-white/80' : 'text-gray-600' }}">
                            Residential & commercial fencing solutions
                        </p>
                    </div>
                </div>
            </button>

            <button wire:click="setType('kitchen')"
                    class="group relative overflow-hidden rounded-xl border-2 p-6 text-left transition-all duration-200 hover:shadow-lg
                           {{ $type == 'kitchen' ? 'border-brand-primary bg-brand-primary text-white shadow-lg ring-1 ring-brand-primary' : 'border-gray-200 bg-white text-gray-900 hover:border-brand-primary/50' }}">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 {{ $type == 'kitchen' ? 'text-white' : 'text-brand-primary' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold">Outdoor Kitchen</h4>
                        <p class="text-sm {{ $type == 'kitchen' ? 'text-white/80' : 'text-gray-600' }}">
                            Custom outdoor cooking spaces
                        </p>
                    </div>
                </div>
            </button>

            <button wire:click="setType('spaces')"
                    class="group relative overflow-hidden rounded-xl border-2 p-6 text-left transition-all duration-200 hover:shadow-lg
                           {{ $type == 'spaces' ? 'border-brand-primary bg-brand-primary text-white shadow-lg ring-1 ring-brand-primary' : 'border-gray-200 bg-white text-gray-900 hover:border-brand-primary/50' }}">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 {{ $type == 'spaces' ? 'text-white' : 'text-brand-primary' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold">Outdoor Spaces</h4>
                        <p class="text-sm {{ $type == 'spaces' ? 'text-white/80' : 'text-gray-600' }}">
                            Pavers, decks & living areas
                        </p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <!-- Quote Form -->
    <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-gray-900/5">
        @switch($type)
            @case('fence')
                <livewire:request-a-fence-quote wire:key="livewire-request-a-fence-quote{{rand(0,1000)}}" lazy />
                @break
            @case('kitchen')
                <livewire:request-an-outdoor-kitchen-quote wire:key="livewire-request-an-outdoor-kitchen-quote{{rand(0,1000)}}" lazy />
                @break
            @case('spaces')
                <livewire:request-an-outdoor-spaces-quote wire:key="livewire-request-an-outdoor-spaces-quote{{rand(0,1000)}}" lazy />
                @break
        @endswitch
    </div>
</div>
