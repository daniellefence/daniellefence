<div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Category Filter Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-8" aria-label="Tabs">
            @foreach($blogCategories as $cat)
                <button wire:click="setCategory({{$cat->id}})"
                        class="{{ $category->id == $cat->id ? 'border-outdoor-primary text-outdoor-primary':'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    {{$cat->title}}
                    <span class="ml-2 py-0.5 px-2 text-xs bg-gray-100 rounded-full">
                        {{ $blogs->where('blog_category_id', $cat->id)->count() }}
                    </span>
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Blog Posts List -->
    @if($blogs->count() > 0)
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($blogs as $blog)
                <x-admin-list-item
                    :item="$blog"
                    :link-url="route('admin.blog.preview', $blog->id)"
                    delete-type="blog"
                    :subtitle="'By ' . $blog->user->name . ' • ' . $blog->created_at->diffForHumans() . ($blog->blogcategory ? ' • ' . $blog->blogcategory->title : '')"
                >
                    <x-slot name="customActions">
                        <button
                            wire:click="togglePublished({{ $blog->id }})"
                            class="inline-flex items-center px-2 py-1 border shadow-sm text-xs leading-4 font-medium rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-outdoor-primary transition-colors {{ $blog->published ? 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100' : 'border-gray-300 text-gray-700 bg-gray-50 hover:bg-gray-100' }}"
                        >
                            @if($blog->published)
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Published
                            @else
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Unpublished
                            @endif
                        </button>
                    </x-slot>
                </x-admin-list-item>
            @endforeach
        </ul>

        @if($blogs->hasPages())
            <div class="mt-6">
                <x-admin-pagination :paginator="$blogs" />
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <x-icon.blog class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">No blog posts</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new blog post.</p>
            <div class="mt-6">
                <a href="{{ route('admin.blog.create') }}">
                    <x-button.primary>
                        <x-icon.add class="w-4 h-4 mr-2" />
                        New Post
                    </x-button.primary>
                </a>
            </div>
        </div>
    @endif
</div>
