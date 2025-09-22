<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div>
        <form wire:submit.prevent="save" class="mb-2 flex rounded-md shadow-sm">
            <div class="relative flex flex-grow items-stretch focus-within:z-10">
                <input wire:model="title" type="text" class="block w-full rounded-none rounded-l-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 rounded-r-none" placeholder="Add Category">
            </div>
            <button type="submit" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Add
            </button>
        </form>
    </div>

    <ul wire:sortable="sort" role="list" class="">
        @foreach($categories as $category)
            <x-admin-list-item
                :item="$category"
                :editing-id="$editingId"
                :editing-title="$editingTitle"
                :show-drag-handle="true"
                :show-edit-button="true"
                delete-type="blogCategory"
            />
        @endforeach
    </ul>

</div>
