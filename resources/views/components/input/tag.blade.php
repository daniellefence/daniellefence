@props([
    'label' => '',
    'id' => 'tag_input_' . uniqid(),
    'placeholder' => 'Add tags...'
])

<div class="mb-4"
     x-data="{
        tags: [],
        inputValue: '',
        wireModel: @entangle($attributes->wire('model')).defer,

        init() {
            // Initialize with existing value
            if (this.wireModel) {
                if (typeof this.wireModel === 'string') {
                    this.tags = this.wireModel.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
                } else if (Array.isArray(this.wireModel)) {
                    this.tags = this.wireModel;
                }
            }

            // Watch for changes
            this.$watch('tags', () => {
                this.updateWireModel();
            });
        },

        addTag() {
            const tag = this.inputValue.trim();
            if (tag && !this.tags.includes(tag)) {
                this.tags.push(tag);
                this.inputValue = '';
            }
        },

        removeTag(index) {
            this.tags.splice(index, 1);
        },

        handleBackspace() {
            if (this.inputValue === '' && this.tags.length > 0) {
                this.tags.pop();
            }
        },

        updateWireModel() {
            this.wireModel = this.tags.join(', ');
        }
     }">
    @if($label)
        <label class="mb-2 block text-sm font-medium text-gray-700" for="{{ $id }}">{{ $label }}</label>
    @endif

    <div class="mt-2">
        <!-- Tags Display -->
        <div class="flex flex-wrap gap-2 mb-2" x-show="tags.length > 0">
            <template x-for="(tag, index) in tags" :key="index">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-outdoor-primary text-white">
                    <span x-text="tag"></span>
                    <button type="button" @click="removeTag(index)" class="ml-2 text-white hover:text-gray-200 focus:outline-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </span>
            </template>
        </div>

        <!-- Input Field -->
        <div class="relative">
            <input
                type="text"
                id="{{ $id }}"
                x-model="inputValue"
                @keydown.enter.prevent="addTag()"
                @keydown.comma.prevent="addTag()"
                @keydown.backspace="handleBackspace()"
                placeholder="{{ $placeholder }}"
                class="block w-full rounded-md border-0 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-outdoor-primary sm:text-sm sm:leading-6"
            >
        </div>

        <p class="mt-1 text-xs text-gray-500">Press Enter or comma to add tags</p>
    </div>

    <p class="mt-2 text-sm text-gray-500">
        <x-input-error for="{{ $attributes->wire('model') }}"></x-input-error>
    </p>
</div>