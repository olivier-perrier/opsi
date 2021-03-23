@component('layouts.app')


    @isset($posttype)
        {{ $posttype->name }} - <a href="/posts/create?posttypeId={{ $posttype->id }}">Create</a>
    @endisset

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Content</th>
                @isset($posttype)
                    @foreach ($posttype->fields as $field)
                        <th scope="col">{{ $field->name }}</th>
                    @endforeach
                @endisset
                <th scope="col">Parent</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($posts as $post)

                <tr>
                    <th scope="row">
                        <a href="/posts/{{ $post->id }}">{{ $post->id }}</a>
                    </th>
                    <td>
                        <a href="/posts/{{ $post->id }}/edit">{{ $post->name }}</a>
                    </td>
                    <td>{{ $post->postType->name }}</td>
                    <td>{{ $post->content }}</td>
                    {{-- Custom fields --}}
                    @isset($posttype)
                        @foreach ($posttype->fields as $field)
                            <td>
                                @if ($field->type == 'Relationship')
                                    @if ($field->data($post)->relationship)
                                        <a href="/posts/{{ $post->id }}/edit">
                                            {{ $field->data($post)->relationship->name }}
                                        </a>
                                    @endif
                                @else
                                    @if ($field->data($post))
                                        {{ $field->data($post)->value }}
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    @endisset
                    <td>
                        @isset($post->parent)
                            {{ $post->parent->name }}
                        @endisset
                    </td>
                    <td>
                        <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn btn-outline-danger btn-sm" type="submit" form="formDelete">Delete</button>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>


@endcomponent()
