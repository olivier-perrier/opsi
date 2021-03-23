<footer>

    @if ($template)
        @foreach ($template->datas as $data)
            @if ($data->field->name == 'Footer1')
                {!! $data->value !!}
            @endif
            @if ($data->field->name == 'Footer2')
                {!! $data->value !!}
            @endif
        @endforeach
    @endif

</footer>
