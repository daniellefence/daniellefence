<x-app-layout>
    <div class="min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-[#8e2a2a] to-[#7a2525] py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl">
                    <h1 class="text-4xl font-bold text-white mb-4">Fence & Gate Blog</h1>
                    <p class="text-xl text-white mb-8">
                        Tips, guides, and insights from Central Florida's fence experts since 1976.
                    </p>
                </div>
            </div>
        </div>

        <!-- Blog Content -->
        <div class="py-16">
            <div class="container mx-auto px-4">
                <div class="grid lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        @if(isset($blogs) && $blogs->count() > 0)
                            <div class="space-y-8">
                                @foreach($blogs as $blog)
                                    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                                        @if($blog->getFirstMediaUrl())
                                            <div class="aspect-video">
                                                <img src="{{ $blog->getFirstMediaUrl('featured', 'responsive') }}" 
                                                     alt="{{ $blog->title }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                        @endif
                                        
                                        <div class="p-6">
                                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                                <time datetime="{{ $blog->published_at->format('Y-m-d') }}">
                                                    {{ $blog->published_at->format('F j, Y') }}
                                                </time>
                                                @if($blog->category)
                                                    <span class="mx-2">•</span>
                                                    <span class="bg-[#8e2a2a] text-white px-2 py-1 rounded text-xs">
                                                        {{ $blog->category->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <h2 class="text-2xl font-bold text-gray-900 mb-3">
                                                <a href="{{ route('blog.post', $blog->slug) }}" class="hover:text-[#8e2a2a]">
                                                    {{ $blog->title }}
                                                </a>
                                            </h2>
                                            
                                            <p class="text-gray-600 mb-4">
                                                {{ $blog->excerpt ?: Str::limit(strip_tags($blog->content), 150) }}
                                            </p>
                                            
                                            <a href="{{ route('blog.post', $blog->slug) }}" 
                                               class="inline-flex items-center text-[#8e2a2a] hover:underline font-semibold">
                                                Read More
                                                <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="mt-12">
                                {{ $blogs->links() }}
                            </div>
                        @else
                            <!-- No blogs placeholder -->
                            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                                <i class="fas fa-blog text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Coming Soon</h3>
                                <p class="text-gray-600">We're working on bringing you helpful fence and gate content. Check back soon!</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <!-- Search -->
                        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Search Articles</h3>
                            <form method="GET">
                                <div class="relative">
                                    <input type="text" name="search" 
                                           placeholder="Search blog posts..."
                                           value="{{ request('search') }}"
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8e2a2a] focus:border-transparent">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                <button type="submit" class="w-full mt-3 bg-[#8e2a2a] hover:bg-[#9c3030] text-white font-semibold py-2 px-4 rounded-md transition-colors">
                                    Search
                                </button>
                            </form>
                        </div>
                        
                        <!-- Categories -->
                        @if(isset($categories) && $categories->count() > 0)
                            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Categories</h3>
                                <ul class="space-y-2">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                               class="flex items-center justify-between text-gray-600 hover:text-[#8e2a2a] transition-colors">
                                                <span>{{ $category->name }}</span>
                                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                                                    {{ $category->blogs_count }}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Contact CTA -->
                        <div class="bg-[#8e2a2a] rounded-lg shadow-lg p-6 text-white">
                            <h3 class="text-lg font-bold mb-3">Need Expert Advice?</h3>
                            <p class="mb-4 text-sm">Get professional guidance for your fencing project from our experienced team.</p>
                            <div class="space-y-2">
                                <a href="tel:863-425-3182" class="block text-center bg-white text-[#8e2a2a] font-semibold py-2 px-4 rounded hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-phone mr-2"></i> (863) 425-3182
                                </a>
                                <a href="{{ route('diy.quote') }}" class="block text-center border border-white text-white font-semibold py-2 px-4 rounded hover:bg-white hover:text-[#8e2a2a] transition-colors">
                                    Get Free Quote
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>