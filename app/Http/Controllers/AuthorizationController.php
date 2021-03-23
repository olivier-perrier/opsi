<?php

namespace App\Http\Controllers;

use App\Models\Authorization;


use Illuminate\Http\Request;

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
}
