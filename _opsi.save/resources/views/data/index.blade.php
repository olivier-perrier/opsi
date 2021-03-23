@component('layouts.app')

    All datas - <a href="/datas/create">Create</a>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Post</th>
                <th scope="col">Field</th>
                <th scope="col">Value</th>
                <th scope="col">Relationship</th>
                <th scope="col"></th>
            </tr>
        </thead>

        <tbody>

            @foreach ($datas as $data)

                <tr>
                    <th scope="row"><a href="/datas/{{ $data->id }}">{{ $data->id }}</a></th>
                    <td><a href="/posts/{{ $data->post->id }}">{{ $data->post->name }}</a></td>
                    <td><a href="/posts/{{ $data->field->id }}">{{ $data->field->name }}</a></td>
                    <td>{{ $data->value }}</td>
                    <td>{{ $data->relationship_id }}</td>
                    <td>
                        <form action="/datas/{{ $data->id }}" method="post" id="formDelete">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn btn-outline-danger btn-sm" type="submit" form="formDelete">Delete</button>
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>

@endComponent
