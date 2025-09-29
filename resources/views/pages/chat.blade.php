<x-app-layout>
    <div class="min-h-screen relative section-slate-texture chat-background-image" style="background-image: url('{{ asset('images/fence.webp') }}'); background-size: cover; background-repeat: no-repeat; background-attachment: scroll; background-position: center;">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4 grass-offset pt-20 sm:pt-32">
            <!-- Chat Interface -->
            <div class="rounded-2xl overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Left Side - Grillbert Video -->
                    <div class="p-4 sm:p-8 flex flex-col items-center justify-center bg-white/10 backdrop-blur-md border border-white/20 min-h-[300px] lg:min-h-[600px]">
                        <!-- Header -->
                        <div class="text-center mb-4 sm:mb-8 bg-black/40 rounded-xl p-4 sm:p-6 backdrop-blur-sm">
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2 sm:mb-4 drop-shadow-xl">Chat with Grillbert</h1>
                            <p class="text-sm sm:text-lg text-white drop-shadow-lg">Ask our AI assistant about fencing, installation, and more!</p>
                        </div>

                        <!-- Grillbert Video -->
                        <div class="relative max-w-xs sm:max-w-sm mx-auto">
                            <div class="rounded-2xl overflow-hidden bg-transparent alpha-video-container">
                                <video autoplay loop muted playsinline class="w-full h-auto alpha-video opacity-0 transition-opacity duration-1000"
                                       onloadeddata="this.style.opacity=1"
                                       style="background: transparent;">
                                    <!-- MP4 format for better Safari compatibility -->
                                    @if(file_exists(resource_path('videos/grillbert.mp4')))
                                        <source src="{{ Vite::asset('resources/videos/grillbert.mp4') }}" type="video/mp4">
                                    @endif
                                    <!-- WebM as fallback for other browsers -->
                                    <source src="{{ Vite::asset('resources/videos/grillbert.webm') }}" type="video/webm">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>

                    </div>

                    <!-- Right Side - Zapier Chat Interface -->
                    <div class="flex flex-col bg-brand-light lg:rounded-r-2xl border border-brand-neutral/20 min-h-[500px] lg:min-h-[600px]">
                        <!-- Zapier Chatbot Embed -->
                        <iframe
                            src='https://interfaces.zapier.com/embed/chatbot/cmeded84v002mzi5f9z0o17m9'
                            width='100%'
                            allow='clipboard-write *'
                            class="chat-iframe-border flex-1 min-h-[500px]"
                            title="Chat with Grillbert">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>