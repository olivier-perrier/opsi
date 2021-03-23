@component('layouts.app')

    <p>
        Create Post - <a href="/posts">All posts</a>
    </p>

    <form method="POST" action="/posts?posttypeId={{ $posttypeId }}">
        @csrf
        <label for="posttype">Post type</label>

        <select name="post_type" id="post_type">
            @foreach ($posttypes as $posttype)
                <option value="{{ $posttype->id }}" {{ $posttype->id == $posttypeId ? 'selected' : '' }}>
                    {{ $posttype->name }}
                </option>
            @endforeach
        </select>

        <label for="name">Name</label>
        <input type="text" name="name" value="{{ @old('name') }}">

        <button type="submit">Submit</button>
    </form>

@endcomponent()
