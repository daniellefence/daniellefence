<x-app-layout>
    <livewire:search wire:key="search{{rand(0,10000)}}" :q="request()->input('q')" lazy/>
</x-app-layout>
