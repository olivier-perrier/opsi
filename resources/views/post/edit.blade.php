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

            {{-- New custom --}}

            @foreach ($post->datas as $data)

                <div class="mb-6">

                    {{-- Print label --}}
                    <label for="input{{ $data->field->name }}" class="block mb-1">{{ $data->field->name }}</label>

                    {{-- DEBUG --}}
                    Type : {{ $data->field->type }}

                    @if ($data->field->type == 'Relationship')

                        <select name="datas[{{ $data->id }}]" id="input{{ $data->field->name }}"
                            class="block w-full rounded" value={{ $data->value }}>
                            <option value="" selected></option>
                            @foreach ($posts as $cur_post)
                                <option value="{{ $cur_post->id }}"
                                    {{ $cur_post->id == $data->relationship_id ? 'selected' : '' }}>
                                    {{ $cur_post->postType->name }} -
                                    @if ($cur_post->getDataForFieldName('Name'))
                                        {{ $cur_post->getDataForFieldName('Name')->value }}
                                    @else
                                        <span>"No name"</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>

                    @elseif($data->field->type == 'Textarea')
                        <textarea name="datas[{{ $data->id }}]" id="input{{ $data->field->name }}" class="w-full"
                            cols="30" rows="10">{{ $data->value }} </textarea>

                    @elseif($data->field->type == 'Value')
                        <input type="text" id="input{{ $data->field->name }}"
                            class="block w-full border-gray-300 rounded" name="datas[{{ $data->id }}]"
                            value="{{ $data->dataValue->value }}">

                    @elseif($data->field->type == 'Number')
                        <input type="number" id="input{{ $data->field->name }}"
                            class="block w-full border-gray-300 rounded" name="datas[{{ $data->id }}]"
                            value="{{ $data->value }}">

                    @elseif($data->field->type == 'List')

                        @if ($data->dataList)

                            {{-- DEBUG --}}
                            DataList id : {{ $data->dataList->id }} <br>

                            @if ($data->dataList->dataValues)

                                {{-- DEBUG --}}
                                Nomber of values in the list : {{ count($data->dataList->dataValues) }} <br>

                                @foreach ($data->dataList->dataValues as $dataValue)

                                    <input type="text" id="input{{ $data->field->name }}"
                                        class="mb-1 block w-full border-gray-300 rounded"
                                        name="datas[{{ $data->id }}][{{ $dataValue->id }}]"
                                        value="{{ $dataValue->value }}">

                                @endforeach

                            @endif

                        @endif

                        Ajouter
                        <input type="text" id="input{{ $data->field->name }}"
                            class="block w-full border-gray-300 rounded"
                            name="datas[{{ $data->id }}][]"
                            value="{{ $data->value }}">


                    @elseif($data->field->type == 'Relationship_Field')

                        <select name="datas[{{ $data->id }}]" id="input{{ $data->field->name }}"
                            class="block w-full rounded" value={{ $data->value }}>
                            <option value="" selected></option>
                            @foreach ($fields as $field)
                                <option value="{{ $field->id }}"
                                    {{ $field->id == $data->related_field_id ? 'selected' : '' }}>
                                    {{ $field->postType->name }} -
                                    {{ $field->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- @else
                        <input type="text" id="input{{ $data->field->name }}"
                            class="block w-full border-gray-300 rounded" name="datas[{{ $data->id }}]"
                            value="{{ $data->value }}"> --}}
                    @endif

                </div>


            @endforeach


            <button type="submit"
                class="py-2 px-4 bg-green-500 text-white font-semibold shadow-md rounded-lg">Submit</button>

        </form>



        {{-- Childrens --}}

        @if ($post->children())
            <div class="mb-3">
                <label for="parent" class="col-form-label">Children</label>
                <ul>
                    @foreach ($post->children() as $child)
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
                    <button class="text-red-400" type="submit" form="formDelete">Delete</button>
                </form>
            </div>
        </div>

    </div>



@endcomponent()
