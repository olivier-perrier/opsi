<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">

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


        <div class="shadow overflow-hidden rounded-lg">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="uppercase text-gray-500 bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">Id</th>
                        @empty($posttype)
                            <th scope="col" class="px-6 py-3 text-left">Type</th>
                        @endempty
                        @isset($posttype)
                            @foreach ($posttype->fields as $field)
                                <th scope="col" class="px-6 py-3 text-left">{{ $field->name }}</th>
                            @endforeach
                        @endisset
                        <th scope="col" class="px-6 py-3 text-left"></th> {{-- Delete --}}
                        <th scope="col" class="px-6 py-3 text-left"></th> {{-- Show --}}

                    </tr>
                </thead>
                <tbody class="bg-white divide-y">

                    @foreach ($posts as $post)

                        <tr class="hover:bg-gray-50">
                            <td scope="row" class="px-6 py-4">
                                <a href="/posts/{{ $post->id }}/edit" class="block text-blue-500">{{ $post->id }}</a>
                            </td>

                            {{-- Type --}}
                            {{-- Only shown if we are in the all post view with no predined posttype --}}
                            @empty($posttype)
                                <td class="px-6 py-4">{{ $post->postType->name }}</td>
                            @endempty

                            {{-- Custom fields --}}
                            {{-- Only shown if we are watching a specific type of post --}}
                            @isset($posttype)
                                @foreach ($post->datas as $key => $data)
                                    <td class="px-6 py-4">
                                        @if ($data->field->type == 'Relationship')
                                            @isset($data->relatedPost)
                                                <a href="/posts/{{ $data->relationship_id }}/edit">
                                                    @if ($data->relatedPost->getDataForFieldName('Name'))
                                                        {{ $data->relatedPost->getDataForFieldName('Name')->value }}
                                                    @else
                                                        -
                                                    @endif
                                                </a>
                                            @endisset
                                        @else
                                            @if ($key == 0)
                                                <a href="/posts/{{ $post->id }}/edit" class="text-blue-500">
                                                    {{ $data->value }}
                                                </a>
                                            @else
                                                {{ $data->value }}
                                            @endif
                                        @endif
                                    </td>
                                @endforeach

                            @endisset
                            {{-- Delete --}}
                            <td class="text-right px-2 py-4">
                                <form action="/posts/{{ $post->id }}" method="post" id="formDelete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-link text-red-500 text-decoration-none"
                                        type="submit">Delete</button>
                                </form>
                            </td>
                            <td class="text-right pr-5 py-4">
                                <a href="/posts/{{ $post->id }}/edit"
                                    class="font-bold text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        
        </div>

    </div>

</x-app-layout>
