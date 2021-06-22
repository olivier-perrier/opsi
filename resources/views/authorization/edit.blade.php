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


        <form action="/authorizations/{{ $authorization->id }}" method="post" class="">
            @csrf
            @method('PUT')

            <div class="">
                <label for="name" class="my-1 block">Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg" value="{{ $authorization->name }}">
            </div>

            <div class="mt-5">
                <h1 class="my-3 text-xl">Post types</h1>

                <table class="table-auto min-w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="mx-6 text-left">Post Type name</th>
                            <th scope="col" class="mx-6 text-left">Read</th>
                            <th scope="col" class="mx-6 text-left">Write</th>
                            <th scope="col" class="mx-6 text-left">Owned</th>
                            <th scope="col" class="mx-6 text-left">All</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">

                        @foreach ($authorization->authorizationPosttypes as $authPosttype)

                            <tr>
                                <td class="py-2">
                                    {{ $authPosttype->postType->name }}
                                </td>
                                <td>
                                    <input name="check[{{ $authPosttype->id }}][read]" type="checkbox"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                        {{ $authPosttype->read ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input name="check[{{ $authPosttype->id }}][write]" type="checkbox"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                        {{ $authPosttype->write ? 'checked' : '' }}>
                                <td>
                                    <input name="check[{{ $authPosttype->id }}][own]" type="checkbox"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                        {{ $authPosttype->own ? 'checked' : '' }}>
                                <td> <input name="check[{{ $authPosttype->id }}][all]" type="checkbox"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                        {{ $authPosttype->all ? 'checked' : '' }}></td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="mt-5">
                <h1 class="my-3 text-xl">Specific</h1>
                <div class="mt-2">
                    <label for="posttypes" class="my-2 font-bold">Manage Post types</label>
                    <input type="checkbox" name="edit-posttypes" id="edit-posttypes" class="m-2 rounded"
                    {{ $authorization->edit_post_types ? 'checked' : '' }}>
                </div>
                <div class="mt-2">
                    <label for="users" class="my-2 font-bold">Manage users</label>
                    <input type="checkbox" name="edit-users" id="edit-authorizations" class="m-2 rounded"
                    {{ $authorization->edit_users ? 'checked' : '' }}>
                </div>
                <div class="mt-2">
                    <label for="authorizations" class="my-2 font-bold">Manage authorizations</label>
                    <input type="checkbox" name="edit-authorizations" id="edit-authorizations" class="m-2 rounded"
                    {{ $authorization->edit_authorizations ? 'checked' : '' }}>
                </div>

            </div>

            <div class="mt-5 d-flex">
                <button type="submit"
                    class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Save</button>
                <div class="ml-2 text-gray-500">
                    {{ session('status') }}
                </div>
            </div>

        </form>



        {{-- Id and Delete --}}
        <div class="mt-3 flex justify-between mt-5">

            <div>
                <span class="text-gray-500">
                    Id {{ $authorization->id }}
                </span>
            </div>

            <div class="text-right">
                <form action="/authorizations/{{ $authorization->id }}" method="post" id="formDelete">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400" type="submit" form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
