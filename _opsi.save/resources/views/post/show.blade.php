@component('layouts.app')


    <p>
        <a href="/posts">All {{ $post->posttype->name }}s</a>
    </p>

    <p>
        {{ $post->name }} - <a href="/posts/{{ $post->id }}/edit">Edit</a>
    </p>

    <section>
        <h1>{{ $post->name }}</h1>

        @foreach ($post->posttype->fields as $field)

            <div>
                @if($field->data($post))
                    {{ $field->data($post)->value }}
                @endif
            </div>

        @endforeach

    </section>

@endcomponent()
