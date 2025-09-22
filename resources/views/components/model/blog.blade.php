<li class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
    <div class="p-6">
        <div class="flex items-start justify-between">
            <div class="min-w-0 flex-1">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    <a href="{{$blog->getRoute()}}" target="_blank" class="hover:text-outdoor-primary transition-colors">
                        {{$blog->title}}
                    </a>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <x-icon.user class="h-4 w-4 mr-2 text-gray-400" />
                        <span class="font-medium">{{$blog->user->name}}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Created {{$blog->created_at->diffForHumans()}}</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Updated {{$blog->updated_at->diffForHumans()}}</span>
                    </div>
                </div>

                @if($blog->category)
                    <div class="mt-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-outdoor-primary/10 text-outdoor-primary">
                            {{$blog->category->title}}
                        </span>
                    </div>
                @endif
            </div>

            <div class="flex items-center space-x-2 ml-4">
                <button
                    wire:click="togglePublished({{ $blog->id }})"
                    class="inline-flex items-center px-3 py-2 border shadow-sm text-sm leading-4 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-outdoor-primary transition-colors {{ $blog->published ? 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100' : 'border-gray-300 text-gray-700 bg-gray-50 hover:bg-gray-100' }}"
                >
                    @if($blog->published)
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Published
                    @else
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Unpublished
                    @endif
                </button>
                <x-delete-button type="blog" :guid="$blog->id"/>
            </div>
        </div>
    </div>
</li>
