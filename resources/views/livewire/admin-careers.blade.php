<div>
    <ul role="list" class="space-y-2">
        @foreach($careers as $career)
            <x-admin-list-item
                :item="$career"
                :link-url="route('admin.career.update', $career->id)"
                delete-type="career"
                :subtitle="'Created by ' . $career->user->name . ' on ' . $career->created_at->format('m/d/Y') . ' (' . $career->created_at->diffForHumans() . ')'"
            >
                <x-slot name="customActions">
                    <x-dynamic-component wire:click="togglePublished({{$career->id}})" size="small" :component="$career->published ? 'button.warning':'button.info'">
                        @if($career->published == 1)
                            Unpublish
                        @else
                            Publish
                        @endif
                    </x-dynamic-component>
                </x-slot>
            </x-admin-list-item>
        @endforeach
    </ul>
    @if($careers->hasPages())
        <div class="mt-6">
            {{$careers->links()}}
        </div>
    @endif
</div>
