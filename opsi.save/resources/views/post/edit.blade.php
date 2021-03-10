@component('layouts.app')


    <p>
        <a href="/posts">All {{ $post->posttype->name }}s</a> -
        <a href="/posts/{{ $post->id }}">View</a>
    </p>

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

    <form action="/posts/{{ $post->id }}" method="post">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label for="inputName" class="col-form-label">Name</label>
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

    @foreach ($post->datas as $data)


        <form action="/datas/{{ $data->id }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-3">

                <label for="name" class="form-label">{{ $data->field->name }}</label>

                @if ($data->field->type == 'Relationship')

                    <select name="relationship_id" id="relationship_id" class="form-select"
                        value="{{ $data->relationship_id }}">
                        <option value="" selected></option>
                        @foreach ($posts as $post)
                            <option value="{{ $post->id }}" {{ $post->id == $data->relationship_id ? 'selected' : '' }}>
                                {{ $post->postType->name }} - {{ $post->name }}
                            </option>
                        @endforeach
                    </select>

                @elseif($data->field->type == 'Textarea')
                    <textarea name="value" id="value" class="form-control" cols="30" rows="10">{{ $data->value }}</textarea>

                @elseif($data->field->type == 'Text')
                    <input type="text" class="form-control" name="value" value="{{ $data->value }}">

                @elseif($data->field->type == 'Link')
                    <label for="url" class="form-label">Url</label>
                    <input type="text" class="form-control" name="value_json[url]"
                        value="@isset($data->value_json['url']){{ $data->value_json['url'] }}@endisset">

                    <label for="displayName" class="form-label">Display name</label>
                    <input type="text" class="form-control" name="value_json[displayName]"
                        value="@isset($data->value_json['displayName']){{ $data->value_json['displayName'] }}@endisset">

                @else
                    <input type="text" class="form-control" name="value" value="{{ $data->value }}">
                @endif

            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    @endforeach




    {{-- Childrens --}}
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



@endcomponent()
