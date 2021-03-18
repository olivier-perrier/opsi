@component('layouts.app')



    <x-slot name="header">
        <div class="d-flex justify-content-between">
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

            {{-- New custom --}}
            @foreach ($post->datas as $data)

                <div class="mb-3">

                    {{-- Print label --}}
                    <label for="input{{ $data->field->name }}" class="form-label">{{ $data->field->name }}</label>

                    @if ($data->field->type == 'Relationship')

                        <select name="datas[{{ $data->id }}]"
                            id="input{{ $data->field->name }}" class="form-select" value={{ $data->value }}>
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
                            class="form-control" cols="30" rows="10">{{ $data->value }} </textarea>

                    @elseif($data->field->type == 'Text')
                        <input type="text" id="input{{ $data->field->name }}" class="form-control"
                            name="datas[{{ $data->id }}]" value="{{ $data->value }}">

                    @else
                        {{ $data->value }}
                    @endif

                </div>


            @endforeach

            {{-- Customs --}}
            {{-- @foreach ($post->posttype->fields as $field)

                <div class="mb-3">

                    <label for="input{{ $field->name }}" class="form-label">{{ $field->name }}</label>

                    @if ($field->type == 'Relationship')

                        <select name="content[{{ $field->name }}]" id="input{{ $field->name }}" class="form-select"
                            value=@isset($post->content[$field->name]) {{ $post->content[$field->name] }} @endisset>
                            <option value="" selected></option>
                            @foreach ($posts as $cur_post)
                                <option value="{{ $cur_post->id }}" @isset($post->content[$field->name])
                                        {{ $cur_post->id == $post->content[$field->name] ? 'selected' : '' }}
                                    @endisset
                                    >
                                    {{ $cur_post->postType->name }} - {{ $cur_post->name }}
                                </option>
                            @endforeach
                        </select>

                    @elseif($field->type == 'Textarea')
                        <textarea name="content[{{ $field->name }}]" id="input{{ $field->name }}" class="form-control"
                            cols="30"
                            rows="10">@isset($post->content[$field->name]) {{ $post->content[$field->name] }} @endisset</textarea>

                    @elseif($field->type == 'Text')
                        <input type="text" id="input{{ $field->name }}" class="form-control"
                            name="content[{{ $field->name }}]" @isset($post->content[$field->name])
                        value="{{ $post->content[$field->name] }}" @endisset>

                    @else
                        @isset($post->content[$field->name])
                            {{ $post->content[$field->name] }}
                        @endisset
                    @endif

                </div>


            @endforeach --}}


            <button type="submit" class="btn btn-primary">Submit</button>

        </form>



        {{-- Childrens --}}

        @if ($post->children2())
            <div class="mb-3">
                <label for="parent" class="col-form-label">Children</label>
                <ul>
                    @foreach ($post->children2() as $child)
                        <li>
                            <a href="/posts/{{ $child->id }}">
                                {{ $child->posttype->name }} - {{ $child->name }}
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
                    <button class="btn btn-link link-danger text-decoration-none" type="submit"
                        form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
