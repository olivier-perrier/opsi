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

                    @if ($data->field->type == 'Relationship')
                        <span class="font-bold">{{ $data->field->name }} : </span>
                        <a href="/posts/{{ $data->dataRelationship->post_id }}" class="text-blue-500 underline">
                            @if ($data->dataRelationship->post)
                                {{ $data->dataRelationship->post->name }}
                            @endif
                        </a>
                    @elseif ($data->field->type == 'Value')
                        <span class="font-bold">{{ $data->field->name }} : </span>
                        {{ $data->dataValue->value }}

                    @elseif ($data->field->type == 'List')

                        <span class="font-bold">{{ $data->field->name }} : </span>

                        @foreach ($data->dataList->dataValues as $dataValue)
                            <span>
                                {{ $dataValue->value }}
                            </span>

                        @endforeach

                    @endif


                </div>

            @endforeach

        </div>

        {{-- Parents --}}
        @if (count($post->relationships))
            <div class="mt-3">
                <label>Parents</label>
                <ul>
                    @foreach ($post->relationships as $relationship)
                        <li>
                            <a href="/posts/{{$relationship->data->post->id}}" class="mx-2 text-blue-500">
                                {{ $relationship->data->post->postType->name }} - 
                                {{ $relationship->data->post->name }}
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
