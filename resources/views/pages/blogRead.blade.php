<x-app-layout>
    @php($blog = \App\Models\Blog::findOrFail($id))


    <!-- Blog Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Main Content -->
            <div class="lg:col-span-2" data-aos="fade-right">
                <article class="prose prose-lg max-w-none">
                    <!-- Article Header -->
                    <div class="mb-12">
                        @if($blog->show_date)
                            <div class="mb-4">
                                <time class="text-gray-600 font-semibold">
                                    {{ $blog->created_at->format('F j, Y') }}
                                </time>
                            </div>
                        @endif

                        <h1 class="font-display text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight">
                            {{ $blog->title }}
                        </h1>

                        <livewire:keyword-tags :model="$blog"/>
                    </div>

                    <!-- Featured Image -->
                    @if($blog->photo()->count() > 0)
                        <div class="mb-8">
                            <img class="w-full rounded-2xl shadow-lg"
                                 src="{{ url($blog->photo->path) }}"
                                 alt="{{ $blog->title }}">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="prose prose-lg prose-brand max-w-none">
                        {!! $blog->content !!}
                    </div>

                    <!-- Share Section -->
                    <div class="mt-12 pt-8 border-t border-slate-200">
                        <x-share-this/>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 lg:sticky lg:top-0 lg:h-screen lg:overflow-y-auto lg:pt-4" data-aos="fade-left" data-aos-delay="200">
                <!-- Table of Contents or Related Content -->
                <div class="bg-slate-100 rounded-2xl p-6 mb-8">
                    <h3 class="font-display text-xl font-bold text-slate-900 mb-4">
                        Related Topics
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('request-a-quote') }}" class="block text-blue-700 hover:text-blue-600 font-medium">
                            Get a Free Quote
                        </a>
                        <a href="{{ route('contact') }}" class="block text-green-700 hover:text-green-600 font-medium">
                            Contact Our Experts
                        </a>
                        <a href="{{ route('blog') }}" class="block text-purple-700 hover:text-purple-600 font-medium">
                            More Expert Tips
                        </a>
                    </div>
                </div>

                <!-- Contact CTA -->
                <div class="bg-gray-800 rounded-2xl p-6 text-white">
                    <h3 class="font-display text-xl font-bold mb-4">
                        Need Expert Advice?
                    </h3>
                    <p class="text-gray-200 mb-6">
                        Our team is ready to help with your fencing and outdoor living project.
                    </p>
                    <a href="tel:863-425-3182"
                       class="inline-flex items-center justify-center w-full px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                        Call (863) 425-3182
                    </a>
                </div>
            </aside>
        </div>
    </x-modern-section>

    <!-- Related Articles CTA -->
    <x-modern-cta
        title="Explore More Expert Insights"
        description="Discover more tips, trends, and design inspiration from Central Florida's fencing and outdoor living experts."
        button-text="View All Articles"
        :button-url="route('blog')"
        secondary-text="Contact Our Team"
        secondary-url="tel:863-425-3182"
        :pattern="false" />
</x-app-layout>
