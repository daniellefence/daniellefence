@props([
    'title' => null,
    'subtitle' => null,
    'method' => 'POST',
    'action' => null
])

<x-admin-card :title="$title" :subtitle="$subtitle">
    <form {{ $attributes }} method="{{ $method }}" action="{{ $action }}" class="admin-form space-y-6">
        @if($method !== 'GET')
            @csrf
        @endif

        @if($method === 'PUT' || $method === 'PATCH' || $method === 'DELETE')
            @method($method)
        @endif

        {{ $slot }}
    </form>
</x-admin-card>