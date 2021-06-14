<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostTypePostController extends Controller
{

    public function __construct(PostType $postType)
    {
        $this->middleware('auth');
    }

    public function index(Request $request, PostType $postType)
    {
        Gate::authorize('manage-posttype', $postType);

        // $opt = Auth::user()->authorization->authorizationPosttypes()->where('post_type_id', $postType->id)->first();

        // if ($opt->all) {
        //     $up = $request->user()->organization->users()->with('posts')->get();

        //     $posts = $up->flatMap->posts;
        // } else if ($opt->own) {
        //     $posts = $request->user()->posts()->where('post_type_id', $postType->id)->get();
        // } else {
        //     $posts = [];
        // }
        
        $usersId = Auth::user()->organization->users->map(function ($user, $key) {
            return $user->id;
        });

        $posts = $postType->posts->whereIn('user_id', $usersId);


        return view('post.index', ['posts' => $posts, 'posttype' => $postType]);
    }
}
