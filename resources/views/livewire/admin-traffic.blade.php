<div>
    <ul role="list" class="divide-y divide-gray-100">
        @foreach($traffic as $t)
            <li class="flex justify-between gap-x-6 py-5">
                <div class="flex min-w-0 gap-x-4 bg-white p-2 rounded w-full">
                    <div class="min-w-0 flex-auto">
                        <div class="text-sm font-semibold leading-6 text-gray-900">
                            Date:  {{$t->created_at->format('M/D/Y')}}<br/>
                            IP:  {{$t->ip}}
                        </div>
                        <p class="mt-1 flex text-xs leading-5 text-gray-500">
                            Referer:  {{$t->referer}}<br/>
                            Route::  {{$t->route}}
                        </p>
                    </div>
                </div>

            </li>
        @endforeach
        <div>
            @if($traffic->hasPages())
                <div>
                    {{$traffic->links()}}
                </div>
            @endif
        </div>
    </ul>

</div>
