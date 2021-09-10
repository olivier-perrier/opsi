<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\AuthorizationPosttype;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        Gate::authorize('edit-authorizations');

        return view('authorization.index', [
            'authorizations' => Authorization::All()
        ]);
    }

    public function create(Request $request)
    {
        Gate::authorize('edit-authorizations');

        return view('authorization.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('edit-authorizations');

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $authorization = Authorization::create($validated);

        // Create an AuthorizationsPostTypes for all the PostTypes that exist
        foreach (PostType::all() as $postType) {
            $authorization->authorizationPosttypes()->create(['post_type_id' => $postType->id]);
        }

        return redirect('/authorizations');
    }

    public function edit(Authorization $authorization)
    {
        Gate::authorize('edit-authorizations');

        return view(
            'authorization.edit',
            ['authorization' => $authorization, 'posttypes' => Auth::user()->organization->postType]
        );
    }

    public function update(Request $request, Authorization $authorization)
    {
        Gate::authorize('edit-authorizations');

        $validated = $request->validate([
            'name' => 'required',
            'check' => 'required|array',
            'edit-authorizations' => ''
        ]);

        // dd($request);

        $authorization->edit_post_types = $request->has('edit-posttypes');
        $authorization->edit_users = $request->has('edit-users');
        $authorization->edit_authorizations = $request->has('edit-authorizations');
        $authorization->save();

        // dd($validated);

        // dd($request->input('check'));
        foreach ($authorization->authorizationPosttypes as $authorizationPosttype) {

            if ($request->has('check.' . $authorizationPosttype->id)) {

                foreach (['read', 'write', 'own', 'all'] as $key) {
                    $authorizationPosttype[$key] = $request->has('check.' . $authorizationPosttype->id . '.' . $key);
                }

            } else {
                $authorizationPosttype->read = false;
                $authorizationPosttype->write = false;
                $authorizationPosttype->own = false;
                $authorizationPosttype->all = false;
            }

            $authorizationPosttype->save();
        }

        return back()->with('status', 'Saved');;
    }

    public function destroy(Request $request, Authorization $authorization)
    {
        Gate::authorize('edit-authorizations');

        $authorization->delete();

        return redirect('/authorizations');
    }
}
