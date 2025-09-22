<div x-data="{

    }">
    <div class="overflow-hidden bg-outdoor-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div
                class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
                <div class="lg:pr-8 lg:pt-4">
                    <div class="lg:max-w-lg">
                        <h2 class="text-base font-semibold leading-7 text-outdoor-primary">The Danielle Career&nbsp;Center</h2>
                        <p class="my-2 mb-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Join Our
                            Team</p>
                        <div class="mx-auto max-w-4xl divide-y divide-gray-900/10">
                            <dl class="mt-10 space-y-6 divide-y divide-gray-900/10">
                                @foreach($careers as $career)
                                    <div class="pt-6">
                                        <dt>
                                            <!-- Expand/collapse question button -->
                                            <a href="{{$career->getRoute()}}" wire:click="showModalFunction({{$career->id}})" type="button"
                                                    class="flex w-full items-start justify-between text-left text-gray-900"
                                                    aria-controls="faq-0" aria-expanded="false">
                                                <span class="text-base font-semibold leading-7">
                                                        {{$career->title}}
                                                </span>
                                                <span class="ml-6 flex h-7 items-center">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                             aria-hidden="true">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                                                    </svg>
                                                </span>
                                            </a>
                                        </dt>

                                    </div>
                                @endforeach
                            </dl>
                        </div>

                    </div>
                </div>
                <img src="{{Vite::asset('resources/images/careers.jpg')}}" alt="Product screenshot"
                     class="hidden sm:block w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem] md:-ml-4 lg:-ml-0"
                     width="2432" height="1442">
                <div class="prose col-span-2 mt-6 text-lg  text-gray-600">
                    <h2>Still on the fence about your next career move?</h2>
                    <p>At Danielle Fence, we are always looking for hard-working and motivated individuals to join our
                        team in these positions:</p>
                    <ul>
                        <li>Fence Installers</li>
                        <li>Inside / Outside Sales Representatives</li>
                        <li>Administrative/Operations</li>
                    </ul>
                    <p>If you have qualified experience in any of these areas, please send us your resume today! We may
                        have the perfect opportunity waiting for you.</p>
                    <p>If you have any questions regarding the positions we have open, please contact our HR Department
                        at 863.425.3182 ext. 1215 or HR@daniellefence.net.</p>
                    <div>
                        <a href="{{route('apply')}}">
                            <x-button.danger size="large" class="w-full">Apply Today!</x-button.danger>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
