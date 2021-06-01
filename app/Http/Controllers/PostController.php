<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Data;
use App\Models\DataList;
use App\Models\DataValue;
use App\Models\DataRelationship;
use App\Models\Field;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class PostController extends Controller
{

    public function __construct(Post $post)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('post.index', [
            'posts' => Auth::user()->posts,
        ]);
    }

    public function show(Post $post)
    {
        Gate::authorize('manage-post', $post);

        return view('post.show', [
            'post' => $post
        ]);
    }

    public function create(Request $request)
    {
        $posttypeId = $request->query("posttypeId");
        return view('post.create', ['posttypes' => PostType::all(), 'posttypeId' => $posttypeId, 'posttype' => Posttype::find($posttypeId)]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'posttype' => 'required',
            'name' => 'required',
            'order' => 'integer',
        ]);

        // Crée le nouveau post sur le PostType
        $post = Post::create([
            'post_type_id' => $validated['posttype'],
            'name' => $validated['name'],
            'user_id' => Auth::id(),
        ]);


        // Crée les nouvelles données sur le post grâce aux Fields
        $fields = $post->postType->fields;

        // dd($fields);
        foreach ($fields as $key => $field) {
            $data = new Data();
            $data->post_id = $post->id;
            $data->field_id = $field->id;
            $data->save();

            if ($field->type == "Value") {
                $dataValue = new DataValue();
                $dataValue->data_id = $data->id;
                $dataValue->save();
            } else if ($field->type == "List") {
                $list = new DataList();
                $list->data_id = $data->id;
                $list->save();
            } else if ($field->type == "Relationship") {
                $list = new DataRelationship();
                $list->data_id = $data->id;
                $list->save();
            } else {
                dd("error PostControler store");
            }
        }

        return redirect('posts/' . $post->id . '/edit');
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('manage-post', $post);

        $validated = $request->validate([
            'name' => '',
            'content' => '',
            'parent_id' => '',
        ]);
        $post->update($validated);

        // Update the datas
        if ($request->has('datas')) {

            // dd($request->input('datas'));

            foreach ($request->input('datas') as $key => $dataValue) {

                $data = Data::find($key);

                // dd($data);

                if ($data->field->type == 'Relationship') {

                    $data->dataRelationship()->update(['post_id' => $dataValue]);
                } else if ($data->field->type == 'Relationship_Field') {
                    // dd($data);
                    $data->update(['related_field_id' => $dataValue]);
                } else if ($data->field->type == 'List') {

                    foreach ($dataValue as $dataValueKey => $dataValueItem) {

                        $dataValueExisting = DataValue::find($dataValueKey);

                        if ($dataValueExisting) {
                            $dataValueExisting->update(['value' => $dataValueItem]);
                            // dd($dataValueExisting);

                        } else {
                            if ($dataValueItem != "") {

                                $newDataValue = DataValue::create([
                                    'value' =>  $dataValueItem,
                                ]);
                                $data->dataList->dataValues()->save($newDataValue);
                            }
                        }
                    }
                } else if ($data->field->type == 'Value') {
                    $data->dataValue()->update(['value' => $dataValue]);
                }
            }
        }

        return back();
    }

    public function edit(Request $request, Post $post)
    {
        Gate::authorize('manage-post', $post);

        return view('post.edit', ['post' => $post, 'posts' => Post::all(), 'fields' => Field::all()]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('manage-post', $post);

        $post->datas()->delete();

        $post->delete();

        return back();
    }
}
