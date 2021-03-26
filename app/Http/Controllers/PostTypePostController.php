<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostTypePostController extends Controller
{
    public function index(Request $request, PostType $postType)
    {

        $isAuth = $request->user()->authorized_posttypes()->contains('name', $postType->name);

        if ($isAuth) {
            return view('post.index', ['posts' => $postType->posts, 'posttype' => $postType]);
        } else {
            abort(403);
        }
    }
}
