<div>
    <form wire:submit.prevent="save">
        <x-input.text wire:model="title" label="Title"/>
        <x-input.trix wire:model="description" label="Description"/>
        <x-input.textarea wire:model="keywords" label="Keywords (Comma Seperated)"/>
        <div>
        	<label>PIP</label>
        <input wire:model="pip" type="file"/> 
        </div>
 
        <x-input.filepond multiple="true" wire:model="photos" label="Photos"/>
        <x-button.submit text="Save"/>
    </form>

    <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
        <ul wire:sortable="updatePhotoOrder" role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @foreach($product->photos()->orderBy('order','asc')->get() as $photo)
                <li wire:sortable.item="{{$photo->id}}" wire:key="photo-{{$photo->id,rand(0,10000)}}" class="relative">
                    <a href="{{route('admin.products.product.photo.edit',['id'=>$photo->id])}}" class=" aspect-w-10 aspect-h-7 group block w-full overflow-hidden rounded-lg bg-gray-100" >
                        <img src="{{asset('storage/'.$photo->path)}}"
                             alt="{{$photo->title}}"
                             class=" object-cover">
                    </a>
                    <p class=" mt-2 block truncate text-sm font-medium text-gray-900">{{$photo->title}}</p>
                    <div class="mt-2">
                        <livewire:keyword-tags wire:key="keyword-tags-{{$photo->id.rand(0,10000)}}" :model="$photo"/>
                    </div>
                    <div class="mt-2 flex gap-1">
                        <x-button.info  wire:sortable.handle size="small"><x-icon.drag class="fill-white w-4"/></x-button.info>
                        <x-delete-button type="photo" :guid="$photo->id"/>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
    <section>
        <h2>Current PIP</h2>
        @if($product->pip)
            <embed src="{{asset('storage/'.$product->pip->path)}}" width="500" height="375"
                   type="application/pdf">
            <div class="mt-8">
                <x-delete-button type="pip" :guid="$product->pip->id"/>
            </div>
        @endif
    </section>


</div>

