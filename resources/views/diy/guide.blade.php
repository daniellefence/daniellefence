@extends('layouts.app')

@section('title', 'DIY Installation Guides')

@section('content')
<div class="bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-red-800 to-red-900 text-white py-12">
        <div class="container mx-auto px-4">
            <nav class="text-sm mb-4 opacity-90">
                <a href="{{ route('diy.index') }}" class="hover:text-yellow-300">DIY Products</a>
                <span class="mx-2">/</span>
                <span>Installation Guides</span>
            </nav>
            
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                @if($type)
                    {{ $guides[$type] }}
                @else
                    DIY Installation Guides
                @endif
            </h1>
            
            <p class="text-xl opacity-90">
                Professional installation instructions for the do-it-yourself installer
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        @if(!$type)
            {{-- Guide Selection --}}
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-center">Choose Your Installation Guide</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    @foreach($guides as $key => $title)
                        <a href="{{ route('diy.guide', $key) }}" 
                           class="bg-white p-8 rounded-lg shadow-lg hover:shadow-xl transition-shadow group">
                            <div class="flex items-start">
                                <div class="bg-red-100 p-4 rounded-lg mr-6 group-hover:bg-red-200 transition">
                                    @switch($key)
                                        @case('aluminum')
                                            <i class="fas fa-industry text-3xl text-red-600"></i>
                                            @break
                                        @case('vinyl')
                                            <i class="fas fa-home text-3xl text-red-600"></i>
                                            @break
                                        @case('wood')
                                            <i class="fas fa-tree text-3xl text-red-600"></i>
                                            @break
                                        @case('gate')
                                            <i class="fas fa-door-open text-3xl text-red-600"></i>
                                            @break
                                    @endswitch
                                </div>
                                
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold mb-2 group-hover:text-red-600 transition">
                                        {{ $title }}
                                    </h3>
                                    <p class="text-gray-600 mb-4">
                                        @switch($key)
                                            @case('aluminum')
                                                Complete installation guide for aluminum fencing systems including post setting and panel installation.
                                                @break
                                            @case('vinyl')
                                                Step-by-step instructions for vinyl fence installation with professional tips and tricks.
                                                @break
                                            @case('wood')
                                                Traditional wood fence installation including proper post placement and panel attachment.
                                                @break
                                            @case('gate')
                                                Specialized guide for installing gates with proper hinge placement and alignment.
                                                @break
                                        @endswitch
                                    </p>
                                    <div class="flex items-center text-sm text-red-600 font-medium">
                                        <span>Download PDF Guide</span>
                                        <i class="fas fa-download ml-2"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- General Tips Section --}}
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold mb-6">Before You Begin - Essential Tips</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-bold mb-4 text-red-600">Tools You'll Need</h3>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    Post hole digger or shovel
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    Level (4-foot recommended)
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    Measuring tape
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    Drill with bits
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    Concrete mix
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-600 mr-2"></i>
                                    String line and stakes
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold mb-4 text-red-600">Important Reminders</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-2 mt-1"></i>
                                    <span>Call 811 before digging to locate utilities</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-eye text-blue-600 mr-2 mt-1"></i>
                                    <span>Check local building codes and permits</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-ruler text-green-600 mr-2 mt-1"></i>
                                    <span>Verify property lines before installation</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-clock text-purple-600 mr-2 mt-1"></i>
                                    <span>Allow concrete to cure 24-48 hours</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Specific Guide Content --}}
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    {{-- Guide Header --}}
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-8 border-b">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold mb-2">{{ $guides[$type] }}</h2>
                                <p class="text-gray-600">Complete step-by-step installation instructions</p>
                            </div>
                            <div class="text-right">
                                <button onclick="downloadPDF()" 
                                        class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                                    <i class="fas fa-download mr-2"></i>
                                    Download PDF
                                </button>
                                <p class="text-sm text-gray-500 mt-2">Complete guide with photos</p>
                            </div>
                        </div>
                    </div>

                    {{-- Guide Content --}}
                    <div class="p-8">
                        @switch($type)
                            @case('aluminum')
                                <div class="space-y-8">
                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 1: Planning and Layout</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Measure your property line and mark fence boundaries</li>
                                            <li>• Determine gate locations and sizes needed</li>
                                            <li>• Calculate the number of posts needed (typically 6-8 feet apart)</li>
                                            <li>• Mark post locations with spray paint or stakes</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 2: Post Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Dig holes 24-30 inches deep and 6 inches wider than post</li>
                                            <li>• Set corner and end posts first, ensuring they're plumb</li>
                                            <li>• Use fast-setting concrete around posts</li>
                                            <li>• Allow concrete to cure for 4-6 hours minimum</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 3: Panel Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Attach brackets to posts at proper height</li>
                                            <li>• Install panels between posts, checking for level</li>
                                            <li>• Secure panels with provided hardware</li>
                                            <li>• Install top rail caps and post caps</li>
                                        </ul>
                                    </section>
                                </div>
                                @break

                            @case('vinyl')
                                <div class="space-y-8">
                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 1: Site Preparation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Clear the fence line of debris and vegetation</li>
                                            <li>• Call 811 to mark underground utilities</li>
                                            <li>• Establish a straight line using string and stakes</li>
                                            <li>• Mark post locations every 6-8 feet</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 2: Post Setting</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Dig holes 1/3 the length of the post plus 6 inches</li>
                                            <li>• Add 4-6 inches of gravel for drainage</li>
                                            <li>• Set posts in concrete, ensuring they're plumb and aligned</li>
                                            <li>• Allow concrete to cure 24-48 hours before continuing</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 3: Rail and Picket Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Install bottom rail first, then top rail</li>
                                            <li>• Insert pickets into the bottom rail channel</li>
                                            <li>• Secure pickets into the top rail</li>
                                            <li>• Install post caps and any decorative elements</li>
                                        </ul>
                                    </section>
                                </div>
                                @break

                            @case('wood')
                                <div class="space-y-8">
                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 1: Materials and Planning</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Select pressure-treated lumber for longevity</li>
                                            <li>• Plan for 6-8 foot spacing between posts</li>
                                            <li>• Account for grade changes and slopes</li>
                                            <li>• Gather all necessary hardware and tools</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 2: Post Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Dig holes 2-3 feet deep depending on fence height</li>
                                            <li>• Set posts in concrete or well-packed soil</li>
                                            <li>• Use a level to ensure posts are plumb</li>
                                            <li>• Allow adequate time for setting before adding rails</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 3: Frame and Board Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Install horizontal rails between posts</li>
                                            <li>• Attach fence boards starting from one end</li>
                                            <li>• Use spacers to maintain consistent gaps</li>
                                            <li>• Apply stain or sealant for protection</li>
                                        </ul>
                                    </section>
                                </div>
                                @break

                            @case('gate')
                                <div class="space-y-8">
                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 1: Gate Planning</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Determine gate width (typically 3-4 feet for walk-through)</li>
                                            <li>• Plan for proper clearance and swing direction</li>
                                            <li>• Select appropriate hinges for gate weight</li>
                                            <li>• Consider ground clearance and drainage</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 2: Post Reinforcement</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Use larger posts for gate supports (typically 6x6)</li>
                                            <li>• Set gate posts deeper with more concrete</li>
                                            <li>• Allow extra curing time before hanging gate</li>
                                            <li>• Check posts are perfectly plumb and parallel</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h3 class="text-xl font-bold mb-4 text-red-600">Step 3: Gate Installation</h3>
                                        <ul class="space-y-2 ml-4">
                                            <li>• Attach hinges to gate frame first</li>
                                            <li>• Position gate and mark hinge locations on post</li>
                                            <li>• Install hinges with proper spacing and alignment</li>
                                            <li>• Test swing and adjust as needed</li>
                                            <li>• Install latch hardware and test operation</li>
                                        </ul>
                                    </section>
                                </div>
                                @break
                        @endswitch

                        {{-- Special Notice for 8' Fences --}}
                        @if(in_array($type, ['aluminum', 'vinyl']))
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                                    <div>
                                        <h4 class="font-bold text-blue-800 mb-2">Special Note for 8-Foot Fences</h4>
                                        <p class="text-blue-700">
                                            For 8-foot tall fence installations, the middle rail is <strong>NOT</strong> centered in the panel. 
                                            Please contact us at (863) 425-3182 for exact positioning specifications before installation.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Safety Warning --}}
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-8">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl mr-3 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-yellow-800 mb-2">Important Safety Information</h4>
                                    <ul class="text-yellow-700 space-y-1">
                                        <li>• Always call 811 before digging to avoid utility lines</li>
                                        <li>• Wear appropriate safety equipment including eye protection</li>
                                        <li>• Check local building codes and permit requirements</li>
                                        <li>• Have utilities marked at least 2 business days before starting</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="text-center mt-8 space-x-4">
                    <a href="{{ route('diy.guide') }}" 
                       class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to All Guides
                    </a>
                    
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-phone mr-2"></i>
                        Need Help? Contact Us
                    </a>
                </div>
            </div>
        @endif

        {{-- Contact Section --}}
        <div class="max-w-4xl mx-auto mt-12">
            <div class="bg-gradient-to-r from-red-800 to-red-900 text-white rounded-lg p-8 text-center">
                <h2 class="text-2xl font-bold mb-4">Need Professional Installation?</h2>
                <p class="text-lg mb-6">
                    Our experienced team can handle the entire installation process for you
                </p>
                <div class="space-x-4">
                    <a href="tel:8634253182" 
                       class="inline-flex items-center bg-white text-red-800 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition">
                        <i class="fas fa-phone mr-2"></i>
                        Call (863) 425-3182
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="inline-flex items-center border-2 border-white text-white px-6 py-3 rounded-lg font-bold hover:bg-white hover:text-red-800 transition">
                        <i class="fas fa-envelope mr-2"></i>
                        Get Quote
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function downloadPDF() {
    // In a real implementation, this would trigger a PDF download
    // For now, we'll show an alert
    alert('PDF download feature coming soon! Please call (863) 425-3182 for detailed installation guides.');
}
</script>
@endpush