<div>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="border-r border-gray-200 text-center py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Id</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Guard Name</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Users Count</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        @forelse($roles as $role)
            <tr class="hover:bg-gray-50">
                <td class="border-r border-gray-200 text-center whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                    {{ $role->id }}
                </td>
                <td class="border-r border-gray-200 text-center whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ $role->name }}
                </td>
                <td class="border-r border-gray-200 text-center whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ $role->guard_name }}
                </td>
                <td class="border-r border-gray-200 text-center whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ $role->users->count() ?? 0 }}
                </td>
                <td class="border-r border-gray-200 text-center whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    {{ $role->created_at->format('M j, Y') }}
                </td>
                <td class="border-r border-gray-200 text-center whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                    <div class="flex justify-center space-x-2">
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                        <x-delete-button :guid="$role->id" type="role"></x-delete-button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-8 text-gray-500">
                    No roles found. <a href="{{ route('admin.roles.create') }}" class="text-indigo-600 hover:text-indigo-900">Create your first role</a>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
