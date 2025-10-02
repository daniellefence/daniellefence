<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            @livewire('product-configurator', ['product' => $product])
        </div>
    </div>
</x-app-layout>