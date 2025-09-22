<div class="py-4">
    @if(!empty($keywords))
        @php($count = 0)
        @foreach($keywords as $keyword)
            @if($clickable)
                <a href="{{route('search',['q'=>$keyword])}}" class="bg-outdoor-primary inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-outdoor-primary text-white ring-1 ring-inset m-1">
                    {!! ucwords($keyword) !!}
                </a>
            @else
                <span class="bg-outdoor-primary inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-outdoor-primary text-white ring-1 ring-inset m-1">
                    {!! ucwords($keyword) !!}
                </span>
            @endif
            @php($count ++)
            @php($count > count($styles)-1 ? $count = 0:'')
        @endforeach
   @endif
</div>
