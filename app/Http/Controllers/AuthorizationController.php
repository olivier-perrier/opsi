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

        $authorization = Authorization::create($validated);

        // Create an AuthorizationsPostTypes for all the PostTypes that exist
        foreach (PostType::all() as $postType) {
            $authorization->authorizationPosttypes()->create(['post_type_id' => $postType->id]);
        }

        return redirect('/authorizations');
    }

    public function edit(Authorization $authorization)
    {
        // Gate::authorize('manage-authorizations');

        return view(
            'authorization.edit',
            ['authorization' => $authorization, 'posttypes' => PostType::all()]
        );
    }

    public function update(Request $request, Authorization $authorization)
    {
        Gate::authorize('manage-authorizations');

        $validated = $request->validate([
            'name' => 'required',
        ]);

        // dd($request->input('check'));
        foreach ($authorization->authorizationPosttypes as $authorizationPosttype) {
            // dd($authorizationPosttype->id);
            if (Arr::exists($request['check'], $authorizationPosttype->id)) {
                $checkAuthPostType = $request['check'][$authorizationPosttype->id];
                // if ($checkAuthPostType) {
                // dd($checkAuthPostType);
                if (Arr::exists($checkAuthPostType, 'read')) {
                    // dd('exist');
                    $authorizationPosttype->read = true;
                } else {
                    // dd('exist');
                    $authorizationPosttype->read = false;
                }
                // dd('ok');
                $authorizationPosttype->save();

                // }
            } else {
                // dd('not exist' .$authorizationPosttype->id );
            }
            if (collect($request->input('check'))->contains($authorizationPosttype->id)) {
                dd('ok');
            }
        }


        // foreach ($request['check'] as $postTypeId => $postTypeAuthorizations) {
        //     $opt = PostType::find($postTypeId)->authorizationsPosttypes->where('authorization_id', $authorization->id)->first();

        //     $opt->read = false;
        //     $opt->write = false;
        //     $opt->own = false;
        //     $opt->all = false;

        //     foreach ($postTypeAuthorizations as $action => $value) {
        //         $opt[$action] = true;
        //     }
        //     $opt->save();
        // }

        return back()->with('status', 'Saved');;
    }

    public function destroy(Request $request, Authorization $authorization)
    {
        Gate::authorize('manage-posttypes');

        $authorization->delete();

        return redirect('/authorizations');
    }
}
