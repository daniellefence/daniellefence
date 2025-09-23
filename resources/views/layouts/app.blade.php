<!DOCTYPE html>
<html class="h-full antialiased" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $pageTitle ?? seo()->meta('title') }}</title>
    <meta name="description" content="{{ $pageDescription ?? seo()->meta('description') }}">
    <meta name="keywords" content="{{ $pageKeywords ?? seo()->meta('keywords') }}">
    <meta name="author" content="Danielle Fence & Outdoor Living">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ config('app.url') }}">

    <!-- Geographic Meta Tags -->
    <meta name="geo.region" content="US-FL">
    <meta name="geo.placename" content="Florida">
    <meta name="geo.position" content="27.7663,-82.6404">
    <meta name="ICBM" content="27.7663,-82.6404">

    <!-- Business Meta Tags -->
    <meta name="rating" content="5">
    <meta name="distribution" content="global">
    <meta name="revisit-after" content="1 days">
    <meta name="language" content="English">
    <meta name="expires" content="never">
    <meta name="coverage" content="Worldwide">
    <meta name="target" content="all">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">

    <!-- Performance Optimization -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://script.advertiserreports.com">
    <link rel="dns-prefetch" href="https://kit.fontawesome.com">

    <!-- Core Web Vitals Optimization -->
    <meta name="format-detection" content="telephone=no">
    <meta name="color-scheme" content="light">
    <meta http-equiv="x-dns-prefetch-control" content="on">

    <!-- Critical Resource Hints -->
    <link rel="preload" href="https://fonts.bunny.net/inter/files/inter-latin-400-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/inter/files/inter-latin-600-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=playfair-display:400,500,600,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=playfair-display:400,500,600,700&display=swap" rel="stylesheet"></noscript>

    <!-- Preload critical images -->
    <link rel="preload" href="{{Vite::asset('resources/images/logo.webp')}}" as="image" type="image/webp">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('site.webmanifest')}}">
       <meta name="msapplication-TileColor" content="#8e2a2a">
    <meta name="theme-color" content="#ffffff">
    <link rel="mask-icon" href="{{url('safari-pinned-tab.svg')}}" color="#8e2a2a">
    <link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" media="print" onload="this.media='all'" crossorigin="anonymous">
    <noscript><link href="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/css/swiffy-slider.min.css" rel="stylesheet" crossorigin="anonymous"></noscript>
    <x-google-analytics/>
	

    <x-open-graph/>
    <x-schema-markup/>

    <!-- FontAwesome Kit - Defer loading -->
    <script src="https://kit.fontawesome.com/560f7d512e.js" crossorigin="anonymous" async></script>

    @livewireStyles
    @stack('head')
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Removed critical CSS component that was overriding brand styles -->

    <!-- Defer non-critical scripts -->
    <script>
        // Suppress browser extension errors - deferred
        window.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('error', function(e) {
                if (e.filename && e.filename.includes('chrome-extension://')) {
                    e.preventDefault();
                    return false;
                }
            });

            window.addEventListener('unhandledrejection', function(e) {
                if (e.reason && e.reason.message && e.reason.message.includes('chrome-extension://')) {
                    e.preventDefault();
                    return false;
                }
            });

            const originalConsoleError = console.error;
            console.error = function(...args) {
                const message = args.join(' ');
                if (!message.includes('chrome-extension://') &&
                    !message.includes('ERR_FILE_NOT_FOUND') &&
                    !message.includes('completion_list.html')) {
                    originalConsoleError.apply(console, args);
                }
            };
        });
    </script>
</head>
<body class="font-sans relative antialiased ">
<template>
    <x-color-loader/>
</template>
<x-banner/>
<x-to-top/>
<x-header/>
<div class="relative">
    {{ $slot ?? '' }}
    @yield('content')
</div>
<livewire:footer lazy="on-load"/>
@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider.min.js" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/swiffy-slider@1.6.0/dist/js/swiffy-slider-extensions.min.js" crossorigin="anonymous" defer></script>

<!-- Optimized Performance Monitoring -->
<script>
    // Critical performance optimizations
    (function() {
        // Preload critical resources immediately
        const preloadImportantAssets = () => {
            // Preload hero images if they exist
            const heroImages = document.querySelectorAll('.hero img, [data-hero] img');
            heroImages.forEach(img => {
                if (img.src && !img.src.includes('data:')) {
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = img.src;
                    document.head.appendChild(link);
                }
            });
        };

        // Optimized lazy loading with reduced threshold
        const initLazyLoading = () => {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                }, {
                    rootMargin: '50px',
                    threshold: 0.1
                });

                document.querySelectorAll('img[data-src]').forEach(img => imageObserver.observe(img));
            }
        };

        // Enhanced prefetching with priority
        const initSmartPrefetch = () => {
            const links = document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]');
            links.forEach(link => {
                const prefetchLink = () => {
                    if (!link.dataset.preloaded) {
                        const linkTag = document.createElement('link');
                        linkTag.rel = 'prefetch';
                        linkTag.href = link.href;
                        document.head.appendChild(linkTag);
                        link.dataset.preloaded = 'true';
                    }
                };

                // Prefetch on hover with immediate execution
                link.addEventListener('mouseenter', prefetchLink, { once: true });
                // Also prefetch on touch for mobile
                link.addEventListener('touchstart', prefetchLink, { once: true });
            });
        };

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                preloadImportantAssets();
                initLazyLoading();
                initSmartPrefetch();
            });
        } else {
            preloadImportantAssets();
            initLazyLoading();
            initSmartPrefetch();
        }
    })();

    // Service Worker Registration for Performance
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        });
    }
</script>

@stack('scripts')
@stack('modals')

</body>
</html>
