@component('layouts.app')

    <form method="POST" action="/posttypes/{{ $postType->id }}">
        @method('PUT')
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name" value="{{ $postType->name }}">
        <button type="submit">Submit</button>
    </form>

    <ul>
        @foreach ($postType->fields as $field)
            <li>
                {{ $field->name . ' <' . $field->type . '>' }}

                <form method="POST" action="/fields/{{ $field->id }}">
                    @method('PUT')
                    @csrf
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{ $field->name }}">
                    <label for="type">Type</label>
                    <input type="text" name="type" value="{{ $field->type }}">
                    <label for="order">Order</label>
                    <input type="number" name="order" value="{{ $field->order }}">
                    <button type="submit">Submit</button>
                </form>
                <form action="/fields/{{ $field->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>

        @endforeach

        <li>
            Ajouter
            <form method="POST" action="/fields?posttype={{ $postType->id }}">
                @method('POST')
                @csrf
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ @old('name') }}">
                <label for="type">Type</label>
                <input type="text" name="type" value="{{ @old('type') }}">
                <button type="submit">Ajouter</button>
            </form>
        </li>
    </ul>

    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

@endComponent
