<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('manage-posttypes');

        $posttypes = PostType::all();

        return view('posttype.index', [
            'postTypes' => PostType::all()
        ]);
    }

    public function edit(PostType $postType)
    {
        Gate::authorize('manage-posttypes');

        return view('posttype.edit', [
            'postType' => $postType
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-posttypes');

        $validated = $request->validate([
            'name' => 'required'
        ]);

        $posttype = PostType::create($validated);

        // Set the new Post type in the first Authorization of the current user
        $request->user()->authorizations->first()->posttypes()->attach($posttype);
        
        return back();
    }

    public function update(Request $request, PostType $postType)
    {
        Gate::authorize('manage-posttypes');

        $validated = $request->validate([
            'name' => 'required'
        ]);

        $postType->update($validated);

        return back();
    }

    public function destroy(Request $request, PostType $postType)
    {
        Gate::authorize('manage-posttypes');

        $postType->authorizations()->detach();

        if ($postType->posts->count()) {
            $request->session()->flash('message', 'Please delete all the Posts for this Post type before ' . $postType->posts->count());
            return back();
        } else {
            $postType->delete();
        }

        return back();
    }
}
