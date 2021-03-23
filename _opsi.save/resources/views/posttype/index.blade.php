@component('layouts.app')

    Post Types

    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($postTypes as $posttype)
                <tr>

                    <th scope="row">
                        <a href="/posttypes/{{ $posttype->id }}">{{ $posttype->id }}</a>
                    </th>
                    <td>
                        <a href="/posttypes/{{ $posttype->id }}/edit">{{ $posttype->name }}</a>
                    </td>
                    <td>
                        <form action="/posttypes/{{ $posttype->id }}" method="post" id="formDelete">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button class="btn btn-outline-danger btn-sm" type="submit" form="formDelete">Delete</button>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>


    <form action="/posttypes" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Create new</label>
            <input type="text" class="form-control" name="name" value="{{ @old('name') }}">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>

@endcomponent
