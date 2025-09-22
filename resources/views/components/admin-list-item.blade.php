@props([
    'item',
    'editingId' => null,
    'editingTitle' => '',
    'showDragHandle' => false,
    'showEditButton' => false,
    'showDeleteButton' => true,
    'deleteType' => 'item',
    'titleField' => 'title',
    'subtitle' => null,
    'linkUrl' => null,
    'linkTarget' => null,
    'customActions' => null
])

<li class="flex justify-between items-center gap-x-6 py-5 bg-white border border-2 rounded shadow my-1 p-4"
    @if($showDragHandle)
        wire:sortable.item="{{ $item->id }}"
        wire:key="item-{{ $item->id }}"
        class="item-holder"
    @endif
>
    <div class="flex gap-2 items-center justify-between w-full">
        @if($editingId === $item->id)
            <div class="flex items-center gap-2 flex-1">
                @if($showDragHandle)
                    <div class="cursor-move" wire:sortable.handle>
                        <x-icon.drag class="w-6"></x-icon.drag>
                    </div>
                @endif
                <input
                    type="text"
                    wire:model="editingTitle"
                    wire:keydown.enter="saveEdit({{ $item->id }})"
                    wire:keydown.escape="cancelEditing"
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    autofocus
                >
            </div>
            <div class="flex items-center gap-2">
                <button
                    wire:click="saveEdit({{ $item->id }})"
                    class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    Save
                </button>
                <button
                    wire:click="cancelEditing"
                    class="inline-flex items-center px-2 py-1 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Cancel
                </button>
            </div>
        @else
            <div class="flex items-center gap-2">
                @if($showDragHandle)
                    <div class="cursor-move" wire:sortable.handle>
                        <x-icon.drag class="w-6"></x-icon.drag>
                    </div>
                @endif
                <div class="min-w-0 flex-auto">
                    @if($linkUrl)
                        <p class="text-sm font-semibold leading-6 text-gray-900">
                            <a href="{{ $linkUrl }}"
                               @if($linkTarget) target="{{ $linkTarget }}" @endif
                               class="hover:text-outdoor-primary transition-colors">
                                {{ data_get($item, $titleField) }}
                            </a>
                        </p>
                    @else
                        <p class="text-sm font-semibold leading-6 text-gray-900 @if($showEditButton) cursor-pointer hover:text-blue-600 @endif"
                           @if($showEditButton) wire:click="startEditing({{ $item->id }})" @endif>
                            {{ data_get($item, $titleField) }}
                        </p>
                    @endif
                    @if($subtitle)
                        <p class="text-xs text-gray-500">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if($customActions)
                    {{ $customActions }}
                @endif
                @if($showEditButton)
                    <button
                        wire:click="startEditing({{ $item->id }})"
                        class="text-blue-600 hover:text-blue-900 text-xs font-medium"
                    >
                        Edit
                    </button>
                @endif
                @if($showDeleteButton && ($deleteType !== 'blogCategory' || $item->id != 1))
                    <x-delete-button :guid="$item->id" :type="$deleteType"></x-delete-button>
                @endif
            </div>
        @endif
    </div>
</li>