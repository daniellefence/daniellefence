@props([
    'align'=>'',
    'title'=>'',
    'key'=>''
])
<div class="{{$align ? 'bg-gray-100':''}} py-4">
    <x-page-wrap>
        <div class="lg:grid lg:auto-rows-min lg:grid-cols-12 lg:gap-x-8">
            @if($align)
                <div class="mt-12 lg:col-span-7 lg:row-span-3 ">
                    <div>
                        <x-carousel :page="$key"></x-carousel>
                    </div>
                </div>
            @endif
            <div class="mt-8 lg:col-span-5 ">
                <h3>{{$title}}</h3>
                <div class="mt-10 prose">{{$description}}</div>
            </div>
            @if(!$align)
                <div class="mt-12 lg:col-span-7 lg:row-span-3 ">
                    <div>
                        <x-carousel :page="$key"></x-carousel>
                    </div>
                </div>
            @endif
        </div>

    </x-page-wrap>
</div>
