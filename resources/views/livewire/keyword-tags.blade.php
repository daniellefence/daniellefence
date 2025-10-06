<div class="py-4">
    @if(!empty($tags))
        @php($count = 0)
        @foreach($tags as $tag)
            @if($clickable)
                <a href="{{route('search',['q'=>$tag])}}" class="bg-outdoor-primary inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-outdoor-primary text-white ring-1 ring-inset m-1">
                    {!! ucwords($tag) !!}
                </a>
            @else
                <span class="bg-outdoor-primary inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-outdoor-primary text-white ring-1 ring-inset m-1">
                    {!! ucwords($tag) !!}
                </span>
            @endif
            @php($count ++)
            @php($count > count($styles)-1 ? $count = 0:'')
        @endforeach
   @endif
</div>
