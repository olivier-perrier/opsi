<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\PostType;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if ($field->type != 'Data' && $field->type =! 'Relationship') {
       
            echo("Warning Field Type is not reconizer");
            dd($field);
        }


        return back();
    }

    public function edit(Request $request, Field $field)
    {
        // Gate::authorize('manage-post', $field);

        $posttypes = Auth::user()->organization->postTypes;

        return view('field.edit', ['field' => $field, 'posttypes' => $posttypes]);
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
            // $data->order = $field->order;
            $data->save();
        }

        if($field->type == 'Relationship'){
            $field->fieldRelationship->post_type_id = $request->input('posttype');
            $field->fieldRelationship->save();
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
