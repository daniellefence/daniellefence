@php
    $data = $this->getViewData();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            SEO & Content Analytics
        </x-slot>

        <x-slot name="description">
            Search engine optimization insights and content performance
        </x-slot>

        <div class="space-y-6">
            {{-- SEO Coverage Overview --}}
            <div class="grid gap-4 md:grid-cols-2">
                {{-- Coverage Percentage --}}
                <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-100 border border-blue-200 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-blue-900">SEO Coverage</h3>
                        <span class="px-3 py-1 text-sm font-medium rounded-full 
                            {{ $data['seo_coverage']['status'] === 'excellent' ? 'bg-green-100 text-green-800' : 
                               ($data['seo_coverage']['status'] === 'good' ? 'bg-blue-100 text-blue-800' : 
                                ($data['seo_coverage']['status'] === 'fair' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($data['seo_coverage']['status']) }}
                        </span>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex items-end space-x-2 mb-2">
                            <span class="text-4xl font-bold text-blue-900">{{ $data['seo_coverage']['coverage_percent'] }}%</span>
                            <span class="text-sm text-blue-600 mb-1">of content optimized</span>
                        </div>
                        
                        <div class="w-full bg-blue-200 rounded-full h-3">
                            <div class="h-3 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500" 
                                 style="width: {{ $data['seo_coverage']['coverage_percent'] }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-blue-600">Optimized</p>
                            <p class="font-bold text-blue-900">{{ $data['seo_coverage']['seo_records'] }}</p>
                        </div>
                        <div>
                            <p class="text-blue-600">Missing SEO</p>
                            <p class="font-bold text-blue-900">{{ $data['seo_coverage']['missing'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Content Breakdown --}}
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-100 border border-green-200 rounded-lg">
                    <h3 class="text-lg font-medium text-green-900 mb-4">Content Breakdown</h3>
                    
                    <div class="space-y-4">
                        {{-- Blog Posts --}}
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Blog Posts</p>
                                    <p class="text-xs text-gray-500">Published: {{ $data['content_insights']['blog_posts']['published'] }} | Drafts: {{ $data['content_insights']['blog_posts']['drafts'] }}</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-green-700">{{ $data['content_insights']['blog_posts']['published'] + $data['content_insights']['blog_posts']['drafts'] }}</span>
                        </div>

                        {{-- Pages --}}
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Static Pages</p>
                                    <p class="text-xs text-gray-500">{{ $data['content_insights']['pages']['recent'] }} added this month</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-blue-700">{{ $data['content_insights']['pages']['total'] }}</span>
                        </div>

                        {{-- Products --}}
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Products</p>
                                    <p class="text-xs text-gray-500">{{ $data['content_insights']['products']['with_descriptions'] }} with descriptions</p>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-purple-700">{{ $data['content_insights']['products']['total'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Optimization Suggestions --}}
            @if(count($data['optimization_suggestions']) > 0)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900">Optimization Suggestions</h4>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($data['optimization_suggestions'] as $suggestion)
                            <div class="p-4 flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    @if($suggestion['priority'] === 'high')
                                        <div class="w-2 h-2 mt-2 bg-red-400 rounded-full"></div>
                                    @elseif($suggestion['priority'] === 'medium')
                                        <div class="w-2 h-2 mt-2 bg-yellow-400 rounded-full"></div>
                                    @else
                                        <div class="w-2 h-2 mt-2 bg-green-400 rounded-full"></div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <h5 class="text-sm font-medium text-gray-900">{{ $suggestion['title'] }}</h5>
                                        <span class="px-2 py-1 text-xs rounded 
                                            {{ $suggestion['priority'] === 'high' ? 'bg-red-100 text-red-800' : 
                                               ($suggestion['priority'] === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ ucfirst($suggestion['priority']) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $suggestion['description'] }}</p>
                                    <p class="text-xs text-blue-600 mt-2">💡 {{ $suggestion['action'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Footer --}}
            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                <p class="text-xs text-gray-500">Last analyzed: {{ now()->format('M j, Y g:i A') }}</p>
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Auto-refresh: 10min
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>