@extends('layouts.app')

@section('content')
<div class="relative isolate overflow-hidden bg-white">
    <!-- Hero Section -->
    @php
        $mapUrl = $area->hasMapDisplay() ? $area->getMapBackgroundUrl(1920, 1080, 12) : null;
        $hasValidMap = $mapUrl && !empty($mapUrl);
    @endphp

    <div class="relative py-16 sm:py-20 overflow-hidden {{ !$hasValidMap ? 'bg-gray-900' : '' }}"
         @if($hasValidMap)
         style="background-image: url('{{ $mapUrl }}'); background-size: cover; background-position: center;"
         @endif>

        @if(!$hasValidMap)
        <!-- Clean geometric pattern for fallback -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 100px 100px;"></div>
        </div>
        @endif
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8 z-10">
            <div class="mx-auto max-w-3xl text-center">
                <!-- Clean hero card matching site design -->
                <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg p-8 lg:p-10 border border-gray-100">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl mb-6">
                        {{ $service }} in <span class="text-brand-primary-900">{{ $area->title }}</span>, FL
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Professional {{ strtolower($service) }} services in {{ $area->title }}, Florida. Licensed, insured, and locally trusted since 1976.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-brand-primary-900 text-white font-semibold rounded-lg hover:bg-brand-primary-800 transition-colors duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Get Free Estimate
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
                </div>
            </div>
        </div>
    </div>

    <!-- Service Details Section -->
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-3xl">
                @if($area->services_content)
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                        {{ $service }} Services in {{ $area->title }}
                    </h2>
                    <div class="prose prose-lg max-w-none mb-12 text-gray-600">
                        {!! $area->services_content !!}
                    </div>
                @endif

                @switch($service)
                    @case('Vinyl Fencing')
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                            Premium Vinyl Fencing in {{ $area->title }}
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p>Transform your {{ $area->title }} property with our premium vinyl fencing solutions. Vinyl fencing offers the perfect combination of beauty, durability, and low maintenance that Florida homeowners love.</p>

                            <h3>Why Choose Vinyl Fencing in {{ $area->title }}?</h3>
                            <ul>
                                <li><strong>Weather Resistant:</strong> Perfect for Florida's humid climate and severe weather</li>
                                <li><strong>Low Maintenance:</strong> No painting, staining, or sealing required</li>
                                <li><strong>Long-Lasting:</strong> 20+ year lifespan with proper installation</li>
                                <li><strong>Variety of Styles:</strong> Privacy, picket, ranch rail, and decorative options</li>
                                <li><strong>Property Value:</strong> Increases your {{ $area->title }} home's curb appeal and value</li>
                            </ul>

                            <h3>Vinyl Fencing Styles Available in {{ $area->title }}</h3>
                            <ul>
                                <li>Privacy Vinyl Fencing - 6ft and 8ft heights available</li>
                                <li>Vinyl Picket Fencing - Traditional and contemporary designs</li>
                                <li>Vinyl Ranch Rail Fencing - Perfect for larger properties</li>
                                <li>Decorative Vinyl Fencing - Custom designs and colors</li>
                            </ul>
                        </div>
                        @break

                    @case('Wood Fencing')
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                            Classic Wood Fencing in {{ $area->title }}
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p>Enhance your {{ $area->title }} property with timeless wood fencing. Our premium wood fencing combines natural beauty with practical functionality for Florida homes.</p>

                            <h3>Wood Fencing Benefits for {{ $area->title }} Homes</h3>
                            <ul>
                                <li><strong>Natural Beauty:</strong> Timeless appeal that complements any architectural style</li>
                                <li><strong>Customizable:</strong> Easily painted or stained to match your preferences</li>
                                <li><strong>Cost-Effective:</strong> Affordable option for large properties</li>
                                <li><strong>Privacy:</strong> Excellent for creating private outdoor spaces</li>
                                <li><strong>Eco-Friendly:</strong> Sustainable and renewable material</li>
                            </ul>

                            <h3>Wood Fencing Options in {{ $area->title }}</h3>
                            <ul>
                                <li>Cedar Fencing - Natural resistance to insects and decay</li>
                                <li>Pine Fencing - Cost-effective and readily available</li>
                                <li>Cypress Fencing - Naturally weather-resistant for Florida climate</li>
                                <li>Redwood Fencing - Premium option with natural beauty</li>
                            </ul>
                        </div>
                        @break

                    @case('Chain Link Fencing')
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                            Reliable Chain Link Fencing in {{ $area->title }}
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p>Secure your {{ $area->title }} property with our durable chain link fencing solutions. Perfect for commercial properties, industrial sites, and residential applications where security and visibility are priorities.</p>

                            <h3>Chain Link Fencing Advantages for {{ $area->title }}</h3>
                            <ul>
                                <li><strong>Security:</strong> Effective deterrent for trespassing and theft</li>
                                <li><strong>Durability:</strong> Galvanized steel construction resists rust and corrosion</li>
                                <li><strong>Low Maintenance:</strong> Minimal upkeep required</li>
                                <li><strong>Visibility:</strong> Allows clear sightlines while providing security</li>
                                <li><strong>Cost-Effective:</strong> Excellent value for large perimeter applications</li>
                            </ul>

                            <h3>Chain Link Options in {{ $area->title }}</h3>
                            <ul>
                                <li>Galvanized Chain Link - Standard protection against rust</li>
                                <li>Vinyl-Coated Chain Link - Color options with enhanced protection</li>
                                <li>Privacy Slats - Add privacy to your chain link fence</li>
                                <li>Security Gates - Matching gates for vehicle and pedestrian access</li>
                            </ul>
                        </div>
                        @break

                    @case('Commercial Fencing')
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                            Professional Commercial Fencing in {{ $area->title }}
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p>Protect your {{ $area->title }} business with our comprehensive commercial fencing solutions. We understand the unique security and aesthetic needs of commercial properties in Central Florida.</p>

                            <h3>Commercial Fencing Solutions for {{ $area->title }} Businesses</h3>
                            <ul>
                                <li><strong>Security Fencing:</strong> High-security options for sensitive areas</li>
                                <li><strong>Perimeter Fencing:</strong> Define and secure your property boundaries</li>
                                <li><strong>Access Control:</strong> Automated gates and entry systems</li>
                                <li><strong>Decorative Fencing:</strong> Enhance your business's curb appeal</li>
                                <li><strong>Compliance:</strong> Meet local zoning and safety requirements</li>
                            </ul>

                            <h3>Commercial Fencing Types in {{ $area->title }}</h3>
                            <ul>
                                <li>Ornamental Iron Fencing - Elegant security for upscale businesses</li>
                                <li>Chain Link with Security Features - Cost-effective perimeter security</li>
                                <li>Aluminum Fencing - Low-maintenance and corrosion-resistant</li>
                                <li>Privacy Fencing - Vinyl or wood for screening applications</li>
                            </ul>
                        </div>
                        @break

                    @case('Fence Installation')
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-8">
                            Expert Fence Installation in {{ $area->title }}
                        </h2>
                        <div class="prose prose-lg max-w-none">
                            <p>Trust Danielle Fence for professional fence installation in {{ $area->title }}. Our experienced team ensures your fence is installed correctly the first time, providing years of reliable service.</p>

                            <h3>Our {{ $area->title }} Fence Installation Process</h3>
                            <ol>
                                <li><strong>Free Consultation:</strong> On-site evaluation and detailed estimate</li>
                                <li><strong>Permits & Planning:</strong> Handle all necessary permits and HOA approvals</li>
                                <li><strong>Property Survey:</strong> Mark utilities and establish property lines</li>
                                <li><strong>Professional Installation:</strong> Expert installation by licensed contractors</li>
                                <li><strong>Clean-Up:</strong> Complete site cleanup and final inspection</li>
                            </ol>

                            <h3>Why Choose Professional Installation in {{ $area->title }}?</h3>
                            <ul>
                                <li><strong>Proper Foundation:</strong> Correct post setting for Florida soil conditions</li>
                                <li><strong>Weather Considerations:</strong> Installation techniques suited for Florida climate</li>
                                <li><strong>Code Compliance:</strong> Meet all local building codes and regulations</li>
                                <li><strong>Warranty Protection:</strong> Installation warranty for peace of mind</li>
                                <li><strong>Time Savings:</strong> Efficient installation by experienced professionals</li>
                            </ul>
                        </div>
                        @break
                @endswitch
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Our {{ $service }} Process in {{ $area->title }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    From initial consultation to final installation, we make the process easy for {{ $area->title }} customers.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 rounded-full bg-brand-primary-100 flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-brand-primary-600">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Free Consultation</h3>
                    <p class="mt-2 text-gray-600">Schedule your free on-site consultation in {{ $area->title }}.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto h-16 w-16 rounded-full bg-brand-primary-100 flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-brand-primary-600">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Design & Quote</h3>
                    <p class="mt-2 text-gray-600">Receive a detailed quote and design for your project.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto h-16 w-16 rounded-full bg-brand-primary-100 flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-brand-primary-600">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Professional Installation</h3>
                    <p class="mt-2 text-gray-600">Our licensed team installs your fence to perfection.</p>
                </div>

                <div class="text-center">
                    <div class="mx-auto h-16 w-16 rounded-full bg-brand-primary-100 flex items-center justify-center mb-4">
                        <span class="text-2xl font-bold text-brand-primary-600">4</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Final Inspection</h3>
                    <p class="mt-2 text-gray-600">Quality check and project completion in {{ $area->title }}.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-brand-primary-600">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Ready for {{ $service }} in {{ $area->title }}?
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">
                    Contact us today for a free estimate on your {{ strtolower($service) }} project in {{ $area->title }}.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('contact') }}" class="rounded-md bg-yellow-500 px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-yellow-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500">
                        Get Free Estimate
                    </a>
                    <a href="tel:{{ config('app.phone', '863-665-1447') }}" class="text-sm font-semibold leading-6 text-white">
                        Call (863) 665-1447 <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Service",
    "name": "{{ $service }} in {{ $area->title }}, FL",
    "description": "Professional {{ strtolower($service) }} services in {{ $area->title }}, Florida",
    "provider": {
        "@type": "LocalBusiness",
        "name": "Danielle Fence & Outdoor Living",
        "telephone": "{{ config('app.phone', '863-665-1447') }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "4805 St Rd 60 West",
            "addressLocality": "{{ $area->title }}",
            "addressRegion": "FL",
            "postalCode": "33860",
            "addressCountry": "US"
        }
    },
    "areaServed": {
        "@type": "City",
        "name": "{{ $area->title }}",
        "addressRegion": "FL",
        "addressCountry": "US"
    },
    "hasCredential": "Licensed and Insured"
}
</script>
@endpush
@endsection