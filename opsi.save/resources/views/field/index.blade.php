@component('layouts.app')

    Fields - <a href="/fields/create">Create</a>

    <ul>
        @foreach ($fields as $field)
            <li>

                <form action="/fields/{{ $field->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    {{ $field->id }} - {{ $field->name . '<' . $field->type . '>' }}
                    <button class="btn btn-outline-danger btn-sm" type="submit">Delete</button>
                </form>

            </li>
        @endforeach

    </ul>

@endcomponent()
