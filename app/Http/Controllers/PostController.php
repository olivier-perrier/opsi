<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Data;
use App\Models\PostType;
use App\Models\User;
use ArrayObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('post.index', [
            'posts' => AUth::user()->posts,
        ]);
    }

    public function show(Post $post)
    {
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
            'post_type' => 'required',
            'name' => 'required',
        ]);

        $posttypeId = $request->query("posttypeId");

        // Crée le nouveau post sur le PostType
        $post = Post::create([
            'post_type_id' => $validated['post_type'],
            'name' => $validated['name'],
            'user_id' => Auth::id(),
        ]);


        // Crée les nouvelles données sur le post grâce aux Fields
        $fields = PostType::find($validated['post_type'])->fields;

        foreach ($fields as $key => $field) {
            $data = new Data();
            $data->post_id = $post->id;
            $data->field_id = $field->id;
            $data->value = '';
            $data->save();
        }

        return redirect('posttypes/' . $posttypeId . '/posts');
    }

    public function update(Request $request, Post $post)
    {

        $validated = $request->validate([
            'name' => '',
            'content' => '',
            'parent_id' => '',
        ]);
        $post->update($validated);


        if($request->has('content')){

            $content = $post->content;
            foreach ($request->input('content') as $key => $value) {
                $content[$key] = $value;
            }

            $post->content = $content;
            $post->save();
        
        }

        return back();
    }

    public function edit(Post $post)
    {
        if (auth::id() == $post->user_id) {
            return view('post.edit', ['post' => $post, 'posts' => Post::all()]);
        } else {
            abort(403);
        }
    }

    public function destroy(Post $post)
    {
        $post->datas()->delete();

        $post->delete();

        return back();
    }
}
