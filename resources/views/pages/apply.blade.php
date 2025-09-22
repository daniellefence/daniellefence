<x-app-layout>
    @once
        @push('head')
            <link href="https://unpkg.com/trix@1.2.3/dist/trix.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
                  rel="stylesheet"/>
            <script
                src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
            <script src="https://www.google.com/recaptcha/api.js?render={{setting()->get("google_recaptcha_site_key")}}"></script>
        @endpush
        @push('scripts')
            <script src="https://unpkg.com/trix@1.2.3/dist/trix.js" defer></script>
            <script>
                FilePond.registerPlugin(FilePondPluginImagePreview);
            </script>
        @endpush
    @endonce
<livewire:apply :id="$id"></livewire:apply>
</x-app-layout>