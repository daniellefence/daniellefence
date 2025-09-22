<div x-data="{
        expanded:0
    }" class="">
    <x-page-heading>
        <x-slot name="heading">Frequently Asked Questions</x-slot>
    </x-page-heading>
    <div class="mx-auto max-w-4xl divide-y divide-gray-900/10">
        <dl class="mt-10 space-y-6 divide-y divide-gray-900/10">
            @foreach(\App\Models\Faq::orderBy('order','asc')->get() as $faq)
                <div class="pt-6">
                    <dt>
                        <button @click="expanded == {{$faq->id}} ? expanded = 0:expanded = {{$faq->id}}" type="button" class="flex w-full items-start justify-between text-left text-gray-900" aria-controls="faq-0" aria-expanded="false">
                            <span class="text-base font-semibold leading-7">{{$faq->question}}</span>
                            <span class="ml-6 flex h-7 items-center">
                                    <svg :class="expanded == {{$faq->id}} ? 'hidden':''" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                <svg x-cloak :class="expanded == {{$faq->id}} ? '':'hidden'" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                </svg>
                              </span>
                        </button>
                    </dt>
                    <dd x-show="expanded == {{$faq->id}}" x-cloak class="mt-2 pr-12 transition" id="faq-0">
                        <p class="text-base leading-7 text-gray-600 prose">
                            {!! $faq->answer !!}
                        </p>
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
