@component('layouts.app')

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Field') }} - {{ $field->name }}
            </h2>
            <a href="/fields">All</a>
        </div>
    </x-slot>

    <div class="container py-5">

        {{-- Name --}}
        <form method="POST" action="/fields/{{ $field->id }}" class="mb-3">
            @method('PUT')
            @csrf

            <div class="mt-2">
                <label for="inputName" class="block font-bold">Name</label>
                <input type="text" id="inputName" class="mt-1 block w-full rounded-lg" name="name"
                    value="{{ $field->name }}">
            </div>

            <div class="mt-2">

                <label for="inputType" class="block font-bold">Type</label>
                <select name="type" id="inputType" class="w-full rounded-lg">
                    <option value="Data" {{ $field->type == 'Data' ? 'selected' : '' }}>Data</option>
                    <option value="Relationship" {{ $field->type == 'Relationship' ? 'selected' : '' }}>Relationship
                    </option>
                </select>
            </div>




            @if ($field->type == 'Data')
                This field is a value. There is nothing more to do here. <br>

            @elseif($field->type == 'Relationship')
                This field is a Relationship. You can specify the Post type of the relation. <br>
                FieldRelationship related <br>
                {{ $field->fieldRelationship }}

                <div class="mt-2">

                    <label for="posttype" class="block font-bold">Post type</label>
                        <select name="posttype" id="posttype" class="w-full rounded-lg">
                            <option value="" {{ $field->type == 'Value' ? 'selected' : '' }}></option>
                            @foreach ($posttypes as $posttype)
                                <option value="{{ $posttype->id }}"
                                    {{ $posttype->id == $field->fieldRelationship->post_type_id ? 'selected' : '' }}>
                                    {{ $posttype->name }}</option>
                            @endforeach
                            </option>
                        </select>
                </div>

            @else
                Warning the Type of the Field is not reconized {{ $field->type }}
            @endif

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg">Save</button>
        </form>

    </div>


@endComponent
