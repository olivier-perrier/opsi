<?php

namespace App\Http\Controllers;

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

        $postType->fields()->create(['name' => $validated['name'], 'type' => $validated['type']]);

        return back(); //redirect('posttypes');
    }

    
    public function update(Request $request, Field $field)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'order' => 'integer',

        ]);

        $field->update($validated);
        
        return back();
    }

    public function destroy(Field $field)
    {

        $field->datas()->delete();

        $field->delete();

        return back();
    }
}
