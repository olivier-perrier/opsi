<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }}
            </h2>

        </div>
    </x-slot>

    <x-slot name="menuSidebar2">
        <x-sidebar>
            {{ $menuSidebar2 }}
        </x-sidebar>
    </x-slot>


    <div class="container py-6">

        @foreach ($users as $user)

            <a href="/users/{{ $user->id }}/edit" class="text-blue-500 underline">{{ $user->name }}</a> <br>

        @endforeach

        {{ $menuSidebar2 }}
    </div>

</x-app-layout>
