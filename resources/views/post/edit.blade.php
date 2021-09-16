@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $post->posttype->name }} - {{ $post->name }}
            </h2>
            <div>
                <a href="/posts">All {{ $post->posttype->name }}s</a> - <a href="/posts/{{ $post->id }}">View</a>
            </div>
        </div>
    </x-slot>

    <div class="container py-5">

        <form action="/posts/{{ $post->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-6">
                <label for="name" class="block mb-1">Name</label>
                <input type="text" id="name" class="block w-full border-gray-300 rounded" name="name"
                    value="{{ $post->name }}">
            </div>

            {{-- Parent --}}
            <div class="mb-6">
                <label for="name" class="block mb-1">Parent</label>

                <select name="parent_id" id="parent_id"
                    class="block w-full rounded" value={{ $post->parent_id }}>
                    <option value="" selected></option>
                    @foreach ($posts as $cur_post)
                        <option value="{{ $cur_post->id }}"
                            {{ $cur_post->id == $post->parent_id ? 'selected' : '' }}>
                            {{ $cur_post->postType->name }} - {{ $cur_post->name }}
                        </option>
                    @endforeach
                </select>
               
            </div>

            {{-- New custom --}}

            @foreach ($post->datas as $data)
                <div class="mb-3">

                    {{-- Print label --}}
                    <label for="input{{ $data->field->name }}" class="block mb-1">
                        {{ $data->field->name }}
                    </label>

                    @if ($data->field->type == 'Data')
                        <input type="text" id="input{{ $data->field->name }}" class="block w-full border-gray-300 rounded"
                            name="datas[{{ $data->id }}]" value="{{ $data->value }}">

                    @elseif ($data->field->type == 'Relationship')
                        <select name="datas[{{ $data->id }}]" id="input{{ $data->field->name }}"
                            class="block w-full rounded" value={{ $data->value }}>
                            <option value="" selected></option>
                            @foreach ($posts as $cur_post)
                                <option value="{{ $cur_post->id }}"
                                    {{ $cur_post->id == $data->relationship_id ? 'selected' : '' }}>
                                    {{ $cur_post->postType->name }} - {{ $cur_post->name }}
                                </option>
                            @endforeach
                        </select>

                    @elseif($data->field->type == 'Textarea')
                        <textarea name="datas[{{ $data->id }}]" id="input{{ $data->field->name }}"
                            class="w-full" cols="30" rows="10">{{ $data->value }} </textarea>


                    @elseif($data->field->type == 'Number')
                        <input type="number" id="input{{ $data->field->name }}"
                            class="block w-full border-gray-300 rounded" name="datas[{{ $data->id }}]"
                            value="{{ $data->value }}">

                    @endif

                </div>
                
                
                @endforeach
                
                
                <button type="submit"
                class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Submit</button>
                
            </form>
            
            {{-- Relationships --}}
            @if (count($post->relationships))
            <div class="mt-3">
                <label>Relationships</label>
                <ul>
                    @foreach ($post->relationships as $relationship)
                        <li>
                            <a href="/posts/{{ $relationship->post->id }}/edit" class="mx-2 text-blue-500">
                                {{ $relationship->post->postType->name }} -
                                {{ $relationship->post->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Id and Delete --}}
        <div class="flex justify-between mt-5">

            <div>
                <span class="text-gray-500">
                    Id {{ $post->id }}
                </span>
            </div>

            <div class="text-right">
                <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-400" type="submit" form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
