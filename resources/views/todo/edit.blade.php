<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Todo edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Flash messages --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('danger'))
                        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                            {{ session('danger') }}
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">{{ __('Edit Todo Page') }}</h3>

                    <form method="POST" action="{{ route('todo.update', $todo) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                :value="old('name', $todo->title)" required autofocus autocomplete="title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('todo.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
