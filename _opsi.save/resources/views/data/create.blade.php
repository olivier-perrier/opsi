@component('layouts.app')

    <p>
        Create Data - <a href="/datas">All Datas</a>
    </p>

    <form method="POST" action="/datas">
        @csrf

        <div class="mb-3">

            <label for="post_id" class="form-label">Post</label>
            <select name="post_id" id="post_id" class="form-select">
                @foreach ($posts as $post)
                    <option value="{{ $post->id }}">{{ $post->name }}</option>
                @endforeach
            </select>

        </div>

        <div class="mb-3">

            <label for="field_id"  class="form-label">Field</label>
            <select name="field_id" id="field_id" class="form-select">
                @foreach ($fields as $field)
                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endcomponent()
