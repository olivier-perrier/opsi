<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>

            <a href="/users/create">Create</a>


        </div>
    </x-slot>

    {{-- <x-slot name="menuSidebar2">
        <x-sidebar>
            {{ $menuSidebar2 }}
        </x-sidebar>
    </x-slot> --}}



    <div class="container py-6">

        <div class="mb-3">
            Me 
            <a href="/users/{{ Auth::id() }}/edit" class="text-blue-500 underline">{{  Auth::user()->name }}</a> <br>
        </div>


        @foreach ($users as $user)

            <a href="/users/{{ $user->id }}/edit" class="text-blue-500 underline">{{ $user->name }}</a> <br>

        @endforeach

    </div>

</x-app-layout>
