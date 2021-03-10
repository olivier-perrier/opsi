@component('layouts.app')

    <form method="POST" action="/datas/{{ $data->id }}">
        @method('PUT')
        @csrf
        <label for="value">{{ $data->field->name }}</label>

        @if ($data->field->type == 'Relationship')

            <select name="relationship_id" id="relationship_id">
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->postType->name }} - {{ $post->name }}</option>
                @endforeach
            </select>

        @else
            <input type="text" name="value" value="{{ $data->value }}">
        @endif

        <button type="submit">Submit</button>
    </form>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endComponent
