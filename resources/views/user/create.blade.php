@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a User
            </h2>


        </div>
    </x-slot>

    <div class="container py-5">

        <form method="POST" action="/users">
            @csrf

            <div class="mb-3">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ @old('name') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="block font-medium">Email</label>
                <input type="text" name="email" class="mt-1 block w-full rounded-lg" value="{{ @old('email') }}">
            </div>

            <div class="mb-3">
                <label for="password" class="block font-medium">Password</label>
                <input type="password" name="password" class="mt-1 block w-full rounded-lg" value="{{ @old('password') }}">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="block font-medium">Password conformation</label>
                <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-lg"
                    value="{{ @old('password_confirmation') }}">
            </div>

            <button type="submit"
                class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Submit</button>
        </form>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>

@endcomponent()
