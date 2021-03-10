<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;

class PostTypePostController extends Controller
{
    public function index(PostType $postType)
    {
        return view('post.index', ['posts' => $postType->posts, 'posttype' => $postType]);
    }
}
