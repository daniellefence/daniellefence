<x-app-layout>
    <x-page-wrap>
        <div x-data="{
            show:'showcase'
        }">
            <div class="flex justify-center items-center">
                <div class="mt-10 mb-10 grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <button @click="show='showcase'" type="button"
                            class="inline-flex justify-center items-center border rounded-md font-semibold uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150   px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            :class="show == 'showcase' ? 'bg-danger border-danger text-white hover:bg-danger_alt focus:ring-danger_alt focus-visible:outline-danger_alt':'bg-gray-100 border-gray-200 text-black hover:bg-gray-200 focus:ring-gray-200 focus-visible:outline-gray-200'"
                    >
                        Showcase
                    </button>
                    <button @click="show='hardware_catalog'" type="button"
                            class="inline-flex justify-center items-center border rounded-md font-semibold uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150   px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            :class="show == 'hardware_catalog' ? 'bg-danger border-danger text-white hover:bg-danger_alt focus:ring-danger_alt focus-visible:outline-danger_alt':'bg-gray-100 border-gray-200 text-black hover:bg-gray-200 focus:ring-gray-200 focus-visible:outline-gray-200'"
                    >
                        Hardware Catalog
                    </button>
                    <button @click="show='fire_features_catalogs'" type="button"
                            class="inline-flex justify-center items-center border rounded-md font-semibold uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150   px-2 py-2 text-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            :class="show == 'fire_features_catalogs' ? 'bg-danger border-danger text-white hover:bg-danger_alt focus:ring-danger_alt focus-visible:outline-danger_alt':'bg-gray-100 border-gray-200 text-black hover:bg-gray-200 focus:ring-gray-200 focus-visible:outline-gray-200'"
                    >
                        Fire Features Catalogs
                    </button>
                </div>
            </div>
            <div>
                <div x-cloak x-show="show=='showcase'">
                    <embed style="width:100%;" class="min-h-screen" src="hardware-catalog.pdf" type="application/pdf"/>
                </div>
                <div x-cloak x-show="show=='hardware_catalog'">hardware catalog</div>
                <div x-cloak x-show="show=='fire_features_catalogs'">fire features catalogs</div>
            </div>
        </div>
    </x-page-wrap>
</x-app-layout>