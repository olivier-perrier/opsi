<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\PostType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menuSidebar = Auth::user()->authorizations->reduce(function ($carry, $item) {
            return $carry->union($item->posttypes);
        }, collect([]));

        return view(
            'user.index',
            [
                'users' => User::all(),
                'menuSidebar2' => $menuSidebar
            ]
        );
    }

    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user, 'authorizations' => Authorization::all()]);
    }

    public function update(Request $request, User $user)
    {

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
