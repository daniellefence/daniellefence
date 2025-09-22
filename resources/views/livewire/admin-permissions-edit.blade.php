<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Permission: {{ $permission->name }}</h1>
            <a href="{{ route('admin.permissions.read') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Permissions
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="update" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Permission Name</label>
                    <input type="text" wire:model="name" id="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="e.g., users.create or blog.update" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <p class="mt-1 text-sm text-gray-500">Use dot notation for grouping (e.g., users.create, blog.read)</p>
                </div>

                <div>
                    <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard Name</label>
                    <select wire:model="guard_name" id="guard_name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="web">web</option>
                        <option value="api">api</option>
                    </select>
                    @error('guard_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Permission Information --}}
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Created:</span>
                        <span class="text-gray-600">{{ $permission->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Updated:</span>
                        <span class="text-gray-600">{{ $permission->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Roles with this permission:</span>
                        <span class="text-gray-600">{{ $permission->roles()->count() }}</span>
                    </div>
                </div>
            </div>

            {{-- Roles that have this permission --}}
            @if($permission->roles()->count() > 0)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Roles with this Permission</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($permission->roles as $role)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Permission Naming Guidelines --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-medium text-blue-900 mb-2">Permission Naming Guidelines</h3>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• Use lowercase letters, dots, and hyphens only</li>
                    <li>• Follow the pattern: <code class="bg-blue-100 px-1 rounded">resource.action</code> (e.g., users.create, blog.read)</li>
                    <li>• Common actions: create, read, update, delete, publish, manage</li>
                    <li>• Be specific: <code class="bg-blue-100 px-1 rounded">blog.publish</code> instead of just <code class="bg-blue-100 px-1 rounded">publish</code></li>
                </ul>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.permissions.read') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Permission
                </button>
            </div>
        </form>
    </div>
</div>
