<div>
    @if($contacts->count() > 0)
        <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <ul role="list" class="divide-y divide-gray-100">
                @foreach($contacts as $contact)
                    <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                        <div class="flex min-w-0 gap-x-4">
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    {{ $contact->first_name }} {{ $contact->last_name }}
                                    @if($contact->company)
                                        <span class="text-gray-500">- {{ $contact->company }}</span>
                                    @endif
                                </p>
                                <p class="mt-1 text-xs leading-5 text-gray-500">
                                    <a href="mailto:{{ $contact->email }}" class="hover:text-blue-600">{{ $contact->email }}</a>
                                    @if($contact->phone)
                                        • <a href="tel:{{ $contact->phone }}" class="hover:text-blue-600">{{ $contact->phone }}</a>
                                    @endif
                                </p>
                                @if($contact->message)
                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                        {{ Str::limit($contact->message, 150) }}
                                    </p>
                                @endif
                                @if($contact->how_did_you_hear_about_us)
                                    <p class="mt-1 text-xs text-gray-400">
                                        How they heard about us: {{ $contact->how_did_you_hear_about_us }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-x-4">
                            <div class="text-right">
                                <p class="text-xs text-gray-500">
                                    {{ $contact->created_at->format('M j, Y') }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $contact->created_at->format('g:i A') }}
                                </p>
                            </div>
                            <x-delete-button :guid="$contact->id" type="contact"/>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        @if($contacts->hasPages())
            <div class="mt-6">
                {{ $contacts->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-2-4h.01M9 16h6m-6 0V8a2 2 0 012-2h4.586a1 1 0 01.707.293l2.414 2.414A1 1 0 0119 9.414V16a2 2 0 01-2 2H9a2 2 0 01-2-2V8z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No contacts</h3>
            <p class="mt-1 text-sm text-gray-500">No contact submissions have been received yet.</p>
        </div>
    @endif
</div>
