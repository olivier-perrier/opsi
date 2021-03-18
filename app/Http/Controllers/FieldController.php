<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\PostType;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    const RELATIONSHIP = 'Relationship';

    public function index()
    {
        return view('field.index', ['fields' => Field::all()]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'order' => 'integer',
        ]);

        $postType = PostType::find($request->query('posttype'));

        $field = $postType->fields()->create($validated);

        // Create data for every post with this new field
        foreach ($field->posttype->posts as $post) {
            $post->datas()->create(['field_id' => $field->id, 'order' => $field->order]);
        }

        return back();
    }


    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'order' => 'integer',

        ]);

        $field->update($validated);

        // Update the order to all datas
        foreach ($field->datas as $data) {
            $data->order = $field->order;
            $data->save();
        }

        return back();
    }

    public function destroy(Field $field)
    {

        $field->datas()->delete();

        $field->delete();

        return back();
    }
}
