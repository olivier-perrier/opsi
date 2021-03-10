<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Data;
use App\Models\PostType;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        return view('post.index', [
            'posts' => Post::all(),
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
        return view('post.create', ['posttypes' => PostType::all(), 'posttypeId' => $posttypeId]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_type' => 'required',
            'name' => 'required',
        ]);

        $posttypeId = $request->query("posttypeId");

        // Crée le nouveau post sur le PostType
        $post = PostType::find($validated['post_type'])->posts()->create($validated);

        // Crée les nouvelles données sur le post grâce aux Fields
        $fields = PostType::find($validated['post_type'])->fields;

        $datas = [];
        foreach ($fields as $key => $field) {
            // $datas[$key] = new Data(['post_id' => $post->id, 'field_id' => $field->id]);
            // $datas[$key] = ['post_id' => $post->id, 'field_id' => $field->id];
            $data = new Data();
            $data->post_id = $post->id;
            $data->field_id = $field->id;
            $data->value = '';
            $data->save();
            // Data::create(['post_id' => $post->id, 'field_id' => $field->id, 'value' => '']);
        }

        return redirect('posttypes/'. $posttypeId . '/posts');
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => '',
            'content' => '',
            'parent_id' => '',
        ]);

        $post->update($validated);

        return back();
    }

    public function edit(Post $post)
    {
        return view('post.edit', ['post' => $post, 'posts' => Post::all()]);
    }

    public function destroy(Post $post)
    {
        $post->datas()->delete();

        $post->delete();

        return back();
    }
}
