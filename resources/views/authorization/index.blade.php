<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Authorizations') }}
            </h2>
            <a href="/authorizations/create">Create</a>
        </div>
    </x-slot>


    <div class="container py-6">

        @foreach ($authorizations as $authorization)

            <a href="/authorizations/{{ $authorization->id }}/edit" class="text-blue-500 underline">
                {{ $authorization->name }}
            </a> <br>

        @endforeach
    </div>

</x-app-layout>
