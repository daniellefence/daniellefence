<!DOCTYPE html>
<html class="h-full bg-white " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ seo()->meta('title') }}</title>
    <meta name="keywords" content="{{seo()->meta('keywords')}}">
    <meta name="description" content="{{seo()->meta('description')}}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#8e2a2a">
    <meta name="msapplication-TileColor" content="#8e2a2a">
    <meta name="theme-color" content="#ffffff">
    <!-- CKEditor 5 will be loaded per component as needed -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.32.6/filepond.css" rel="stylesheet">
    @livewireStyles
    @stack('head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">
<x-banner/>
<template>
    <x-color-loader/>
</template>

<div class="min-h-full">
    @auth
        <div class="fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col lg:border-r lg:border-gray-200 lg:bg-gray-100 lg:pb-4 lg:pt-5">
            <!-- Logo -->
            <div class="flex items-center justify-center px-4 py-4">
                <a href="{{ route('admin.read') }}" class="flex items-center hover:opacity-80 transition-opacity">
                    <img class="w-auto" src="{{ asset('logo-small.png') }}" alt="Danielle Fence & Outdoor Living">
                </a>
            </div>

            <div class="mt-2 flex h-0 flex-1 flex-col overflow-y-auto pt-1 admin-sidebar">
                        <nav class="mt-6 px-3">
                            <div class="space-y-1">
                                @php
                                    $allMenuItems = adminMenu()->get();
                                    $systemItems = [];
                                    $customerItems = ['Contacts', 'Quote Requests', 'Reviews'];
                                    $contentItems = ['Blogs', 'FAQ', 'Areas We Serve'];
                                    $marketingItems = ['Google Analytics Code'];
                                    $careerItems = ['Careers', 'Applications'];
                                    $specialItems = ['LLMs.txt Editor', 'Sitemap.xml Editor', 'S.E.O.'];
                                    $diyItems = ['DIY Colors', 'DIY Heights', 'DIY Spacings', 'DIY Product Categories'];
                                    $productItems = ['Products'];
                                    $userItems = ['Users', 'Roles', 'Permissions'];
                                    $trafficItems = ['Traffic'];
                                    $promotionItems = ['Specials'];

                                    $bottomSystemItems = array_filter($allMenuItems, function($item) use ($systemItems) {
                                        return in_array($item['label'], $systemItems);
                                    });
                                    $bottomCustomerItems = array_filter($allMenuItems, function($item) use ($customerItems) {
                                        return in_array($item['label'], $customerItems);
                                    });
                                    $bottomContentItems = array_filter($allMenuItems, function($item) use ($contentItems) {
                                        return in_array($item['label'], $contentItems);
                                    });
                                    $bottomMarketingItems = array_filter($allMenuItems, function($item) use ($marketingItems) {
                                        return in_array($item['label'], $marketingItems);
                                    });
                                    $bottomCareerItems = array_filter($allMenuItems, function($item) use ($careerItems) {
                                        return in_array($item['label'], $careerItems);
                                    });
                                    $bottomPromotionItems = array_filter($allMenuItems, function($item) use ($promotionItems) {
                                        return in_array($item['label'], $promotionItems);
                                    });
                                    $bottomTrafficItems = array_filter($allMenuItems, function($item) use ($trafficItems) {
                                        return in_array($item['label'], $trafficItems);
                                    });
                                    $bottomUserItems = array_filter($allMenuItems, function($item) use ($userItems) {
                                        return in_array($item['label'], $userItems);
                                    });
                                    $bottomProductItems = array_filter($allMenuItems, function($item) use ($productItems) {
                                        return in_array($item['label'], $productItems);
                                    });
                                    $bottomDiyItems = array_filter($allMenuItems, function($item) use ($diyItems) {
                                        return in_array($item['label'], $diyItems);
                                    });
                                    $bottomItems = array_filter($allMenuItems, function($item) use ($specialItems) {
                                        return in_array($item['label'], $specialItems);
                                    });
                                @endphp

                                <!-- Customer Management -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Customer Management</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomCustomerItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Content Management -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Content Management</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomContentItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Human Resources -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Human Resources</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomCareerItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Promotions -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Promotions</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomPromotionItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Statistics -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Statistics</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomTrafficItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Marketing -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Marketing</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomMarketingItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- User Management -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">User Management</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomUserItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Product Management -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Product Management</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomProductItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- DIY Management -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">DIY Management</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomDiyItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>

                                <!-- Search Engine Optimization -->
                                <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wide mb-1">Search Engine Optimization</div>
                                <div class="space-y-1 mb-3">
                                    @foreach($bottomItems as $menu)
                                        <x-nav-item :menu="$menu"/>
                                    @endforeach
                                </div>
                            </div>
                        </nav>

                        <!-- Buttons and User Menu at Bottom -->
                        <div class="mt-auto px-3 pb-4">
                            <!-- User Management Button -->
                            <a href="{{ route('admin.user.read') }}"
                               class="w-full inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mb-2">
                                User Management
                            </a>

                            <!-- Activity Button -->
                            <a href="{{ route('admin.read') }}"
                               class="w-full inline-flex items-center justify-center rounded-md bg-outdoor-primary px-3 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-outdoor-primary focus:ring-offset-2 mb-2">
                                Activity
                            </a>

                            <!-- General Settings Link -->
                            <a href="{{ route('admin.general.read') }}"
                               class="w-full inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mb-2">
                                General Settings
                            </a>

                            <!-- Profile Dropdown -->
                            <div x-data="{showProfile:false}"
                                @keyup.window.escape="showProfile = false"
                                @click.outside="showProfile = false"
                                class="relative inline-block text-left w-full">
                                <div>
                                    <button @click="showProfile = true" type="button"
                                            class="group w-full rounded-md bg-gray-100 px-3.5 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-outdoor-primary focus:ring-offset-2 focus:ring-offset-gray-100"
                                            id="options-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="flex w-full items-center justify-between">
                                            <span class="flex min-w-0 items-center justify-between space-x-3">
                                                <img class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300"
                                                    src="{{auth()->user()->profile_photo_url}}"
                                                    alt="{{auth()->user()->name}}">
                                                    <span class="flex min-w-0 flex-1 flex-col">
                                                        <span class="truncate text-sm font-medium text-gray-900">{{auth()->user()->name}}</span>
                                                        <span class="truncate text-sm text-gray-500">{{auth()->user()->title}}</span>
                                                    </span>
                                                    </span>
                                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                         d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z"
                                                            clip-rule="evenodd"/>
                                                </svg>
                                                </span>
                                            </button>
                                        </div>
                                        <div
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            x-show="showProfile"
                                            x-cloak
                                            class="absolute left-0 right-0 z-10 bottom-full mb-1 origin-bottom divide-y divide-gray-200 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                            role="menu" aria-orientation="vertical" aria-labelledby="options-menu-button" tabindex="-1">
                                            <div class="py-1" role="none">
                                                <a href="{{route('profile.show')}}" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Profile</a>
                                            </div>
                                            <div class="py-1" role="none">
                                                <form method="post" action="{{route('logout')}}">
                                                    @csrf
                                                    <button type="submit" class="w-ful text-left text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1">Logout</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            @endauth
            <div class="flex flex-col lg:pl-64">

                    <main class="flex-1">
                @auth
                        <div class="border-b border-gray-200 px-4 py-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="min-w-0 flex-1">
                    <h1 class="text-lg font-medium leading-6 text-gray-900 sm:truncate">{{danielle()->pageHeader('title')}}</h1>
                </div>
                <div class="mt-4 flex sm:ml-4 sm:mt-0 gap-1">
                    @foreach(danielle()->pageHeader('buttons') as $button)
                        <a href="{{env('APP_URL').'/'.$button['route']}}">
                            <button type="button"
                                    class="sm:order-0 order-1 ml-3 inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:ml-0">
                                @if(isset($button['icon']))
                                    <x-dynamic-component class="fill-outdoor-primary w-6 h-6" :component="'icon.'.$button['icon']"/>
                                @else
                                    {{$button['label']}}
                                @endif
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>
            @endauth
            {{$slot}}
        </main>
    </div>
</div>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.32.6/filepond.min.js" integrity="sha512-sVH0xv/XXXk6JOql+ha35za7uIeFNQxhSAo2tHAmvloeDRXLLBdhablKfZg38beXDzJCHr/+Z7x2aP0o7Lk/Fg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- CKEditor 5 will be loaded per component as needed -->

@livewireScripts
@stack('scripts')
@stack('modals')
</body>
</html>
