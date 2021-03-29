<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthorizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('manage-authorizations');

        return view('authorization.index', [
            'authorizations' => Authorization::All()
        ]);
    }

    public function create(Request $request)
    {
        Gate::authorize('manage-authorizations');

        return view('authorization.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-authorizations');

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $post = Authorization::create($validated);

        return redirect('/authorizations');
    }

    public function edit(Authorization $authorization)
    {
        Gate::authorize('manage-authorizations');

        // if (Auth::id() == $post->user_id) {
        return view(
            'authorization.edit',
            ['authorization' => $authorization, 'posttypes' => PostType::all()]
            // ['authorization' => $authorization, 'posttypes' => PostType::where('hidden', false)->orWhereNull('hidden')->get()]
        );
        // } else {
        // abort(403);
        // }
    }

    public function update(Request $request, Authorization $authorization)
    {
        Gate::authorize('manage-authorizations');

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
        } else {
            $authorization->posttypes()->detach();
        }

        return back()->with('status', 'Saved');;
    }

    public function destroy(Request $request, Authorization $authorization)
    {
        Gate::authorize('manage-posttypes');

        $authorization->delete();

        return redirect('/authorizations');
    }
}
