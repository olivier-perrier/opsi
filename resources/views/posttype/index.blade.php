@component('layouts.app')


    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post types') }}
            </h2>
            <a href="/posttypes/create">Create</a>
        </div>
    </x-slot>


    <div class="container py-5">

        <div class="mb-6 shadow overflow-hidden rounded-lg">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="uppercase text-gray-500 bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3 px-6 text-left">Id</th>
                        <th scope="col" class="py-3 px-6 text-left">Name</th>
                        <th scope="col" class="py-3 px-6 text-left"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">

                    @foreach ($postTypes as $posttype)
                        <tr>

                            <td scope="row" class="py-4 px-6">
                                <a href="/posttypes/{{ $posttype->id }}/edit">{{ $posttype->id }}</a>
                            </td>
                            <td class="py-4 px-6">
                                <a href="/posttypes/{{ $posttype->id }}/edit" class="text-blue-500">{{ $posttype->name }}</a>
                            </td>
                            <td class="py-4 px-6">
                                <form action="/posttypes/{{ $posttype->id }}" method="post" id="formDelete"
                                    class="text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500" type="submit">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        @if (session('message'))
            <div class="p-5 bg-yellow-200 text-yellow-800 rounded-lg">
                {{ session('message') }}
            </div>
        @endif


        <form action="/posttypes" method="post" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="name" class="block mb-1">Create new</label>
                <input type="text" class="block w-full rounded" name="name" placeholder="Name" value="{{ @old('name') }}">
            </div>
            <div class="block text-right">
                <button type="submit"
                    class="py-2 px-4 shadow-sm text-white font-medium bg-indigo-500 rounded-lg">Create</button>
            </div>
        </form>
    </div>


@endcomponent
