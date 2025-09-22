<div>
    <a href="{{$item->getRoute()}}" class="group flex flex-col text-sm gap-y-8">
        @if($item->photos()->count() >0)
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="{{asset('storage/'.$item->photos()->orderBy('order','asc')->first()->path)}}" alt="{{$item->title}}" class="h-full w-full object-cover object-center">
            </div>
        @endif
        <h3 class="mt-8 font-medium text-center text-gray-900">{{$item->title}}</h3>
    </a>
</div>

