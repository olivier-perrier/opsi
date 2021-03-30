<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Data;
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
            'posttype_id' => $validated['posttype'],
            'name' => $validated['name'],
            'user_id' => Auth::id(),
        ]);


        // Crée les nouvelles données sur le post grâce aux Fields
        $fields = PostType::find($validated['posttype'])->fields;

        // dd($fields);
        foreach ($fields as $key => $field) {
            $data = new Data();
            $data->post_id = $post->id;
            $data->field_id = $field->id;
            $data->value = '';
            $data->save();
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

            foreach ($request->input('datas') as $key => $dataValue) {

                $data = Data::find($key);

                if ($data->field->type == 'Relationship') {

                    $data->update(['relationship_id' => $dataValue]);
                } else if ($data->field->type == 'Relationship_Field') {
                    // dd($data);
                    $data->update(['related_field_id' => $dataValue]);
                } else {
                    $data->update(['value' => $dataValue]);
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
