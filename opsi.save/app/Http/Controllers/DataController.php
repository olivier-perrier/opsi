<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Post;
use App\Models\Field;
use Illuminate\Http\Request;

class DataController extends Controller
{

    public function index()
    {
        return view('data.index', ['datas' => Data::all()]);
    }

    public function create()
    {
        return view('data.create', ['posts' => Post::all(), 'fields' => Field::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required',
            'field_id' => 'required',
        ]);

        $data = new Data();
        $data->post_id = $validated['post_id'];
        $data->field_id = $validated['field_id'];

        $data->save();

        return back();
    }

    public function show(Data $data)
    {
        return view('data.show', ['data' => $data, 'posts' => Post::all()]);
    }

    public function update(Request $request, Data $data)
    {

        $validated = $request->validate([
            'value' => '',
            'value_json' => '',
            'relationship_id' => '',
        ]);


        $data->update($validated);

        // To Delete
        // Sauvegarde tous les champs du json
        if ($request->input('value_json')) {
            $options = $data->value_json;
            foreach ($request->input('value_json') as $key => $value) {
                $url = $request->input('value_json.' . $key);
                $options[$key] = $url;
            }
            $data->value_json = $options;
            $data->save();
        }

        return back();
    }

    public function destroy(Data $data)
    {
        $data->delete();

        return redirect("/datas");
    }
}
