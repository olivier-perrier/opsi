<?php

namespace App\Http\Controllers;

use App\Models\Authorization;
use App\Models\PostType;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Gate::authorize('manage-users');
        // dd(auth()->user()->children);
        
        return view('user.index', ['users' => auth()->user()->children]);
    }

    public function create(Request $request)
    {

        // dd(auth()->id());
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make("password"),
            'parent_id' => auth()->id()
            // 'password' => Hash::make($request->password),
        ]);

        // Auth::login($user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make("password"),
        //     // 'password' => Hash::make($request->password),
        // ]));

        event(new Registered($user));

        return redirect("/users");
        // return redirect(RouteServiceProvider::HOME);
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
