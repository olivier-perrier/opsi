@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->posttype->name }} - {{ $post->name }}
            </h2>
            <a href="/posts">All {{ $post->posttype->name }}s</a>

        </div>
    </x-slot>


    <div class="container py-5">

        {{-- Name --}}
        <h1>{{ $post->name }}</h1>

        {{-- Datas --}}
        <div class="mt-3">

            @foreach ($post->datas as $data)

                <div class="mt-3 block p-5 border rounded-lg bg-white shadow-sm">

                    @if ($data->field->type == 'Relationship')
                        <span class="font-bold">{{ $data->field->name }} : </span>
                        <a href="/posts/{{ $data->relatedPost->id }}" class="text-blue-500 underline">{{ $data->relatedPost->name }}</a>
                    @else
                    <span class="font-bold">{{ $data->field->name }} : </span>
                    {{ $data->value }}
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


        <div class="mt-3 flex justify-between">
            <div></div>
            <a href="/posts/{{ $post->id }}/edit" class="text-gray-500">Edit</a>
        </div>

    </div>

@endcomponent()
