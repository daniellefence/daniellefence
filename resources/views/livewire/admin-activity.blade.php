<x-admin-card title="Recent Activity" subtitle="Latest system activity and user actions">
    <x-slot name="actions">
        <x-button.secondary size="small">
            <x-icon.activity class="w-4 h-4 mr-2" />
            Export
        </x-button.secondary>
    </x-slot>

    <x-admin-table :headers="['Timestamp', 'User', 'Action', 'Model ID', 'Model Class']" :padding="false">
        @foreach($activities as $activity)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="font-medium">{{ $activity->created_at->format('m/d/Y') }}</div>
                    <div class="text-gray-500">{{ $activity->created_at->format('h:i:s a') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8">
                            <img class="h-8 w-8 rounded-full" src="{{ $activity->user->profile_photo_url }}" alt="{{ $activity->user->name }}">
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">{{ $activity->user->name }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                        @if(str_contains(strtolower($activity->action), 'create'))
                            bg-green-100 text-green-800
                        @elseif(str_contains(strtolower($activity->action), 'update'))
                            bg-blue-100 text-blue-800
                        @elseif(str_contains(strtolower($activity->action), 'delete'))
                            bg-red-100 text-red-800
                        @else
                            bg-gray-100 text-gray-800
                        @endif">
                        {{ $activity->action }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $activity->model_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ class_basename($activity->model_class) }}</code>
                </td>
            </tr>
        @endforeach
    </x-admin-table>

    @if($activities->hasPages())
        <x-admin-pagination :paginator="$activities" />
    @endif
</x-admin-card>
