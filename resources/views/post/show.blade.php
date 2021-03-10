@component('layouts.app')

    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->posttype->name }} - {{ $post->name }}
            </h2>
            <a href="/posts">All {{ $post->posttype->name }}s</a>

        </div>
    </x-slot>


    <div class="container py-5">

        {{-- Name --}}
        <h1>{{ $post->name }}</h1>

        {{-- Content --}}
        <p>
            {{ $post->content }}
        </p>

        {{-- Fields --}}
        <div>
            @foreach ($post->posttype->fields as $field)

                <div>
                    @if ($field->data($post))
                        {{ $field->data($post)->value }}
                    @endif
                </div>

            @endforeach
        </div>

        {{-- Parent --}}
        @isset($post->parent)
            <div class="mb-3">
                <label>Parent</label>
                <ul>
                    <li>
                        <a href="/posts/{{ $post->parent->id }}" class="card-link">{{ $post->parent->posttype->name }} -
                            {{ $post->parent->name }}</a>
                    </li>
                </ul>
            </div>
        @endisset


        <p>
            <a href="/posts/{{ $post->id }}/edit">Edit</a>
        </p>

    </div>

@endcomponent()
