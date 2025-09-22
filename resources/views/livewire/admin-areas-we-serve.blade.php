<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <ul role="list" class="divide-y divide-gray-100">
        @foreach($areas as $area)
            <x-admin-list-item
                :item="$area"
                :editing-id="$editingId"
                :editing-title="$editingTitle"
                :show-edit-button="true"
                delete-type="area"
            />
        @endforeach
    </ul>

    <div>
        @if($areas->hasPages())
            <div>
                {!! $areas->links() !!}
            </div>
        @endif
    </div>
</div>
