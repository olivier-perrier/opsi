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

        {{-- Fields --}}
        <div class="mt-2">

            <label for="fields" class="block font-bold">Fields</label>
            <ul class="list-group mb-3">
                <li>

                    <div class="grid grid-cols-5 gap-4">

                        <div class="">
                            <label for="name" class="block text-left">Name</label>
                        </div>
                        <div class="">
                            <label for="type" class="block text-left">Type</label>
                        </div>
                        <div class="">
                            <label for="order" class="block text-left">Order</label>
                        </div>
                        <div class="mx-auto mt-auto">
                            <label for="order" class="block text-left"></label>
                        </div>
                        <div class="mx-auto mt-auto">
                            <label for="order" class="block text-left"></label>
                        </div>

                    </div>


                </li>
                @foreach ($postType->fields as $field)


                    <li>

                        <div class="grid grid-cols-5 gap-4">


                            <div class="col-span-4">

                                <form method="POST" action="/fields/{{ $field->id }}" class="mb-3">
                                    @method('PUT')
                                    @csrf

                                    <div class="grid grid-cols-4 gap-4">

                                        <div class="">
                                            {{-- <label for="name" class="block font-bold">Name</label> --}}
                                            <input type="text" name="name" class="block w-full rounded-lg"
                                                value="{{ $field->name }}">
                                        </div>
                                        <div class="">
                                            {{-- <label for="type" class="block font-bold">Type</label> --}}
                                            <input type="text" name="type" class="block w-full rounded-lg"
                                                value="{{ $field->type }}">
                                        </div>
                                        <div class="">
                                            {{-- <label for="order" class="block font-bold">Order</label> --}}
                                            <input type="number" name="order" min=0 class="block w-full rounded-lg"
                                                value="{{ $field->order }}">
                                        </div>
                                        <div class="mt-auto">
                                            <button type="submit"
                                                class="px-4 py-2 block text-white bg-green-500 rounded-lg">Save</button>
                                        </div>

                                    </div>
                                </form>

                            </div>


                            <div class="my-auto col-span-1">
                                <form action="/fields/{{ $field->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400">Delete</button>
                                </form>
                            </div>

                        </div>


                    </li>

                @endforeach

            </ul>

        </div>


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
                            <option value="Number" {{ @old('type') == 'Number' ? 'selected' :'' }}>Number</option>
                            <option value="Relationship" {{ @old('type') == 'Relationship' ? 'selected' : '' }}>Relationship</option>
                            <option value="Relationship_Field" {{ @old('type') == 'Relationship_Field' ? 'selected' : '' }}>Relationship_Field</option>
                            <option value="Text" {{ @old('type') == 'Text' ? 'selected' :'' }}>Text</option>
                            <option value="Textarea" {{ @old('type') == 'Textarea' ? 'selected' : '' }}>Textarea</option>
                        </select>
                </div>
                <div class="">
                    {{-- <label for="order" class="visually-hidden">Order</label> --}}
                    <input type="number" name="order" class="w-full rounded-lg" min=0 id="order" placeholder="Order"
                        value="{{ @old('order') }}">
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
