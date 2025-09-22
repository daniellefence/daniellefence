<div>
    <form wire:submit.prevent="save">
        <x-input.text wire:model="title" label="Title"/>
        <x-input.text wire:model="price" label="Price"/>
        <x-input.text wire:model="url" label="Url"/>
        <x-input.select wire:model="condition" :options="['new'=>'New','used'=>'Used','refurbished'=>'Refurbished']"
                        label="Condition"/>
        <x-input.text wire:model="brand" label="Brand"/>
        <x-input.trix wire:model="content" label="Content"/>
        <x-input.filepond wire:model="photos" label="Photos"/>
        <div class="mt-2">
            <x-button.submit/>
        </div>
    </form>
    <div class="px-4 pt-8 sm:px-6 lg:px-8">
        <ul role="list"
            class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @foreach($special->photos as $photo)
            <li class="relative">
                <a href="{{$special->getRoute()}}"
                    class="aspect-w-10 aspect-h-7 group block w-full overflow-hidden rounded-lg bg-gray-100">
                    <!-- Current: "", Default: "group-hover:opacity-75" -->
                    <img
                        src="{{asset('storage/'.$photo->path)}}"
                        alt="" class="object-cover">
                </a>
                <x-delete-button :guid="$photo->id" type="photo"/>
            </li>
            @endforeach
        </ul>
    </div>

</div>
