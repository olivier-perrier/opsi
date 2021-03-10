@component('layouts.app')

    <x-slot name="header">
        <div class="d-flex justify-content-between">
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
                <label for="posttype" class="form-label">Post type</label>

                <select name="post_type" id="posttype" class="form-select">
                    @foreach ($posttypes as $posttype)
                        <option value="{{ $posttype->id }}" {{ $posttype->id == $posttypeId ? 'selected' : '' }}>
                            {{ $posttype->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ @old('name') }}">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>

@endcomponent()
