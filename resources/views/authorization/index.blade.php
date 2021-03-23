<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Authorizations') }}
            </h2>
            <a href="/authorizations/create">Create</a>
        </div>
    </x-slot>


    <div class="container">

        @foreach ($authorizations as $authorization)

            {{ $authorization }}

        @endforeach
    </div>

</x-app-layout>
