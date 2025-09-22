<x-app-layout>
    <x-page-wrap>
        <div class="flex items-center justify-center py-8 bg-gradient-to-r from-brand-light to-white">
            <a href="{{route('contact')}}" class="inline-flex items-center px-8 py-4 bg-brand-primary text-brand-light font-semibold rounded-lg hover:bg-brand-primary/90 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                Contact us to purchase
            </a>
        </div>
        <div style="height: 100vh;">
            <embed class="flex flex-col" src="{{Vite::asset('resources/catalogs/hardware-catalog.pdf')}}"  width="100%" height="100%"
                   type="application/pdf">
        </div>

    </x-page-wrap>
</x-app-layout>'