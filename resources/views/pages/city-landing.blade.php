@extends('layouts.app')

@section('content')
<div class="relative isolate overflow-hidden bg-gray-900">
    <!-- Hero Section -->
    @php
        $mapUrl = $area->hasMapDisplay() ? $area->getMapBackgroundUrl(1920, 1080, 12) : null;
        $hasValidMap = $mapUrl && !empty($mapUrl);
    @endphp

    <div class="relative py-20 sm:py-24 flex items-center overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"
         @if($hasValidMap)
         style="background-image: linear-gradient(rgba(17, 24, 39, 0.8), rgba(17, 24, 39, 0.8)), url('{{ $mapUrl }}'); background-size: cover; background-position: center;"
         @endif>

        <!-- Enhanced animated background -->
        <div class="absolute inset-0 opacity-20">
            <!-- Animated mesh gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-brand-primary-600/20 via-transparent to-yellow-500/20 animate-pulse"></div>
            <!-- Floating geometric shapes -->
            <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-yellow-400/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/3 right-1/4 w-40 h-40 bg-brand-primary-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
            <!-- Subtle dot pattern -->
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.1) 2px, transparent 2px), radial-gradient(circle at 75% 75%, rgba(255, 193, 7, 0.1) 1px, transparent 1px); background-size: 100px 100px; animation: float 8s ease-in-out infinite;"></div>
        </div>

        <!-- Neomorphic floating elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="neo-icon absolute top-1/4 left-1/4 w-3 h-3 animate-float" style="animation-delay: 0s; animation-duration: 4s;"></div>
            <div class="neo-icon absolute top-1/3 right-1/3 w-2 h-2 animate-float" style="animation-delay: 1s; animation-duration: 5s;"></div>
            <div class="neo-icon absolute bottom-1/4 left-1/3 w-4 h-4 animate-float" style="animation-delay: 2s; animation-duration: 6s;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 z-10 w-full">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Clean hero card matching site design -->
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg p-8 lg:p-12 border border-gray-100">

                    <!-- Premium badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-brand-primary-50 border border-brand-primary-200 rounded-full text-brand-primary-700 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Premium Since 1976
                    </div>

                    <!-- Main headline -->
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl mb-6">
                        {{ $area->title }}'s
                        <span class="text-brand-primary-900">Premier Fence</span>
                        <span class="block text-2xl sm:text-3xl lg:text-4xl text-gray-600 font-medium mt-2">Experts</span>
                    </h1>

                    <!-- Description -->
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                        Transform your {{ $area->title }} property with premium fencing solutions.
                        <span class="font-semibold text-brand-primary-700">Professional installation</span>,
                        <span class="font-semibold text-brand-primary-700">unbeatable quality</span>,
                        <span class="font-semibold text-brand-primary-700">lifetime satisfaction guaranteed</span>.
                    </p>

                    <!-- CTA buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-8">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-brand-primary-900 text-white font-semibold rounded-lg hover:bg-brand-primary-800 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Get FREE Estimate
                        </a>

                        <a href="tel:{{ config('app.phone', '863-665-1447') }}" class="inline-flex items-center px-6 py-4 text-brand-primary-900 font-semibold hover:text-brand-primary-700 transition-colors duration-200">
                            <div class="flex items-center justify-center w-10 h-10 bg-brand-primary-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-brand-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="text-sm text-gray-500">Call Now</div>
                                <div class="text-lg font-bold">(863) 665-1447</div>
                            </div>
                        </a>
                    </div>

                    <!-- Trust indicators -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
                        <div class="flex items-center justify-center px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-green-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Licensed & Insured
                        </div>
                        <div class="flex items-center justify-center px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            50+ Years Experience
                        </div>
                        <div class="flex items-center justify-center px-4 py-3 bg-orange-50 border border-orange-200 rounded-lg text-orange-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            FREE Estimates
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Services Section -->
    <div class="py-24 sm:py-32 bg-gradient-to-b from-gray-200 via-gray-300 to-gray-400">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <div class="inline-flex items-center px-4 py-2 bg-brand-primary-600/20 border border-brand-primary-500/30 rounded-full text-brand-primary-800 text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Premium Fencing Solutions
                </div>

                <h2 class="text-2xl font-black tracking-tight text-gray-900 sm:text-3xl mb-6">
                    Transform Your {{ $area->title }} Property
                </h2>

                @if($area->services_content)
                    <div class="text-lg leading-8 text-gray-800 prose prose-lg max-w-none">
                        {!! $area->services_content !!}
                    </div>
                @else
                    <p class="text-lg leading-8 text-gray-800 max-w-2xl mx-auto">
                        From residential privacy fences to commercial security solutions, we deliver premium fencing that enhances your property value and provides lasting protection.
                    </p>
                @endif
            </div>

            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Vinyl Fencing -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white group relative overflow-hidden hover-lift hover-morph rounded-3xl shadow-xl border border-gray-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative p-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 hover-elastic">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">Vinyl Fencing</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Weather-resistant, maintenance-free vinyl fencing that looks beautiful for decades. Perfect for {{ $area->title }}'s climate.</p>
                            <a href="{{ route('city.vinyl-fencing', $area->slug) }}" class="hover-magnetic inline-flex items-center text-lg font-semibold text-blue-600 hover:text-blue-700 group-hover:translate-x-2 transition-all duration-300">
                                Explore Vinyl Options
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 group-hover:scale-125 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Wood Fencing -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white group relative overflow-hidden hover-tilt hover-glow rounded-3xl shadow-xl border border-gray-200">
                        <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative p-8">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-600 to-amber-700 rounded-2xl flex items-center justify-center mb-6 hover-bounce">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-amber-600 transition-colors">Wood Fencing</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Timeless natural beauty with customizable staining and design options. Classic elegance for {{ $area->title }} homes.</p>
                            <a href="{{ route('city.wood-fencing', $area->slug) }}" class="hover-ripple inline-flex items-center text-lg font-semibold text-amber-600 hover:text-amber-700 group-hover:translate-x-2 transition-all duration-300">
                                View Wood Styles
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 group-hover:rotate-12 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Chain Link Fencing -->
                <div class="group relative overflow-hidden rounded-3xl bg-white shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-gray-600 to-gray-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-gray-600 transition-colors">Chain Link Fencing</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Durable, cost-effective security fencing for commercial and residential properties throughout {{ $area->title }}.</p>
                        <a href="{{ route('city.chain-link-fencing', $area->slug) }}" class="inline-flex items-center text-lg font-semibold text-gray-700 hover:text-gray-800 group-hover:translate-x-2 transition-all duration-300">
                            Security Solutions
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Commercial Fencing -->
                <div class="group relative overflow-hidden rounded-3xl bg-white shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors">Commercial Fencing</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Professional-grade fencing solutions for {{ $area->title }} businesses, warehouses, and industrial facilities.</p>
                        <a href="{{ route('city.commercial-fencing', $area->slug) }}" class="inline-flex items-center text-lg font-semibold text-indigo-600 hover:text-indigo-700 group-hover:translate-x-2 transition-all duration-300">
                            Business Solutions
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Fence Installation -->
                <div class="group relative overflow-hidden rounded-3xl bg-white shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-gray-200">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 group-hover:text-green-600 transition-colors">Professional Installation</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Expert installation services with {{ date('Y') - 1976 }}+ years of experience serving {{ $area->title }} properties with precision.</p>
                        <a href="{{ route('city.fence-installation', $area->slug) }}" class="inline-flex items-center text-lg font-semibold text-green-600 hover:text-green-700 group-hover:translate-x-2 transition-all duration-300">
                            Installation Process
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Contact CTA -->
                <div class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-brand-primary-600 to-brand-primary-700 shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-brand-primary-500">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative p-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Free Consultation</h3>
                        <p class="text-yellow-100 mb-6 leading-relaxed">Get your personalized quote and design consultation for your {{ $area->title }} fencing project today.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center text-lg font-semibold text-yellow-300 hover:text-yellow-200 group-hover:translate-x-2 transition-all duration-300">
                            Start Your Project
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dynamic Statistics Section -->
    <div class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-24 sm:py-32 relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-yellow-400 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-40 h-40 bg-brand-primary-400 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center mb-16">
                <div class="inline-flex items-center px-4 py-2 bg-yellow-500/20 border border-yellow-400/30 rounded-full text-yellow-300 text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Trusted by {{ $area->title }} Families
                </div>

                <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                    Central Florida's<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-yellow-300">
                        #1 Fence Company
                    </span>
                </h2>

                <p class="mt-6 text-lg text-gray-300 max-w-2xl mx-auto">
                    {{ date('Y') - 1976 }}+ years of excellence serving {{ $area->title }} and all of Central Florida with unmatched quality and service.
                </p>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 mb-16">
                <div class="neo-pressed text-center group hover-bounce cursor-pointer p-4">
                    <div class="text-5xl font-black text-yellow-400 mb-2 hover-elastic">50+</div>
                    <div class="text-sm font-medium text-gray-300 uppercase tracking-wider">Years Experience</div>
                </div>
                <div class="neo-pressed text-center group hover-shake cursor-pointer p-4">
                    <div class="text-5xl font-black text-yellow-400 mb-2 hover-elastic">10K+</div>
                    <div class="text-sm font-medium text-gray-300 uppercase tracking-wider">Fences Installed</div>
                </div>
                <div class="neo-pressed text-center group hover-float cursor-pointer p-4">
                    <div class="text-5xl font-black text-yellow-400 mb-2 hover-elastic">98%</div>
                    <div class="text-sm font-medium text-gray-300 uppercase tracking-wider">Customer Satisfaction</div>
                </div>
                <div class="neo-pressed text-center group hover-glow cursor-pointer p-4">
                    <div class="text-5xl font-black text-yellow-400 mb-2 hover-elastic">24HR</div>
                    <div class="text-sm font-medium text-gray-300 uppercase tracking-wider">Quote Response</div>
                </div>
            </div>

            <!-- Enhanced Features Grid -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="perspective-card">
                    <div class="perspective-card-inner neo-dark group text-center p-6 hover-lift">
                        <div class="neo-icon mx-auto w-20 h-20 bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center mb-6 hover-elastic">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors">Licensed & Insured</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">Fully licensed contractors with comprehensive insurance coverage protecting every {{ $area->title }} project.</p>
                    </div>
                </div>

                <div class="perspective-card">
                    <div class="perspective-card-inner neo-dark group text-center p-6 hover-tilt">
                        <div class="neo-icon mx-auto w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center mb-6 hover-bounce">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-400 transition-colors">Lifetime Warranty</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">Industry-leading warranty coverage on all materials and workmanship for {{ $area->title }} installations.</p>
                    </div>
                </div>

                <div class="perspective-card">
                    <div class="perspective-card-inner neo-dark group text-center p-6 hover-glow">
                        <div class="neo-icon mx-auto w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-500 flex items-center justify-center mb-6 hover-shake">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-purple-400 transition-colors">Local {{ $area->title }} Experts</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">Deep local knowledge of {{ $area->title }} regulations, soil conditions, and community preferences.</p>
                    </div>
                </div>

                <div class="perspective-card">
                    <div class="perspective-card-inner neo-dark group text-center p-6 hover-magnetic">
                        <div class="neo-icon mx-auto w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center mb-6 hover-float">
                            <svg class="h-10 w-10 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-yellow-400 transition-colors">Transparent Pricing</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">No hidden fees, no surprises. Upfront pricing with detailed quotes for every {{ $area->title }} project.</p>
                    </div>
                </div>
            </div>

            <!-- Customer testimonial preview -->
            <div class="mt-16 text-center">
                <div class="inline-flex items-center gap-2 text-yellow-400 mb-4">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                </div>
                <blockquote class="text-xl text-white italic font-medium max-w-3xl mx-auto">
                    "Danielle Fence transformed our {{ $area->title }} backyard into a private paradise. The quality is outstanding and the team was professional throughout the entire process."
                </blockquote>
                <div class="mt-4 text-gray-400">
                    — Sarah M., {{ $area->title }} Homeowner
                </div>
            </div>
        </div>
    </div>

    @if($area->page_content)
    <!-- Custom Content Section -->
    <div class="py-24 sm:py-32 bg-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl prose prose-lg text-gray-800">
                {!! nl2br(e($area->page_content)) !!}
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced CTA Section -->
    <div class="relative bg-gradient-to-br from-brand-primary-600 via-brand-primary-700 to-brand-primary-800 overflow-hidden">
        <!-- Dynamic background patterns -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-yellow-400 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <!-- Geometric pattern overlay -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        </div>

        <div class="relative px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <!-- Urgent action badge -->
                <div class="inline-flex items-center px-6 py-3 bg-yellow-500/20 border border-yellow-400/30 rounded-full text-yellow-300 text-sm font-medium mb-8 animate-bounce">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Limited Time: FREE Design Consultation
                </div>

                <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl mb-6">
                    Transform Your<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-yellow-300 to-yellow-500">
                        {{ $area->title }} Property Today
                    </span>
                </h2>

                <p class="mx-auto mt-8 max-w-2xl text-lg leading-8 text-gray-200">
                    Join thousands of satisfied {{ $area->title }} homeowners who chose Danielle Fence for their property transformation. Get your personalized quote and design consultation today.
                </p>

                <!-- Enhanced CTA buttons -->
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-6">
                    <a href="{{ route('contact') }}"
                       class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-black text-gray-900 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-2xl hover:from-yellow-500 hover:to-yellow-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Get FREE Estimate
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-yellow-500 to-yellow-400 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl opacity-0 group-hover:opacity-50 blur transition-opacity duration-300"></div>
                    </a>

                    <a href="tel:{{ config('app.phone', '863-665-1447') }}"
                       class="group inline-flex items-center text-lg font-bold text-white hover:text-yellow-300 transition-all duration-300 transform hover:scale-105">
                        <div class="mr-4 p-2 bg-white/20 rounded-full group-hover:bg-yellow-400/20 transition-colors duration-300 group-hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm text-gray-300 group-hover:text-yellow-200">Call Now for Instant Quote</div>
                            <div class="text-lg font-black">(863) 665-1447</div>
                        </div>
                    </a>
                </div>

                <!-- Trust signals and urgency -->
                <div class="mt-12 flex flex-wrap items-center justify-center gap-8 text-sm text-gray-300">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        24-Hour Quote Response
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        No Pressure Sales
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        100% Satisfaction Guarantee
                    </div>
                </div>

                <!-- Service area reminder -->
                <div class="mt-8 text-center">
                    <p class="text-gray-400 text-sm">
                        Proudly serving {{ $area->title }} and surrounding Central Florida communities since 1976
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Neomorphism Base Variables */
:root {
    --neo-bg: #e0e5ec;
    --neo-bg-dark: #2d3142;
    --neo-shadow-light: #ffffff;
    --neo-shadow-dark: #a3b1c6;
    --neo-shadow-dark-inset: #252936;
    --neo-shadow-light-inset: #353a4f;
}

/* Dark Neomorphism for Dark Sections */
.neo-dark {
    background: var(--neo-bg-dark);
    box-shadow:
        8px 8px 16px var(--neo-shadow-dark-inset),
        -8px -8px 16px var(--neo-shadow-light-inset);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.neo-dark:hover {
    box-shadow:
        12px 12px 24px var(--neo-shadow-dark-inset),
        -12px -12px 24px var(--neo-shadow-light-inset),
        inset 2px 2px 4px rgba(255, 255, 255, 0.1);
}

/* Pressed/Active Neomorphism */
.neo-pressed {
    box-shadow:
        inset 8px 8px 16px var(--neo-shadow-dark-inset),
        inset -8px -8px 16px var(--neo-shadow-light-inset);
}

/* Button Neomorphism */
.neo-button {
    background: linear-gradient(145deg, #f0c419, #d4a017);
    box-shadow:
        8px 8px 16px #b8900f,
        -8px -8px 16px #f0d423;
    border-radius: 15px;
    border: none;
    transition: all 0.3s ease;
}

.neo-button:hover {
    box-shadow:
        12px 12px 24px #b8900f,
        -12px -12px 24px #f0d423,
        inset 2px 2px 4px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.neo-button:active {
    box-shadow:
        inset 8px 8px 16px #b8900f,
        inset -8px -8px 16px #f0d423;
    transform: translateY(0);
}

/* Glass Neomorphism */
.neo-glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow:
        8px 8px 32px rgba(0, 0, 0, 0.3),
        -8px -8px 32px rgba(255, 255, 255, 0.1),
        inset 1px 1px 2px rgba(255, 255, 255, 0.2);
    border-radius: 20px;
}

/* Icon Neomorphism */
.neo-icon {
    background: linear-gradient(145deg, #2a2d3a, #1f212b);
    box-shadow:
        6px 6px 12px #1a1c25,
        -6px -6px 12px #363a4f;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.neo-icon:hover {
    box-shadow:
        8px 8px 16px #1a1c25,
        -8px -8px 16px #363a4f,
        inset 2px 2px 4px rgba(255, 255, 255, 0.1);
    transform: scale(1.1);
}

/* Floating Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes neo-glow {
    0%, 100% {
        box-shadow:
            8px 8px 16px var(--neo-shadow-dark-inset),
            -8px -8px 16px var(--neo-shadow-light-inset),
            0 0 20px rgba(255, 193, 7, 0.3);
    }
    50% {
        box-shadow:
            8px 8px 16px var(--neo-shadow-dark-inset),
            -8px -8px 16px var(--neo-shadow-light-inset),
            0 0 40px rgba(255, 193, 7, 0.5);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-neo-glow {
    animation: neo-glow 3s ease-in-out infinite;
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
}

.animate-shimmer {
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

/* Service Cards with Neomorphism */
.service-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.service-card:hover {
    transform: translateY(-8px) scale(1.02);
}

/* Gradient text animation */
@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient-x {
    animation: gradient-x 3s ease infinite;
    background-size: 200% 200%;
}

/* Stats counter animation */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-count-up {
    animation: countUp 0.8s ease-out forwards;
}

/* Advanced Hover Effects */
.hover-lift {
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.hover-lift:hover {
    transform: translateY(-12px) scale(1.03);
    box-shadow:
        0 25px 50px rgba(0, 0, 0, 0.3),
        0 12px 24px rgba(0, 0, 0, 0.2),
        inset 2px 2px 6px rgba(255, 255, 255, 0.1);
}

/* 3D Tilt Effect */
.hover-tilt {
    transform-style: preserve-3d;
    transition: all 0.3s ease;
}

.hover-tilt:hover {
    transform: perspective(1000px) rotateX(10deg) rotateY(-10deg) translateZ(20px);
}

/* Magnetic Hover Effect */
.hover-magnetic {
    transition: all 0.3s ease;
    position: relative;
}

.hover-magnetic:hover {
    transform: scale(1.1) rotate(2deg);
}

.hover-magnetic::before {
    content: '';
    position: absolute;
    inset: -10px;
    background: radial-gradient(circle, rgba(255, 193, 7, 0.2) 0%, transparent 70%);
    border-radius: inherit;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hover-magnetic:hover::before {
    opacity: 1;
}

/* Glow Pulse Effect */
.hover-glow {
    transition: all 0.3s ease;
}

.hover-glow:hover {
    box-shadow:
        0 0 20px rgba(255, 193, 7, 0.5),
        0 0 40px rgba(255, 193, 7, 0.3),
        0 0 60px rgba(255, 193, 7, 0.1),
        inset 0 0 20px rgba(255, 193, 7, 0.1);
    transform: scale(1.05);
}

/* Morphing Border Effect */
.hover-morph {
    position: relative;
    transition: all 0.4s ease;
}

.hover-morph::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: inherit;
    padding: 2px;
    background: linear-gradient(45deg, #ffc107, #ff6b35, #f7931e, #ffc107);
    background-size: 200% 200%;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask-composite: exclude;
    opacity: 0;
    animation: border-spin 3s linear infinite paused;
}

.hover-morph:hover::before {
    opacity: 1;
    animation-play-state: running;
}

@keyframes border-spin {
    to {
        background-position: 200% 200%;
    }
}

/* Ripple Effect */
.hover-ripple {
    position: relative;
    overflow: hidden;
}

.hover-ripple::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.hover-ripple:hover::after {
    width: 300px;
    height: 300px;
}

/* Floating Animation */
.hover-float {
    transition: all 0.3s ease;
}

.hover-float:hover {
    transform: translateY(-8px);
    animation: gentle-float 2s ease-in-out infinite;
}

@keyframes gentle-float {
    0%, 100% { transform: translateY(-8px); }
    50% { transform: translateY(-12px); }
}

/* Shake Effect */
.hover-shake:hover {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

/* Bounce Effect */
.hover-bounce:hover {
    animation: bounce 0.6s ease;
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
    40%, 43% { transform: translateY(-15px); }
    70% { transform: translateY(-8px); }
    90% { transform: translateY(-3px); }
}

/* Color Shift Effect */
.hover-color-shift {
    transition: all 0.4s ease;
}

.hover-color-shift:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scale(1.05);
}

/* 3D Perspective Card */
.perspective-card {
    perspective: 1000px;
}

.perspective-card-inner {
    transform-style: preserve-3d;
    transition: transform 0.6s;
}

.perspective-card:hover .perspective-card-inner {
    transform: rotateY(10deg) rotateX(10deg);
}

/* Elastic Scale */
.hover-elastic:hover {
    animation: elastic-scale 0.6s ease;
}

@keyframes elastic-scale {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    70% { transform: scale(0.95); }
    100% { transform: scale(1.05); }
}

/* Text shadows for better readability */
.neo-text-shadow {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

/* Responsive Neomorphism */
@media (max-width: 768px) {
    .neo-dark {
        box-shadow:
            4px 4px 8px var(--neo-shadow-dark-inset),
            -4px -4px 8px var(--neo-shadow-light-inset);
    }

    .neo-button {
        box-shadow:
            4px 4px 8px #b8900f,
            -4px -4px 8px #f0d423;
    }

    /* Reduce hover effects on mobile for performance */
    .hover-lift:hover,
    .hover-tilt:hover,
    .hover-magnetic:hover {
        transform: scale(1.02);
    }
}
</style>
@endpush

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "LocalBusiness",
    "name": "Danielle Fence & Outdoor Living",
    "description": "Professional fence installation services in {{ $area->title }}, Florida",
    "url": "{{ url()->current() }}",
    "telephone": "{{ config('app.phone', '863-665-1447') }}",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "4805 St Rd 60 West",
        "addressLocality": "{{ $area->title }}",
        "addressRegion": "FL",
        "postalCode": "33860",
        "addressCountry": "US"
    },
    "areaServed": {
        "@type": "City",
        "name": "{{ $area->title }}",
        "addressRegion": "FL",
        "addressCountry": "US"
    },
    "serviceType": [
        "Fence Installation",
        "Vinyl Fencing",
        "Wood Fencing",
        "Chain Link Fencing",
        "Commercial Fencing"
    ],
    "foundingDate": "1976",
    "hasCredential": "Licensed and Insured"
}
</script>
@endpush
@endsection