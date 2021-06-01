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

            <div class="mt-3">
                <label for="posttypes" class="my-1 block">Post types</label>

                {{-- {{$authorization->users}} --}}
                {{-- {{$authorization->authorizationPosttypes}} --}}


                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th scope="col" class="mx-6 text-left">Post Type name</th>
                            <th scope="col" class="mx-6 text-left">Read</th>
                            <th scope="col" class="mx-6 text-left">Write</th>
                            <th scope="col" class="mx-6 text-left">Owned</th>
                            <th scope="col" class="mx-6 text-left">All</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($authorization->authorizationPosttypes as $authPosttype)

                            <tr>
                                <td>
                                    {{ $authPosttype->postType->name }}
                                </td>
                                <td>{{ $authPosttype->read }}</td>
                                <td>{{ $authPosttype->write }}</td>
                                <td>{{ $authPosttype->own }}</td>
                                <td>{{ $authPosttype->all }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

                <div class="grid md:grid-cols-3 gap-3">

                    @foreach ($posttypes as $posttype)

                        <div class="p-4 max-w-xs bg-white rounded-xl shadow-md">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="posttypes[{{ $posttype->id }}]"
                                    {{ $authorization->posttypes->contains($posttype->id) ? 'checked' : '' }}
                                    class="form-tick appearance-none h-6 w-6 border border-gray-300 rounded-lg">
                                <span class="">{{ $posttype->name }}</span>
                            </label>
                        </div>
                    @endforeach
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
