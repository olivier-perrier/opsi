<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;

class PostTypeController extends Controller
{
    public function index()
    {
        $posttypes = PostType::all();

        return view('posttype.index', [
            'postTypes' => PostType::all()
        ]);
    }

    public function show(PostType $postType)
    {
        return view('posttype.show', [
            'postType' => $postType
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        PostType::create($validated);

        return back();
    }

    public function update(Request $request, PostType $postType)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        $postType->update($validated);

        return back();
    }
}
