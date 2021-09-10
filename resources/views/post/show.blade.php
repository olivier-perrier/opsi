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
        <h1 class="text-xl">{{ $post->name }}</h1>

        {{-- Datas --}}
        <div class="mt-3">

            @foreach ($post->datas as $data)

                <div class="mt-3 block p-5 border rounded-lg bg-white shadow-sm">

                    @if ($data->field->type == 'Data')
                        <span class="font-bold">{{ $data->field->name }} : </span>
                        {{ $data->value }}

                    @elseif ($data->field->type == 'Relationship')
                        <span class="font-bold">{{ $data->field->name }} : </span>
                        <a href="/posts/{{ $data->post_id }}" class="text-blue-500 underline">
                            @if ($data->post)
                                {{ $data->post->name }}
                            @endif
                        </a>


                    @endif


                </div>

            @endforeach

        </div>

        {{-- Relationships --}}
        @if (count($post->relationships))
            <div class="mt-3">
                <label>Relationships</label>
                <ul>
                    @foreach ($post->relationships as $relationship)
                        <li>
                            <a href="/posts/{{ $relationship->post->id }}" class="mx-2 text-blue-500">
                                {{ $relationship->post->postType->name }} -
                                {{ $relationship->post->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif




        <div class="mt-3 flex justify-between">
            <div></div>
            <a href="/posts/{{ $post->id }}/edit" class="text-gray-500">Edit</a>
        </div>

    </div>

@endcomponent()
