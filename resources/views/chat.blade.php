<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-gray-100 section-slate-texture">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grass-offset">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Chat with Grillbert</h1>
                <p class="text-lg text-gray-600">Ask our AI assistant about fencing, DIY projects, and more!</p>
            </div>

            <!-- Chat Interface -->
            <div class="rounded-2xl overflow-hidden min-h-[600px]">
                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">
                    <!-- Left Side - Grillbert Video -->
                    <div class="p-8 flex flex-col items-center justify-center">
                        <!-- Thought Bubble -->
                        <div class="relative mb-6">
                            <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-200 relative max-w-sm mx-auto">
                                <h2 class="text-xl font-bold text-gray-900 mb-2 text-center">Meet Grillbert</h2>
                                <p class="text-gray-600 text-center">Your friendly fencing assistant</p>

                                <!-- Thought bubble tail -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full">
                                    <div class="w-0 h-0 border-l-[15px] border-r-[15px] border-t-[15px] border-l-transparent border-r-transparent border-t-white"></div>
                                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-[1px] w-0 h-0 border-l-[16px] border-r-[16px] border-t-[16px] border-l-transparent border-r-transparent border-t-gray-200"></div>
                                </div>

                                <!-- Small thought bubbles -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-8">
                                    <div class="w-3 h-3 bg-white rounded-full border border-gray-200"></div>
                                </div>
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-12 -translate-x-2">
                                    <div class="w-2 h-2 bg-white rounded-full border border-gray-200"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Grillbert Video -->
                        <div class="relative max-w-sm mx-auto">
                            <div class="rounded-2xl overflow-hidden bg-transparent">
                                <video autoplay loop muted playsinline class="w-full h-auto alpha-video">
                                    <source src="{{ asset('videos/grillbert.webm') }}" type="video/webm">
                                    <source src="{{ asset('videos/grillbert.mov') }}" type="video/quicktime">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>

                    </div>

                    <!-- Right Side - Zapier Chat Interface -->
                    <div class="flex flex-col h-full bg-white rounded-r-2xl border border-gray-200">
                        <!-- Zapier Chatbot Embed -->
                        <iframe
                            src='https://interfaces.zapier.com/embed/chatbot/cmeded84v002mzi5f9z0o17m9'
                            height='100%'
                            width='100%'
                            allow='clipboard-write *'
                            style="border: none; min-height: 600px;"
                            title="Chat with Grillbert">
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- Disclaimer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Grillbert is an AI assistant. For complex projects, please
                    <a href="{{ route('contact') }}" class="text-success hover:text-brand-green underline">contact our experts</a>
                    or call <a href="tel:8634253182" class="text-success hover:text-brand-green underline">(863) 425-3182</a>.
                </p>
            </div>
        </div>
    </div>


</x-app-layout>