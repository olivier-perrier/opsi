@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post type') }} - {{ $postType->name }}
            </h2>
            <a href="/posttypes">All</a>
        </div>
    </x-slot>

    <div class="container py-5">

        {{-- Name --}}
        <form method="POST" action="/posttypes/{{ $postType->id }}" class="mb-3">
            @method('PUT')
            @csrf
            <div class="">
                <label for="inputName" class="block font-bold">Name</label>
                <input type="text" id="inputName" class="mt-1 block w-full rounded-lg" name="name"
                    value="{{ $postType->name }}">
            </div>
            <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg">Save</button>
        </form>


        Fields
        <table class="min-w-full divide-y divide-gray-200">

            <thead class="uppercase text-gray-500 bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">Id</th>
                    <th scope="col" class="px-6 py-3 text-left">Name</th>
                    <th scope="col" class="px-6 py-3 text-left">Type</th>
                    <th scope="col" class="px-6 py-3 text-left">Order</th>
                    <th scope="col" class="px-6 py-3 text-left"></th> {{-- Show --}}
                    <th scope="col" class="px-6 py-3 text-left"></th> {{-- Delete --}}

                </tr>
            </thead>
            <tbody class="bg-white divide-y">

                @foreach ($postType->fields as $field)

                    <tr class="hover:bg-gray-50">

                        <td scope="row" class="px-6 py-4">
                            <a href="/fields/{{ $field->id }}/edit"
                                class="block text-blue-500">{{ $field->id }}</a>
                        </td>

                        <td class="px-6 py-4">{{ $field->name }}</td>

                        <td class="px-6 py-4">{{ $field->type }}</td>

                        <td class="px-6 py-4">{{ $field->order }}</td>

                        {{-- Delete --}}
                        <td class="text-right px-2 py-4">
                            <form action="/fields/{{ $field->id }}" method="post" id="formDelete">
                                @csrf
                                @method('DELETE')
                                <button class="btn-link text-red-400 text-decoration-none" type="submit">Delete</button>
                            </form>
                        </td>
                        <td class="text-right pr-5 py-4">
                            <a href="/fields/{{ $field->id }}/edit"
                                class="font-bold text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

        


        {{-- New --}}
        <label for="fields" class="mt-2 col-form-label">New</label>
        <form method="POST" action="/fields?posttype={{ $postType->id }}" class="row">
            @method('POST')
            @csrf
            <div class="grid grid-cols-5 gap-4">

                <div class="">
                    {{-- <label for="name" class="visually-hidden">Name</label> --}}
                    <input type="text" name="name" class="w-full rounded-lg" id="name" placeholder="Name"
                        value="{{ @old('name') }}">
                </div>
                <div class="">
                    {{-- <label for="type" class="visually-hidden">Type</label> --}}
                    <select name="type" id="type" class="w-full rounded-lg">
                        <option value="Data" {{ @old('type') == 'Data' ? 'selected' : '' }}>Data</option>
                        <option value="Relationship" {{ @old('type') == 'Relationship' ? 'selected' : '' }}>Relationship
                        </option>
                    </select>
                </div>
                <div class="">
                    {{-- <label for="order" class="visually-hidden">Order</label> --}}
                    <input type="number" name="order" class="w-full rounded-lg" min=0 id="order" placeholder="Order"
                        value="{{ @old('order') || 1 }}">
                </div>
                <div class="my-auto">
                    <button type="submit" class="px-4 py-2 block text-white bg-blue-500 rounded-lg">Add</button>
                </div>
            </div>

        </form>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>


@endComponent
