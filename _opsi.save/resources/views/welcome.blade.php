<x-public.layout>

    <div>

        {{ $page_home->content }}
    </div>


    @foreach ($page_home->datas as $data)
        <div>
            {{ $data->value }}
        </div>
    @endforeach



    {{-- @getSetting(icon) --}}


    </x-layout>
