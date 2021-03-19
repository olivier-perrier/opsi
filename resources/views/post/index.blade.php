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
                    @empty($posttype)
                        <th scope="col">Type</th>
                    @endempty
                    @isset($posttype)
                        @foreach ($posttype->fields as $field)
                            <th scope="col">{{ $field->name }}</th>
                        @endforeach
                    @endisset
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="bg-white">

                @foreach ($posts as $post)

                    <tr>
                        <th scope="row">
                            <a href="/posts/{{ $post->id }}/edit">{{ $post->id }}</a>
                        </th>
                        <td>
                            <a href="/posts/{{ $post->id }}/edit">
                                @if ($post->getDataForFieldName('Name'))
                                    {{ $post->getDataForFieldName('Name')->value }}
                                @endif
                            </a>
                        </td>
                        {{-- Type --}}
                        {{-- Only shown if we are in the all post view with no predined posttype --}}
                        @empty($posttype)
                            <td>{{ $post->postType->name }}</td>
                        @endempty

                        {{-- Custom fields --}}
                        {{-- Only shown if we are watching a specific type of post --}}
                        @isset($posttype)
                            @foreach ($post->datas as $data)
                                <td>
                                    @if ($data->field->type == 'Relationship')
                                        r*
                                        @isset($data->relationship)
                                            <a href="/posts/{{ $data->relationship_id }}/edit">
                                                @if ($data->relationship->getDataForFieldName('Name'))
                                                    {{ $data->relationship->getDataForFieldName('Name')->value }}
                                                @endif
                                            </a>
                                        @endisset
                                    @else
                                        {{ $data->value }}
                                    @endif
                                </td>
                            @endforeach

                        @endisset
                        {{-- Delete --}}
                        <td class="text-right px-5">
                            <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-link link-danger text-decoration-none" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>

    </div>

</x-app-layout>
