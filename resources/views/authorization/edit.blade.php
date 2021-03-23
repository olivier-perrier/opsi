@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Authorizations') }}
            </h2>
            <a href="/authorizations/create">Create</a>
        </div>
    </x-slot>

    <div class="container py-6">

        @foreach ($authorization->posttypes() as $pt)
            {{ $pt }}
        @endforeach

        {{-- {{ $authorization->posttypes() }} --}}

        <form action="/authorizations/{{ $authorization->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="block">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ $authorization->name }}">
            </div>

            <div class="mb-3">
                <label for="posttypes" class="block">Post types</label>

                @foreach ($posttypes as $posttype)

                    <div class="my-2 p-4 max-w-xs bg-white rounded-xl shadow-md">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="posttypes[{{ $posttype->id }}]" value="1"
                                class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-lg">
                            <span class="">{{ $posttype->name }}</span>
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="mb-3">
                <label for="users" class="block">Name</label>
                <input type="text" name="users" class="mt-1 block w-full rounded-lg" value="{{ @old('name') }}">
            </div>

            <button type="submit" class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Save</button>

        </form>



        {{-- Id and Delete --}}
        <div class="flex justify-between mt-5">

            <div>
                <span class="text-gray-500">
                    Id {{ $authorization->id }}
                </span>
            </div>

            <div class="text-right">
                <form action="/authorizations/{{ $authorization->id }}" method="post" id="formDelete">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500" type="submit" form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
