<a href="{{route($menu['route'])}}"
   class="{{in_array(\Illuminate\Support\Facades\Route::currentRouteName(),$menu['active']) ? 'text-outdoor-primary bg-white shadow-sm border-r-2 border-outdoor-primary':'text-gray-700'}} hover:bg-gray-50 hover:text-gray-900 group flex items-center rounded-md px-3 py-2 text-sm font-medium transition-all duration-150 ease-in-out admin-focus">
    <x-dynamic-component :component="'icon.'.$menu['icon']" class="{{ in_array(\Illuminate\Support\Facades\Route::currentRouteName(),$menu['active']) ? 'fill-outdoor-primary':'fill-gray-400 group-hover:fill-gray-500' }} mr-3 h-5 w-5 flex-shrink-0 transition-colors"/>
    <span class="truncate">{{$menu['label']}}</span>

    @if(in_array(\Illuminate\Support\Facades\Route::currentRouteName(),$menu['active']))
        <span class="ml-auto">
            <svg class="h-4 w-4 text-outdoor-primary" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </span>
    @endif
</a>