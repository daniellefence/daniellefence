@props([
    'type' => 'success', // success, error, warning, info
    'title' => null,
    'dismissible' => true
])

<div x-data="{ show: true }" x-show="show" x-transition
     class="rounded-md p-4 {{ $type === 'success' ? 'bg-green-50' : ($type === 'error' ? 'bg-red-50' : ($type === 'warning' ? 'bg-yellow-50' : 'bg-blue-50')) }}">
    <div class="flex">
        <div class="flex-shrink-0">
            @if($type === 'success')
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.25a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            @elseif($type === 'error')
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                </svg>
            @elseif($type === 'warning')
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
            @else
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
            @endif
        </div>
        <div class="ml-3">
            @if($title)
                <h3 class="text-sm font-medium {{ $type === 'success' ? 'text-green-800' : ($type === 'error' ? 'text-red-800' : ($type === 'warning' ? 'text-yellow-800' : 'text-blue-800')) }}">
                    {{ $title }}
                </h3>
            @endif
            <div class="text-sm {{ $type === 'success' ? 'text-green-700' : ($type === 'error' ? 'text-red-700' : ($type === 'warning' ? 'text-yellow-700' : 'text-blue-700')) }}">
                {{ $slot }}
            </div>
        </div>
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" type="button"
                            class="inline-flex rounded-md p-1.5 {{ $type === 'success' ? 'bg-green-50 text-green-500 hover:bg-green-100' : ($type === 'error' ? 'bg-red-50 text-red-500 hover:bg-red-100' : ($type === 'warning' ? 'bg-yellow-50 text-yellow-500 hover:bg-yellow-100' : 'bg-blue-50 text-blue-500 hover:bg-blue-100')) }} focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $type === 'success' ? 'focus:ring-green-600' : ($type === 'error' ? 'focus:ring-red-600' : ($type === 'warning' ? 'focus:ring-yellow-600' : 'focus:ring-blue-600')) }}">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>