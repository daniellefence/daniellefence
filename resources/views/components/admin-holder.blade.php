<x-admin-layout>
    <div {{$attributes}} wire:ignore.self>

        <div class=" bg-white rounded shadow-lg border">

            <main class="py-10 rounded-xl">
                <div class="px-4 sm:px-6 lg:px-8 overflow-auto">
                    {{$slot}}
                </div>
            </main>
        </div>
    </div>
</x-admin-layout>

