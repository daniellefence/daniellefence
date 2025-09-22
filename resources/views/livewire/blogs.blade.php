<div>
    <x-page-heading>
        <x-slot name="heading">From the blog</x-slot>
        <x-slot name="subheading">
            <p>When it comes to taking your outdoor living space to the next level, our team at Danielle Fence & Outdoor
                Living is here to help. Read through our blog to learn more about our great selection of fence and
                outdoor living products, helpful information, tips, and design inspiration.
            </p>
            <p> Don’t see what you’re looking for? Contact us! Our design experts would love to create something unique
                for you. If you have any questions about our products or would like to get in touch about a new project,
                contact us today.</p>
        </x-slot>
    </x-page-heading>
    <div class="mx-auto max-w-2xl text-center my-14">
        <a href="{{route('contact')}}">
            <x-button.danger type="large">Contact Us</x-button.danger>
        </a>
    </div>
    <x-page-wrap nopadding>


        <div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <select id="tabs" name="tabs"
                        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">
                            {{$category->title}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <!-- Current: "", Default: "" -->
                        @foreach($categories as $category)
                            <button wire:click="setBlogCategory({{$category->id}})"
                                    class="{{ $category->id == $blogCategoryId ? 'border-outdoor-primary text-outdoor-primary':'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                                {{$category->title}}
                            </button>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>
        <div class="mx-auto mt-4 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            @foreach($blogs as $blog)
                <article class="flex flex-col items-start justify-between">
                    <div class="relative w-full">
                        @if($blog->photo)
                            <a data-fslightbox="gallery-{{$blog->id}}" href="{{$blog->photo->path}}">
                                <img src="{{$blog->photo->path}}" alt="{{$blog->title}}"
                                     class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                            </a>
                        @endif
                    </div>
                    <div class="max-w-xl">
                        <div class="my-8">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                {{$blog->blogcategory->title}}
                            </span>
                        </div>
                        @if($blog->show_date)
                        <div class="mt-8 flex items-center gap-x-4 text-xs">
                            <time datetime="{{$blog->created_at}}" class="text-gray-500">
                                {{$blog->created_at->format('m/d/Y')}}
                            </time>
                        </div>
                        @endif
                        <div class="group relative">
                            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                <a href="{{$blog->getRoute()}}">
                                    <span class="absolute inset-0"></span>
                                    {{$blog->title}}
                                </a>
                            </h3>
                            <div class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </x-page-wrap>
</div>
