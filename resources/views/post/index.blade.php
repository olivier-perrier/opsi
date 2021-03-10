<x-app-layout>

    <x-slot name="header">
        <div class="d-flex justify-content-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @isset($posttype)
                    {{ $posttype->name }}s
                @else
                    {{ __('Posts') }}
                @endisset
            </h2>
            @isset($posttype)
                <a href="/posts/create?posttypeId={{ $posttype->id }}">Create</a>
            @endisset
        </div>
    </x-slot>



    <div class="container py-5">

        <table class="table rounded shadow bg-light">

            <thead class="text-secondary text-uppercase">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col py-3">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">Content</th>
                    @isset($posttype)
                        @foreach ($posttype->fields as $field)
                            <th scope="col">{{ $field->name }}</th>
                        @endforeach
                    @endisset
                    <th scope="col">Parent</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="bg-white">

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
                                        @if ($field->data($post))
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
                        {{-- Delete --}}
                        <td class="text-right px-5">
                            <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link link-danger text-decoration-none" type="submit"
                                    form="formDelete">Delete</button>
                            </form>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</x-app-layout>
