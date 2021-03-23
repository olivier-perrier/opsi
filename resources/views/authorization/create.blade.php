@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Authorizations') }}
            </h2>
            <a href="/authorizations/create">Create</a>
        </div>
    </x-slot>

    <div class="container py-5">

        <form method="POST" action="/authorizations">
            @csrf

            <div class="mb-3">
                <label for="name" class="block">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ @old('name') }}">
            </div>

            <div class="block text-right">
                <button type="submit"
                    class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Create</button>
            </div>
        </form>

    </div>

@endcomponent()
