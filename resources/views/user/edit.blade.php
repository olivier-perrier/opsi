@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User') }}
            </h2>
            <a href="/user/create">Create</a>
        </div>
    </x-slot>

    <div class="container py-6">

        <form action="/users/{{ $user->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="email" class="block">Email</label>
                <label for="email" class="block">{{ $user->email }}</label>
            </div>

            <div class="mb-3">
                <label for="name" class="block">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ $user->name }}">
            </div>

            <div class="mb-3">
                <label for="posttypes" class="block">Authorization</label>

                <select name="authorization" id="authorization" class="my-2 px-4 min-w-full rounded-md shadow-md">
                    <option value=""></option>
                    @foreach ($authorizations as $authorization)
                        <option value="{{ $authorization->id }}"
                            {{ $authorization->id == $user->authorization_id ? 'selected' : '' }}>
                            {{ $authorization->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <button type="submit" class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Save</button>

        </form>



        {{-- Id and Delete --}}
        <div class="flex justify-between mt-5">

            <div>
                <span class="text-gray-500">
                    Id {{ $user->id }}
                </span>
            </div>

            <div class="text-right">
                <form action="/user/{{ $user->id }}" method="post" id="formDelete">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400" type="submit" form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
