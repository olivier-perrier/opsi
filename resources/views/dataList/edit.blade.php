@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data List') }}
            </h2>
            <a href="/posts/{{$dataList->data->post->id}}/edit">Return Post</a>

        </div>
    </x-slot>

    <div class="container py-5">


        <form action="/dataList/{{ $dataList->id }}" method="post" class="mb-3">
            @csrf
            @method('PUT')

            @foreach ($dataList->dataValues as $dataValue)

                <input type="text" id="inputs[{{ $dataValue->id }}]" class="mb-2 block w-full border-gray-300 rounded"
                    name="inputs[{{ $dataValue->id }}]" value="{{ $dataValue->value }}">

            @endforeach

            <button type="submit" class="py-2 px-4 bg-green-500 text-white shadow-md rounded-lg">Save</button>
        </form>

        <form action="/dataValue?dataList={{ $dataList->id }}" method="post" class="mb-3 flex justify-end">
            @csrf

            <button type="submit" class="py-2 px-4 bg-blue-500 text-white shadow-md rounded-lg">Add</button>

        </form>

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>


@endComponent
