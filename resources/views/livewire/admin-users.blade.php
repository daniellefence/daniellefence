<div>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="border-r border-gray-200 text-center py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Id</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Title</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Latest activity</th>
            <th scope="col" class="border-r border-gray-200 text-center px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Actions</th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        @foreach($users as $user)
            <x-model.user :user="$user"></x-model.user>
        @endforeach
        <!-- More people... -->
        </tbody>
    </table>
</div>



