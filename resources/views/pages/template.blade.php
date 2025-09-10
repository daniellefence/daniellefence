<x-app-layout>
<div class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4">
        <h1 class="text-3xl font-bold mb-8">{{ $title ?? 'Page Title' }}</h1>
        <div class="prose max-w-none">
            {{ $content ?? 'Page content will be loaded from database.' }}
        </div>
    </div>
</div>
</x-app-layout>
