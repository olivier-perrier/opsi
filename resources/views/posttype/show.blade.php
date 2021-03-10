@component('layouts.app')

    <x-slot name="header">
        <div class="d-flex justify-content-between">
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
                <label for="inputName" class="col-form-label">Name</label>
                <input type="text" id="inputName" class="form-control" name="name" value="{{ $postType->name }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <label for="fields" class="col-form-label">Fields</label>
        <ul class="list-group mb-3">
            @foreach ($postType->fields as $field)
                <li>
                    <div class="row">
                        <div class="col-auto">

                            <form method="POST" action="/fields/{{ $field->id }}" class="row mb-3">
                                @method('PUT')
                                @csrf
                                <div class="col-auto">
                                    <label for="name" class="visually-hidden">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $field->name }}">
                                </div>
                                <div class="col-auto">
                                    <label for="type" class="visually-hidden">Type</label>
                                    <input type="text" name="type" class="form-control" value="{{ $field->type }}">
                                </div>
                                <div class="col-auto">
                                    <label for="order" class="visually-hidden">Order</label>
                                    <input type="number" name="order" class="form-control" value="{{ $field->order }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-auto">
                            <form action="/fields/{{ $field->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link link-danger">Delete</button>
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
            <div class="col-auto">
                <label for="name" class="visually-hidden">Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                    value="{{ @old('name') }}">
            </div>
            <div class="col-auto">
                <label for="type" class="visually-hidden">Type</label>
                <input type="text" name="type" class="form-control" id="type" placeholder="Type"
                    value="{{ @old('type') }}">
            </div>
            <div class="col-auto">
                <label for="order" class="visually-hidden">Order</label>
                <input type="number" name="order" class="form-control" id="order" placeholder="Order"
                    value="{{ @old('order') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Ajouter</button>
            </div>
        </form>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>


@endComponent
