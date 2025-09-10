<x-app-layout>
<div class="bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-[#8e2a2a] to-[#7a2525] text-white w-full p-10">
        <div class="container mx-auto aspect-video flex items-center justify-center">
            <div class="text-center">
                <nav class="text-sm mb-4 opacity-90">
                    <a href="{{ route('diy.index') }}" class="hover:text-yellow-300">DIY Products</a>
                    <span class="mx-2">/</span>
                    <span>Easy Fixes</span>
                </nav>
                
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Easy Fence Fixes</h1>
                <p class="text-xl opacity-90">
                    Simple DIY solutions for common fence problems
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        {{-- Quick Tips Banner --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-12">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-600 text-2xl mr-4 mt-1"></i>
                <div>
                    <h2 class="text-xl font-bold text-blue-800 mb-2">Before You Start</h2>
                    <p class="text-blue-700">
                        Most fence problems can be fixed with basic tools and a little patience. 
                        If you're uncomfortable with any repair, our professional team is always available to help.
                    </p>
                </div>
            </div>
        </div>

        {{-- Fixes Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($fixes as $index => $fix)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    {{-- Fix Header --}}
                    <div class="bg-gradient-to-r from-green-100 to-green-50 p-6 border-b">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $fix['title'] }}</h3>
                                <div class="flex items-center space-x-4 text-sm">
                                    <span class="flex items-center">
                                        <i class="fas fa-signal text-green-600 mr-1"></i>
                                        <span class="font-medium 
                                            {{ $fix['difficulty'] === 'Easy' ? 'text-green-600' : 'text-yellow-600' }}">
                                            {{ $fix['difficulty'] }}
                                        </span>
                                    </span>
                                    <span class="flex items-center text-gray-600">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $fix['time'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="w-16 h-16 bg-green-500 text-white rounded-full flex items-center justify-center">
                                    <span class="text-2xl font-bold">{{ $index + 1 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Fix Content --}}
                    <div class="p-6">
                        {{-- Tools Required --}}
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-tools text-green-600 mr-2"></i>
                                Tools Required
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($fix['tools'] as $tool)
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        {{ $tool }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        {{-- Instructions --}}
                        <div class="mb-6">
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-list-ol text-green-600 mr-2"></i>
                                Step-by-Step Instructions
                            </h4>
                            
                            @switch($fix['title'])
                                @case('Fixing a Sagging Gate')
                                    <ol class="space-y-3 text-sm text-gray-700">
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                                            Check if hinges are loose and tighten all screws
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                                            Lift gate to proper position and check if post is plumb
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                                            If post is leaning, add diagonal brace or reset post
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                                            Adjust hinge placement if necessary for proper alignment
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">5</span>
                                            Test gate swing and make final adjustments
                                        </li>
                                    </ol>
                                    @break

                                @case('Replacing a Fence Picket')
                                    <ol class="space-y-3 text-sm text-gray-700">
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                                            Remove damaged picket by pulling out nails or screws
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                                            Measure and cut new picket to match existing height
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                                            Position new picket and check alignment with neighbors
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                                            Attach to rails using galvanized nails or screws
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">5</span>
                                            Apply matching stain or paint to blend with existing fence
                                        </li>
                                    </ol>
                                    @break

                                @case('Cleaning Vinyl Fence')
                                    <ol class="space-y-3 text-sm text-gray-700">
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                                            Rinse fence with water to remove loose dirt and debris
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                                            Mix mild detergent with warm water in bucket
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                                            Scrub gently with soft brush, working from bottom to top
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                                            For tough stains, use baking soda paste and let sit 10 minutes
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">5</span>
                                            Rinse thoroughly with clean water and allow to air dry
                                        </li>
                                    </ol>
                                    @break

                                @case('Adjusting Gate Hinges')
                                    <ol class="space-y-3 text-sm text-gray-700">
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">1</span>
                                            Identify if gate is sagging, binding, or not latching properly
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">2</span>
                                            Support gate weight while adjusting hinge positions
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">3</span>
                                            Loosen hinge screws and reposition as needed
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">4</span>
                                            Use level to ensure gate hangs straight and square
                                        </li>
                                        <li class="flex">
                                            <span class="bg-green-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-3 mt-0.5">5</span>
                                            Tighten all screws and test gate operation multiple times
                                        </li>
                                    </ol>
                                    @break
                            @endswitch
                        </div>

                        {{-- Pro Tips --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h5 class="font-bold text-yellow-800 mb-2 flex items-center">
                                <i class="fas fa-star text-yellow-600 mr-2"></i>
                                Pro Tips
                            </h5>
                            @switch($fix['title'])
                                @case('Fixing a Sagging Gate')
                                    <p class="text-sm text-yellow-700">
                                        Prevention is key! Apply gate spring to reduce weight stress on hinges and check hardware annually.
                                    </p>
                                    @break
                                @case('Replacing a Fence Picket')
                                    <p class="text-sm text-yellow-700">
                                        Take a piece of the old picket to the store for exact matching. Weather-exposed wood should match the existing weathering.
                                    </p>
                                    @break
                                @case('Cleaning Vinyl Fence')
                                    <p class="text-sm text-yellow-700">
                                        Clean your vinyl fence 2-3 times per year. Avoid abrasive cleaners or power washing at high pressure.
                                    </p>
                                    @break
                                @case('Adjusting Gate Hinges')
                                    <p class="text-sm text-yellow-700">
                                        Install a gate wheel or caster if the gate is particularly heavy to prevent future sagging issues.
                                    </p>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- When to Call Professionals --}}
        <div class="mt-16 bg-red-50 border border-red-200 rounded-lg p-8">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-red-800 mb-4">When to Call the Professionals</h2>
                <p class="text-red-700 mb-6">
                    While many fence repairs are DIY-friendly, some issues require professional expertise:
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-bold text-red-800 mb-2">Structural Issues</h4>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Leaning or damaged posts</li>
                            <li>• Foundation problems</li>
                            <li>• Major storm damage</li>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-bold text-red-800 mb-2">Safety Concerns</h4>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Repairs near utilities</li>
                            <li>• Height-related work</li>
                            <li>• Heavy lifting situations</li>
                        </ul>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-bold text-red-800 mb-2">Complex Repairs</h4>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li>• Complete section replacement</li>
                            <li>• Drainage issues</li>
                            <li>• Property line disputes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact Section --}}
        <div class="mt-12 bg-gradient-to-r from-red-800 to-red-900 text-white rounded-lg p-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Need Professional Help?</h2>
            <p class="text-lg mb-6 opacity-90">
                Our experienced team has been serving Central Florida for 49 years
            </p>
            
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="tel:8634253182" 
                   class="inline-flex items-center bg-white text-red-800 px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition">
                    <i class="fas fa-phone mr-3"></i>
                    Call (863) 425-3182
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center border-2 border-white text-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-red-800 transition">
                    <i class="fas fa-envelope mr-3"></i>
                    Request Service
                </a>
                
                <a href="{{ route('diy.index') }}" 
                   class="inline-flex items-center border-2 border-white text-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-red-800 transition">
                    <i class="fas fa-tools mr-3"></i>
                    DIY Products
                </a>
            </div>
        </div>

        {{-- Additional Resources --}}
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-8 text-center">More DIY Resources</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('diy.guide') }}" 
                   class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center group">
                    <i class="fas fa-file-pdf text-3xl text-green-600 mb-4 group-hover:text-green-700"></i>
                    <h3 class="font-bold mb-2">Installation Guides</h3>
                    <p class="text-sm text-gray-600">Complete step-by-step installation instructions</p>
                </a>
                
                <a href="{{ route('diy.index') }}" 
                   class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center group">
                    <i class="fas fa-shopping-cart text-3xl text-green-600 mb-4 group-hover:text-green-700"></i>
                    <h3 class="font-bold mb-2">DIY Products</h3>
                    <p class="text-sm text-gray-600">Browse our selection of DIY-friendly materials</p>
                </a>
                
                <a href="tel:8634253182" 
                   class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center group">
                    <i class="fas fa-question-circle text-3xl text-green-600 mb-4 group-hover:text-green-700"></i>
                    <h3 class="font-bold mb-2">Expert Advice</h3>
                    <p class="text-sm text-gray-600">Call our experts for personalized guidance</p>
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>