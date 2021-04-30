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

            <div class="mb-2">
                <label for="inputName" class="block font-bold">Name</label>
                <input type="text" id="inputName" class="mt-1 block w-full rounded-lg" name="name"
                    value="{{ $field->name }}">
            </div>

            <div class="">

                <label for="inputType" class="block font-bold">Type</label>
                <select name="type" id="inputType" class="w-full rounded-lg">
                    <option value="Value" {{ @old('type') == 'Value' ? 'selected' : '' }}>Value</option>
                    <option value="List" {{ @old('type') == 'List' ? 'selected' : '' }}>List</option>
                    <option value="Tab" {{ @old('type') == 'Tab' ? 'selected' : '' }}>Tab</option>
                    <option value="Relationship" {{ @old('type') == 'Relationship' ? 'selected' : '' }}>Relationship
                    </option>
                </select>
            </div>

            <button type="submit" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg">Save</button>
        </form>


        @if ($field->type == 'Value')
            This field is a value. There is nothing more to do here. <br>
            FieldValue related <br>
            {{ $field->fieldValue }}

        @elseif($field->type == 'List')
            This field is a list. There is nothing more to do here. <br>
            FieldList related <br>
            {{ $field->fieldList }}

        @else
            Other {{ $field->type }}
        @endif

        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </div>


@endComponent
