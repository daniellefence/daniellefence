<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Fetch Google Reviews Button -->
    <div class="mb-4">
        <button wire:click="fetchGoogleReviews"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Fetch Google Reviews
        </button>
    </div>

    <ul @if(auth()->user()->hasPermission('reviewUpdate'))  wire:sortable="updateOrder" @endif role="list"
        class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        @foreach($reviews as $review)
            <li wire:sortable.item="{{$review->id}}" wire:key="review-{{$review->id}}"
                class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 w-full">
                <div class="flex w-full justify-between min-w-0 gap-x-4">
                    <div>
                        <div class="cursor-pointer" wire:sortable.handle>
                            @if(auth()->user()->hasPermission('reviewUpdate'))
                                <x-icon.drag class="w-4"></x-icon.drag>
                            @endif
                        </div>
                        @if($review->photos()->count() > 0)
                            <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                 src="{{url($review->photos()->first()->path)}}" alt="{{$review->title}}"/>
                        @endif
                    </div>

                    <div class="min-w-0 flex-auto">
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            {{$review->name}}
                        </p>
                        <div class="mt-1 flex">
                            <x-output.five-star :stars="$review->stars"></x-output.five-star>
                        </div>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            {!! \Illuminate\Support\Str::limit($review->content) !!}
                        </p>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            Created: {{$review->created_at->format('m/d/Y')}}
                        </p>
                    </div>

                </div>
                <div class="flex gap-1">
                    @if(permission()->check('reviewUpdate'))
                        <div>
                            @if($review->hidden)
                                <x-button wire:click="setHiddenFalse({{$review->id}})" size="small">Show</x-button>
                            @else
                                <x-button.warning wire:click="setHiddenTrue({{$review->id}})" size="small">Hide</x-button.warning>
                            @endif
                        </div>
                        <div>
                            <a href="{{route('admin.review.update',['id'=>$review->id])}}">
                                <x-button size="small">
                                    <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                                </x-button>
                            </a>
                        </div>

                    @endif
                    @if(permission()->check('reviewDelete'))
                        <x-delete-button :guid="$review->id" type="review"/>
                    @endif
                </div>


            </li>
        @endforeach
        <div class="p-4">
            @if($reviews->hasPages())
                {{$reviews->links()}}
            @endif
        </div>
    </ul>
</div>

