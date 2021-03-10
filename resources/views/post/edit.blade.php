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

            {{-- Content --}}
            <div class="mb-3">
                <label for="inputContent" class="col-form-label">Content</label>
                <textarea name="content" id="inputContent" class="form-control" rows="10">{{ $post->content }}</textarea>
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

        {{-- Fields --}}
        Fields
        @foreach ($post->posttype->fields as $field)
            @if ($field->data($post))
                <form action="/datas/{{ $field->data($post)->id }}" method="post" class="mb-3">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label for="name" class="form-label">{{ $field->name }}</label>

                        @if ($field->type == 'Relationship')

                            <select name="relationship_id" id="relationship_id" class="form-select"
                                value="{{ $field->data($post) }}">
                                <option value="" selected></option>
                                @foreach ($posts as $cur_post)
                                    <option value="{{ $cur_post->id }}"
                                        {{ $cur_post->id == $field->data($post)->relationship_id ? 'selected' : '' }}>
                                        {{ $cur_post->postType->name }} - {{ $cur_post->name }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($field->type == 'Textarea')
                            <textarea name="value" id="value" class="form-control" cols="30"
                                rows="10">{{ $field->data($post) }}</textarea>

                        @elseif($field->type == 'Text')
                            <input type="text" class="form-control" name="value"
                                value="{{ $field->data($post)->value }}">


                        @else
                            <input type="text" class="form-control" name="value"
                                value="{{ $field->data($post)->value }}">
                        @endif

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            @else
                <form action="/datas" method="post" class="mb-3">
                    @csrf
                    <label for="name" class="form-label">{{ $field->name }}</label>
                    <input type="text" class="visually-hidden" name="post_id" value="{{ $post->id }}">
                    <input type="text" class="visually-hidden" name="field_id" value="{{ $field->id }}">
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            @endif

        @endforeach



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
