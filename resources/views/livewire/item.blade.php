<div>
    <a href="{{$item->getRoute()}}" class="group flex flex-col text-sm gap-y-8">
        @php
            // Get image URL based on item type
            $imageUrl = null;

            // For Categories, ONLY use hero_image field (not photo fallback)
            if ($item instanceof App\Models\Category) {
                if ($item->hero_image) {
                    $imageUrl = asset('storage/' . $item->hero_image);
                }
            }
            // For Products, use first photo
            elseif (method_exists($item, 'photos') && $item->photos()->count() > 0) {
                $imageUrl = asset('storage/' . $item->photos()->orderBy('order','asc')->first()->path);
            }
        @endphp

        @if($imageUrl)
            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                <img src="{{$imageUrl}}" alt="{{$item->title}}" class="h-full w-full object-cover object-center">
            </div>
        @endif
        <h3 class="mt-8 font-medium text-center text-gray-900">{{$item->title}}</h3>
    </a>
</div>

