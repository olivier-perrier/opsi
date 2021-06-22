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

        // Getting the authorization of the user
        $opt = Auth::user()->authorization->authorizationPosttypes()->where('post_type_id', $postType->id)->first();

        if ($opt->read || $opt->write) {

            // Get all users of the organization
            $usersId = Auth::user()->organization->users->map(function ($user, $key) {
                return $user->id;
            });

            // Get all posts of these users
            $posts = $postType->posts->whereIn('user_id', $usersId);
            
        } else {
            $posts = Auth::user()->posts->where('post_type_id', $postType->id);
        }

        return view('post.index', ['posts' => $posts, 'posttype' => $postType]);
    }
}
