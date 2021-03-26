@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a {{ $posttype->name }}
            </h2>
            <a href="/posts">
                All {{ $posttype->name }}s
            </a>

        </div>
    </x-slot>

    <div class="container py-5">

        <form method="POST" action="/posts?posttypeId={{ $posttypeId }}">
            @csrf

            <div class="mb-3">
                <label for="posttype" class="block font-medium">Post type</label>

                <select name="posttype" id="posttype" class="mt-1 block w-full rounded-lg">
                    @foreach ($posttypes as $posttype)
                        <option value="{{ $posttype->id }}" {{ $posttype->id == $posttypeId ? 'selected' : '' }}>
                            {{ $posttype->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ @old('name') }}">
                @error('name')
                    <p class="my-2 text-sm text-gray-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            <button type="submit"
                class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Submit</button>
        </form>

    </div>

@endcomponent()
