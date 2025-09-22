<tr>
    <td class="border-r border-gray-200 whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">
        {{$user->id}}
    </td>
    <td class="flex gap-2 border-r border-gray-200 whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
        <div>
            <img src="{{$user->profile_photo_url}}" alt="{{$user->name}}"/>
        </div>
        <div class="flex flex-col">
            {{$user->name}}
            @if($user->isSuperUser())
                <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">Superuser</span>
            @endif
        </div>

    </td>
    <td class="border-r border-gray-200 whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{$user->title}}</td>
    <td class="border-r border-gray-200 whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        <a href="mailto:'{{$user->email}}'">
            {{$user->email}}
        </a>
    </td>
    <td class="border-r border-gray-200 whitespace-nowrap px-3 py-4 text-sm text-gray-500">
        {{$user->latestActivity()}}
    </td>
    <td class="border-r border-gray-200 relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
        <div class="flex gap-1">
            @if(auth()->user()->canUpdateUser() && auth()->user()->id != $user->id)
                <a href="{{route('admin.user.update',['id'=>$user->id])}}">
                    <x-button size="small">
                        <x-icon.edit class="w-4 fill-white"></x-icon.edit>
                    </x-button>
                </a>
            @endif
            @if(auth()->user()->canDeleteUser() && auth()->user()->id != $user->id && !$user->isSuperUser())
                <x-delete-button type="user" :guid="$user->id"></x-delete-button>
            @endif
            @if(auth()->user()->isSuperUser() && auth()->user()->id != $user->id)
                <x-loginAs :id="$user->id"></x-loginAs>
            @endif
        </div>

    </td>
</tr>
