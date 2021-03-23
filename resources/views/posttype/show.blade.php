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
            <div class="mb-3">
                <label for="inputName" class="block font-bold">Name</label>
                <input type="text" id="inputName" class="block w-full rounded" name="name" value="{{ $postType->name }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <label for="fields" class="block font-bold">Fields</label>
        <ul class="list-group mb-3">
            @foreach ($postType->fields as $field)

                <li>

                    <div class="grid grid-cols-6 gap-4">

                        <div class="">
                            <label for="name" class="block font-bold text-left">Name</label>
                        </div>
                        <div class="">
                            <label for="type" class="block font-bold text-left">Type</label>
                        </div>
                        <div class="">
                            <label for="order" class="block font-bold text-left">Order</label>
                        </div>
                        <div class="mx-auto mt-auto">
                        </div>

                    </div>


                </li>

                <li>

                    <div class="grid grid-cols-6 gap-4">


                        <div class="col-span-5">

                            <form method="POST" action="/fields/{{ $field->id }}" class="mb-3">
                                @method('PUT')
                                @csrf

                                <div class="grid grid-cols-4 gap-4">

                                    <div class="">
                                        <label for="name" class="block font-bold">Name</label>
                                        <input type="text" name="name" class="block w-full rounded"
                                            value="{{ $field->name }}">
                                    </div>
                                    <div class="">
                                        <label for="type" class="block font-bold">Type</label>
                                        <input type="text" name="type" class="block w-full rounded"
                                            value="{{ $field->type }}">
                                    </div>
                                    <div class="">
                                        <label for="order" class="block font-bold">Order</label>
                                        <input type="number" name="order" class="block w-full rounded"
                                            value="{{ $field->order }}">
                                    </div>
                                    <div class="mx-auto mt-auto">
                                        <button type="submit"
                                            class="px-4 py-2 block text-white bg-green-500 rounded">Save</button>
                                    </div>

                                </div>
                            </form>

                        </div>


                        <div class="my-auto mx-auto col-span-1">
                            <form action="/fields/{{ $field->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </div>

                    </div>


                </li>

            @endforeach

        </ul>

        {{-- Ajouter --}}
        <label for="fields" class="col-form-label">Ajouter</label>
        <form method="POST" action="/fields?posttype={{ $postType->id }}" class="row">
            @method('POST')
            @csrf
            <div class="">
                <label for="name" class="visually-hidden">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                    value="{{ @old('name') }}">
            </div>
            <div class="">
                <label for="type" class="visually-hidden">Type</label>
                <input type="text" name="type" class="form-control" id="type" placeholder="Type"
                    value="{{ @old('type') }}">
            </div>
            <div class="">
                <label for="order" class="visually-hidden">Order</label>
                <input type="number" name="order" class="form-control" id="order" placeholder="Order"
                    value="{{ @old('order') }}">
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary mb-3">Ajouter</button>
            </div>
        </form>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>


@endComponent
