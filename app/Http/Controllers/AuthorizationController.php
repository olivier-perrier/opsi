<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('authorization.index', [
            'authorizations' => Authorization::All()
        ]);
    }

    public function create(Request $request)
    {
        return view('authorization.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $post = Authorization::create($validated);

        return back();
    }

    public function edit(Authorization $authorization)
    {
        // if (Auth::id() == $post->user_id) {
        return view('authorization.edit', ['authorization' => $authorization, 'posttypes' => PostType::all()]);
        // } else {
        // abort(403);
        // }
    }

    public function update(Request $request, Authorization $authorization)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        // dd($request);
        // dd(collect($request->input('posttypes'))->keys());

        // If no data sent then detach all
        if ($request->has('posttypes')) {

            // Create a collection of the request result
            // then collect only the keys
            // use the keys as sync attachement for the Model
            $authorization->posttypes()->sync(collect($request->input('posttypes'))->keys());
       
        }else{
            $authorization->posttypes()->detach();
        }

        return back();
    }
}
