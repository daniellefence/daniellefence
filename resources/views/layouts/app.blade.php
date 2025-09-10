<!DOCTYPE html>
<html class="h-full antialiased" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('seo.site_name', 'Danielle Fence - Professional Fence Installation') }}</title>
    <meta name="description" content="{{ config('seo.default_description', 'Professional fence installation and DIY fence supplies. Aluminum, vinyl, wood fencing. 49 years serving Central Florida.') }}">
    <link href="{{ asset('fonts/figtree.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    <meta name="msapplication-TileColor" content="#8e2a2a">
    <meta name="theme-color" content="#ffffff">
    @livewireStyles
    @stack('head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans relative antialiased">
    <x-header/>
    <div class="relative">
        {{ $slot }}
    </div>
    <x-footer/>
    @livewireScripts
    @stack('scripts')
    @stack('modals')
</body>
</html>
