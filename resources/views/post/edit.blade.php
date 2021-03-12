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

        {{-- Id --}}
        <form>
            <div class="row">
                <div class="col-auto">
                    <label for="inputId" class="col-form-label">Id</label>
                </div>
                <div class="col-auto">
                    <input type="text" id="inputId" class="form-control" value="{{ $post->id }}" disabled>
                </div>
            </div>
        </form>

        <form action="/posts/{{ $post->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label for="inputName" class="col-form-label d-inline-flex">Name</label>
                <input type="text" id="inputName" class="form-control" name="name" value="{{ $post->name }}">
            </div>

            {{-- Parent --}}
            <div class="mb-3">
                <label for="parent" class="col-form-label">Parent</label>
                <select class="form-select" name="parent_id" id="parent_id">
                    <option value="" selected></option>
                    @foreach ($posts as $_post)
                        <option value="{{ $_post->id }}"
                            {{ $post->parent && $post->parent->id == $_post->id ? 'selected' : '' }}>
                            {{ $_post->posttype->name }} - {{ $_post->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        Fields
        <form action="/posts/{{ $post->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            @foreach ($post->posttype->fields as $field)

                <div class="mb-3">

                    {{-- Print label --}}
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


            @endforeach

            <button type="submit" class="btn btn-primary">Submit</button>

        </form>



        {{-- Childrens --}}
        @if (!$post->children->isEmpty())
            <div>
                <label for="parent" class="col-form-label">Children</label>
                <ul>
                    @foreach ($post->children as $child)
                        <li>
                            <a href="/posts/{{ $child->id }}">
                                {{ $child->posttype->name }} - {{ $child->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="text-right">
            <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                @csrf
                @method('DELETE')
                <button class="btn btn-link link-danger text-decoration-none" type="submit"
                    form="formDelete">Delete</button>
            </form>
        </div>

    </div>



@endcomponent()
