@php
    use Spatie\MediaLibrary\MediaCollections\Models\Media;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div 
        x-data="mediaPickerRichEditor(@js($getExtraAlpineAttributes()))"
        x-init="initMediaPicker()"
        wire:ignore
        {{ $attributes
            ->merge($getExtraAttributes(), escape: false)
            ->merge($getExtraAlpineAttributes(), escape: false)
            ->class([
                'fi-fo-rich-editor',
                'fi-fo-rich-editor-with-media-picker'
            ])
        }}
    >
        <!-- Rich Editor -->
        <div
            x-data="richEditorFormComponent({
                isDisabled: @js($isDisabled()),
                state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$getStatePath()}')") }},
            })"
            x-on:editor-selection-changed="onEditorSelectionChanged($event)"
            {{ $getExtraAlpineAttributeBag() }}
        >
            <div
                class="fi-input-wrp flex rounded-lg  ring-1 transition duration-75 bg-white ring-gray-950/10 focus-within:ring-2 focus-within:ring-primary-600"
                x-bind:class="{
                    'fi-disabled pointer-events-none opacity-70': isDisabled,
                }"
            >
                <div
                    wire:ignore
                    x-ref="editor"
                    class="fi-rich-editor prose max-w-none p-3 prose-sm focus:outline-none prose-headings:font-semibold prose-headings:text-gray-950 prose-p:text-gray-950 prose-a:text-primary-600 prose-a:no-underline prose-a:hover:underline prose-strong:text-gray-950 prose-ol:text-gray-950 prose-ul:text-gray-950 prose-li:text-gray-950 prose-pre:bg-gray-950/5 prose-pre:text-gray-950 prose-hr:border-gray-200 prose-lead:text-gray-600 prose-blockquote:border-l-primary-600 prose-blockquote:text-gray-700"
                ></div>
            </div>
        </div>

        <!-- Media Picker Modal -->
        <div
            x-show="showMediaPicker"
            x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <!-- Backdrop -->
            <div 
                class="absolute inset-0 bg-gray-500/75"
                x-on:click="closeMediaPicker"
            ></div>

            <!-- Modal Panel -->
            <div class="relative bg-white rounded-lg  max-w-7xl mx-4 w-full max-h-[90vh] overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900" x-text="modalTitle"></h3>
                    <button
                        type="button"
                        class="rounded-md p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500"
                        x-on:click="closeMediaPicker"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="p-6 overflow-y-auto max-h-[70vh]">
                    <!-- Search and Filters -->
                    <div class="mb-6 flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input
                                type="text"
                                placeholder="Search media..."
                                x-model="searchQuery"
                                x-on:input.debounce.300ms="searchMedia"
                                class="block w-full rounded-md border-gray-300  focus:border-primary-500 focus:ring-primary-500"
                            >
                        </div>
                        <div class="flex gap-2">
                            <select x-model="selectedType" x-on:change="filterMedia" class="rounded-md border-gray-300  focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Types</option>
                                <option value="image">Images</option>
                                <option value="video">Videos</option>
                                <option value="audio">Audio</option>
                                <option value="document">Documents</option>
                            </select>
                            <select x-model="selectedCollection" x-on:change="filterMedia" class="rounded-md border-gray-300  focus:border-primary-500 focus:ring-primary-500">
                                <option value="">All Collections</option>
                                <template x-for="collection in collections" :key="collection">
                                    <option :value="collection" x-text="collection"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Media Grid -->
                    <template x-if="filteredMedia.length > 0">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                            <template x-for="media in filteredMedia" :key="media.id">
                                <div 
                                    class="group relative aspect-square rounded-lg overflow-hidden cursor-pointer ring-2 ring-transparent hover:ring-primary-500 transition-all duration-200"
                                    x-on:click="selectMedia(media)"
                                    :class="{
                                        'ring-primary-500 ring-2': selectedMediaIds.includes(media.id)
                                    }"
                                >
                                    <!-- Image/Thumbnail -->
                                    <template x-if="media.mime_type && media.mime_type.startsWith('image/')">
                                        <img 
                                            :src="media.preview_url || media.original_url" 
                                            :alt="media.alt_text || media.name"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        >
                                    </template>
                                    
                                    <!-- File Type Icon for non-images -->
                                    <template x-if="!media.mime_type || !media.mime_type.startsWith('image/')">
                                        <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center p-4">
                                            <svg class="h-12 w-12 text-gray-400 mb-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                            </svg>
                                            <span class="text-xs text-gray-500 text-center truncate w-full" x-text="media.name"></span>
                                        </div>
                                    </template>

                                    <!-- Selection Overlay -->
                                    <div 
                                        class="absolute inset-0 bg-primary-600/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center"
                                        :class="{
                                            'opacity-100': selectedMediaIds.includes(media.id)
                                        }"
                                    >
                                        <template x-if="selectedMediaIds.includes(media.id)">
                                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        </template>
                                    </div>

                                    <!-- Media Info -->
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                        <p class="text-white text-xs truncate" x-text="media.name"></p>
                                        <p class="text-white/80 text-xs" x-text="formatFileSize(media.size)"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- Empty State -->
                    <template x-if="filteredMedia.length === 0">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900" x-text="emptyStateHeading"></h3>
                            <p class="mt-1 text-sm text-gray-500" x-text="emptyStateDescription"></p>
                        </div>
                    </template>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-between p-6 border-t border-gray-200 bg-gray-50">
                    <div class="text-sm text-gray-500">
                        <span x-text="selectedMediaIds.length"></span> selected
                    </div>
                    <div class="flex gap-3">
                        <button
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            x-on:click="closeMediaPicker"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500"
                            x-on:click="insertSelectedMedia"
                            :disabled="selectedMediaIds.length === 0"
                            :class="{
                                'opacity-50 cursor-not-allowed': selectedMediaIds.length === 0
                            }"
                        >
                            Insert Media
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mediaPickerRichEditor', (config) => ({
                showMediaPicker: false,
                mediaData: [],
                filteredMedia: [],
                collections: [],
                selectedMediaIds: [],
                searchQuery: '',
                selectedType: '',
                selectedCollection: '',
                modalTitle: config.modalTitle || 'Select Media',
                emptyStateHeading: config.emptyStateHeading || 'No media found',
                emptyStateDescription: config.emptyStateDescription || 'Upload some media files to get started.',
                
                init() {
                    this.loadMediaData();
                },

                async loadMediaData() {
                    try {
                        const response = await fetch('/admin/api/media');
                        if (response.ok) {
                            const data = await response.json();
                            this.mediaData = data.media;
                            this.collections = data.collections;
                            this.filteredMedia = this.mediaData;
                        }
                    } catch (error) {
                        console.error('Failed to load media data:', error);
                    }
                },

                openMediaPicker() {
                    this.showMediaPicker = true;
                    this.selectedMediaIds = [];
                    this.searchQuery = '';
                    this.selectedType = '';
                    this.selectedCollection = config.mediaCollection || '';
                    this.filterMedia();
                },

                closeMediaPicker() {
                    this.showMediaPicker = false;
                    this.selectedMediaIds = [];
                },

                selectMedia(media) {
                    const index = this.selectedMediaIds.indexOf(media.id);
                    if (index > -1) {
                        this.selectedMediaIds.splice(index, 1);
                    } else {
                        this.selectedMediaIds.push(media.id);
                    }
                },

                searchMedia() {
                    this.filterMedia();
                },

                filterMedia() {
                    let filtered = this.mediaData;

                    // Filter by search query
                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(media => 
                            media.name.toLowerCase().includes(query) ||
                            media.file_name.toLowerCase().includes(query) ||
                            (media.alt_text && media.alt_text.toLowerCase().includes(query))
                        );
                    }

                    // Filter by type
                    if (this.selectedType) {
                        filtered = filtered.filter(media => {
                            if (!media.mime_type) return false;
                            return media.mime_type.startsWith(this.selectedType + '/');
                        });
                    }

                    // Filter by collection
                    if (this.selectedCollection) {
                        filtered = filtered.filter(media => 
                            media.collection_name === this.selectedCollection
                        );
                    }

                    this.filteredMedia = filtered;
                },

                insertSelectedMedia() {
                    const selectedMedia = this.mediaData.filter(media => 
                        this.selectedMediaIds.includes(media.id)
                    );

                    // Insert each selected media item into the editor
                    selectedMedia.forEach(media => {
                        if (media.mime_type && media.mime_type.startsWith('image/')) {
                            this.insertImage(media);
                        } else {
                            this.insertFile(media);
                        }
                    });

                    this.closeMediaPicker();
                },

                insertImage(media) {
                    const img = `<img src="${media.original_url}" alt="${media.alt_text || media.name}" title="${media.name}" />`;
                    this.insertContent(img);
                },

                insertFile(media) {
                    const link = `<a href="${media.original_url}" target="_blank" title="Download ${media.name}">${media.name}</a>`;
                    this.insertContent(link);
                },

                insertContent(html) {
                    // This method would interact with the rich editor instance
                    // Implementation depends on the specific rich editor being used
                    if (window.tinyMCE && this.editorInstance) {
                        this.editorInstance.insertContent(html);
                    }
                },

                formatFileSize(bytes) {
                    if (!bytes) return '0 B';
                    const units = ['B', 'KB', 'MB', 'GB'];
                    let size = bytes;
                    let unitIndex = 0;
                    
                    while (size >= 1024 && unitIndex < units.length - 1) {
                        size /= 1024;
                        unitIndex++;
                    }
                    
                    return `${size.toFixed(1)} ${units[unitIndex]}`;
                }
            }));
        });
    </script>
</x-dynamic-component>