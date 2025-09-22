<div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none mt-14">
        <p class="text-base font-semibold leading-7 text-outdoor-primary">Career Details</p>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{$career->title}}</h1>
        <div class="my-4 prose">
            {!! $career->content !!}
        </div>
        <a href="{{route('apply',['id'=>$career->id])}}" class="flex justify-end">
            <x-button size="large">Apply</x-button>
        </a>
    </div>
</div>
