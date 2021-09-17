<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Data;
use App\Models\DataList;
use App\Models\DataRelationship;
use App\Models\Field;
use App\Models\Organization;
use App\Models\PostType;
use App\Models\User;
use Carbon\Carbon;
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

        $posts = Auth::user()->organization->users->flatMap(function ($user, $key) {
            return $user->posts;
        });

        // dd($posts);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        Gate::authorize('view-post', $post);

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

        // dd($request->query('posttypeId'));

        $validated = $request->validate([
            'posttype' => '',
            'name' => 'required',
            'order' => 'integer',
        ]);

        // Crée le nouveau post sur le PostType
        $post = Post::create([
            'post_type_id' => $request->query('posttypeId'),
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
        }

        return redirect('posts/' . $post->id . '/edit');
    }

    public function edit(Request $request, Post $post)
    {
        Gate::authorize('edit-post', $post);

        $posts = Auth::user()->organization->posts();

        return view('post.edit', ['post' => $post, 'posts' => $posts, 'fields' => Field::all()]);
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('edit-post', $post);

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

                
                if ($data->field->type == 'Data') {
                    
                    $data->update(['value' => $dataValue]);
                    // dd($data);

                    $data->historicals()->create(['value' => $dataValue, 'timestamp' => Carbon::now()]);

                    
                } else if ($data->field->type == 'Relationship') {
                    
                    // dd($dataValue);
                    $data->update(['relationship_id' => $dataValue]);

                } else if ($data->field->type == 'Relationship_Field') {
                    // dd($data);
                    $data->update(['related_field_id' => $dataValue]);
                }
            }
        }

        return back();
    }


    public function destroy(Post $post)
    {
        Gate::authorize('manage-post', $post);

        $post->datas()->delete();

        $post->delete();

        return back();
    }
}
