<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Create New Role</h1>
            <a href="{{ route('admin.roles.read') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Roles
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

        <form wire:submit.prevent="create" class="space-y-6">
            {{-- Role Basic Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                    <input type="text" wire:model="name" id="name"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           placeholder="Enter role name" required>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

            {{-- Permissions Section --}}
            <div class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Assign Permissions</h3>
                    <div class="text-sm text-gray-500">
                        {{ $selectedCount }} of {{ $totalPermissions }} selected
                    </div>
                </div>

                {{-- Permission Search and Bulk Actions --}}
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <div class="flex-1">
                        <input type="text" wire:model.live="searchPermissions"
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Search permissions...">
                    </div>
                    <div class="flex gap-2">
                        <button type="button" wire:click="selectAllPermissions"
                                class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                            Select All Visible
                        </button>
                        <button type="button" wire:click="deselectAllPermissions"
                                class="px-4 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                            Deselect All Visible
                        </button>
                    </div>
                </div>

                {{-- Permissions Grid --}}
                <div class="space-y-6">
                    @foreach($permissionGroups as $groupName => $permissions)
                        <div class="border rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-3">{{ $groupName }} ({{ $permissions->count() }})</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach($permissions as $permission)
                                    <label class="flex items-center space-x-2 p-2 rounded hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox"
                                               wire:click="togglePermission('{{ $permission->name }}')"
                                               @if(in_array($permission->name, $selectedPermissions)) checked @endif
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.roles.read') }}"
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Role
                </button>
            </div>
        </form>
    </div>
</div>
