<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="/books">
        @csrf

        <!-- Title -->
            <div>
                <x-label for="title" :value="__('Title')" />

                <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" />
            </div>

            <!-- Author -->
            <div class="mt-4">
                <x-label for="author" :value="__('Author')" />

                <x-input id="author" class="block mt-1 w-full" type="text" name="author" :value="old('author')" />
            </div>

            <!-- Release Date -->
            <div class="mt-4">
                <x-label for="released_at" :value="__('Released Date')" />

                <x-input id="released_at" class="block mt-1 w-full" type="text" name="released_at" :value="old('released_at')" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Add Book') }}
                </x-button>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('dashboard') }}">
                    {{ __("Return to dashboard") }}
                </a>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
