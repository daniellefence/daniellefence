<x-app-layout>
    <x-page-heading>
        <x-slot name="heading">Videos</x-slot>
        <x-slot name="subheading">These are some of the videos from our Youtube Channel</x-slot>
    </x-page-heading>
    <div class="bg-white pb-16">
        <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
            <div role="list" class="flex flex-wrap justify-center gap-8">
                @foreach(\App\Models\Video::all() as $video)
                    <div class="relative bg-white rounded-2xl shadow-lg p-6 border border-brand-light hover:shadow-xl transition-shadow duration-300">
                        <livewire:video lazy :video="$video" wire:key="video-{{$video->id.rand(0,10000)}}"/>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
