@once
        @push('scripts')
                <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
                <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js" ></script>
                <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js" ></script>
                <script>
                        FilePond.registerPlugin(
                                FilePondPluginImagePreview,
                                FilePondPluginImageExifOrientation,
                        );
                </script>
        @endpush
        @push('styles')
                <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" media="all">
                <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet" media="all">
        @endpush

@endonce
<div
    class="bg-white rounded-lg mb-2"
    wire:ignore
    x-data
    x-init="
        FilePond.setOptions({
            allowMultiple:'{{$attributes['multiple']}}',
            credits:false,
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
        });
        const pond = FilePond.create($refs.input,{
            onaddfilestart:()=>{isLoadingCheck();},
            onprocessfile:()=>{isLoadingCheck();}
        });
        function isLoadingCheck() {
            var isLoading = pond.getFiles().filter(x=>x.status !==5).length !==0;
            if(isLoading) {
                 
            } else {
                
            }
        }
    "
>
    @if(isset($label))
        <label class="block my-2">{{$label}}</label>
    @endif
        <input class="mt-2" type="file" x-ref="input">
        <x-input-error for="{{$attributes['wire:model']}}"/>
</div>
