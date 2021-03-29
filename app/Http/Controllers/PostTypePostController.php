<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostTypePostController extends Controller
{

    public function __construct(PostType $postType)
    {
        $this->middleware('auth');
    }

    public function index(PostType $postType)
    {
        Gate::authorize('manage-posttype', $postType);

        return view('post.index', ['posts' => $postType->posts, 'posttype' => $postType]);
    }
}
