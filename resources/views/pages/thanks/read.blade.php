<x-app-layout>
    <x-page-wrap>
        <x-page-heading>
            <x-slot name="heading">Thanks for contacting us!</x-slot>
            <x-slot name="subheading">We have received your request.  Please give us a little time and someone will get back with you.  Usually within 24 hours.</x-slot>
        </x-page-heading>
        <a href="{{route('home')}}" class="flex mt-8 items-center justify-center">
            <x-button.danger size="large">Take me home</x-button.danger>
        </a>
    </x-page-wrap>
</x-app-layout>
