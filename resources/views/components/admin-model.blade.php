<li class="relative flex justify-between gap-x-6 py-5 bg-gray-100
rounded-lg mb-2 px-2">
    <div class="flex min-w-0 gap-x-4">
        <img class="h-12 w-12 flex-none bg-gray-50" src="{{url($model->photos()->first()->path)}}" alt="">
        <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-900">
                <a href="{{$model->href}}" target="{{strpos('daniellefence','danielle') > -1 ? '':'_blank'}}">
                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                    {{$model->title}} - {{$model->price}}
                </a>
            </p>
            <p class="mt-1 flex text-xs leading-5 text-gray-500">
               {!! \Illuminate\Support\Str::limit($model->content,120) !!}
            </p>
        </div>
    </div>
    @if(isset($buttons))
    <div class="flex shrink-0 items-center gap-x-4">
        <div class="hidden sm:flex sm:flex-col sm:items-end">
            {!! $buttons !!}
        </div>
    </div>
    @endif
</li>
