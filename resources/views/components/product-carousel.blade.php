<div class="swiffy-slider striped">

    <ul class="slider-container">
        @foreach($product->photos()->orderBy('order','asc')->get() as $photo)
            <li class="flex items-center justify-center">
                <div class="block sm:hidden swipe">
                    <div class="path"></div>
                    <div class="hand-icon"></div>
                </div>
                <div>
                    <div class="bg-white flex items-center justify-center p-4">{{$photo->title}}</div>
                    <a data-fslightbox="gallery" href="{{asset('storage/'.$photo->path)}}">
                        <img src="{{asset('storage/'.$photo->path)}}" style="max-width: 100%;height: auto;"
                             alt="{{$photo->title}}">
                    </a>
                    <div class=" pt-4 pb-8">
                        <livewire:keyword-tags wire:key="photo_keyword_tags{{$photo->id}}" :model="$photo"/>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <button type="button" class="slider-nav"></button>
    <button type="button" class="slider-nav slider-nav-next"></button>

    <div class="slider-indicators">
        @foreach($product->photos as $photo)
            <button @if($loop->first) class="active" @endif></button>
        @endforeach
    </div>
</div>
