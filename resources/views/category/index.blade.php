<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-100 leading-tight">
            {{ __('Todo Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- CREATE BUTTON & FLASH MESSAGE -->
                <div class="p-6 text-xl text-gray-700 dark:text-gray-100">
                    <div class="flex items-center justify-between">
                        <x-create-button href="{{ route('category.create') }}" />

                        <div class="text-sm">
                            @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                   x-init="setTimeout(() => show = false, 5000)"
                                   class="text-green-500 dark:text-green-300">
                                    {{ session('success') }}
                                </p>
                            @endif

                            @if (session('danger'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                   x-init="setTimeout(() => show = false, 5000)"
                                   class="text-red-500 dark:text-red-300">
                                    {{ session('danger') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- CATEGORY TABLE -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead class="text-sm text-gray-600 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3 w-1/4 text-center">Todo</th>
                                <th scope="col" class="px-6 py-3 w-1/4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <!-- TITLE -->                                    
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                                        <a href="{{ route('category.edit', $category->id) }}"
                                           class="text-decoration-none text-blue-500 hover:text-blue-400">
                                            {{ $category->title }}
                                        </a>
                                    </td>

                                    <!-- TODO COUNT -->
                                    <td class="px-6 py-4">
                                        {{ $category->todos->count() }}
                                    </td>

                                    <!-- ACTION -->
                                    <td class="px-6 py-4">                                    

                                            <form action="{{ route('category.destroy', $category) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:underline text-sm font-medium"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
