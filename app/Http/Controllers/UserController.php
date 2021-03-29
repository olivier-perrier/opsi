<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('manage-users');

        return view('user.index', ['users' => User::all()]);
    }

    public function edit(User $user)
    {
        Gate::authorize('manage-users');

        return view('user.edit', ['user' => $user, 'authorizations' => Authorization::all()]);
    }

    public function update(Request $request, User $user)
    {

        Gate::authorize('manage-users');

        // dd(collect($request->input('authorizations'))->keys());

        // If no data sent then detach all
        if ($request->has('authorizations')) {
            $user->authorizations()->sync(collect($request->input('authorizations'))->keys());
        } else {
            $user->authorizations()->detach();
        }
        // dd($user);
        return back();
    }
}
