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

        <table class="table rounded shadow bg-light">

            <thead class="text-secondary text-uppercase">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($postTypes as $posttype)
                    <tr>

                        <th scope="row">
                            <a href="/posttypes/{{ $posttype->id }}">{{ $posttype->id }}</a>
                        </th>
                        <td>
                            <a href="/posttypes/{{ $posttype->id }}">{{ $posttype->name }}</a>
                        </td>
                        <td>
                            <form action="/posttypes/{{ $posttype->id }}/edit" method="post" id="formDelete" class="text-right">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link link-danger text-decoration-none" type="submit"
                                    form="formDelete">Delete</button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>


        <form action="/posttypes" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Create new</label>
                <input type="text" class="form-control" name="name" value="{{ @old('name') }}">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>


@endcomponent
