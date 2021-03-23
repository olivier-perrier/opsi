@component('layouts.app')

    <x-slot name="header">
        <div class="d-flex justify-content-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Authorizations') }}
            </h2>
            <a href="/authorizations/create">Create</a>
        </div>
    </x-slot>

    <div class="container py-5">

        <form method="POST" action="/authorizations">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ @old('name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

@endcomponent()
